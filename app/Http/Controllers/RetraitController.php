<?php

namespace App\Http\Controllers;

use App\HistoriqueClient;
use App\Historique;
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
use App\Equipe;
use App\Systemadmin;
use App\Retraitmtn;
use App\Translationuser;
use App\Retraitmoov;
use App\Retraitgram;
use App\Retraitperfect;
use App\Retraittrust;
use App\Retraitwestern;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RetraitController extends Controller
{
	public function getconventiontoespece()
	{
        $data = ['otp' => "OTP"];
        return view('client.ctoe', $data);
	}
	
	public function getcvtoespece()
	{
		$data = ['otp' => "OTP"];
        return view('client.vtoe', $data);
	}

	public function gencodece()
	{
		// mail
        $otp = rand(100000, 999999);

        $message = "Code OTP Générer : ".$otp;

        $destinataire = auth()->user()->email;

        RetraitController::EnvoieMail($destinataire, $message, "Accès", "");
        flash('Code OTP envoyé sur votre boite mail !!!');
        $data = ['otp' => $otp];
        return view('client.ctoe', $data);
	}
	
	public function gencodeve()
	{
		// mail
        $otp = rand(100000, 999999);

        $message = "Code OTP Générer : ".$otp;

        $destinataire = auth()->user()->email;

        RetraitController::EnvoieMail($destinataire, $message, "Accès", "");
        flash('Code OTP envoyé sur votre boite mail !!!');
        $data = ['otp' => $otp];
        return view('client.vtoe', $data);
	}

	public function cvtoespece(Request $request)
	{
		request()->validate([
            'montant' => 'required|min:0',
            'otp' => 'required']);
            
        if (request('otprecu') == "OTP")
        {
        	flash("Veuillez générer OTP et saisir l'OTP envoyé par sur votre mail.")->error();
        	$data = ['otp' => "OTP"];
        	return view('client.vtoe', $data);
        }
        else
        {
            // verifie l'autorisation par otp

            if (request('otprecu') != request('otp')) {
                flash("L'autorisation par OTP incorrect! Veuillez verifier l'OTP envoyé par sur votre mail ou réeassayer.")->error();
                $data = ['otp' => "OTP"];
        		return view('client.vtoe', $data);
            }
            else
            {

            $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gaincommissionvente;
            
            if ($soldeactuel <= request('montant')) {
                flash("Votre solde est insuffissant!!");
                $data = ['otp' => "OTP"];
        		return view('client.vtoe', $data);
            } else {
                // Alors update compte expediteur : decrementer
                $soldeac = $soldeactuel - request('montant');
                DB::table('avoirs')
                    ->where('id_user', auth()->user()->id)
                    ->update([
                    'gaincommissionvente' => $soldeac
                    ]);

                // Alors update compte destinataire : incrementer
                $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
                $soldeac = $soldeactuel + request('montant');
                DB::table('avoirs')
                    ->where('id_user', auth()->user()->id)
                    ->update([
                        'gainvirtuel' => $soldeac
                        ]);
                        
                $message = "Vous avez transféré ".request('montant')." $ SSI de votre compte commission sur vente dans votre compte virtuel.";
                HistoriqueClient::saveHistorique($message, auth()->user()->id );
                flash($message);
                $data = ['otp' => "OTP"];
        		return view('client.vtoe', $data);
            }
            }
       }
	}
	
	public function conventiontoespece(Request $request)
	{
		request()->validate([
            'montant' => 'required|min:0',
            'otp' => 'required']);
            
        if (request('otprecu') == "OTP")
        {
        	flash("Veuillez générer OTP et saisir l'OTP envoyé par sur votre mail.")->error();
        	$data = ['otp' => "OTP"];
        	return view('client.ctoe', $data);
        }
        else
        {
            // verifie l'autorisation par otp

            if (request('otprecu') != request('otp')) {
                flash("L'autorisation par OTP incorrect! Veuillez verifier l'OTP envoyé par sur votre mail ou réeassayer.")->error();
                $data = ['otp' => "OTP"];
        		return view('client.ctoe', $data);
            }
            else
            {

            $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gaincommissionvente;
            //dd($soldeactuel > request('montant') && request('montant') < 10);
            if ($soldeactuel < request('montant') ){
                flash("Votre solde est insuffissant");
                $data = ['otp' => "OTP"];
        		return view('client.ctoe', $data);
            }else 
            if (request('montant') < 10) {
                flash("Le montant de votre transaction est inférieur à 10 $ SSI ");
                $data = ['otp' => "OTP"];
        		return view('client.ctoe', $data);
            } else {
                // Alors update compte expediteur : decrementer
                $soldeac = $soldeactuel - request('montant');
                DB::table('avoirs')
                    ->where('id_user', auth()->user()->id)
                    ->update([
                    'gaincommissionvente' => $soldeac
                    ]);

                // Alors update compte destinataire : incrementer
                $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
                $soldeac = $soldeactuel + request('montant');
                DB::table('avoirs')
                    ->where('id_user', auth()->user()->id)
                    ->update([
                        'gainespece' => $soldeac
                        ]);
                        
                $message = "Vous avez transféré ".request('montant')." $ SSI dans votre compte espèce.";
                HistoriqueClient::saveHistorique($message, auth()->user()->id );
                flash($message);
                $data = ['otp' => "OTP"];
        		return view('client.ctoe', $data);
            }
            }
       }
	}
	
	public function getretrait()
	{
		$otp = rand(100000, 999999);

        $message = "Code OTP Générer : ".$otp;

        $destinataire = auth()->user()->email;

        RetraitController::EnvoieMail($destinataire, $message, "Accès", "");
		$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
        $data = ['otp' => $otp, 'max' => $max];
		flash("Veuillez cliquer sur le moyen de retrait de votre choix et renseignez les informations qui suit. Frais sur retrait : 5%");
		flash('Veuillez entrer le code OTP envoyé sur votre boite mail pour valider !!!');
		return view('client.retrait', $data);
	}
	
	public function EnvoieMail($destinataire, $message, $sujet, $objet)
    {

		setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
		date_default_timezone_set('Africa/Porto-Novo');

		$JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
		$HEURE = date("H:i"); // Heure d'envoi de l'email

		$Subject = "$sujet - $JOUR $HEURE";
		
		SendMail::sendmailIndexController($destinataire, $Subject, $message, $objet);
	}
	
	public function genunique($table)
	{
		$rand = rand(1000,9999);
		$existance = DB::table($table)->where('reff', $rand)->get();
		if(isset($existance[0]->reff))
			RetraitController::genunique($table);
		else
			return $rand;
	}
	
	public function setretraitmtn(Request $request)
	{
		if(request('otpmtnsend') == request('otpmtn') ){
			
			$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			
			if($soldeactuel <= 20)
			{
				flash("Votre solde n'atteint pas le seuil minimum!");
                $max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
				$data = ['otp' => request('otpmtnsend'), 'max' => $max];
				return view('client.retrait', $data);
			}
			else {
			    
			    $montantnet = request('montantmtn');
				$fraisretrait = $montantnet * 0.05;
				$montantvalider = $montantnet + $fraisretrait;
            
				if ($soldeactuel < $montantvalider) {
					flash("Votre solde est insuffissant pour terminer l'opération!!");
					$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
					$data = ['otp' => request('otpmtnsend'), 'max' => $max];
					return view('client.retrait', $data);
				} else {
					
					// Alors update compte expediteur : decrementer
					$soldeac = $soldeactuel - $montantvalider;
					DB::table('avoirs')
						->where('id_user', auth()->user()->id)
						->update([
						'gainespece' => $soldeac
						]);
							
					$montantdemander = request('montantmtn');
					
											
					Retraitmtn::create([
						'montant' => $montantdemander,
						'reff'=> RetraitController::genunique('retraitmtns'),
						'numero' => request('numerom'),
						'intitule' => request('nomm'),
						'id_user' => auth()->user()->id
					]);
					
					$compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

                    //debiter le compte admin de 5% comme frais sur retrait
                    $recu=$compteadmin + $fraisretrait;
    
                    //update la table
                    DB::table('systemadmins')
                            ->where('id_AdminPrincipal', 1)
                            ->update([
                            'compteavoirrecu' => $recu
                            ]);
                            
                    // Argent qui sort
					$compteadminsort = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirsortant;

					$recus=$compteadminsort - $montantvalider;

					DB::table('systemadmins')
							->where('id_AdminPrincipal', 1)
							->update([
							'compteavoirrecu' => $recus
							]);
							
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantdemander." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
					HistoriqueClient::saveHistorique($message, auth()->user()->id );
					flash($message);
					$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
					$data = ['otp' => request('otpmtnsend'), 'max' => $max];
					return view('client.retrait', $data);
				}
			}
		}else{
			flash('Code otp incorrect! ');
			$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			$data = ['otp' => request('otpmtnsend'), 'max' => $max];
			return view('client.retrait', $data);
		}
	}
	
	public function setretraitmoov(Request $request)
	{
		if(request('otpmoovsend') == request('otpmoov') ){
			
			$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			
			if($soldeactuel <= 20)
			{
				flash("Votre solde n'atteint pas le seuil minimum!");
                $max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
				$data = ['otp' => request('otpmoovsend'), 'max' => $max];
				return view('client.retrait', $data);
			}
			else {
			    $montantnet = request('montantmoov');
					$fraisretrait = $montantnet * 0.05;
					$montantvalider = $montantnet + $fraisretrait;
            
				if ($soldeactuel < $montantvalider) {
					flash("Votre solde est insuffissant pour terminer l'opération!!");
					$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
					$data = ['otp' => request('otpmoovsend'), 'max' => $max];
					return view('client.retrait', $data);
				} else {
					
					$soldeac = $soldeactuel - $montantvalider;
					DB::table('avoirs')
						->where('id_user', auth()->user()->id)
						->update([
						'gainespece' => $soldeac
						]);

					
					$montantdemander = request('montantmoov');	
					
					Retraitmoov::create([
						'montant' => $montantdemander,
						'reff'=> RetraitController::genunique('retraitmoovs'),
						'numero' => request('numeromoov'),
						'intitule' => request('nommoov'),
						'id_user' => auth()->user()->id
					]);
					
					
					$compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

                    //debiter le compte admin de 5% comme frais sur retrait
                    $recu=$compteadmin + $fraisretrait;
    
                    //update la table
                    DB::table('systemadmins')
                            ->where('id_AdminPrincipal', 1)
                            ->update([
                            'compteavoirrecu' => $recu
                            ]);
                            
                    // Argent qui sort
					$compteadminsort = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirsortant;

					$recus=$compteadminsort - $montantvalider;

					DB::table('systemadmins')
							->where('id_AdminPrincipal', 1)
							->update([
							'compteavoirrecu' => $recus
							]);
					
							
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantdemander." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
					HistoriqueClient::saveHistorique($message, auth()->user()->id );
					flash($message);
					$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
					$data = ['otp' => request('otpmoovsend'), 'max' => $max];
					return view('client.retrait', $data);
				}
			}
		}else{
			flash('Code otp incorrect! ');
			$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			$data = ['otp' => request('otpmoovsend'), 'max' => $max];
			return view('client.retrait', $data);
		}
	}
	
	public function setretraitwestern(Request $request)
	{
		if(request('otpwesternsend') == request('otpwestern') ){
			
			$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			
			if($soldeactuel <= 20)
			{
				flash("Votre solde n'atteint pas le seuil minimum!");
                $max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
				$data = ['otp' => request('otpwesternsend'), 'max' => $max];
				return view('client.retrait', $data);
			}
			else {
                $montantnet = request('montwest');
					$fraisretrait = $montantnet * 0.05;
					$montantvalider = $montantnet + $fraisretrait;	
				if ($soldeactuel < $montantvalider) {
					flash("Votre solde est insuffissant pour terminer l'opération!!");
					$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
					$data = ['otp' => request('otpwesternsend'), 'max' => $max];
					return view('client.retrait', $data);
				} else {
					
					$soldeac = $soldeactuel - $montantvalider;
					DB::table('avoirs')
						->where('id_user', auth()->user()->id)
						->update([
						'gainespece' => $soldeac
						]);

					$montantdemander = request('montwest');					
					Retraitwestern::create([
						'montant' => $montantdemander,
						'reff'=> RetraitController::genunique('retraitwesterns'),
						'nom' => request('nomwest'),
						'prenom' => request('prenomwest'),
						'adresse' => request('addwest'),
						'ville' => request('villewest'),
						'pays' => request('payswest'),
						'motif' => request('motifwest'),
						'id_user' => auth()->user()->id
					]);
					
					$compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

                    //debiter le compte admin de 5% comme frais sur retrait
                    $recu=$compteadmin + $fraisretrait;
    
                    //update la table
                    DB::table('systemadmins')
                            ->where('id_AdminPrincipal', 1)
                            ->update([
                            'compteavoirrecu' => $recu
                            ]);
                            
                    // Argent qui sort
					$compteadminsort = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirsortant;

					$recus=$compteadminsort - $montantvalider;

					DB::table('systemadmins')
							->where('id_AdminPrincipal', 1)
							->update([
							'compteavoirrecu' => $recus
							]);
							
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantdemander." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
					HistoriqueClient::saveHistorique($message, auth()->user()->id );
					flash($message);
					$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
					$data = ['otp' => request('otpwesternsend'), 'max' => $max];
					return view('client.retrait', $data);
				}
			}
		}else{
			flash('Code otp incorrect! ');
			$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			$data = ['otp' => request('otpwesternsend'), 'max' => $max];
			return view('client.retrait', $data);
		}
	}

	public function setretraitgram(Request $request)
	{
		if(request('otpgramsend') == request('otpgram') ){
			
			$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			
			if($soldeactuel <= 20)
			{
				flash("Votre solde n'atteint pas le seuil minimum!");
                $max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
				$data = ['otp' => request('otpgramsend'), 'max' => $max];
				return view('client.retrait', $data);
			}
			else {
                $montantnet = request('montgram');
					$fraisretrait = $montantnet * 0.05;
					$montantvalider = $montantnet + $fraisretrait;
				if ($soldeactuel < $montantvalider) {
					flash("Votre solde est insuffissant pour terminer l'opération!!");
					$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
					$data = ['otp' => request('otpgramsend'), 'max' => $max];
					return view('client.retrait', $data);
				} else {
					
					$soldeac = $soldeactuel - $montantvalider;
					DB::table('avoirs')
						->where('id_user', auth()->user()->id)
						->update([
						'gainespece' => $soldeac
						]);

					
					$montantdemander = request('montgram');
											
					Retraitgram::create([
						'montant' => $montantdemander,
						'reff'=> RetraitController::genunique('retraitgrams'),
						'nom' => request('nomgram'),
						'prenom' => request('prenomgram'),
						'adresse' => request('addgram'),
						'ville' => request('villegram'),
						'pays' => request('paysgram'),
						'motif' => request('motifgram'),
						'id_user' => auth()->user()->id
					]);
					
					$compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

                    //debiter le compte admin de 5% comme frais sur retrait
                    $recu=$compteadmin + $fraisretrait;
    
                    //update la table
                    DB::table('systemadmins')
                            ->where('id_AdminPrincipal', 1)
                            ->update([
                            'compteavoirrecu' => $recu
                            ]);
                            
                    // Argent qui sort
					$compteadminsort = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirsortant;

					$recus=$compteadminsort - $montantvalider;

					DB::table('systemadmins')
							->where('id_AdminPrincipal', 1)
							->update([
							'compteavoirrecu' => $recus
							]);
					
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantdemander." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
					HistoriqueClient::saveHistorique($message, auth()->user()->id );
					flash($message);
					$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
					$data = ['otp' => request('otpgramsend'), 'max' => $max];
					return view('client.retrait', $data);
				}
			}
		}else{
			flash('Code otp incorrect! ');
			$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			$data = ['otp' => request('otpgramsend'), 'max' => $max];
			return view('client.retrait', $data);
		}
	}

	public function setretraitperfect(Request $request)
	{
		if(request('otpperfectsend') == request('otpperfect') ){
			
			$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			
			if($soldeactuel <= 20){
				flash("Votre solde n'atteint pas le seuil minimum!");
                $max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
				$data = ['otp' => request('otpperfectsend'), 'max' => $max];
				return view('client.retrait', $data);
			} else {
			    $montantnet = request('montperfect');
					$fraisretrait = $montantnet * 0.05;
					$montantvalider = $montantnet + $fraisretrait;
				if ($soldeactuel < $montantvalider) {
					flash("Votre solde est insuffissant pour terminer l'opération!!");
					$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
					$data = ['otp' => request('otpperfectsend'), 'max' => $max];
					return view('client.retrait', $data);
				} else {
					
					$soldeac = $soldeactuel - $montantvalider;
					DB::table('avoirs')
						->where('id_user', auth()->user()->id)
						->update([
							'gainespece' => $soldeac
						]);

					$montantdemander = request('montperfect');						
					Retraitperfect::create([
						'montant' => $montantdemander,
						'reff'=> RetraitController::genunique('retraitperfects'),
						'intituler' => request('intitulerperfect'),
						'lien' => request('lienperfect'),
						'id_user' => auth()->user()->id
					]);
					
					
					
					$compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

                    //debiter le compte admin de 5% comme frais sur retrait
                    $recu=$compteadmin + $fraisretrait;
    
                    //update la table
                    DB::table('systemadmins')
                            ->where('id_AdminPrincipal', 1)
                            ->update([
                            'compteavoirrecu' => $recu
                            ]);
                            
                    // Argent qui sort
					$compteadminsort = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirsortant;

					$recus=$compteadminsort - $montantvalider;

					DB::table('systemadmins')
							->where('id_AdminPrincipal', 1)
							->update([
							'compteavoirrecu' => $recus
							]);
					
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantdemander." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
					HistoriqueClient::saveHistorique($message, auth()->user()->id );
					flash($message);
					$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
					$data = ['otp' => request('otpperfectsend'), 'max' => $max];
					return view('client.retrait', $data);
				}
			}
		}else{
			flash('Code otp incorrect! ');
			$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			$data = ['otp' => request('otpperfectsend'), 'max' => $max];
			return view('client.retrait', $data);
		}
	}
	
	public function setretraittrust(Request $request)
	{
		if(request('otptrustsend') == request('otptrust') ){
			
			$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			
			if($soldeactuel <= 20){
				flash("Votre solde n'atteint pas le seuil minimum!");
                $max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
				$data = ['otp' => request('otptrustsend'), 'max' => $max];
				return view('client.retrait', $data);
			} else {
			    	$montantnet = request('monttrust');
					$fraisretrait = $montantnet * 0.05;
					$montantvalider = $montantnet + $fraisretrait;
				if ($soldeactuel < $montantvalider) {
					flash("Votre solde est insuffissant pour terminer l'opération!!");
					$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
					$data = ['otp' => request('otptrustsend'), 'max' => $max];
					return view('client.retrait', $data);
				} else {
					
					$soldeac = $soldeactuel - $montantvalider;
					DB::table('avoirs')
						->where('id_user', auth()->user()->id)
						->update([
							'gainespece' => $soldeac
						]);

					$montantdemander = request('monttrust');						
					Retraittrust::create([
						'montant' => $montantdemander,
						'reff'=> RetraitController::genunique('retraittrusts'),
						'intituler' => request('intitulertrust'),
						'lien' => request('lientrust'),
						'id_user' => auth()->user()->id
					]);
					
					$compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

                    //debiter le compte admin de 5% comme frais sur retrait
                    $recu=$compteadmin + $fraisretrait;
    
                    //update la table
                    DB::table('systemadmins')
                            ->where('id_AdminPrincipal', 1)
                            ->update([
                            'compteavoirrecu' => $recu
                            ]);
                            
                    // Argent qui sort
					$compteadminsort = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirsortant;

					$recus=$compteadminsort - $montantvalider;

					DB::table('systemadmins')
							->where('id_AdminPrincipal', 1)
							->update([
							'compteavoirrecu' => $recus
							]);
					
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantdemander." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
					HistoriqueClient::saveHistorique($message, auth()->user()->id );
					flash($message);
					$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
					$data = ['otp' => request('otptrustsend'), 'max' => $max];
					return view('client.retrait', $data);
				}
			}
		}else{
			flash('Code otp incorrect! ');
			$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
			$data = ['otp' => request('otptrustsend'), 'max' => $max];
			return view('client.retrait', $data);
		}
	}
	
	public function getretraitmtn()
    {
        $de = DB::table('retraitmtns')
			->join('users', 'retraitmtns.id_user', '=', 'users.id')

			->select('reff', 'intitule', 'numero', 'montant', 'codeperso', 'datevalider', 'statut', 'retraitmtns.created_at')
			->where('statut', '!=', 'sup')
			->orderBy('retraitmtns.id', 'DESC')->get();
        $data = ['demandes' => $de];
        return view('admin.retrait.DemandeRetraireMTN', $data);
    }

    public function deletemtn(Request $request){ 
        
        DB::table('retraitmtns')
                    ->where('reff', request("ref"))
                    ->update([
                    'statut' => "sup"
                    ]);
        
        flash("Demande de retrait MTN supprimer avec succès! "); //Filleul supprimer avec succès!
        return Back();
    }
	
	public function getretraitmoov()
    {
        $de = DB::table('retraitmoovs')
			->join('users', 'retraitmoovs.id_user', '=', 'users.id')
			->select('reff', 'intitule', 'numero', 'montant', 'codeperso', 'datevalider', 'statut', 'retraitmoovs.created_at')
			->where('statut', '!=', 'sup')
			->orderBy('retraitmoovs.id', 'DESC')->get();
        $data = ['demandes' => $de];
        return view('admin.retrait.DemandeRetraireMOOV', $data);
    }

    public function deletemoov(Request $request){ 
        
        DB::table('retraitmoovs')
                    ->where('reff', request("ref"))
                    ->update([
                    'statut' => "sup"
                    ]);
        
        flash("Demande de retrait MOOV supprimer avec succès! "); //Filleul supprimer avec succès!
        return Back();
    }
	
	public function getretraitwestern()
	{
		$de = DB::table('retraitwesterns')
			->join('users', 'retraitwesterns.id_user', '=', 'users.id')
			->select('reff', 'retraitwesterns.nom', 'retraitwesterns.prenom', 'retraitwesterns.motif', 'retraitwesterns.adresse','retraitwesterns.ville','retraitwesterns.pays', 'montant', 'codeperso', 'datevalider', 'statut', 'retraitwesterns.created_at')
			->where('statut', '!=', 'sup')
			->orderBy('retraitwesterns.id', 'DESC')->get();
        $data = ['demandes' => $de];
        return view('admin.retrait.DemandeRetraireWESTERN', $data);
	}
	
	public function deletewesterns(Request $request){ 
        
        DB::table('retraitwesterns')
                    ->where('reff', request("ref"))
                    ->update([
                    'statut' => "sup"
                    ]);
        
        flash("Demande de retrait WESTERN supprimer avec succès! "); //Filleul supprimer avec succès!
        return Back();
    }

	public function getretraitgram()
	{ 
		$de = DB::table('retraitgrams')
			->join('users', 'retraitgrams.id_user', '=', 'users.id')
			->select('reff', 'retraitgrams.nom', 'retraitgrams.prenom', 'retraitgrams.motif', 'retraitgrams.adresse','retraitgrams.ville','retraitgrams.pays', 'montant', 'codeperso', 'datevalider', 'statut', 'retraitgrams.created_at')
			->where('statut', '!=', 'sup')
			->orderBy('retraitgrams.id', 'DESC')->get();
        $data = ['demandes' => $de];
        return view('admin.retrait.DemandeRetraireGRAM', $data);
	}

	public function deletegrams(Request $request){ 
        
        DB::table('retraitgrams')
                    ->where('reff', request("ref"))
                    ->update([
                    'statut' => "sup"
                    ]);
        
        flash("Demande de retrait MONEY GRAM supprimer avec succès! "); //Filleul supprimer avec succès!
        return Back();
    }
	
	public function getretraitperfect()
	{
		$de = DB::table('retraitperfects')
			->join('users', 'retraitperfects.id_user', '=', 'users.id')
			->select('reff', 'intituler', 'lien', 'montant', 'codeperso', 'datevalider', 'statut', 'retraitperfects.created_at')
			->where('statut', '!=', 'sup')
			->orderBy('retraitperfects.id', 'DESC')->get();
        $data = ['demandes' => $de];
        return view('admin.retrait.DemandeRetrairePERFECT', $data);
	}
	
	public function deleteperfects(Request $request){ 
        
        DB::table('retraitperfects')
                    ->where('reff', request("ref"))
                    ->update([
                    'statut' => "sup"
                    ]);
        
        flash("Demande de retrait PERFECT MONEY supprimer avec succès! "); //Filleul supprimer avec succès!
        return Back();
    }

	public function getretraittrust()
	{
		$de = DB::table('retraittrusts')
			->join('users', 'retraittrusts.id_user', '=', 'users.id')
			->select('reff', 'intituler', 'lien', 'montant', 'codeperso', 'datevalider', 'statut', 'retraittrusts.created_at')
			->where('statut', '!=', 'sup')
			->orderBy('retraittrusts.id', 'DESC')->get();
        $data = ['demandes' => $de];
        return view('admin.retrait.DemandeRetraireTRUST', $data);
	}

	public function deletetrust(Request $request){ 
        
        DB::table('retraittrusts')
                    ->where('reff', request("ref"))
                    ->update([
                    'statut' => "sup"
                    ]);
        
        flash("Demande de retrait TRUST WALLET supprimer avec succès! "); //Filleul supprimer avec succès!
        return Back();
    }
	

	public function getrecumtn()
	{
		$demandes = DB::table('retraitmtns')->where('reff', request('refrecu'))->get()[0];
        $data = ['demande' => $demandes];
        return view('admin.formrecuretraire.mtn', $data);
	}
	
	public function getrecumoov()
	{
		$demandes = DB::table('retraitmoovs')->where('reff', request('refrecu'))->get()[0];
        $data = ['demande' => $demandes];
        return view('admin.formrecuretraire.moov', $data);
	}
	
	public function getrecuwestern()
	{
		$demandes = DB::table('retraitwesterns')->where('reff', request('refrecu'))->get()[0];
        $data = ['demande' => $demandes];
        return view('admin.formrecuretraire.western', $data);
	}
	
	public function getrecugram()
	{
		$demandes = DB::table('retraitgrams')->where('reff', request('refrecu'))->get()[0];
        $data = ['demande' => $demandes];
        return view('admin.formrecuretraire.gram', $data);
	}
	
	public function getrecuperfect()
	{
		$demandes = DB::table('retraitperfects')->where('reff', request('refrecu'))->get()[0];
        $data = ['demande' => $demandes];
        return view('admin.formrecuretraire.perfect', $data);
	}
	
	public function getrecutrust()
	{
		$demandes = DB::table('retraittrusts')->where('reff', request('refrecu'))->get()[0];
        $data = ['demande' => $demandes];
        return view('admin.formrecuretraire.trust', $data);
	}
	
	public function setrecumtn(Request $request)
	{
	    setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');

		if(isset(DB::table('retraitmtns')->where('reff', request('reff'))->where('statut', 'oui')->get()[0]))
            {flash('Recu déjà envoyer.');

        	return Back();}
        
        else{

		// Mise à jour dans la base de donnee
        DB::table('retraitmtns')
                ->where('reff', request('reff'))
                ->update([
                'datevalider' => strftime('%A %d %B %Y à %H:%M'),
                'statut' => 'oui'
                ]);

        $client = DB::table('retraitmtns')
						->join('users', 'retraitmtns.id_user', '=', 'users.id')
						->where('reff', request('reff'))
						->get()[0];
		$destinataire = $client->email;
        $sujet = "RECU SSI";

        $objet = "Retrait Mobile Money MTN";
		
		$JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
        $HEURE = date("H:i"); // Heure d'envoi de l'email

        $Subject = "$sujet - $JOUR $HEURE";

        $data = [ 
			'objet' => $objet, 
            'reff' => $client->reff, 
            'montant' => $client->montant, 
            'intitule' => $client->intitule, 
            'numero' =>  $client->numero, 
            'datevalider' => $client->datevalider, 
            'montantf' => RetraitController::conversionfcfa($client->montant)
        ];
        
        SendMail::sendretrait($destinataire, $Subject, $data, "admin.mailrecuretrait.mtnmail");
		$message_reception = "Vous avez reçu un mail comportant le reçu de votre retrait sur compte MTN dont le montant est ".$client->montant." $ SSI ";
        HistoriqueClient::saveHistorique($message_reception, $client->id_user);
		flash("Reçu envoyé avec succes!!");
        
        return Back();
    	}
	}
	
	public function setrecumoov(Request $request)
	{
		setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');

        if(isset(DB::table('retraitmoovs')->where('reff', request('reff'))->where('statut', 'oui')->get()[0]))
            {flash('Recu déjà envoyer.');

        	return Back();}
        
        else{
        
		// Mise à jour dans la base de donnee
        DB::table('retraitmoovs')
                ->where('reff', request('reff'))
                ->update([
                'datevalider' => strftime('%A %d %B %Y à %H:%M'),
                'statut' => 'oui'
                ]);

        $client = DB::table('retraitmoovs')
						->join('users', 'retraitmoovs.id_user', '=', 'users.id')
						->where('reff', request('reff'))
						->get()[0];
		$destinataire = $client->email;
        $sujet = "RECU SSI";

        $objet = "Retrait FLOOZ MONEY MOOV";
		
		$JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
        $HEURE = date("H:i"); // Heure d'envoi de l'email

        $Subject = "$sujet - $JOUR $HEURE";

        $data = [ 
			'objet' => $objet, 
            'reff' => $client->reff, 
            'montant' => $client->montant, 
            'intitule' => $client->intitule, 
            'numero' =>  $client->numero, 
            'datevalider' => $client->datevalider, 
            'montantf' => RetraitController::conversionfcfa($client->montant)
        ];
        
        SendMail::sendretrait($destinataire, $Subject, $data, "admin.mailrecuretrait.moovmail");
		$message_reception = "Vous avez reçu un mail comportant le reçu de votre retrait sur compte MOOV dont le montant est ".$client->montant." $ SSI ";
        HistoriqueClient::saveHistorique($message_reception, $client->id_user);
		flash("Reçu envoyé avec succes!!");
        
        return Back(); }
	}
	
	public function setrecuwestern(Request $request)
	{
		setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');
        
        if(isset(DB::table('retraitwesterns')->where('reff', request('reff'))->where('statut', 'oui')->get()[0]))
            {flash('Recu déjà envoyer.');

        	return Back();}
        
        else{
        

		// Mise à jour dans la base de donnee
        DB::table('retraitwesterns')
                ->where('reff', request('reff'))
                ->update([
                'datevalider' => strftime('%A %d %B %Y à %H:%M'),
                'statut' => 'oui'
                ]);

        $client = DB::table('retraitwesterns')
						->join('users', 'retraitwesterns.id_user', '=', 'users.id')
						->where('reff', request('reff'))
						->get()[0];
		$destinataire = $client->email;
        $sujet = "RECU SSI";

        $objet = "Retrait WESTERN UNION";
		
		$JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
        $HEURE = date("H:i"); // Heure d'envoi de l'email

        $Subject = "$sujet - $JOUR $HEURE";

        $data = [ 
			'objet' => $objet, 
            'reff' => $client->reff, 
            'montant' => $client->montant, 
            'nom' => $client->nom, 
            'prenom' =>  $client->prenom,
			'adresse' =>  $client->adresse,
			'ville' =>  $client->ville,
			'pays' =>  $client->pays,
			'motif' =>  $client->motif,
            'datevalider' => $client->datevalider, 
            'montantf' => RetraitController::conversionfcfa($client->montant)
        ];
        
        SendMail::sendretrait($destinataire, $Subject, $data, "admin.mailrecuretrait.westernmail");
		$message_reception = "Vous avez reçu un mail comportant le reçu de votre retrait sur compte WESTERN UNION dont le montant est ".$client->montant." $ SSI ";
        HistoriqueClient::saveHistorique($message_reception, $client->id_user);
		flash("Reçu envoyé avec succes!!");
        
        return Back(); }
	}
	
	public function setrecugram(Request $request)
	{
		setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');
        
        if(isset(DB::table('retraitgrams')->where('reff', request('reff'))->where('statut', 'oui')->get()[0]))
            {flash('Recu déjà envoyer.');

        	return Back();}
        
        else{
		// Mise à jour dans la base de donnee
        DB::table('retraitgrams')
                ->where('reff', request('reff'))
                ->update([
                'datevalider' => strftime('%A %d %B %Y à %H:%M'),
                'statut' => 'oui'
                ]);

        $client = DB::table('retraitgrams')
						->join('users', 'retraitgrams.id_user', '=', 'users.id')
						->where('reff', request('reff'))
						->get()[0];
		$destinataire = $client->email;
        $sujet = "RECU SSI";

        $objet = "Retrait MONEY GRAM";
		
		$JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
        $HEURE = date("H:i"); // Heure d'envoi de l'email

        $Subject = "$sujet - $JOUR $HEURE";

        $data = [ 
			'objet' => $objet, 
            'reff' => $client->reff, 
            'montant' => $client->montant, 
            'nom' => $client->nom, 
            'prenom' =>  $client->prenom,
			'adresse' =>  $client->adresse,
			'ville' =>  $client->ville,
			'pays' =>  $client->pays,
			'motif' =>  $client->motif,
            'datevalider' => $client->datevalider, 
            'montantf' => RetraitController::conversionfcfa($client->montant)
        ];
        
        SendMail::sendretrait($destinataire, $Subject, $data, "admin.mailrecuretrait.grammail");
		$message_reception = "Vous avez reçu un mail comportant le reçu de votre retrait sur compte MONEY GRAM dont le montant est ".$client->montant." $ SSI ";
        HistoriqueClient::saveHistorique($message_reception, $client->id_user);
		flash("Reçu envoyé avec succes!!");
        
        return Back();
	}
	}
	
	public function setrecuperfect(Request $request)
	{
		setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');
     if(isset(DB::table('retraitperfects')->where('reff', request('reff'))->where('statut', 'oui')->get()[0]))
            {flash('Recu déjà envoyer.');

        	return Back();}
        
        else{   
		// Mise à jour dans la base de donnee
        DB::table('retraitperfects')
                ->where('reff', request('reff'))
                ->update([
                'datevalider' => strftime('%A %d %B %Y à %H:%M'),
                'statut' => 'oui'
                ]);

        $client = DB::table('retraitperfects')
						->join('users', 'retraitperfects.id_user', '=', 'users.id')
						->where('reff', request('reff'))
						->get()[0];
		$destinataire = $client->email;
        $sujet = "RECU SSI";

        $objet = "Retrait PERFECT MONEY";
		
		$JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
        $HEURE = date("H:i"); // Heure d'envoi de l'email

        $Subject = "$sujet - $JOUR $HEURE";

        $data = [ 
			'objet' => $objet, 
            'reff' => $client->reff, 
            'montant' => $client->montant, 
            'intituler' => $client->intituler, 
            'lien' =>  $client->lien,
            'datevalider' => $client->datevalider, 
            'montantf' => RetraitController::conversionfcfa($client->montant)
        ];
        
        SendMail::sendretrait($destinataire, $Subject, $data, "admin.mailrecuretrait.perfectmail");
		$message_reception = "Vous avez reçu un mail comportant le reçu de votre retrait sur compte PERFECT MONEY dont le montant est ".$client->montant." $ SSI ";
        HistoriqueClient::saveHistorique($message_reception, $client->id_user);
		flash("Reçu envoyé avec succes!!");
        
        return Back();
	}
	}
	
	public function setrecutrust(Request $request)
	{
		setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');
        
        if(isset(DB::table('retraittrusts')->where('reff', request('reff'))->where('statut', 'oui')->get()[0]))
            {flash('Recu déjà envoyer.');

        	return Back();}
        
        else{  
		// Mise à jour dans la base de donnee
        DB::table('retraittrusts')
                ->where('reff', request('reff'))
                ->update([
                'datevalider' => strftime('%A %d %B %Y à %H:%M'),
                'statut' => 'oui'
                ]);

        $client = DB::table('retraittrusts')
						->join('users', 'retraittrusts.id_user', '=', 'users.id')
						->where('reff', request('reff'))
						->get()[0];
		$destinataire = $client->email;
        $sujet = "RECU SSI";

        $objet = "Retrait TRUST WALLET";
		
		$JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
        $HEURE = date("H:i"); // Heure d'envoi de l'email

        $Subject = "$sujet - $JOUR $HEURE";

        $data = [ 
			'objet' => $objet, 
            'reff' => $client->reff, 
            'montant' => $client->montant, 
            'intituler' => $client->intituler, 
            'lien' =>  $client->lien,
            'datevalider' => $client->datevalider, 
            'montantf' => RetraitController::conversionfcfa($client->montant)
        ];
        
        SendMail::sendretrait($destinataire, $Subject, $data, "admin.mailrecuretrait.trustmail");
		$message_reception = "Vous avez reçu un mail comportant le reçu de votre retrait sur compte TRUST WALLET dont le montant est ".$client->montant." $ SSI ";
        HistoriqueClient::saveHistorique($message_reception, $client->id_user);
		flash("Reçu envoyé avec succes!!");
        
        return Back(); }
	}
	
	public function conversionfcfa($value)
    { return $value * 500;}
}

?>