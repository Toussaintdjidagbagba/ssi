<?php

namespace App\Http\Controllers;

use App\Providers\InterfaceServiceProvider;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\HistoriqueClient;
use App\Achatssi;
use App\Retraitvisa as Visa;
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
use App\Systemadmin;
use App\Translationuser;
use App\Soneb;
use App\Sbeeconventiel;
use App\Sbeecarte;
use App\Canal;
use App\Longrich;
use App\Health;
use App\Agence;
use App\Trace;
use App\Mtnmoov;
use App\NSIA;

class ServiceController extends Controller 
{
    public function getnsiagservice(){
        // NSIAG
        $data = NSIA::where('libelle', "NSIAG")->get();
        return view('services.nsiavie', compact('data'));
    }
    
    public function setnsiagservice(Request $request){
            
            NSIA::where('id', request('id'))->update(['Statut' => "v", 'DateValider'=>date('d-m-Y')]);
            
            
            $fil = NSIA::where('id', request('id'))->first();
            $dest = DB::table('users')->where('id', $fil->idUser)->first();
            $destinataire = $dest->email;
            
            $message = "La demande NSIA Assurance GBODJEKWE a été effectué avec succès. Veuillez vous connectez à l'application NSIA VIE en utilisant votre numéro de téléphone.";
            InterfaceServiceProvider::EnvoieMail($destinataire, $message, "NSIA GBODJEKWE", "Résultat");
            
            // Commission gagner
            $comv = $fil->montant * InterfaceServiceProvider::GetTaux($dest->Pack, "NSIAGB", "client") / 100;

            $soldeactuel_comv = DB::table('avoirs')->where('id_user', $fil->idUser)->first();
            $soldeac_comv = $soldeactuel_comv->gaincommissionvente + $comv;
            $compv = $soldeactuel_comv->compv + $comv;
    
            DB::table('avoirs')
                ->where('id_user', $fil->idUser)
                ->update([
                   'gaincommissionvente' => $soldeac_comv,
                   'compv' => $compv
                 ]);
    
            InterfaceServiceProvider::inderminiterparrain($dest->id, $comv, $fil->montant, $dest->Pack, "NSIAGB", "client");
            
            flash('Demande valider avec succès.');
       
        return Back();
    }
    
    // Service NSIA
    
    public function getnsiaservice()
    {
        $data = NSIA::where('libelle', "NSIAA")->orderBy('created_at', 'DESC')->get();
        return view('services.nsia', compact('data'));
    }

    public function deletensia(Request $request){ 
        
        $ex = DB::table('nsias')->where('id', request("ref"))->first();
        $nom = $ex->nom;
        // save 
        $addt = new Trace();
        $addt->contenu = json_encode($ex);
        $addt->action = session("utilisateur")->id;
        $addt->save();
        $ex = DB::table('nsias')->where('id', request("ref"))->delete();
        flash("NSIA Automobile : demande de ".$nom." supprimer avec succès! "); 
        return Back();
    }
    
    public function deletensiavie(Request $request){ 
        
        $ex = DB::table('nsias')->where('id', request("ref"))->first();
        $nom = $ex->num;
        // save 
        $addt = new Trace();
        $addt->contenu = json_encode($ex);
        $addt->action = session("utilisateur")->id;
        $addt->save();
        $ex = DB::table('nsias')->where('id', request("ref"))->delete();
        flash("NSIA Automobile : demande de ".$nom." supprimer avec succès! "); 
        return Back();
    }
    
    public function vautonsia(Request $request){
        
        if ($request->hasFile('fich')) {
            $reference = "NSIANVAAR-".date('Ymdhis');
            $ext  = $request->file('fich')->getClientOriginalExtension();
            $namefile = $reference.".".$ext;
            $upload = "nsia/uploadadmin/";
            $request->file('fich')->move($upload, $namefile);
               
            $path = $upload.$namefile;
            
            NSIA::where('id', request('id'))->update(["docfinal" => $path, 'Statut' => "v", 'DateValider'=>date('d-m-Y')]);
            
            
            $fil = NSIA::where('id', request('id'))->first();
            $dest = DB::table('users')->where('id', $fil->idUser)->first();
            $destinataire = $dest->email;
            
            $message = "La demande NSIA Assurance a été effectué avec succès. Veuillez vous connectez pour télécharger les documents.";
            InterfaceServiceProvider::EnvoieMail($destinataire, $message, "NSIA Automobile", "Résultat");
            
            // Commission gagner
            $comv = $fil->montant * InterfaceServiceProvider::GetTaux($dest->Pack, "NSIAAUTO", "client") / 100;

            $soldeactuel_comv = DB::table('avoirs')->where('id_user', $fil->idUser)->first();
            $soldeac_comv = $soldeactuel_comv->gaincommissionvente + $comv;
            $compv = $soldeactuel_comv->compv + $comv;
    
            DB::table('avoirs')
                ->where('id_user', $fil->idUser)
                ->update([
                   'gaincommissionvente' => $soldeac_comv,
                   'compv' => $compv
                 ]);
    
            InterfaceServiceProvider::inderminiterparrain($dest->id, $comv, $fil->montant, $dest->Pack, "NSIA", "client");
            
            flash('Demande valider avec succès.');
        
        }else
            flash('Veuillez importer les fichiers.');
        // Validation de admin automobile
        return Back();
    }
    
    public function mautonsia(){
        DB::table('nsias')->where('id', request("id"))->update(["montant" => request('montant')]);
        
        $fil = NSIA::where('id', request('id'))->first();
        $dest = DB::table('users')->where('id', $fil->idUser)->first();
        $destinataire = $dest->email;
        $message = "Montant à payer pour l'assurance automobile est de : ".request('montant')." SSI. Veuilez-vous connectez à la plateforme pour confirmer pour demande.";
        InterfaceServiceProvider::EnvoieMail($destinataire, $message, "NSIA Automobile", "Montant à payer pour l'assurance automobile.");
        
        HistoriqueClient::saveHistorique($message, $fil->idUser);
        flash('Montant saisir avec succès');
        return Back();
    }

    public function setnsia()
    {
        setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');

        $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
        $HEURE = date("H:i:s"); // Heure d'envoi de l'email

        $datevalider = "$JOUR à $HEURE";
        
        //dd($datevalider);
        
        // Mise à jour dans la base de donnee
        DB::table('mtnmoovs')
                    ->where('id', request('id'))
                    ->update([
                        'Statut' => 'oui', 
                        'DateValider' => $datevalider
                    ]);
        $d = DB::table('mtnmoovs')->where('id', request('id'))->first();

        $user = DB::table('users')->where('id', $d->IdUser)->first();
        // Commission sur vente
        if($d->libelle == "Crédit P3")
            $comv = $d->MontantPayer * InterfaceServiceProvider::GetTaux($user->Pack, "SMTNP3", "client") / 100;
        else
            if($d->type == "depot")
                $comv = $d->MontantPayer * InterfaceServiceProvider::GetTaux($user->Pack, "SMTNDEPOT", "client") / 100;
            else
                if($d->libelle == "NSIAG")
                    $comv = InterfaceServiceProvider::GetTaux($user->Pack, "SNSIAG", "client");
                else
                    $comv = $d->MontantPayer * InterfaceServiceProvider::GetTaux($user->Pack, "SMTNAUTRE", "client") / 100;

       $soldeactuel_comv = DB::table('avoirs')->where('id_user', $d->IdUser)->first();
       $soldeac_comv = $soldeactuel_comv->gaincommissionvente + $comv;
       $compv = $soldeactuel_comv->compv + $comv;

        DB::table('avoirs')
            ->where('id_user', $d->IdUser)
            ->update([
               'gaincommissionvente' => $soldeac_comv,
               'compv' => $compv
             ]);

        InterfaceServiceProvider::inderminiterparrain($user->id, $comv, $d->MontantPayer, $user->Pack, "SMTNAUTRE", "client");
                        
        $message_reception = "Votre demande d'achat de forfait MTN/MOOV dont le montant est ".$d->MontantPayer." $ SSI est validé ";
        HistoriqueClient::saveHistorique($message_reception, $d->IdUser);
        flash("Reçu envoyé avec succès.");
        return Back();
    }
    
    
    
    /////////////// à supprimer après mise à jour
    
    public function setachat(Request $request)
    {
        if (!auth()->guest()) {
            
            Achatssi::create([
                'codeperso' => request('id'), 
                'montant' => request('montant'),
                'referencepaye' => request('ref'),
                'libellecompte' => request('compte')
            ]);
            $libellecompte = "";
            if(request('compte') == 1) $libellecompte = "Compte Espèce";
            if(request('compte') == 2) $libellecompte = "Compte Virtuel";
            $message = "Vous avez demandé un achat de ".request('montant')." $ SSI sur votre ".$libellecompte.". Votre demande est en attente de confirmation..";
            HistoriqueClient::saveHistorique($message, auth()->user()->id );
            
            flash('Votre demande est en attente de confirmation..');
            
            return Back();
		}
		else
		{
		   flash("Vous devez être connecté pour effectuée l'achat de $ SSI. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur Achat $ SSI");
	       return redirect('/connexion');
		}
    }
    
    public function setretraitvisa(Request $request)
    {
        if (!auth()->guest()) {
            $resultat = auth()->attempt([
                'id' => auth()->user()->id,
                'password' => request('pass')
            ]);
            if($resultat){
    			$soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
    			
    			if($soldeactuel <= 20)
    			{
    				flash("Votre solde n'atteint pas le seuil minimum de 20 $ SSI !");
                    return Back();
    			}
    			else {
    			    
    			    $montantnet = request('montant');
    				$fraisretrait = $montantnet * 1 / 100;
    				$montantvalider = $montantnet + $fraisretrait;
                
    				if ($soldeactuel < $montantvalider) {
    					flash("Votre solde est insuffissant pour terminer l'opération!!");
    					return Back();
    				} else {
    					
    					// Alors update compte expediteur : decrementer
    					$soldeac = $soldeactuel - $montantvalider;
    					DB::table('avoirs')
    						->where('id_user', auth()->user()->id)
    						->update([
    						'gainespece' => $soldeac
    						]);
    							
    					$montantdemander = request('montant');
    		            
    		            $add = new Visa();
                        $add->codeperso = request('id');
                        $add->intitule = request('intituler'); // Intitulé de la carte
                        $add->nom = request('name'); // Nom et prénom de la carte
                        $add->idcarte = request('identifiant'); //Identifiant de la carte
                        $add->mont = request('montant'); //Montant à crédité en $ SSI
                        $add->save();
                        
                        $message = "Vous avez demandé un retrait de ".request('montant')." $ SSI sur votre ".request('intituler')."
                        dont l'identifiant est ".request('identifiant')." auquel est associé ".request('name').". Votre demande est en attente de confirmation..";
                        HistoriqueClient::saveHistorique($message, auth()->user()->id );
                        
    					        
                        // Argent qui sort
    					$compteadminsort = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirsortant;
    
    					$recus=$compteadminsort - $montantvalider;
    
    					DB::table('systemadmins')
    							->where('id_AdminPrincipal', 1)
    							->update([
    							'compteavoirrecu' => $recus
    							]);
    							
    					
    					flash($message);
    				    return Back();
    				}
    			}
    		}else{
    			flash('Mot de passe incorrect!');
    			return Back();
    		}
		}
		else
		{
		   flash("Vous devez être connecté pour effectuée le retrait. Si vous ne possédez pas de compte, inscrivez-vous");
	       return redirect('/connexion');
		}
    }
    
    public function conversionfcfa($value)
    { return $value * 500;}
    
    /////////////////////////////////////////////


    // Achat
    public function setdeleteachat(Request $request){

        DB::table('achatssis')
        ->where('id', request("id"))
        ->update([
            'statut' => 3
        ]);
        
        flash("Demande d'achat $ SSI supprimer avec succès! "); //Filleul supprimer avec succès!
        return Back();
    }
    
    public function getdemandeachat()
    {
        $achats = DB::table('achatssis')->orderByRaw("statut DESC, id DESC ")->where('statut', '!=', 3)->paginate(20);
        return view('admin.dashboardachatgain', compact('achats'));
    }
    
    public function setservirachat(Request $request)
    {

        $id = request('id');
        
        $achat = DB::table('achatssis')->where('id', $id)->get()[0]; 
        $codeperso = $achat->codeperso;
        //dd(DB::table('users')->where('codeperso', $codeperso)->get()[0]);
        if(isset(DB::table('users')->where('codeperso', $codeperso)->get()[0]))
        {

            $user = DB::table('users')->where('codeperso', $codeperso)->get()[0];
            
            // crédit le compte client
            // 1 pour gain espèce 
            // 2 pour gain virtuel
            setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
            date_default_timezone_set('Africa/Porto-Novo');
            if(DB::table('achatssis')->where('id', $id)->first()->statut == 0) {
                flash("L'achat a été déjà confirmer.");
                return Back();
            }else{

                if($achat->libellecompte == 1)
                {
                    $soldeactuel = DB::table('avoirs')->where('id_user', $user->id)->get()[0]->gainespece;
                    $soldeac = $soldeactuel + $achat->montant;
                    DB::table('avoirs')
                    ->where('id_user', $user->id)
                    ->update([
                        'gainespece' => $soldeac,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
                
                if($achat->libellecompte == 2)
                {
                    $soldeactuel = DB::table('avoirs')->where('id_user', $user->id)->get()[0]->gainvirtuel;
                    $soldeac = $soldeactuel + $achat->montant;
                    DB::table('avoirs')
                    ->where('id_user', $user->id)
                    ->update([
                        'gainvirtuel' => $soldeac, 
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
                

                DB::table('achatssis')
                ->where('id', $id)
                ->update([
                    'statut' => 0,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                
                setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                date_default_timezone_set('Africa/Porto-Novo');

                $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
                $HEURE = date("H:i"); // Heure d'envoi de l'email

                $Subject = "Achat de gain SSI - $JOUR $HEURE";
                
                $data = [
                    'prenom' => $user->prenom, 
                    'nom' => $user->nom, 
                    'montant' => $achat->montant ];
                    $destinataire = $user->email;  
                    $message_reception = "Vous avez reçu un mail comportant le reçu de Achat de GAIN SSI dont le montant est ".$achat->montant." $ SSI ";
                    HistoriqueClient::saveHistorique($message_reception, $user->id);
                    SendMail::sendachat($destinataire, $Subject, $data);
                    flash("Un message de validation a été envoyer");
                    return Back();
                }

            }else{
                flash("L'utilisateur qui effectue la demande n'existe pas")->error();
                return Back();
            }
    }

        public function setechecachat(Request $request)
        {

            $id = request('id');

            $achat = DB::table('achatssis')->where('id', $id)->get()[0]; 
            $codeperso = $achat->codeperso;
            //dd(DB::table('users')->where('codeperso', $codeperso)->get()[0]);
            if(isset(DB::table('users')->where('codeperso', $codeperso)->get()[0]))
            {

                $user = DB::table('users')->where('codeperso', $codeperso)->get()[0];

                setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                date_default_timezone_set('Africa/Porto-Novo');

            $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
            $HEURE = date("H:i"); // Heure d'envoi de l'email

            $Subject = "Achat de gain SSI - $JOUR $HEURE";
            
            $data = [
                'prenom' => $user->prenom, 
                'nom' => $user->nom ];
                $destinataire = $user->email;

                SendMail::sendachatechec($destinataire, $Subject, $data);
                flash("Un message d'échec a été envoyer");
                return Back();

            }else{
                flash("L'utilisateur qui effectue la demande n'existe pas")->error();
                return Back();
            }
        }

    // Visa
        public function getdemandevisa()
        {
            $visas = DB::table('retraitvisas')->orderByRaw("statut DESC, id DESC ")->where('statut', '!=', 3)->paginate(20);
            return view('admin.demandevisa', compact('visas'));
        }

        public function setdeletevisa(Request $request){

            DB::table('retraitvisas')
            ->where('id', request("id"))
            ->update([
                'statut' => 3
            ]);

            flash("Demande de retrait visa supprimer avec succès! ");
            return Back();
        }

        public function setservirvisa(Request $request)
        {

            $id = request('id');

            $visa = DB::table('retraitvisas')->where('id', $id)->get()[0]; 
            $codeperso = $visa->codeperso;
            //dd(DB::table('users')->where('codeperso', $codeperso)->get()[0]);
            if(isset(DB::table('users')->where('codeperso', $codeperso)->get()[0]))
            {

                $user = DB::table('users')->where('codeperso', $codeperso)->get()[0];

                
                DB::table('retraitvisas') 
                ->where('id', $id)
                ->update([
                    'statut' => 0,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                $comv = $visa->FraisSSI * InterfaceServiceProvider::GetTaux($user->Pack, "SDVISA", "client") / 100;

                $soldeactuel_comv = DB::table('avoirs')->where('id_user', $user->id)->first();
                $soldeac_comv = $soldeactuel_comv->gaincommissionvente + $comv;
                
                $pvcom = $soldeactuel_comv->compv + $comv;
                DB::table('avoirs')
                    ->where('id_user', $user->id)
                    ->update([
                      'gaincommissionvente' => $soldeac_comv,
                      'compv' => $pvcom
                    ]); 

                
                // Débiter le compte de admin des taux sortant
                $comv_admin = $visa->FraisSSI * InterfaceServiceProvider::GetTaux($user->Pack, "SDVISA", "client") / 100;
               $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirsortant;
               $recu=$compteadmin + $comv_admin;

                //update la table
                DB::table('systemadmins')
                        ->update([
                        'compteavoirsortant' => $recu
                        ]); 
                
                InterfaceServiceProvider::inderminiterparrain($user->id, $comv, $visa->mont, $user->Pack, "SDVISA", "client");

                setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                date_default_timezone_set('Africa/Porto-Novo');

                $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
                $HEURE = date("H:i"); // Heure d'envoi de l'email

                $Subject = "Dépôt sur carte VISA SSI - $JOUR $HEURE";
                
                $data = [
                    'prenom' => $user->prenom, 
                    'nom' => $user->nom, 
                    'montant' => $visa->mont,
                    'intitule' => $visa->intitule,
                    'nomcarte' => $visa->nom,
                    'idcarte' => $visa->idcarte,
                    'montantf' => InterfaceServiceProvider::conversionfcfa($visa->mont),
                    'datevalider' => $JOUR.' à '.$HEURE
                ];
                $destinataire = $user->email;  
                $message_reception = "Vous avez reçu un mail comportant le reçu de dépôt sur carte visa dont le montant est ".$visa->mont." $ SSI ";
                HistoriqueClient::saveHistorique($message_reception, $user->id);
                SendMail::sendretraitvisa($destinataire, $Subject, $data);
                flash("Un message de validation a été envoyer");
                return Back();

            }else{
            flash("L'utilisateur qui effectue la demande n'existe pas")->error();
            return Back();
            }
        }
    
    public function setechecvisa(Request $request)
    {

        $id = request('id');
        
        $visa = DB::table('retraitvisas')->where('id', $id)->get()[0]; 
        $codeperso = $visa->codeperso;
        //dd(DB::table('users')->where('codeperso', $codeperso)->get()[0]);
        if(isset(DB::table('users')->where('codeperso', $codeperso)->get()[0]))
        {

            $user = DB::table('users')->where('codeperso', $codeperso)->get()[0];
            
            setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
            date_default_timezone_set('Africa/Porto-Novo');

            $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
            $HEURE = date("H:i"); // Heure d'envoi de l'email

            $Subject = "Retrait sur Carte visa SSI - $JOUR $HEURE";
            
            $data = [
                'prenom' => $user->prenom, 
                'nom' => $user->nom ];
                $destinataire = $user->email;

                SendMail::sendechecretraitvisa($destinataire, $Subject, $data);
                flash("Un message d'échec a été envoyer");
                return Back();
            }else{
                flash("L'utilisateur qui effectue la demande n'existe pas")->error();
                return Back();
            }
        }
    

    // Canal +
        public function getcanalservice()
        {
            $de = DB::table('canals')->where('Statut', '!=', 'sup')->orderBy('RefRecu', 'DESC')->get();
            $data = ['demandes' => $de];
            return view('services.DemandeCanal', $data);
        }

        public function getcanalrecu()
        {
            $demandes = DB::table('canals')->where('RefRecu', request('refrecu'))->get()[0];
            $data = ['demande' => $demandes];
            return view('formrecu.formrecucanal', $data);
        }

        public function setcanalrecu(Request $request)
        {

            if(isset(DB::table('canals')->where('RefRecu', request('refrecu'))->where('Statut', 'oui')->get()[0]))
            {
                flash('Recu déjà envoyer.');
                return Back();
            }
            else
            {
                request()->validate([
                    'reglement' => 'required|string',
                    'dateespire' => 'required|date',
                ]);

                setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                date_default_timezone_set('Africa/Porto-Novo');

                $data = [
                    'nom' => request('nom'),
                    'prenom' => request('prenom'),
                    'CodePersoUser' => request('CodePersoUser'),
                    'refrecu' => request('refrecu'),
                    'Numerocarte' => request('Numerocarte'),
                    'WhatsApp' => request('WhatsApp'),
                    'montant' => request('montant'),
                    'mail' => request('mail'),
                    'Choisirformule' => request('Choisirformule'),
                    'Dureenmois' => request('Dureenmois'),
                    'dateespire' => request('dateespire'),
                    'totale' => request('montant'),
                    'daterecu' => strftime('%A %d %B %Y à %H:%M'),
                    'modereglement' => request('modereglement'),
                    'libelle' => request('libelle'),
                    'solderestant' => request('solde'),
                    'reglementnum' => request('reglement')
                ];

                // Mise à jour dans la base de donnee
                DB::table('canals')
                ->where('RefRecu', request('refrecu'))
                ->update([
                    'Nom' => request('nom'),
                    'Prenom' => request('prenom'),
                    'daterecu' => strftime('%A %d %B %Y à %H:%M'),
                    'modereglement' => request('modereglement'),
                    'libelle' => request('libelle'),
                    'solderestant' => request('solde'),
                    'reglementnum' => request('reglement'),
                    'dateespire' => request('dateespire'),
                    'Statut' => 'oui'
                ]);

                $d = DB::table('canals')->where('RefRecu', request('refrecu'))->get()[0];

                $user = DB::table('users')->where('id', $d->IdUser)->first();

                // Commission sur vente
                //$comv = request('montant') * 2 / 100;
                $comv = request('montant') * InterfaceServiceProvider::GetTaux($user->Pack, "SCANAL", "client") / 100;

                $soldeactuel_comv = DB::table('avoirs')->where('id_user', $d->IdUser)->first();
                $soldeac_comv = $soldeactuel_comv->gaincommissionvente + $comv;
                
                $pvcom = $soldeactuel_comv->compv + $comv;
                DB::table('avoirs')
                ->where('id_user', $d->IdUser)
                ->update([
                    'gaincommissionvente' => $soldeac_comv,
                    'compv' => $pvcom
                ]);

                InterfaceServiceProvider::inderminiterparrain($user->id, $comv, request('montant'), $user->Pack, "SCANAL", "client");

                $destinataire = request('mail');

                $sujet = "FACTURE SSI";

                $objet = "SSI : Facture ".request('libelle');

                // Envoie de recu
                InterfaceServiceProvider::EnvoieRecuCANAL(
                    $destinataire, 
                    $sujet, 
                    $objet,
                    request('nom'),
                    request('prenom'),
                    request('CodePersoUser'),
                    request('refrecu'),
                    request('Numerocarte'),
                    request('WhatsApp'),
                    request('montant'),
                    request('mail'),
                    request('Choisirformule'),
                    request('dateespire'),
                    request('montant'),
                    strftime('%A %d %B %Y à %H:%M'),
                    request('modereglement'),
                    request('libelle'),
                    request('solde'),
                    request('Dureenmois'),
                    request('reglement')
                );

                $message_reception = "Vous avez reçu un mail comportant le reçu de CANAL+ dont le montant est ".request('montant')." $ SSI ";
                HistoriqueClient::saveHistorique($message_reception, $d->IdUser);

                flash('Recu envoyer avec succès!!!');

                return Back();
            }
        }

        public function deletecanals(Request $request){ 
            
            DB::table('canals')
            ->where('RefRecu', request("ref"))
            ->update([
                'Statut' => "sup"
            ]);
            
            flash("Demande de CANAL PLUS supprimer avec succès! "); //Filleul supprimer avec succès!
            return Back();
        }

    // Soneb
    public function getsonebrecu()
    {
        $demandes = DB::table('sonebs')->where('RefRecu', request('refrecu'))->get()[0];
        $data = ['demande' => $demandes];
        return view('formrecu.formrecusoneb', $data);
    }

    public function setsonebrecu(Request $request)
    {

        if(isset(DB::table('sonebs')->where('RefRecu', request('refrecu'))->where('Statut', 'oui')->get()[0]))
            {flash('Recu déjà envoyer.');
            return Back(); }
        else{

        request()->validate([
            'reglement' => 'required|string',
            ]);

        setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');
        
        
        $d = DB::table('sonebs')->where('RefRecu', request('refrecu'))->get()[0];
        
        $mont = $d->Montant;

        $data = [
            'nom' => request('nom'),
            'prenom' => request('prenom'),
            'CodePersoUser' => request('CodePersoUser'),
            'refrecu' => request('refrecu'),
            'police' => request('police'),
            'WhatsApp' => request('WhatsApp'),
            'montant' => $mont,
            'mail' => request('mail'),
            'presentation' => request('presentation'),
            'FraisSSI' => $d->FraisSSI,
            'totale' => $d->MontantPayer,
            'daterecu' => strftime('%A %d %B %Y à %H:%M'),
            'modereglement' => request('modereglement'),
            'libelle' => request('libelle'),
            'solderestant' => request('solde'),
            'periode' => request('periode'),
            'reglementnum' => request('reglement')
        ];

        // Mise à jour dans la base de donnee
        DB::table('sonebs')
                    ->where('RefRecu', request('refrecu'))
                    ->update([
                    'daterecu' => strftime('%A %d %B %Y à %H:%M'),
                    'modereglement' => request('modereglement'),
                    'libelle' => request('libelle'),
                    'solderestant' => request('solde'),
                    'reglementnum' => request('reglement'),
                    'periode' => request('periode'),
                    'Statut' => 'oui'
                    ]);

                    
        // Commission sur vente pour client
                //$comv = $d->FraisSSI * 45 / 100;

                $user = DB::table('users')->where('id', $d->IdUser)->first();

                $comv = $d->FraisSSI * InterfaceServiceProvider::GetTaux($user->Pack, "SSONEB", "client") / 100;

                $soldeactuel_comv = DB::table('avoirs')->where('id_user', $d->IdUser)->first();
                $soldeac_comv = $soldeactuel_comv->gaincommissionvente + $comv;
                
                $pvcom = $soldeactuel_comv->compv + $comv;
                DB::table('avoirs')
                    ->where('id_user', $d->IdUser)
                    ->update([
                      'gaincommissionvente' => $soldeac_comv,
                      'compv' => $pvcom
                    ]); 

                
                // Débiter le compte de admin des taux sortant
                $comv_admin = $d->FraisSSI * InterfaceServiceProvider::GetTaux($user->Pack, "SSONEB", "client") / 100;
               $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirsortant;
               $recu=$compteadmin + $comv_admin;

                //update la table
                DB::table('systemadmins')
                        ->update([
                        'compteavoirsortant' => $recu
                        ]); 
                
                InterfaceServiceProvider::inderminiterparrain($user->id, $comv, $d->Montant, $user->Pack, "SSONEB", "client");

        $destinataire = request('mail');

        $sujet = "FACTURE SSI";

        $objet = "SSI : Facture ".request('libelle');

        // Envoie de recu
        InterfaceServiceProvider::EnvoieRecu(
            $destinataire, 
            $sujet, 
            $objet,
            request('nom'),
            request('prenom'),
            request('CodePersoUser'),
            request('refrecu'),
            request('police'),
            request('WhatsApp'),
            $mont,
            request('mail'),
            request('presentation'),
            $d->FraisSSI,
            $d->MontantPayer,
            strftime('%A %d %B %Y à %H:%M'),
            request('modereglement'),
            request('libelle'),
            request('solde'),
            request('periode'),
            request('reglement')
        );
        
        $message_reception = "Vous avez reçu un mail comportant le reçu de SONEB dont le montant est ".$d->Montant." $ SSI ";
        HistoriqueClient::saveHistorique($message_reception, $d->IdUser);
        flash('Recu envoyer avec succès!!!');
        
        return Back();

        }
        //return view('mail.recusoneb', $data);
    }

    public function getsonebservice()
    {
        $de = DB::table('sonebs')->where('Statut', '!=', 'sup')->orderBy('RefRecu', 'DESC')->get();
        $data = ['demandes' => $de];
        return view('services.DemandeSoneb', $data); 
    }

    public function deletesoneb(Request $request){ 
        
        $occurence = json_encode(DB::table('sonebs')->where('RefRecu', request("ref"))->first());
        TraceController::setTrace("Vous avez supprimé la demande soneb dont les informations sont les suivants : ".$occurence.".",session("utilisateur")->id);        
        DB::table('sonebs')->where('RefRecu', request("ref"))->delete();
        flash("Demande de soneb supprimer avec succès! ");
        return Back();
    }
    
    public function rejetsoneb(Request $request){ 
        $infdem = DB::table('sonebs')->where('RefRecu', request("dem"))->first();
        $iduser = $infdem->idUser;
        $montantuser = $infdem->MontantPayer;
        // restaurer les fonds
        $soldeactuel = DB::table('avoirs')->where('id_user', $iduser)->first()->gainvirtuel;
        $soldeac = $soldeactuel + $montantuser;
        DB::table('avoirs')->where('id_user', $iduser)->update(['gainvirtuel' => $soldeac]);
        HistoriqueClient::saveHistorique("Demande soneb rejet et fonds restaurer.", $iduser );
        // supprimer la demande
        $occurence = json_encode(DB::table('sonebs')->where('RefRecu', request("dem"))->first());
        TraceController::setTrace("Vous avez supprimé la demande soneb dont les informations sont les suivants : ".$occurence.".",session("utilisateur")->id);        
        DB::table('sonebs')->where('RefRecu', request("dem"))->delete();
        flash("Demande de soneb rejeté avec succès! ");
        return Back();
    }

    // SBEE CARTE
    public function getsbeecarterecu()
    {
        $demandes = DB::table('sbeecartes')->where('RefRecu', request('refrecu'))->get()[0];
        $data = ['demande' => $demandes];
        return view('formrecu.formrecusbeecarte', $data);   
    }
    
    public function getsbeecarteservice()
    {
        $de = DB::table('sbeecartes')->where('Statut', '!=', 'sup')->orderBy('RefRecu', 'DESC')->get();
        $data = ['demandes' => $de];
        return view('services.DemandeSbeecarte', $data);
    }

    public function deletesbeecarte(Request $request){ 
        
        DB::table('sbeecartes')
                    ->where('RefRecu', request("ref"))
                    ->update([
                    'Statut' => "sup"
                    ]);
        
        flash("Demande de SBEE CARTE supprimer avec succès! "); //Filleul supprimer avec succès!
        return Back();
    }

    public function setsbeecarterecu(Request $request)
    {
        if(isset(DB::table('sbeecartes')->where('RefRecu', request('refrecu'))->where('Statut', 'oui')->get()[0]))
            {flash('Recu déjà envoyer.');
            return Back();}
        else{

        request()->validate([
            'reglement' => 'required|string',
            ]);

        setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');
        
        $d = DB::table('sbeecartes')->where('RefRecu', request('refrecu'))->get()[0];
        
        $mont = $d->Montant;
        
        //dd(floatval(request('FraisSSI')));

        $data = [
            'nom' => request('nom'),
            'prenom' => request('prenom'),
            'CodePersoUser' => request('CodePersoUser'),
            'refrecu' => request('refrecu'),
            'police' => request('police'),
            'WhatsApp' => request('WhatsApp'),
            'montant' => $mont,
            'mail' => request('mail'),
            'FraisSSI' => $d->FraisSSI,
            'totale' => $d->MontantPayer,
            'daterecu' => strftime('%A %d %B %Y à %H:%M'),
            'modereglement' => request('modereglement'),
            'libelle' => request('libelle'),
            'solderestant' => request('solde'),
            'CodeSTS' => request('sts'),
            'entretien' => request('entretien'),
            'Kwh' => request('kwh'),
            'reglementnum' => request('reglement')
        ];

        // Mise à jour dans la base de donnee
        DB::table('sbeecartes')
                    ->where('RefRecu', request('refrecu'))
                    ->update([
                    'daterecu' => strftime('%A %d %B %Y à %H:%M'),
                    'modereglement' => request('modereglement'),
                    'libelle' => request('libelle'),
                    'solderestant' => request('solde'),
                    'reglementnum' => request('reglement'),
                    'CodeSTS' => request('sts'),
                    'entretien' => request('entretien'),
                    'Kwh' => request('kwh'),
                    'Statut' => 'oui'
                    ]);

                    $user = DB::table('users')->where('id', $d->IdUser)->first();
                    
                    // Commission sur vente pour client
                $comv = $d->FraisSSI * InterfaceServiceProvider::GetTaux($user->Pack, "SSBEE", "client") / 100;

                $soldeactuel_comv = DB::table('avoirs')->where('id_user', $d->IdUser)->first();
                
                $soldeac_comv = $soldeactuel_comv->gaincommissionvente + $comv;
                
                $pvcom = $soldeactuel_comv->compv + $comv;

                DB::table('avoirs')
                    ->where('id_user', $d->IdUser)
                    ->update([
                      'gaincommissionvente' => $soldeac_comv,
                      'compv' => $pvcom
                    ]);

                // Débiter le compte de admin des taux sortant
                $comv_admin = $d->FraisSSI * InterfaceServiceProvider::GetTaux($user->Pack, "SSBEE", "client") / 100;
               $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirsortant;
               $recu=$compteadmin + $comv_admin;

                //update la table
                DB::table('systemadmins')
                        ->update([
                        'compteavoirsortant' => $recu
                        ]);     
                    
                InterfaceServiceProvider::inderminiterparrain($user->id, $comv, $d->Montant, $user->Pack, "SSBEE", "client");
        $destinataire = request('mail');

        $sujet = "FACTURE SSI";

        $objet = "SSI : Facture ".request('libelle');

        // Envoie de recu
        InterfaceServiceProvider::EnvoieRecuCREDITSBEE(
            $destinataire, 
            $sujet, 
            $objet,
            request('nom'),
            request('prenom'),
            request('CodePersoUser'),
            request('refrecu'),
            request('police'),
            request('WhatsApp'),
            $mont,
            request('mail'),
            $d->FraisSSI,
            $d->MontantPayer,
            strftime('%A %d %B %Y à %H:%M'),
            request('modereglement'),
            request('libelle'),
            request('solde'),
            request('sts'),
            request('entretien'),
            request('kwh'),
            request('reglement')
        );

        $message_reception = "Vous avez reçu un mail comportant le reçu de SBEE: Achat de crédit CARTE dont le montant est ".$d->Montant." $ SSI ";
        HistoriqueClient::saveHistorique($message_reception, $d->IdUser);

        flash('Recu envoyer avec succès!!!');

        return Back();
        }
    }

    // SBEE CONVENTIONNEL
    public function getsbeeconventionnelrecu()
    {
        $demandes = DB::table('sbeeconventiels')->where('RefRecu', request('refrecu'))->get()[0];
        $data = ['demande' => $demandes];
        return view('formrecu.formrecusbeeconventionnel', $data);

        //return view('mail.recusoneb');
    }

    public function getsbeeconventionnelservice()
    {
        $de = DB::table('sbeeconventiels')->where('Statut', '!=', 'sup')->orderBy('RefRecu', 'DESC')->get();
        $data = ['demandes' => $de];
        return view('services.DemandeSbeeconventionnel', $data);
    }

    public function deletesbeeconventionnel(Request $request){ 
        
        DB::table('sbeeconventiels')
                    ->where('RefRecu', request("ref"))
                    ->update([
                    'Statut' => "sup"
                    ]);
        
        flash("Demande de Sbee Conventionnel supprimer avec succès! "); //Filleul supprimer avec succès!
        return Back();
    }

    public function setsbeeconventionnelrecu(Request $request)
    {

        if(isset(DB::table('sbeeconventiels')->where('RefRecu', request('refrecu'))->where('Statut', 'oui')->get()[0]))
        {
            flash('Recu déjà envoyer.');
            return Back();
        }
        else
        {

        request()->validate([
            'reglement' => 'required|string',
            ]);

        setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');
        
        $d = DB::table('sbeeconventiels')->where('RefRecu', request('refrecu'))->get()[0];

        $mont = $d->Montant;

        $data = [
            'nom' => request('nom'),
            'prenom' => request('prenom'),
            'CodePersoUser' => request('CodePersoUser'),
            'refrecu' => request('refrecu'),
            'police' => request('police'),
            'WhatsApp' => request('WhatsApp'),
            'montant' => $mont,
            'mail' => request('mail'),
            'presentation' => request('presentation'),
            'FraisSSI' => $d->FraisSSI,
            'totale' => $d->MontantPayer,
            'daterecu' => strftime('%A %d %B %Y à %H:%M'),
            'modereglement' => request('modereglement'),
            'libelle' => request('libelle'),
            'solderestant' => request('solde'),
            'periode' => request('periode'),
            'reglementnum' => request('reglement')
        ];

        // Mise à jour dans la base de donnee
        DB::table('sbeeconventiels')
                    ->where('RefRecu', request('refrecu'))
                    ->update([
                    'daterecu' => strftime('%A %d %B %Y à %H:%M'),
                    'modereglement' => request('modereglement'),
                    'libelle' => request('libelle'),
                    'solderestant' => request('solde'),
                    'reglementnum' => request('reglement'),
                    'periode' => request('periode'),
                    'Statut' => 'oui'
                    ]);

                    $user = DB::table('users')->where('id', $d->IdUser)->first();
        // Commission sur vente pour client
                $comv = $d->FraisSSI * InterfaceServiceProvider::GetTaux($user->Pack, "SSBEECONVENTIONNEL", "client") / 100;

                $soldeactuel_comv = DB::table('avoirs')->where('id_user', $d->IdUser)->first();
                

                $soldeac_comv = $soldeactuel_comv->gaincommissionvente + $comv;
                
                $pvcom = $soldeactuel_comv->compv + $comv;

                DB::table('avoirs')
                    ->where('id_user', $d->IdUser)
                    ->update([
                      'gaincommissionvente' => $soldeac_comv,
                      'compv' => $pvcom
                    ]);

                // Débiter le compte de admin des 45% sortant
                $comv_admin = $d->FraisSSI * InterfaceServiceProvider::GetTaux($user->Pack, "SSBEECONVENTIONNEL", "client") / 100;
               $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirsortant;
               $recu=$compteadmin + $comv_admin;

                //update la table
                DB::table('systemadmins')
                        ->update([
                        'compteavoirsortant' => $recu
                        ]); 

                        InterfaceServiceProvider::inderminiterparrain($user->id, $comv, $d->Montant, $user->Pack, "SSBEECONVENTIONNEL", "client");

        $destinataire = request('mail');

        $sujet = "FACTURE SSI";

        $objet = "SSI : Facture ".request('libelle');

        // Envoie de recu
        InterfaceServiceProvider::EnvoieRecuSBEE(
            $destinataire,
            $sujet,
            $objet,
            request('nom'),
            request('prenom'),
            request('CodePersoUser'),
            request('refrecu'),
            request('police'),
            request('WhatsApp'),
            $mont,
            request('mail'),
            request('presentation'),
            $d->FraisSSI,
            $d->MontantPayer,
            strftime('%A %d %B %Y à %H:%M'),
            request('modereglement'),
            request('libelle'),
            request('solde'),
            request('periode'),
            request('reglement')
        );
        
        $message_reception = "Vous avez reçu un mail comportant le reçu de SBEE CONVENTIONEL dont le montant de la facture est ".$d->Montant." $ SSI ";
        HistoriqueClient::saveHistorique($message_reception, $d->IdUser);

        flash('Recu envoyer avec succès!!!');

        return Back();
        }
    }

    // MTN ET MOOV
    public function getmtnmoovservice()
    {
        $de = DB::table('mtnmoovs')->where('Statut', '!=', 'sup')->orderByRaw("Statut ASC, id DESC")->paginate(20);
        $data = ['demandes' => $de];
        return view('services.Demandemtnmoov', $data);
    }

    public function deletemtnmoov(Request $request){ 
        
        DB::table('mtnmoovs')
                    ->where('id', request("ref"))
                    ->update([
                    'Statut' => "sup"
                    ]);
        
        flash("Demande de MTN / MOOV supprimer avec succès! "); //Filleul supprimer avec succès!
        return Back();
    }

    public function setmtnmoovrecu()
    {
        setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');

        $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
        $HEURE = date("H:i:s"); // Heure d'envoi de l'email

        $datevalider = "$JOUR à $HEURE";
        
        //dd($datevalider);
        
        // Mise à jour dans la base de donnee
        DB::table('mtnmoovs')
                    ->where('id', request('id'))
                    ->update([
                        'Statut' => 'oui', 
                        'DateValider' => $datevalider
                    ]);
        $d = DB::table('mtnmoovs')->where('id', request('id'))->first();

        $user = DB::table('users')->where('id', $d->IdUser)->first();
        // Commission sur vente
        if($d->libelle == "Crédit P3")
            $comv = $d->MontantPayer * InterfaceServiceProvider::GetTaux($user->Pack, "SMTNP3", "client") / 100;
        else
            if($d->type == "depot")
                $comv = $d->MontantPayer * InterfaceServiceProvider::GetTaux($user->Pack, "SMTNDEPOT", "client") / 100;
            else
                if($d->libelle == "NSIAG")
                    $comv = InterfaceServiceProvider::GetTaux($user->Pack, "SNSIAG", "client");
                else
                    $comv = $d->MontantPayer * InterfaceServiceProvider::GetTaux($user->Pack, "SMTNAUTRE", "client") / 100;

       $soldeactuel_comv = DB::table('avoirs')->where('id_user', $d->IdUser)->first();
       $soldeac_comv = $soldeactuel_comv->gaincommissionvente + $comv;
       $compv = $soldeactuel_comv->compv + $comv;

        DB::table('avoirs')
            ->where('id_user', $d->IdUser)
            ->update([
               'gaincommissionvente' => $soldeac_comv,
               'compv' => $compv
             ]);

        InterfaceServiceProvider::inderminiterparrain($user->id, $comv, $d->MontantPayer, $user->Pack, "SMTNAUTRE", "client");
                        
        $message_reception = "Votre demande d'achat de forfait MTN/MOOV dont le montant est ".$d->MontantPayer." $ SSI est validé ";
        HistoriqueClient::saveHistorique($message_reception, $d->IdUser);
        flash("Reçu envoyé avec succès.");
        return Back();
    }

    // Formation
    public function getajoutercours()
    {
        //return view('layouts.tempEditPage');
        $list = Mesformation::all();
        return view('admin.upload_cour', compact('list'));   
    }

    public function setajoutercours(Request $request)
    {
        request()->validate([
            'cours' => ['required', 'mimes:pdf'],
            'cout' => 'required',
            'link' => 'required',
            'titre' => 'required',
            'date' => 'required',
        ]);

        if ($request->hasFile('cours')) {
            $referenceNote = "Formation-".date('ymdhis');
            $namefile = $referenceNote.".pdf";
            $upload = "coursformation/upload/";
            $request->file('cours')->move($upload, $namefile);
               
            $path = $upload.$namefile;

            $article = Mesformation::create([
                'doc' => $path,
                'titre' => request('titre'),
                'cout' => request('cout'),
                'coutlink' => request('link'),
                'id_user' => 1,
                'datelancement' => request('date')
            ]);

            flash('Formation programmée.');
        }else
            flash('Veuillez importer un cours');

        return Back();
    }
    
    // Agences
    public function getagence()
    {
        $list = Agence::all();
        return view('admin.addagence', compact('list'));
    }

    public function setagence(Request $request)
    {
        request()->validate([
            'nom' => 'required',
            'description' => 'required',
            'long' => 'required',
            'lat' => 'required',
            'tel' => 'required',
            'adr' => 'required',
        ]);

        if ($request->hasFile('log')) {
            $referenceNote = "agen-".date('ymdhis');
            $namefile = $referenceNote.'.'.$request->file('log')->getClientOriginalExtension();
            $upload = "mapsapi/images/";
            $request->file('log')->move($upload, $namefile);
            
        		            
            $path = $namefile;

            $ag = new Agence();
            $ag->name = request('nom');
            $ag->images = $path;
            $ag->description = request('description');
            $ag->longitude = request('long');
            $ag->latitude = request('lat');
            $ag->phone = request('tel');
            $ag->adresse = request('adr');
            $ag->save();

            flash('Agence créer avec succès.');
        }else
            flash('Veuillez importer une image. ');

        return Back();
    }
    
    public function getmodifagence(Request $request){
        $agen = DB::table('agences')->where('id', $request->id)->first();
        
        return view('admin.modifagence', compact('agen'));
    }
    
    public function deleteagences(Request $request){
        
        $agen = DB::table('agences')->where('id', $request->id)->first();
        
        TraceController::setTrace(json_encode($agen) , 2);
        
        DB::table('agences')->where('id', $request->id)->delete();
        
        flash('Suppression effectuer avec succès. ');

        return Back();
    }
    
    public function setmodifagence(Request $request){
        request()->validate([
            'nom' => 'required',
            'description' => 'required',
            'long' => 'required',
            'lat' => 'required',
            'tel' => 'required',
            'adr' => 'required',
        ]);
        
        Agence::where('id', request('idA'))->update([
            'name' => request('nom'),
            'description' => request('description'),
            'longitude' => request('long'),
            'latitude' => request('lat'),
            'phone' => request('tel'),
            'adresse' => request('adr')
        ]);
        
        flash('Mise à jour effectuer avec succès. ');

        return Back();
    }

    // Activaction filleul 

    public function activeraccount(Request $request)
    {
        return view('admin.activercompte');
    }

    public function validefilleulinscription(Request $request)
    {
            $data_user = DB::table('users')->where('codeperso', request('id'))->first();

            $iduser = $data_user->id;

                $active = DB::table('users')->select('compteactive')->where('id', $iduser)->first()->compteactive;

                if ($active == "non") {

                    //Verifier si le solde du parrain suffit et valider
                    $pa = DB::table('users')->select('parrain')->where('id', $iduser)->get()[0]->parrain;

                    $id_pa = DB::table('users')->select('id')->where('codeunique', $pa)->get()[0]->id;

                    $verifsolde = DB::table('avoirs')->select('gainespece')->where('id_user', $id_pa)->get()[0]->gainespece;

                    $valeur_a_payer = DB::table('packs')->where('id', $data_user->Pack)->first()->valeur;

                    if ($verifsolde >= $valeur_a_payer) {
                        $soldea = $verifsolde - $valeur_a_payer;

                        if (!isset(DB::table('avoirs')->where('id_user', $iduser)->first()->id)) {
                            DB::table('avoirs')
                            ->where('id_user', $id_pa)
                            ->update(['gainespece' => $soldea]);
                        } 
                    } 
                    
                    // Procédure d'activation

                    // Initialisation du compte avoir de l'utilisateur

                    if (!isset(DB::table('avoirs')->where('id_user', $iduser)->first()->id)) {
                        $id_avoirs = InterfaceServiceProvider::user_init($iduser, "");


                        // Pourcentage

                        $pourcentageespece = InterfaceServiceProvider::PourcentageFilleulEspece();

                        $pourcentagevirtuel = InterfaceServiceProvider::PourcentageFilleulVirtuel();

                        // Calcule de la valeur en %

                        $gain_espece = $valeur_a_payer * ($pourcentageespece / 100);

                        $gain_virtuel = $valeur_a_payer * ($pourcentagevirtuel / 100);

                        // alors le parrain beneficie de ces valeurs

                        $gainsvirtuel_actuel = InterfaceServiceProvider::VirtuelActuel($id_pa);

                        $gainsvirtuel_actuel_mise_a_jour = $gainsvirtuel_actuel + $gain_virtuel;
                        DB::table('avoirs')
                        ->where('id_user', $id_pa)
                        ->update(['gainvirtuel' => $gainsvirtuel_actuel_mise_a_jour]);

                        $gaincommissionvente_actuel = InterfaceServiceProvider::GainCommissionVente_Actuel($id_pa);

                        $compvac = DB::table('avoirs')->where('id_user', $id_pa)->first()->compv + $gain_espece;

                        $gaincommissionvente_actuel_mise_a_jour = $gaincommissionvente_actuel + $gain_espece;
                        DB::table('avoirs')
                        ->where('id_user', $id_pa)
                        ->update(['gaincommissionvente' => $gaincommissionvente_actuel_mise_a_jour, 'compv' => $compvac]);

                        InterfaceServiceProvider::inderminiterparrain($iduser, $gain_espece, 0, $data_user->Pack, "SINSCRIPTION", "client");

                        // Compte de l'administrateur
                        $gainsadmin_actuel = InterfaceServiceProvider::AdminCompteRecu();

                        $gainsadmin_actuel_mise_a_jour = $gainsadmin_actuel + $valeur_a_payer;
                        DB::table('systemadmins')->update(['compteavoirrecu' => $gainsadmin_actuel_mise_a_jour]);

                    }
                    
                    $u = DB::table('users')
                        ->select('nom', 'prenom', 'sexe', 'email', 'codeunique', 'nomuser', 'codeperso', 'parrain', 'Pack')
                        ->where('id', $iduser)
                        ->get();
                    // Activer le compte

                    DB::table('users')
                    ->where('id', $iduser)
                    ->update(['compteactive' => 'oui']);

                    $nomparrain = InterfaceServiceProvider::NomParrain($u[0]->parrain);
                    $destinataire = $u[0]->email;
                    
                    $pack = DB::table('packs')->where('id', $u[0]->Pack)->first()->libelle;

                    $data = [
                        'nom' => $u[0]->nom,
                        'prenom' => $u[0]->prenom,
                        'codeunique' => $u[0]->codeunique,
                        'nomparrain' => $nomparrain,
                        'codeperso' => $u[0]->codeperso,
                        'nomuser' => $u[0]->nomuser, 
                        'Pack' => $pack
                    ];

                    setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                    date_default_timezone_set('Africa/Porto-Novo');

                        $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
                        $HEURE = date("H:i"); // Heure d'envoi de l'email

                        $Subject = "Compte crée avec succès - $JOUR $HEURE";

                        SendMail::sendmailValidation($destinataire, $Subject, $data);

                        $donner = ['nom' => $u[0]->nom, 'prenom' => $u[0]->prenom, 'id' => $u[0]->codeperso, 'nomuser' => $u[0]->nomuser, 'sponsor' => $nomparrain, 'Pack' => $pack];
                        return view('authentification.validerregister', $donner);
                }    
    }
}