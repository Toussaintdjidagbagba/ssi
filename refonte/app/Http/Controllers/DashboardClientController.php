<?php

namespace App\Http\Controllers;

use App\Historique;
use App\HistoriqueClient;
use App\Articlepdf;
use App\Galerie;
use App\Evenement;
use App\Notificationcontact;
use App\User;
use App\Avoir;
use App\Etape;
use App\Mesformation;
use App\MoyenPayement;
use App\Niveau;
use App\Systemadmin; 
use App\Translationuser;
use DB;
use App\Providers\InterfaceServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardClientController extends Controller
{
    // Changement de packs
	public function setpack()
	{
		if (isset(auth()->user()->id)) {

			$valeurpack = DB::table('packs')->where('id', request('packnew'))->first()->valeur;

			$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;

			if($soldeactuel < $valeurpack){
				flash("Solde insuffissant pour effectué l'action")->error();
            	return Back();
			}else{
				// Alors update compte expediteur : decrementer
				$soldeac = $soldeactuel - $valeurpack;
				DB::table('avoirs')
				->where('id_user', auth()->user()->id)
				->update([
					'gainespece' => $soldeac
				]);

				//update la table
                    DB::table('systemadmins')
                       ->update([
                            'compteavoirrecu' => $valeurpack
                            ]);

                DB::table('users')
					->where('id', auth()->user()->id)
					->update([
						'Pack' => request('packnew')
					]);

                $packancien = DB::table('packs')->where('id', auth()->user()->Pack)->first()->libelle;

                $packnouveau =  DB::table('packs')->where('id', request('packnew'))->first()->libelle;

                $message = "Vous êtes passé de ".$packancien." au ".$packnouveau." avec succès.";

                HistoriqueClient::saveHistorique($message, auth()->user()->id );

                flash($message);
            	return Back();
			}
			# code...
		}else{
			flash("Vous devez etre connecté pour effectué l'action")->error();

            return redirect('/connexion');
		}
	}
	
	// Nature
	public function getnature()
	{
		return view('client.nature');
	}

	public function getmesnatures()
	{
		$etape = DB::table('niveaux')->select('id_etape')->where('id_user', auth()->user()->id)->orderBy('id_etape', 'DESC')->get()[0]->id_etape;
		return view('client.mesnature', compact('etape'));
	}


	// Tranferts de compte espèce vers compte espèce destinatire
	public function gettransfert()
	{
		return view('client.transfert');
	}

	public function settransfert(Request $request)
	{
		request()->validate([
			'id' => 'required',
			'montant' => 'required|min:0']);

        // Verifier l'existance de id
		if (isset(DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso)) {

            // verifie l'autorisation par otp

			if (session('otprecu') != request('otp')) {
				flash("L'autorisation par OTP incorrect! Veuillez verifier l'OTP envoyé par sur votre mail ou réeassayer.")->error();

				return view('client.transfert');
			}
			else
			{
            // Verifier le compte actuel du parrain au traver du montant

				$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
				$montantnet = request('montant');
				//$fraisretrait = $montantnet * 0.03; 
				$fraisretrait = $montantnet * InterfaceServiceProvider::GetTaux(auth()->user()->Pack, "TC", "client") / 100;
				$montantvalider = $montantnet + $fraisretrait;
            //dd($soldeactuel < request('montant'));
				if ($soldeactuel <= $montantvalider) {
					flash("Votre solde est insuffissant!!");
					
					return view('client.transfert');
				} else {
                // Alors update compte expediteur : decrementer
					$soldeac = $soldeactuel - $montantvalider;
					DB::table('avoirs')
					->where('id_user', auth()->user()->id)
					->update([
						'gainespece' => $soldeac
					]);

                //debiter le compte admin de 3% comme frais sur retrait
					$compteadmint = DB::table('systemadmins')->get()[0]->compteavoirrecu;

					$recut=$compteadmint + $fraisretrait;

                    //update la table
					DB::table('systemadmins')
					->update([
						'compteavoirrecu' => $recut
					]);

                // Alors update compte destinataire : incrementer
					$iddest = DB::table('users')->where('codeperso', request('id'))->get()[0]->id;
					$soldeactuel = DB::table('avoirs')->where('id_user', $iddest)->get()[0]->gainespece;
					$soldeac = $soldeactuel + $montantnet;
					DB::table('avoirs')
					->where('id_user', $iddest)
					->update([
						'gainespece' => $soldeac
					]);

					//InterfaceServiceProvider::inderminiterparrain(auth()->user()->id, $fraisretrait, auth()->user()->Pack, "TC", "client");

					// save historique envoie

					$message = "Vous avez transféré ".request('montant')." $ SSI à ". DB::table('users')->where('codeperso', request('id'))->get()[0]->prenom . " 
					" . DB::table('users')->where('codeperso', request('id'))->get()[0]->nom." dont l'identifiant est :
					".DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso.". Frais du transfert ".$fraisretrait.". Transfert effectué avec succès.";

					HistoriqueClient::saveHistorique($message, auth()->user()->id );

					// save historique reçu

					$messagedest = "Vous avez reçu ".request('montant')." $ SSI de ". auth()->user()->prenom . " 
					" . auth()->user()->nom;

					HistoriqueClient::saveHistorique($messagedest, $iddest );
					
					flash($message);
					
					return view('client.transfert');
				}
			}
		} else {
			flash("L'identifiant n'existe pas")->error();
			return view('client.transfert');
		}
	}

	// Tranferts de commission sur vente vers virtuel (soit)
	public function getcvtovirtuel()
	{
		return view('client.vtoe');
	}

	public function cvtovirtuel(Request $request)
	{
		request()->validate([
			'montant' => 'required|min:0',
			'otp' => 'required']);

		if (session('otprecu') != request('otp')) {
			flash("L'autorisation par OTP incorrect! Veuillez verifier l'OTP envoyé par sur votre mail ou réeassayer.")->error();

			return view('client.vtoe');
		}
		else
		{

			$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gaincommissionvente;

			$montantnet = request('montant');
			$fraisretrait = $montantnet * InterfaceServiceProvider::GetTaux(auth()->user()->Pack, "CVV", "client") / 100;
			$montantvalider = $montantnet + $fraisretrait;
			if ($soldeactuel <= $montantvalider) {
				flash("Votre solde est insuffissant!!");

				return view('client.vtoe');
			} else {
                // Alors update compte expediteur : decrementer
				$soldeac = $soldeactuel - $montantvalider;
				DB::table('avoirs')
				->where('id_user', auth()->user()->id)
				->update([
					'gaincommissionvente' => $soldeac
				]);

                // Alors update compte destinataire : incrementer
				$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
				$soldeac = $soldeactuel + $montantnet;
				DB::table('avoirs')
				->where('id_user', auth()->user()->id)
				->update([
					'gainvirtuel' => $soldeac
				]);

				//debiter le compte admin de 3% comme frais sur retrait
				$compteadmint = DB::table('systemadmins')->get()[0]->compteavoirrecu;

				$recut=$compteadmint + $fraisretrait;

                    //update la table
				DB::table('systemadmins')
				->update([
					'compteavoirrecu' => $recut
				]);

				//InterfaceServiceProvider::inderminiterparrain(auth()->user()->id, $fraisretrait, auth()->user()->Pack, "CVV", "client");

				$message = "Vous avez transféré ".request('montant')." $ SSI de votre compte commission sur vente dans votre compte virtuel.";
				HistoriqueClient::saveHistorique($message, auth()->user()->id );

				$messagedst = "Vous avez reçu ".request('montant')." $ SSI de votre compte commission sur vente depuis votre compte virtuel.";
				HistoriqueClient::saveHistorique($messagedst, auth()->user()->id );

				flash($message);

				return view('client.vtoe');
			}

		}
	}

	// Transfert de commission sur vente vers espce
	public function getconventiontoespece()
	{
		return view('client.ctoe');
	}

	public function conventiontoespece(Request $request)
	{
		request()->validate([
			'montant' => 'required|min:0',
			'otp' => 'required']);

            // verifie l'autorisation par otp

		if (session('otprecu') != request('otp')) {
			flash("L'autorisation par OTP incorrect! Veuillez verifier l'OTP envoyé par sur votre mail ou réeassayer.")->error();
			return view('client.ctoe');
		}
		else
		{
			$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gaincommissionvente;

			$montantnet = request('montant');
			$fraisretrait = $montantnet * InterfaceServiceProvider::GetTaux(auth()->user()->Pack, "CVE", "client") / 100;
			$montantvalider = $montantnet + $fraisretrait;

			if ($soldeactuel < $montantvalider ){
				flash("Votre solde est insuffissant");
				return view('client.ctoe');
			}

			if ($montantvalider < 10) {
				flash("Le montant de votre transaction est inférieur à 10 $ SSI ");
				
				return view('client.ctoe');
			} else {
                // Alors update compte expediteur : decrementer
				$soldeac = $soldeactuel - $montantvalider;
				DB::table('avoirs')
				->where('id_user', auth()->user()->id)
				->update([
					'gaincommissionvente' => $soldeac
				]);

                // Alors update compte destinataire : incrementer
				$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
				$soldeac = $soldeactuel + $montantnet;
				DB::table('avoirs')
				->where('id_user', auth()->user()->id)
				->update([
					'gainespece' => $soldeac
				]);

				//debiter le compte admin de 3% comme frais sur retrait
				$compteadmint = DB::table('systemadmins')->get()[0]->compteavoirrecu;

				$recut=$compteadmint + $fraisretrait;

                //update la table
				DB::table('systemadmins')
				->update([
					'compteavoirrecu' => $recut
				]);

				//InterfaceServiceProvider::inderminiterparrain(auth()->user()->id, $fraisretrait, auth()->user()->Pack, "CVE", "client");

				$message = "Vous avez transféré ".request('montant')." $ SSI dans votre compte espèce.";
				HistoriqueClient::saveHistorique($message, auth()->user()->id );
				
				$messagedst = "Vous avez reçu ".request('montant')." $ SSI de votre compte espèce.";
				HistoriqueClient::saveHistorique($messagedst, auth()->user()->id );
				
				flash($message);
				
				return view('client.ctoe');
			}
		}

	}

	// Retrait
	public function getretrait()
	{
		$otp = rand(100000, 999999);

        $message = "Code OTP Générer : ".$otp;

        $destinataire = auth()->user()->email;

        InterfaceServiceProvider::EnvoieMail($destinataire, $message, "Accès", "");
        
		$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
        Session::put('otp', $otp);
        Session::put('max', $max);

		flash("Veuillez cliquer sur le moyen de retrait de votre choix et renseignez les informations qui suit. Frais sur retrait : 5%");
		
		return view('client.retrait');
	}

	public function setretraitmtn(Request $request)
	{
		if(session('otp') == request('otpmtn') ){
			
			$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			
			if($soldeactuel < 20)
			{
				flash("Votre solde n'atteint pas le seuil minimum!. Minimal : 20 $ SSI");
				return view('client.retrait', $data);
			}
			else {
			    
			    $montantnet = request('montantmtn');
				//$fraisretrait = $montantnet * 0.05;
				$fraisretrait = $montantnet * InterfaceServiceProvider::GetTaux(auth()->user()->Pack, "RMTN", "client") / 100;

				$montantvalider = $montantnet + $fraisretrait;
            
				if ($soldeactuel < $montantvalider) {
					flash("Votre solde est insuffissant pour terminer l'opération!!");
					return view('client.retrait', $data);
				} else {
					
					// Alors update compte expediteur : decrementer
					$soldeac = $soldeactuel - $montantvalider;
					DB::table('avoirs')
						->where('id_user', auth()->user()->id)
						->update([
						'gainespece' => $soldeac
						]);
						
					Retraitmtn::create([
						'montant' => $montantnet,
						'reff'=> InterfaceServiceProvider::genunique('retraitmtns'),
						'numero' => request('numerom'),
						'intitule' => request('nomm'),
						'id_user' => auth()->user()->id
					]);
					
					$compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;

                    //debiter le compte admin de 5% comme frais sur retrait
                    $recu=$compteadmin + $fraisretrait;
    
                    //update la table
                    DB::table('systemadmins')
                            ->update([
                            'compteavoirrecu' => $recu
                            ]);
                            
                    // Argent qui sort
					$compteadminsort = DB::table('systemadmins')->get()[0]->compteavoirsortant;

					$recus=$compteadminsort - $montantvalider;

					DB::table('systemadmins')
							->update([
							'compteavoirrecu' => $recus
							]);

					//InterfaceServiceProvider::inderminiterparrain(auth()->user()->id, $fraisretrait, auth()->user()->Pack, "RMTN", "client");
							
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantdemander." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
					HistoriqueClient::saveHistorique($message, auth()->user()->id );
					flash($message);
					return view('client.retrait');
				}
			}
		}else{
			flash('Code otp incorrect! ');
			return view('client.retrait');
		}
	}
	
	public function setretraitmoov(Request $request)
	{
		if(session('otp') == request('otpmoov') ){
			
			$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			
			if($soldeactuel < 20)
			{
				flash("Votre solde n'atteint pas le seuil minimum! Minimal : 20 $ SSI");
                return view('client.retrait');
			}
			else {
			    $montantnet = request('montantmoov');
					//$fraisretrait = $montantnet * 0.05;
					$fraisretrait = $montantnet * InterfaceServiceProvider::GetTaux(auth()->user()->Pack, "RMOOV", "client") / 100;

					$montantvalider = $montantnet + $fraisretrait;
            
				if ($soldeactuel < $montantvalider) {
					flash("Votre solde est insuffissant pour terminer l'opération!!");
					return view('client.retrait');
				} else {
					
					$soldeac = $soldeactuel - $montantvalider;
					DB::table('avoirs')
						->where('id_user', auth()->user()->id)
						->update([
						'gainespece' => $soldeac
						]);
					
					Retraitmoov::create([
						'montant' => $montantnet,
						'reff'=> InterfaceServiceProvider::genunique('retraitmoovs'),
						'numero' => request('numeromoov'),
						'intitule' => request('nommoov'),
						'id_user' => auth()->user()->id
					]);
					
					
					$compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;

                    //debiter le compte admin de 5% comme frais sur retrait
                    $recu=$compteadmin + $fraisretrait;
    
                    //update la table
                    DB::table('systemadmins')
                            
                            ->update([
                            'compteavoirrecu' => $recu
                            ]);
                            
                    // Argent qui sort
					$compteadminsort = DB::table('systemadmins')->get()[0]->compteavoirsortant;

					$recus=$compteadminsort - $montantvalider;

					DB::table('systemadmins')
							
							->update([
							'compteavoirrecu' => $recus
							]);
					
							
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantdemander." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
					HistoriqueClient::saveHistorique($message, auth()->user()->id );
					flash($message);
					return view('client.retrait');
				}
			}
		}else{
			flash('Code otp incorrect! ');
			return view('client.retrait');
		}
	}
	
	public function setretraitwestern(Request $request)
	{
		if(session('otp') == request('otpwestern') ){
			
			$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			
			if($soldeactuel < 20)
			{
				flash("Votre solde n'atteint pas le seuil minimum! Minimal : 20 $ SSI");
                return view('client.retrait');
			}
			else {
                $montantnet = request('montwest');
					//$fraisretrait = $montantnet * 0.05;
					$fraisretrait = $montantnet * InterfaceServiceProvider::GetTaux(auth()->user()->Pack, "RWESTERN", "client") / 100;
					$montantvalider = $montantnet + $fraisretrait;	
				if ($soldeactuel < $montantvalider) {
					flash("Votre solde est insuffissant pour terminer l'opération!!");
					return view('client.retrait');
				} else {
					
					$soldeac = $soldeactuel - $montantvalider;
					DB::table('avoirs')
						->where('id_user', auth()->user()->id)
						->update([
						'gainespece' => $soldeac
						]);
			
					Retraitwestern::create([
						'montant' => $montantnet,
						'reff'=> InterfaceServiceProvider::genunique('retraitwesterns'),
						'nom' => request('nomwest'),
						'prenom' => request('prenomwest'),
						'adresse' => request('addwest'),
						'ville' => request('villewest'),
						'pays' => request('payswest'),
						'motif' => request('motifwest'),
						'id_user' => auth()->user()->id
					]);
					
					$compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;

                    //debiter le compte admin de 5% comme frais sur retrait
                    $recu=$compteadmin + $fraisretrait;
    
                    //update la table
                    DB::table('systemadmins')
                            
                            ->update([
                            'compteavoirrecu' => $recu
                            ]);
                            
                    // Argent qui sort
					$compteadminsort = DB::table('systemadmins')->get()[0]->compteavoirsortant;

					$recus=$compteadminsort - $montantvalider;

					DB::table('systemadmins')
							
							->update([
							'compteavoirrecu' => $recus
							]);
							
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantdemander." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
					HistoriqueClient::saveHistorique($message, auth()->user()->id );
					flash($message);
					return view('client.retrait');
				}
			}
		}else{
			flash('Code otp incorrect! ');
			return view('client.retrait');
		}
	}

	public function setretraitgram(Request $request)
	{
		if(session('otp') == request('otpgram') ){
			
			$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			
			if($soldeactuel < 20)
			{
				flash("Votre solde n'atteint pas le seuil minimum! Minimal : 20 $ SSI");
                return view('client.retrait');
			}
			else {
                $montantnet = request('montgram');
					//$fraisretrait = $montantnet * 0.05;
					$fraisretrait = $montantnet * InterfaceServiceProvider::GetTaux(auth()->user()->Pack, "RGRAM", "client") / 100;
					$montantvalider = $montantnet + $fraisretrait;
				if ($soldeactuel < $montantvalider) {
					flash("Votre solde est insuffissant pour terminer l'opération!!");
					return view('client.retrait');
				} else {
					
					$soldeac = $soldeactuel - $montantvalider;
					DB::table('avoirs')
						->where('id_user', auth()->user()->id)
						->update([
						'gainespece' => $soldeac
						]);
											
					Retraitgram::create([
						'montant' => $montantnet,
						'reff'=> InterfaceServiceProvider::genunique('retraitgrams'),
						'nom' => request('nomgram'),
						'prenom' => request('prenomgram'),
						'adresse' => request('addgram'),
						'ville' => request('villegram'),
						'pays' => request('paysgram'),
						'motif' => request('motifgram'),
						'id_user' => auth()->user()->id
					]);
					
					$compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;

                    //debiter le compte admin de 5% comme frais sur retrait
                    $recu=$compteadmin + $fraisretrait;
    
                    //update la table
                    DB::table('systemadmins')
                            
                            ->update([
                            'compteavoirrecu' => $recu
                            ]);
                            
                    // Argent qui sort
					$compteadminsort = DB::table('systemadmins')->get()[0]->compteavoirsortant;

					$recus=$compteadminsort - $montantvalider;

					DB::table('systemadmins')
							
							->update([
							'compteavoirrecu' => $recus
							]);
					
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantdemander." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
					HistoriqueClient::saveHistorique($message, auth()->user()->id );
					flash($message);
					return view('client.retrait');
				}
			}
		}else{
			flash('Code otp incorrect! ');
			return view('client.retrait');
		}
	}

	public function setretraitperfect(Request $request)
	{
		if(session('otp') == request('otpperfect') ){
			
			$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			
			if($soldeactuel < 20){
				flash("Votre solde n'atteint pas le seuil minimum! Minimal : 20 $ SSI");
                return view('client.retrait');
			} else {
			    $montantnet = request('montperfect');
					//$fraisretrait = $montantnet * 0.05;
					$fraisretrait = $montantnet * InterfaceServiceProvider::GetTaux(auth()->user()->Pack, "RPERFECT", "client") / 100;
					$montantvalider = $montantnet + $fraisretrait;
				if ($soldeactuel < $montantvalider) {
					flash("Votre solde est insuffissant pour terminer l'opération!!");
					return view('client.retrait');
				} else {
					
					$soldeac = $soldeactuel - $montantvalider;
					DB::table('avoirs')
						->where('id_user', auth()->user()->id)
						->update([
							'gainespece' => $soldeac
						]);
					
					Retraitperfect::create([
						'montant' => $montantnet,
						'reff'=> InterfaceServiceProvider::genunique('retraitperfects'),
						'intituler' => request('intitulerperfect'),
						'lien' => request('lienperfect'),
						'id_user' => auth()->user()->id
					]);					
					
					$compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;

                    //debiter le compte admin de 5% comme frais sur retrait
                    $recu=$compteadmin + $fraisretrait;
    
                    //update la table
                    DB::table('systemadmins')
                            ->update([
                            'compteavoirrecu' => $recu
                            ]);
                            
                    // Argent qui sort
					$compteadminsort = DB::table('systemadmins')->get()[0]->compteavoirsortant;

					$recus=$compteadminsort - $montantvalider;

					DB::table('systemadmins')
							
							->update([
							'compteavoirrecu' => $recus
							]);
					
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantdemander." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
					HistoriqueClient::saveHistorique($message, auth()->user()->id );
					flash($message);
					return view('client.retrait');
				}
			}
		}else{
			flash('Code otp incorrect! ');
			return view('client.retrait');
		}
	}
	
	public function setretraittrust(Request $request)
	{
		if(session('otp') == request('otptrust') ){
			
			$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			
			if($soldeactuel < 20){
				flash("Votre solde n'atteint pas le seuil minimum! Minimal : 20 $ SSI");
                return view('client.retrait');
			} else {
			    	$montantnet = request('monttrust');
					//$fraisretrait = $montantnet * 0.05;
					$fraisretrait = $montantnet * InterfaceServiceProvider::GetTaux(auth()->user()->Pack, "RTRUST", "client") / 100;
					$montantvalider = $montantnet + $fraisretrait;
				if ($soldeactuel < $montantvalider) {
					flash("Votre solde est insuffissant pour terminer l'opération!!");
					return view('client.retrait');
				} else {
					
					$soldeac = $soldeactuel - $montantvalider;
					DB::table('avoirs')
						->where('id_user', auth()->user()->id)
						->update([
							'gainespece' => $soldeac
						]);
						
					Retraittrust::create([
						'montant' => $montantnet,
						'reff'=> InterfaceServiceProvider::genunique('retraittrusts'),
						'intituler' => request('intitulertrust'),
						'lien' => request('lientrust'),
						'id_user' => auth()->user()->id
					]);
					
					$compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;

                    //debiter le compte admin de 5% comme frais sur retrait
                    $recu=$compteadmin + $fraisretrait;
    
                    //update la table
                    DB::table('systemadmins')
                            
                            ->update([
                            'compteavoirrecu' => $recu
                            ]);
                            
                    // Argent qui sort
					$compteadminsort = DB::table('systemadmins')->get()[0]->compteavoirsortant;

					$recus=$compteadminsort - $montantvalider;

					DB::table('systemadmins')
							
							->update([
							'compteavoirrecu' => $recus
							]);
					
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantdemander." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
					HistoriqueClient::saveHistorique($message, auth()->user()->id );
					flash($message);
					return view('client.retrait');
				}
			}
		}else{
			flash('Code otp incorrect! ');
			return view('client.retrait');
		}
	}

	// Profil
	public function getprofil()
    {
        $users = DB::table('users')->where('id', auth()->user()->id)->get();
        $data = ['users' => $users];
        return view('client.profil', $data);
    }

    public function setprofil(Request $request)
    {
        request()->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'sexe' => 'required',
            'tel' => 'required' ]);

            DB::table('users')
            ->where('id', auth()->user()->id)
            ->update([
            'nom' => request('nom'),
            'prenom' =>request('prenom'),
            'sexe' =>request('sexe'),
            'tel' =>request('tel') 
            ]);
            
            $users = DB::table('users')
                     ->where('id', auth()->user()->id)
                     ->get();
            $data = ['users' => $users];
        return view('client.profil', $data);    
        
    }

}