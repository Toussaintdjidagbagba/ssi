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
use App\Mtnmoov;

class ServiceController extends Controller 
{
    
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
            'statut' => "sup"
        ]);
        
        flash("Demande d'achat $ SSI supprimer avec succès! "); //Filleul supprimer avec succès!
        return Back();
    }
    
    public function getdemandeachat()
    {
        $achats = DB::table('achatssis')->orderByRaw("statut DESC, id DESC ")->where('statut', '!=', 'sup')->paginate(20);
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
            if(DB::table('achatssis')->where('id', $id)->first()->statut == "0") {
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
                    'statut' => "0",
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
            $visas = DB::table('retraitvisas')->orderByRaw("statut DESC, id DESC ")->where('statut', '!=', 'sup')->paginate(20);
            return view('admin.demandevisa', compact('visas'));
        }

        public function setdeletevisa(Request $request){

            DB::table('retraitvisas')
            ->where('id', request("id"))
            ->update([
                'statut' => "sup"
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
                    'statut' => "0",
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                date_default_timezone_set('Africa/Porto-Novo');

            $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
            $HEURE = date("H:i"); // Heure d'envoi de l'email

            $Subject = "Retrait sur carte VISA SSI - $JOUR $HEURE";
            
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
            $message_reception = "Vous avez reçu un mail comportant le reçu de retrait sur carte visa dont le montant est ".$visa->mont." $ SSI ";
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

                $soldeactuel_comv = DB::table('avoirs')->where('id_user', $d->IdUser)->get()[0]->gaincommissionvente;
                $soldeac_comv = $soldeactuel_comv + $comv;
                DB::table('avoirs')
                ->where('id_user', $d->IdUser)
                ->update([
                    'gaincommissionvente' => $soldeac_comv
                ]);

                InterfaceServiceProvider::inderminiterparrain($user->id, $comv, $user->Pack, "SCANAL", "client");

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

                $soldeactuel_comv = DB::table('avoirs')->where('id_user', $d->IdUser)->get()[0]->gaincommissionvente;
                $soldeac_comv = $soldeactuel_comv + $comv;
                DB::table('avoirs')
                    ->where('id_user', $d->IdUser)
                    ->update([
                      'gaincommissionvente' => $soldeac_comv
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
                
                InterfaceServiceProvider::inderminiterparrain($user->id, $comv, $user->Pack, "SSONEB", "client");

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
        
        DB::table('sonebs')
                    ->where('RefRecu', request("ref"))
                    ->update([
                    'Statut' => "sup"
                    ]);
        
        flash("Demande de soneb supprimer avec succès! "); //Filleul supprimer avec succès!
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

                $soldeactuel_comv = DB::table('avoirs')->where('id_user', $d->IdUser)->get()[0]->gaincommissionvente;
                $soldeac_comv = $soldeactuel_comv + $comv;
                DB::table('avoirs')
                    ->where('id_user', $d->IdUser)
                    ->update([
                      'gaincommissionvente' => $soldeac_comv
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
                    
                InterfaceServiceProvider::inderminiterparrain($user->id, $comv, $user->Pack, "SSBEE", "client");
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

                $soldeactuel_comv = DB::table('avoirs')->where('id_user', $d->IdUser)->get()[0]->gaincommissionvente;
                $soldeac_comv = $soldeactuel_comv + $comv;
                DB::table('avoirs')
                    ->where('id_user', $d->IdUser)
                    ->update([
                      'gaincommissionvente' => $soldeac_comv
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

                        InterfaceServiceProvider::inderminiterparrain($user->id, $comv, $user->Pack, "SSBEECONVENTIONNEL", "client");

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
                    'Statut' => 'oui', 'DateValider' => $datevalider
                    ]);
                    $d = DB::table('mtnmoovs')->where('id', request('id'))->get()[0];

        $user = DB::table('users')->where('id', $d->IdUser)->first();
        // Commission sur vente
        if($d->libelle == "Crédit P3")
            //$comv = $d->MontantPayer * 0.4 / 100;
            $comv = $d->MontantPayer * InterfaceServiceProvider::GetTaux($user->Pack, "SMTNP3", "client") / 100;
        else
            if($d->type == "depot")
                //$comv = $d->MontantPayer * 0.2 / 100;
                $comv = $d->MontantPayer * InterfaceServiceProvider::GetTaux($user->Pack, "SMTNDEPOT", "client") / 100;
            else
                $comv = $d->MontantPayer * InterfaceServiceProvider::GetTaux($user->Pack, "SMTNAUTRE", "client") / 100;

       $soldeactuel_comv = DB::table('avoirs')->where('id_user', $d->IdUser)->get()[0]->gaincommissionvente;
       $soldeac_comv = $soldeactuel_comv + $comv;
        DB::table('avoirs')
            ->where('id_user', $d->IdUser)
            ->update([
               'gaincommissionvente' => $soldeac_comv
             ]);

        InterfaceServiceProvider::inderminiterparrain($user->id, $comv, $user->Pack, "SMTNAUTRE", "client");
                        
       //dd($comv);
                        
       $message_reception = "Votre demande d'achat de forfait MTN/MOOV dont le montant est ".$d->MontantPayer." $ SSI est validé ";
        HistoriqueClient::saveHistorique($message_reception, $d->IdUser);
                        
        return Back();
    }
}