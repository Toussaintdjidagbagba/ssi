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
use App\Retraitmtn;
use App\Niveau;
use App\Trace;
use App\Systemadmin; 
use App\Translationuser;
use DB;
use App\Retraitmoov;
use App\Retraitgram;
use App\Retraitperfect;
use App\Models\ServiceModel;
use App\Retraittrust;
use App\Retraitwestern;
use App\Mtnmoov;
use App\NSIA;
use App\Providers\InterfaceServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardClientController extends Controller
{
    
    public function getnonvieass(){
        $data= NSIA::where('libelle',  "NSIAA")->where("idUser", auth()->user()->id)->get();
        return view('client.assnonvie', compact("data"));
    }
    
    public function setnonvieass(Request $request){
        request()->validate([
            'name' => 'required',
            'moteur' => 'required',
            'puissance' => 'required',
            'nbre' => 'required',
        ]);
        
        if ($request->hasFile('carte')) {
            $reference = "NSIANVAA-".date('Ymdhis');
            $ext  = $request->file('carte')->getClientOriginalExtension();
            $namefile = $reference.".".$ext;
            $upload = "nsia/upload/";
            $request->file('carte')->move($upload, $namefile);
               
            $path = $upload.$namefile;

            $add = new NSIA();
            $add->idUser = auth()->user()->id;
            $add->nom = request('name');
            $add->puissance = request('puissance');
            $add->moteur = request('moteur');
            $add->nombre = request('nbre');
            $add->duree = request('duree');
            $add->libelle = "NSIAA";
            $add->doc = $path;
            $add->num = request('tel');
            $add->save();            

            flash('Enregistrement effectué avec succès. Veuillez patienter pour connaitre le montant à payer. ');
        }else
            flash('Veuillez importer la carte grise');

        return Back();
    }
    
    public function setnonvieassval(Request $request){
        $id = request('id');
        
        $demande = DB::table('nsias')->where('id', $id)->first();
        
        $compte = DB::table('avoirs')->where('id_user', $demande->idUser)->first();
        
        if($compte->gainvirtuel >= $demande->montant){
            $compterestant = DB::table('avoirs')->where('id_user', $demande->idUser)->first()->gainvirtuel - $demande->montant; 
                
            DB::table('avoirs')->where('id_user', $demande->idUser)->update(['gainvirtuel' => $compterestant]);
            
            NSIA::where('id', $id)->update(["montantV" => 1]);
            flash('Validation effectué avec succès. ');
            
            $message = "Vous avez effectué une demande de NSIA Automobile d'une montant de ".$demande->montant;

			HistoriqueClient::saveHistorique($message, auth()->user()->id );
        }else{
            flash('Impossible de valider l\'opération! Veuillez vérifier votre compte virtuel et réessayer. ');
        }
        return Back();
    }
    
    public function setretraitssipv(){
        request()->validate([
			'id' => 'required',
			'montant' => 'required|min:0']);
        $pv = DB::table('users')->where('codeperso', request('id'))->first();
        // Verifier l'existance de id
		if (isset($pv->codeperso)) {

            // verifie l'autorisation par otp

			if (session('otprecu') != request('otp')) {
				flash("L'autorisation par OTP incorrect! Veuillez verifier l'OTP envoyé par sur votre mail ou réeassayer.")->error();
				return view('client.retraitssi');
			}
			else
			{
                // Verifier le compte actuel du parrain au traver du montant
				$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
				$montantnet = request('montant');
				//$fraisretrait = $montantnet * 0.03; 
				$fraisretrait = InterfaceServiceProvider::GetTaux(auth()->user()->Pack, "sretraitssi", "client", $montantnet);
				$montantvalider = $montantnet + $fraisretrait;
                //dd($soldeactuel < request('montant'));
				if ($soldeactuel <= $montantvalider) {
					flash("Votre solde est insuffissant!!");
					return view('client.retraitssi');
				} else {
                    // save demande 
                    $savedemande = new ServiceModel();
                    $savedemande->montant = $montantnet;
                    $savedemande->montantpayer = $montantvalider;
                    $savedemande->expediteur = auth()->user()->id;
                    $savedemande->destinataire = $pv->id;
                    $savedemande->nameservice = "retrait";
                    $savedemande->save();
					// save historique envoie

					$message = "Vous avez effectué une demande de retrait de ".request('montant')." SSI de gain espèce auprès du point de vente ". $pv->nomuser." dont l'identifiant est : ".$pv->codeperso.". Frais de retrait ".$fraisretrait.". En attente de confirmation du point de vente.";

					HistoriqueClient::saveHistorique($message, auth()->user()->id );

					// save historique reçu

					$messagedest = "Vous avez reçu une demande de retrait de ".request('montant')." SSI sur gain virtuel de ". auth()->user()->prenom . " 
					" . auth()->user()->nom;

					HistoriqueClient::saveHistorique($messagedest, $pv->id );
					
					flash($message);
					
					return view('client.retraitssi');
				}
			}
		} else {
			flash("L'identifiant n'existe pas")->error();
			return view('client.retraitssi');
		}
        
    }
    
    public function getopp(){
        $allopp = ServiceModel::where('destinataire', auth()->user()->id)->orderby('created_at', 'desc')->get();
        
        return view('client.operationdist', compact('allopp'));
    }
    
    public function delopp(){
        return Back();
    }
    
    public function setopp(){
        $codedemande = request("codes");
        
        $demande = ServiceModel::where('idS', $codedemande)->first();
        
        if($demande->statut == 1)
        {
            flash("La demande a été traité..");
            return Back();
        }
        
        if($demande->nameservice == "achatssi"){
            if($demande->typ == "virtuel"){
                // Recup compte virtuel destinataire
                $comptedest = DB::table('avoirs')->where('id_user', $demande->destinataire)->first()->gainvirtuel - $demande->montant;
                if($comptedest < 0 ){
                    $message = "Le solde du point de vente est insuffisant pour valider la demande d'achat SSI.";
    			    HistoriqueClient::saveHistorique($message, $demande->expediteur );
                    $messageerreur = "Votre compte virtuel est insuffisant pour valider la demande d'achat SSI.";
                    HistoriqueClient::saveHistorique($messageerreur, $demande->destinataire);
                    flash("Votre compte virtuel est insuffisant pour valider la demande d'achat SSI.");
                    return Back();
                }
                DB::table('avoirs')->where('id_user', $demande->destinataire)->update(['gainvirtuel' => $comptedest]);
            }
            if($demande->typ == "espece"){
                // Recup compte virtuel destinataire
                $comptedest = DB::table('avoirs')->where('id_user', $demande->destinataire)->first()->gainespece - $demande->montant;
                if($comptedest < 0 ){
                    $message = "Le solde du point de vente est insuffisant pour valider la demande d'achat SSI.";
    			    HistoriqueClient::saveHistorique($message, $demande->expediteur );
                    $messageerreur = "Votre compte espèce est insuffisant pour valider la demande d'achat SSI.";
                    HistoriqueClient::saveHistorique($messageerreur, $demande->destinataire);
                    flash("Votre compte espèce est insuffisant pour valider la demande d'achat SSI.");
                    return Back();
                }
                DB::table('avoirs')->where('id_user', $demande->destinataire)->update(['gainespece' => $comptedest]);
            }
            // deduire montant du compte
            
            $messagedest = "";
            if($demande->typ == "virtuel"){
                // Recup compte expediteur
                $compteexpe = DB::table('avoirs')->where('id_user', $demande->expediteur)->first()->gainvirtuel + $demande->montant; 
                
                // crediter compte expediteur suivant le type de compte
                DB::table('avoirs')->where('id_user', $demande->expediteur)->update(['gainvirtuel' => $compteexpe]);
                
                $message = "Vous avez reçu ".$demande->montant." SSI sur gain virtuel auprès du point de vente ".auth()->user()->nomuser;
			    HistoriqueClient::saveHistorique($message, $demande->expediteur );
			    
			    $messagedest = "Vous avez valider une demande d'achat de ".request('montant')." SSI sur gain virtuel au ". InterfaceServiceProvider::LibelleFilleul($demande->expediteur);
            }
            if($demande->typ == "espece"){
                // Recup compte expediteur
                $compteexpe = DB::table('avoirs')->where('id_user', $demande->expediteur)->first()->gainespece + $demande->montant; 
                
                // crediter compte expediteur suivant le type de compte
                DB::table('avoirs')->where('id_user', $demande->expediteur)->update(['gainespece' => $compteexpe]);
                
                $message = "Vous avez reçu ".$demande->montant." SSI sur gain espèce auprès du point de vente ".auth()->user()->nomuser;
			    HistoriqueClient::saveHistorique($message, $demande->expediteur );
			    
			    $messagedest = "Vous avez valider une demande d'achat de ".request('montant')." SSI sur gain espèce au ". InterfaceServiceProvider::LibelleFilleul($demande->expediteur);
            }
            
            HistoriqueClient::saveHistorique($messagedest, $demande->destinataire);
            flash($messagedest);
			ServiceModel::where('idS', $codedemande)->update(["statut" => 1, "datevalid" => date("d-m-Y")]);
			return Back();
        }
        
        if($demande->nameservice == "retrait"){
            // Recup solde actuel de expediteur
            $compteexpe = DB::table('avoirs')->where('id_user', $demande->expediteur)->first()->gainespece;
            
            // verif si solde suffisant
            if($compteexpe < $demande->montantpayer){
                flash("Le solde de l'expéditeur est insuffissant!!");
				return Back();
            }else{
                // preleve montant payer du virtuel 
                $restexpe = $compteexpe - $demande->montantpayer;
                DB::table('avoirs')->where('id_user', $demande->expediteur)->update(['gainespece' => $restexpe]);
                
                // verser montant dans virtuel destinataire
                DB::table('avoirs')->where('id_user', $demande->destinataire)->update(['gainespece' => $demande->montant]);
            
                // diff montant et montant payer pour commission
                $fraisretrait = $demande->montantpayer - $demande->montant;
            
                // 0.5% pour commission sur vente destinataire
                $comdest = $fraisretrait / 2;
                $newcom = DB::table('avoirs')->where('id_user', $demande->destinataire)->first()->gaincommissionvente + $comdest;
                DB::table('avoirs')->where('id_user', $demande->destinataire)->update(['gaincommissionvente' => $newcom]);
            
                // 0.5% pour commission admin
                $comadmin = $fraisretrait / 2;
                $compteadmint = DB::table('systemadmins')->get()[0]->compteavoirrecu;
                $recut=$compteadmint + $comadmin;
                DB::table('systemadmins')->update(['compteavoirrecu' => $recut]);
                
                $messagedest = "Vous avez reçu comme commission sur vente ".$comdest." SSI pour l'opération retrait de ".$demande->montant." du client ". InterfaceServiceProvider::LibelleFilleul($demande->expediteur);
            
                HistoriqueClient::saveHistorique($messagedest, $demande->destinataire);
                
                ServiceModel::where('idS', $codedemande)->update(["statut" => 1, "datevalid" => date("d-m-Y")]);
                
                return Back();
            }
            
        }
    }
    
    public function retraitssipv(){
        return view('client.retraitssi');
    }
    
    public function setachatssipv(){
        request()->validate([
			'id' => 'required',
			'montant' => 'required|min:0']);
        $pv = DB::table('users')->where('codeperso', request('id'))->first();
        // Verifier l'existance de id
		if (isset($pv->codeperso)) {

			
			    $lib = "";
                if(request("typ") == 0) $lib = "virtuel"; if(request("typ") == 1) $lib = "espece";
                    // save demande 
                    $savedemande = new ServiceModel();
                    $savedemande->montant = request('montant');
                    $savedemande->expediteur = auth()->user()->id;
                    $savedemande->destinataire = $pv->id;
                    $savedemande->nameservice = "achatssi";
                    $savedemande->typ = $lib;
                    $savedemande->ref = request('ref');
                    $savedemande->save();
					// save historique envoie
					
					$message = "Vous avez effectué une demande d'achat de ".request('montant')." $ SSI sur votre compte gain ".$lib." auprès du point de vente ". $pv->prenom . " 
					" . $pv->nom." dont l'identifiant est : ".$pv->codeperso.". En attente de confirmation du point de vente.";

					HistoriqueClient::saveHistorique($message, auth()->user()->id );

					// save historique reçu

					$messagedest = "Vous avez reçu une demande d'achat de ".request('montant')." $ SSI sur gain ".$lib." de ". auth()->user()->prenom . " ".auth()->user()->nom;

					HistoriqueClient::saveHistorique($messagedest, $pv->id );
					
					flash("Votre demande est en attente de validation.");
					
					return view('client.achatssi');
			
		} else {
			flash("L'identifiant n'existe pas")->error();
			return view('client.achatssi');
		}
    }

    public function achatssipv(){
        return view('client.achatssi');
    }

    public function clientregle()
    {
        return view('client.regle');
    }
    
    public function clientgains()
    {
        $gains = DB::table('avoirs')->select('gainvirtuel', 'gainespece', 'gaincommissionvente', 'id_user')->where('id_user', auth()->user()->id)->get();

        // mail
        // code
        $code = "";
        $data = ['gains' => $gains, 'redirect' => "gains", 'xxx' => $code];
        return view('client.gain', $data);
    }

    public function clientdashboard()
    {
        $type = auth()->user()->type;

        if ($type == "client") {
            $gains = DB::table('avoirs')->select('gainvirtuel', 'gainespece', 'gaincommissionvente', 'compv', 'cvpv', 'id_user')->where('id_user', auth()->user()->id)->get();

            $users = DB::table('users')
                     ->where('parrain', auth()->user()->codeunique)
                     ->where('users.compteactive', '!=', 'sup');
            
            $nc = count(DB::table('users')->where('parrain', auth()->user()->codeunique)->where('users.compteactive', '!=', 'sup')->where('users.Pack', 1)->get());
            
            $nv = count(DB::table('users')->where('parrain', auth()->user()->codeunique)->where('users.compteactive', '!=', 'sup')->where('users.Pack', 2)->get());
                     
            $users = $users->orderBy('created_at', 'DESC')->get();

            $filleuladmin = DB::table('niveaux')->select('nombredefilleul', 'id_user')->where('id_user', auth()->user()->id)->orderBy('id_etape', 'DESC')->get();

            $etapeactuel = DB::table('avoirs')->select('etapeActuel')->where('id_user', auth()->user()->id)->get()[0]->etapeActuel;

            $data = ['etape' => $etapeactuel, 'gains' => $gains, 'filleuls' => $users ,'filleuladmin' => $filleuladmin, "nv" => $nv, "nc"=>$nc];
            return view('client.dashboard', $data);
        }
        
    }
    
    public function filleulclient()
    {
        $type = auth()->user()->type;

        if ($type == "client") {
            $users = DB::table('users')
                     ->where('parrain', auth()->user()->codeunique)
                     ->where('users.compteactive', '!=', 'sup')
                     ->where('users.Pack', 1)
                     ->orderBy('created_at', 'DESC')
                     ->get();
            return view('client.listclient', compact('users'));
        }
        
    }
    
    public function filleulvendeur()
    {
        $type = auth()->user()->type;

        if ($type == "client") {
            $users = DB::table('users')
                     ->where('parrain', auth()->user()->codeunique)
                     ->where('users.compteactive', '!=', 'sup')
                     ->where('users.Pack', 2)
                     ->orderBy('created_at', 'DESC')
                     ->get();
            return view('client.listvendeur', compact('users'));
        }
        
    }
    
    public function sedeconnecter(Request $request)
    {
        auth()->logout();
        return redirect('/connexion');
    }
    
    public function logout() {
      auth()->logout();
        return redirect('/connexion');
    }
    
	// Mise à jour 
	public function updatepv()
	{
		$allavoirs = DB::table('avoirs')->get();
		foreach ($allavoirs as $value) {
		    /*$data = DB::table('avoirs')->where('id_user', $value->id_user)->first();
			$add = new Trace();
			$add->contenu = json_encode($data);
			$add->save(); */
			
			$n = floor(floor($value->compv) / 10) * 10;
			DB::table('avoirs')->where('id_user', $value->id_user)->update([
				"cvpv" => $n
			]);
		} 
		/*
		
		$allusers = DB::table('users')->where('compteactive', '!=', 'oui' )->get();
		//dd($allusers);
		foreach ($allusers as $value) {
			$data = DB::table('users')->where('id', $value->id)->first();
			$add = new Trace();
			$add->contenu = json_encode($data);
			$add->save();
			DB::table('users')->where('id', $value->id)->delete();
		}*/
	}

    // Changement de packs
	public function setpack()
	{
		if (isset(auth()->user()->id)) {
		    
		    $valeurpack1 = DB::table('packs')->where('id', request('packnew'))->first()->valeur;
		    
		    $valeurpack2 = DB::table('packs')->where('id', auth()->user()->Pack)->first()->valeur;

			$valeurpack = $valeurpack1 - $valeurpack2;

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
				/*
                    DB::table('systemadmins')
                       ->update([
                            'compteavoirrecu' => $valeurpack
                            ]); */

                DB::table('users')
					->where('id', auth()->user()->id)
					->update([
						'Pack' => request('packnew')
					]);
					
				// Pourcentage
				    $pa = DB::table('users')->select('parrain')->where('id', auth()->user()->id)->get()[0]->parrain;

                    $id_pa = DB::table('users')->select('id')->where('codeunique', $pa)->get()[0]->id;

                    $pourcentageespece = InterfaceServiceProvider::PourcentageFilleulEspece();

                    $pourcentagevirtuel = InterfaceServiceProvider::PourcentageFilleulVirtuel();

                    // Calcule de la valeur en %

                    $gain_espece = $valeurpack * ($pourcentageespece / 100);

                    $gain_virtuel = $valeurpack * ($pourcentagevirtuel / 100);

                    // alors le parrain beneficie de ces valeurs

                    $gainsvirtuel_actuel = InterfaceServiceProvider::VirtuelActuel($id_pa);

                    $gainsvirtuel_actuel_mise_a_jour = $gainsvirtuel_actuel + $gain_virtuel;
                    DB::table('avoirs')
                    ->where('id_user', $id_pa)
                    ->update(['gainvirtuel' => $gainsvirtuel_actuel_mise_a_jour]);

                    $gaincommissionvente_actuel = InterfaceServiceProvider::GainCommissionVente_Actuel($id_pa);

                    $gaincommissionvente_actuel_mise_a_jour = $gaincommissionvente_actuel + $gain_espece;
                    DB::table('avoirs')
                    ->where('id_user', $id_pa)
                    ->update(['gaincommissionvente' => $gaincommissionvente_actuel_mise_a_jour]);
                    
                    // Compte de l'administrateur
                    $gainsadmin_actuel = InterfaceServiceProvider::AdminCompteRecu();

                    $gainsadmin_actuel_mise_a_jour = $gainsadmin_actuel + $valeurpack;
                    DB::table('systemadmins')->update(['compteavoirrecu' => $gainsadmin_actuel_mise_a_jour]);
                    

                $packancien = DB::table('packs')->where('id', auth()->user()->Pack)->first()->libelle;

                $packnouveau =  DB::table('packs')->where('id', request('packnew'))->first()->libelle;

                $message = "Vous êtes passé de ".$packancien." au ".$packnouveau." avec succès.";

                HistoriqueClient::saveHistorique($message, auth()->user()->id );

                flash("Vous devez vous reconnecté pour actualisé votre compte.");
            	return Back();
			}
			# code...
		}else{
			flash("Vous devez être connecté pour effectué l'action")->error();

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
	    $idd = auth()->user()->id;
		$etape = DB::table('avoirs')->select('etapeActuel')->where('id_user', auth()->user()->id)->first()->etapeActuel;
		return view('client.mesnature', compact('etape', 'idd'));
	}

    public function gettransfertgv()
	{
		return view('client.transfertgv');
	}
	
	public function settransfertgv(Request $request)
	{
		request()->validate([
			'id' => 'required',
			'montant' => 'required|min:0']);

        // Verifier l'existance de id
		if (isset(DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso)) {

            // verifie l'autorisation par otp

			if (session('otprecu') != request('otp')) {
				flash("L'autorisation par OTP incorrect! Veuillez verifier l'OTP envoyé par sur votre mail ou réeassayer.")->error();

				return view('client.transfertgv');
			}
			else
			{
            // Verifier le compte actuel du parrain au traver du montant

				$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
				$montantnet = request('montant');
				//$fraisretrait = $montantnet * 0.03; 
				$fraisretrait = $montantnet * InterfaceServiceProvider::GetTaux(auth()->user()->Pack, "TC", "client") / 100;
				$montantvalider = $montantnet + $fraisretrait;
                //dd($soldeactuel < request('montant'));
				if ($soldeactuel <= $montantvalider) {
					flash("Votre solde est insuffissant!!");
					
					return view('client.transfertgv');
				} else {
                    // Alors update compte expediteur : decrementer
					$soldeac = $soldeactuel - $montantvalider;
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

                // Alors update compte destinataire : incrementer
					$iddest = DB::table('users')->where('codeperso', request('id'))->get()[0]->id;
					$soldeactuel = DB::table('avoirs')->where('id_user', $iddest)->get()[0]->gainvirtuel;
					$soldeac = $soldeactuel + $montantnet;
					DB::table('avoirs')
					->where('id_user', $iddest)
					->update([
						'gainvirtuel' => $soldeac
					]);

					//InterfaceServiceProvider::inderminiterparrain(auth()->user()->id, $fraisretrait, auth()->user()->Pack, "TC", "client");

					// save historique envoie

					$message = "Vous avez transféré ".request('montant')." $ SSI de gain virutel à ". DB::table('users')->where('codeperso', request('id'))->get()[0]->prenom . " 
					" . DB::table('users')->where('codeperso', request('id'))->get()[0]->nom." dont l'identifiant est :
					".DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso.". Frais du transfert ".$fraisretrait.". Transfert effectué avec succès.";

					HistoriqueClient::saveHistorique($message, auth()->user()->id );

					// save historique reçu

					$messagedest = "Vous avez reçu ".request('montant')." $ SSI sur gain virutel de ". auth()->user()->prenom . " 
					" . auth()->user()->nom;

					HistoriqueClient::saveHistorique($messagedest, $iddest );
					
					flash($message);
					
					return view('client.transfertgv');
				}
			}
		} else {
			flash("L'identifiant n'existe pas")->error();
			return view('client.transfertgv');
		}
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

			if ($montantvalider < 0) {
				flash("Le montant de votre transaction est inférieur à 0 $ SSI ");
				
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
				
				// Mise à jour du PV
				if(floor($montantvalider / 10) > 0){
				    $cpv = DB::table('avoirs')->where('id_user', auth()->user()->id)->first()->cvpv;
				    $cpv += (floor($montantvalider / 10) * 10); 
				    DB::table('avoirs')->where('id_user', auth()->user()->id)->update([
				        "cvpv" => $cpv
				    ]);
				    
				    InterfaceServiceProvider::NiveauControl(auth()->user()->id);
				}

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
			
			if($soldeactuel < 10)
			{
				flash("Votre solde n'atteint pas le seuil minimum!. Minimal : 10 SSI");
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
							
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantnet." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
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
			
			if($soldeactuel < 10)
			{
				flash("Votre solde n'atteint pas le seuil minimum! Minimal : 10 SSI");
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
					
							
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantnet." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
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
			
			if($soldeactuel < 10)
			{
				flash("Votre solde n'atteint pas le seuil minimum! Minimal : 10 SSI");
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
							
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantnet." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
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
			
			if($soldeactuel < 10)
			{
				flash("Votre solde n'atteint pas le seuil minimum! Minimal : 10 SSI");
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
					
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantnet." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
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
			
			if($soldeactuel < 10){
				flash("Votre solde n'atteint pas le seuil minimum! Minimal : 10 SSI");
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
					
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantnet." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
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
			
			if($soldeactuel < 10){
				flash("Votre solde n'atteint pas le seuil minimum! Minimal : 10 SSI");
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
					
					$message = "Félicitation!!. Vous avez effectué un retrait de ".$montantnet." $ SSI de votre compte. Frais sur retrait : ".$fraisretrait." $ SSI. Vous recevez un message de confirmation dans un instant.";
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


           
            	if ($request->hasFile('phot')) {

		            $namefile = 'P_'.request('nom').'_'.request('prenom').'_'.auth()->user()->codeperso;
		            $extavatar  = $request->file('phot')->getClientOriginalExtension();
		            $upload = "photo/profil/";
		            $request->file('phot')->move($upload, $namefile.'.'.$extavatar);
		            
		            DB::table('users')
                    ->where('id', auth()->user()->id)
                    ->update([
                    'photo' => $upload.$namefile.'.'.$extavatar,
                    ]);
		            
		            
            	}
            	
            	if ($request->hasFile('filiden')) {

		            $namefile = 'I_'.request('nom').'_'.request('prenom').'_'.auth()->user()->codeperso;
		            $extavatar  = $request->file('filiden')->getClientOriginalExtension();
		            $upload = "photo/identite/";
		            $request->file('filiden')->move($upload, $namefile.'.'.$extavatar);
		            
		            DB::table('users')
                    ->where('id', auth()->user()->id)
                    ->update([
                        'identite' => $upload.$namefile.'.'.$extavatar,
                    ]);
		            
		            
            	}
		            
            DB::table('users')
            ->where('id', auth()->user()->id)
            ->update([
            'nom' => request('nom'),
            'prenom' =>request('prenom'),
            'sexe' =>request('sexe'),
            'tel' =>request('tel'),
            'numidentite' => request('numide')
            ]);
            
            $users = DB::table('users')
                     ->where('id', auth()->user()->id)
                     ->get();
            $data = ['users' => $users];
            
            flash('Profil mise à jour avec succès.');
        return view('client.profil', $data);    
        
    }

    // Formation
    public function clientformation()
    {
        // recuperation de la base de donnée
        $formation = DB::table('mesformations')->select('id','titre', 'doc', 'cout', 'id_user')->get();
        //dd("kk");
        $data = ['formations' => $formation];
        return view('client.formation', $data);
        
    }

    public function clientformationdelete()
    {
        DB::table('mesformations')->where('id', request('id'))->delete();

        flash("Formation supprimer avec  succès!!!");
        return Back();
        
    }

}