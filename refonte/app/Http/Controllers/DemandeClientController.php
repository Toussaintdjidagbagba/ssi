<?php

namespace App\Http\Controllers;

use App\HistoriqueClient;
use App\Achatssi;
use App\Retraitvisa as Visa;
use App\Historique;
use DB;
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
use Illuminate\Http\Request;
use App\Providers\InterfaceServiceProvider;
use Illuminate\Support\Facades\Session;

class DemandeClientController extends Controller 
{

    /**
    *
    *   Canal Plus
    */
    public function getcanalplus()
    {
        return view('admin.canalplus');
    }

    public function setcanaplus(Request $request)
    {
        request()->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'num' => 'required|min:0',
            'formule' => 'required|string',
            'mois' => 'required',
            'numero' => 'required',
            ]);

        $formule = "";
        $valeurabonnement = 0;

        switch (request('formule')) {
            case 'access1':
                $formule = "access";
                $valeurabonnement = 10;
                break;
            case 'evasion':
                $formule = "evasion";
                $valeurabonnement = 20;
                break;
            case 'essentiel':
                $formule = "essentiel +";
                $valeurabonnement = 24;
                break;
            case 'evasion2':
                $formule = "evasion +";
                $valeurabonnement = 40;
                break;
            case 'tcanal':
                $formule = "tout canal +";
                $valeurabonnement = 80;
                break;
            case 'ocharme':
                $formule = "Option charme";
                $valeurabonnement = 12;
                break;
            case 'acces':
                $formule = "acces +";
                $valeurabonnement = 30;
                break;
            case 'ecran':
                $formule = "2ème écran";
                $valeurabonnement = 12;
                break;
            case 'modif10':
                $formule = "Modification : ".request('observation');
                $valeurabonnement = 10;
                break;
            case 'modif14':
                $formule = "Modification : ".request('observation');
                $valeurabonnement = 14;
                break;
            case 'modif20':
                $formule = "Modification : ".request('observation');
                $valeurabonnement = 20;
                break;
            case 'modif30':
                $formule = "Modification : ".request('observation');
                $valeurabonnement = 30;
                break;
            case 'modif40':
                $formule = "Modification : ".request('observation');
                $valeurabonnement = 40;
                break;
            case 'modif50':
                $formule = "Modification : ".request('observation');
                $valeurabonnement = 50;
                break;
            case 'modif60':
                $formule = "Modification : ".request('observation');
                $valeurabonnement = 60;
                break;
            case 'modif70':
                $formule = "Modification : ".request('observation');
                $valeurabonnement = 70;
                break;
            default:
                $formule = "inconnue";
                $valeurabonnement = 0;
                break;
        }

        $mois = request('mois');

        $valeurabonnementmois = $valeurabonnement * $mois;

        if (!auth()->guest()) {
            // Verification du compte avoirs du client en espèce
            if(isset(DB::table('avoirs')->where('id_user', auth()->user()->id)->where('gainvirtuel', '>=', $valeurabonnementmois)->get()[0]->gainvirtuel))
            {
                // Effectuer le prélèvement 
                $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
                $soldeac = $soldeactuel - $valeurabonnementmois;
                DB::table('avoirs')
                    ->where('id_user', auth()->user()->id)
                    ->update([
                    'gainvirtuel' => $soldeac
                    ]);

                $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;

                //debiter le compte admin
                $recu=$compteadmin + $valeurabonnementmois;

                //update la table
                DB::table('systemadmins')
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);


                $refid = InterfaceServiceProvider::genref('canals');

             /*   // Commission sur vente
                $comv = $valeurabonnementmois * 2 / 100;

                $soldeactuel_comv = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gaincommissionvente;
                $soldeac_comv = $soldeactuel_comv + $comv;
                DB::table('avoirs')
                    ->where('id_user', auth()->user()->id)
                    ->update([
                    'gaincommissionvente' => $soldeac_comv
                    ]);*/

                setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                date_default_timezone_set('Africa/Porto-Novo');

                 Canal::create([
                    'IdUser' => auth()->user()->id, 
                    'NomUser' => auth()->user()->nom, 
                    'EmailUser' => auth()->user()->email, 
                    'TelUser' => request('numero'),
                    'CodePersoUser' => auth()->user()->codeperso,
                    'Nom' => request('nom'), 
                    'Prenom' => request('prenom'), 
                    'Numerocarte' => request('num'), 
                    'Choisirformule' => $formule, 
                    'Dureenmois' => request('mois'),    
                    'Montant' => $valeurabonnementmois,
                    'MontantPayer' => $valeurabonnementmois,
                    
                    'RefRecu' => $refid, 
                    'date' => strftime('%A %d %B %Y à %H:%M')
                ]);
                
                $message = "
                    Vous ".auth()->user()->nom." (".auth()->user()->email.") avez payé ".$valeurabonnementmois." $ SSI pour l'abonnement Canal+'. <br>
                    Montant de l'abonnement : ".$valeurabonnementmois." $ SSI <br>
                    Réference ID : ".$refid;
                HistoriqueClient::saveHistorique($message, auth()->user()->id );
                flash($message);
                
                return Back();

                // Envoyer message sur whatsApp
                //a href=\"whatsapp://send?phone=--your phone--&text=--your text--\">
                //return IndexPrimeController::callUrl("https://api.whatsapp.com/send?phone=22961310573&text=".$message);
                // https://api.whatsapp.com/send?phone=15551234567
            }
            else
            {
                flash("Votre compte est insuffisant pour effectuée cette opération")->error();

                return Back();
            }
        }
        else
        {
            flash("Vous devez être connecté pour effectuée l'abonnement canal plus et payer le coût de l'abonnement à partir de vos compte avoirs. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur Canal +")->error();
            return redirect('/connexion');
        }

    }

    /**
    *
    *   Achat SSI
    */
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


    /**
    *
    *   Service VISA
    */
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
                    $fraisretrait = $montantnet * InterfaceServiceProvider::GetTaux(auth()->user()->Pack, "SV", "client") / 100;
                    //$fraisretrait = $montantnet * 1 / 100;
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

                        //InterfaceServiceProvider::inderminiterparrain(auth()->user()->id, $fraisretrait, auth()->user()->Pack, "SV", "client");
                                
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
                        $compteadminsort = DB::table('systemadmins')->get()[0]->compteavoirsortant;
    
                        $recus=$compteadminsort - $montantvalider;
    
                        DB::table('systemadmins')
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

    /**
    *
    *   Soneb
    */
    public function getsoneb()
    {
        return view('admin.soneb');
    }

    public function setsoneb(Request $request)
    {
        request()->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'police' => 'required|string',
            'numWha' => 'required|min:0',
            'montant' => 'required|min:0',
            'mail' => 'required|string',
            'presentation' => 'required|string',
            ]);

        $valeuradhesionm = request('montant');

        $fraisajouter = InterfaceServiceProvider::fraisssinouvelle($valeuradhesionm);

        $valeuradhesion = $valeuradhesionm + $fraisajouter;

        if (!auth()->guest()) {

            // Verification du compte avoirs du client en espèce
            if(isset(DB::table('avoirs')->where('id_user', auth()->user()->id)->where('gainvirtuel', '>=', $valeuradhesion)->get()[0]->gainvirtuel))
            {
                // Effectuer le prélèvement 
                $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
                $soldeac = $soldeactuel - $valeuradhesion;
                DB::table('avoirs')
                    ->where('id_user', auth()->user()->id)
                    ->update([
                    'gainvirtuel' => $soldeac
                    ]);

                $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;

                //debiter le compte admin 
                $recu=$compteadmin + $valeuradhesionm;

                //update la table
                DB::table('systemadmins')
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);

                $refid = InterfaceServiceProvider::genref('sonebs');

                
                setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                date_default_timezone_set('Africa/Porto-Novo');

                Soneb::create([
                    'IdUser' => auth()->user()->id, 
                    'NomUser' => auth()->user()->nom, 
                    'EmailUser' => auth()->user()->email, 
                    'TelUser' => auth()->user()->tel,
                    'CodePersoUser' => auth()->user()->codeperso,
                    'Nom' => request('nom'), 
                    'Prenom' => request('prenom'), 
                    'Email' => request('mail'), 
                    'WhatsApp' => request('numWha'), 
                    'Police' => request('police'), 
                    'Presentation' => request('presentation'), 
                    'Montant' => $valeuradhesionm,
                    'MontantPayer' => $valeuradhesion,
                    'FraisSSI' => $fraisajouter,
                    'RefRecu' => $refid, 
                    'date' => strftime('%A %d %B %Y à %H:%M')
                ]);


                $message = "Vous ".auth()->user()->nom." ".auth()->user()->email." avez payer ".$valeuradhesion." $ SSI pour solder la facture de la SONEB.";
                HistoriqueClient::saveHistorique($message, auth()->user()->id );
                flash("Vous ".auth()->user()->nom." (".auth()->user()->email.") avez payer ".$valeuradhesion." $ SSI pour solder la facture de la SONEB. <br>
                    Montant facture : ".$valeuradhesionm." $ SSI <br>
                    Frais SSI prélever : ".$fraisajouter." $ SSI. <br>
                    Réference ID : ".$refid);

                return Back();
            }
            else
            {
                flash("Votre compte est insuffisant pour effectuée cette opération")->error();
                return Back();
            }
        }
        else
        {
            flash("Vous devez être connecté pour effectuée le payement de SONEB et payer le coût de la facture à partir de vos compte avoirs. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur SONEB")->error();
            return redirect('/connexion');
        }
    }

    /**
    *
    *   SBEE
    */
    public function getsbee()
    {
        return view('admin.sbee');
    }

    // Facture
    
    public function setsbee2(Request $request)
    {
        request()->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'police' => 'required|string',
            'numWha' => 'required|min:0',
            'montant' => 'required|min:0',
            'mail' => 'required|string',
            'presentation' => 'required|string',

        ]);
            
        $valeuradhesionm = request('montant');

        $fraisajouter = InterfaceServiceProvider::fraisssinouvelle($valeuradhesionm);

        $valeuradhesion = $valeuradhesionm + $fraisajouter;

        if (!auth()->guest()) {

            // Verification du compte avoirs du client en espèce
            if(isset(DB::table('avoirs')->where('id_user', auth()->user()->id)->where('gainvirtuel', '>=', $valeuradhesion)->get()[0]->gainvirtuel))
            {
                // Effectuer le prélèvement 
                $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
                $soldeac = $soldeactuel - $valeuradhesion;
                DB::table('avoirs')
                    ->where('id_user', auth()->user()->id)
                    ->update([
                    'gainvirtuel' => $soldeac
                    ]);

                $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;

                //debiter le compte admin
                $recu=$compteadmin + $valeuradhesionm ;

                //update la table
                DB::table('systemadmins')
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);

                $refid = InterfaceServiceProvider::genref('sbeeconventiels');

                setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                date_default_timezone_set('Africa/Porto-Novo');

                Sbeeconventiel::create([
                    'IdUser' => auth()->user()->id, 
                    'NomUser' => auth()->user()->nom, 
                    'EmailUser' => auth()->user()->email, 
                    'TelUser' => auth()->user()->tel,
                    'CodePersoUser' => auth()->user()->codeperso,
                    'Nom' => request('nom'), 
                    'Prenom' => request('prenom'), 
                    'Email' => request('mail'), 
                    'WhatsApp' => request('numWha'), 
                    'Police' => request('police'), 
                    'Presentation' => request('presentation'), 
                    'Montant' => $valeuradhesionm,
                    'MontantPayer' => $valeuradhesion,
                    'FraisSSI' => $fraisajouter,
                    'RefRecu' => $refid, 
                    'date' => strftime('%A %d %B %Y à %H:%M')
                ]);

                $message = "
                    Vous ".auth()->user()->nom." ".auth()->user()->email." avez payé ".$valeuradhesion." $ SSI pour solder la facture SBEE.";
                HistoriqueClient::saveHistorique($message, auth()->user()->id );
                flash("
                    Vous ".auth()->user()->nom." (".auth()->user()->email.") avez payé ".$valeuradhesion." $ SSI pour solder la facture SBEE. <br>
                    Montant facture : ".$valeuradhesionm." $ SSI <br>
                    Frais prélever : ".$fraisajouter." $ SSI. <br>
                    Réference ID : ".$refid);
                return Back();
            }
            else
            {
                flash("Votre compte est insuffisant pour effectuée cette opération")->error();
                return Back();
            }
        }
        else
        {
            flash("Vous devez être connecté pour effectuée le payement de facture de la SBEE à partir de vos comptes avoirs. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur SBEE")->error();
            return redirect('/connexion');
        }
    }

    // Crédit
    public function setsbee1(Request $request)
    {
        request()->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'police' => 'required|string',
            'numWha' => 'required|min:0',
            'mail' => 'required|string',
            'montant' => 'required',
            ]);
            
        $valeuradhesionm = request('montant');

        $fraisajouter = InterfaceServiceProvider::fraisssinouvelle($valeuradhesionm);

        $valeuradhesion = $valeuradhesionm + $fraisajouter;

        if (!auth()->guest()) {
            // Verification du compte avoirs du client en espèce
            if(isset(DB::table('avoirs')->where('id_user', auth()->user()->id)->where('gainvirtuel', '>=', $valeuradhesion)->get()[0]->gainvirtuel))
            {
                // Effectuer le prélèvement 
                $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
                $soldeac = $soldeactuel - $valeuradhesion;
                DB::table('avoirs')
                    ->where('id_user', auth()->user()->id)
                    ->update([
                    'gainvirtuel' => $soldeac
                    ]);

                $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;

                $recu=$compteadmin + $valeuradhesionm ;

                //update la table
                DB::table('systemadmins')
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);


                $refid = InterfaceServiceProvider::genref('sbeecartes');

                setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                date_default_timezone_set('Africa/Porto-Novo');

                Sbeecarte::create([
                    'IdUser' => auth()->user()->id, 
                    'NomUser' => auth()->user()->nom, 
                    'EmailUser' => auth()->user()->email, 
                    'TelUser' => auth()->user()->tel,
                    'CodePersoUser' => auth()->user()->codeperso,
                    'Nom' => request('nom'), 
                    'Prenom' => request('prenom'), 
                    'Email' => request('mail'), 
                    'WhatsApp' => request('numWha'), 
                    'Police' => request('police'), 
                    'Montant' => $valeuradhesionm,
                    'MontantPayer' => $valeuradhesion,
                    'FraisSSI' => $fraisajouter,
                    'RefRecu' => $refid, 
                    'date' => strftime('%A %d %B %Y à %H:%M')
                ]);

                $message = "
                    Vous ".auth()->user()->nom." ".auth()->user()->email." avez payé ".$valeuradhesion." $ SSI pour l'achat sur le compteur à crédit";
                HistoriqueClient::saveHistorique($message, auth()->user()->id );
                flash("
                    Vous ".auth()->user()->nom." (".auth()->user()->email.") avez payé ".$valeuradhesion." $ SSI pour l'achat sur le compteur à crédit. <br>
                    Montant : ".$valeuradhesionm." $ SSI <br>
                    Frais prélever : ".$fraisajouter." $ SSI. <br>
                    Réference ID : ".$refid);
                return Back();
            }
            else
            {
                flash("Votre compte est insuffisant pour effectuée cette opération")->error();
                return Back();
            }
        }
        else
        {
            flash("Vous devez être connecté pour effectuée votre achat à partir de vos compte avoirs. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur SBEE")->error();
            return redirect('/connexion');
        }

    }

    // MTN
    public function getmtn()
    {
        return view('services_site.mtn.mtn');
    }

    public function setmtn(Request $request)
    {
        $num = substr(request('numero'), -8);
        
        
        $id_num = substr($num, -8, 2);

        if (InterfaceServiceProvider::verifie_mtn($id_num) == 1) {
        
            if (request('lib') == "credit") {
    
                request()->validate([
                    'numero' => 'required|min:0',
                    'forfait' => 'required|min:0',
                    ]);
    
    
                $forfait = "Crédit MTN ";
    
                $valeuradhesion = request('forfait');
    
                if (!auth()->guest()) {
    
                    // Verification du compte avoirs du client en espèce
                    if(isset(DB::table('avoirs')->where('id_user', auth()->user()->id)->where('gainvirtuel', '>=', $valeuradhesion)->get()[0]->gainvirtuel))
                    {
                        // Effectuer le prélèvement 
                        $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
                        $soldeac = $soldeactuel - $valeuradhesion;
                        DB::table('avoirs')
                            ->where('id_user', auth()->user()->id)
                            ->update([
                            'gainvirtuel' => $soldeac
                            ]);
    
                        $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;
    
                        //debiter le compte admin
                        $recu=$compteadmin + $valeuradhesion;
    
                        //update la table
                        DB::table('systemadmins')
                                
                                ->update([
                                'compteavoirrecu' => $recu
                                ]);
    
                        Mtnmoov::create([
                            'IdUser' => auth()->user()->id, 
                            'NomUser' => auth()->user()->nom, 
                            'EmailUser' => auth()->user()->email, 
                            'CodePersoUser' => auth()->user()->codeperso, 
                            'Tel' => request('numero'), 
                            'MontantPayer' => request('forfait'), 
                            'libelle' => $forfait
                        ]);
    
                        //flash("Vous recevez un message de confirmation dans un instant.");
                        $message = "Vous ".auth()->user()->nom." (".auth()->user()->email.") avez payé ".$valeuradhesion." $ SSI pour ".$forfait." sur le numéro ".request('numero').".";
                        HistoriqueClient::saveHistorique($message, auth()->user()->id );
                        flash($message);
                        return Back();
                    }
                    else
                    {
                        flash("Votre compte est insuffisant pour effectuée cette opération")->error();
    
                        return Back();
                    }
                }
                else
                {
                    flash("Vous devez être connecté pour effectuée l'achat et payer les frais à partir de vos compte avoirs. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur MTN")->error();
                    return redirect('/connexion');
                }
    
            }
    
            if (request('lib') == "maxi") {
    
                request()->validate([
                    'numero' => 'required|min:0',
                    ]);
                $forfait = "";
                $valeuradhesion = 0;
    
                switch (request('forfaitlib')) {
                    case 1:
                        $forfait = "FORFAIT APPEL + INTERNET MTN : 1 $ SSI (48h)";
                        $valeuradhesion = 1;
                        break;
                    case 2:
                        $forfait = "FORFAIT APPEL + INTERNET MTN : 2 $ SSI (07jrs)";
                        $valeuradhesion = 2;
                        break;
                    case 3:
                        $forfait = "FORFAIT APPEL + INTERNET MTN : 3 $ SSI (07jrs)";
                        $valeuradhesion = 3;
                        break;
                    case 6:
                        $forfait = "FORFAIT APPEL + INTERNET MTN : 5 $ SSI (30jrs)";
                        $valeuradhesion = 5;
                        break;
                    case 5:
                        $forfait = "FORFAIT APPEL + INTERNET MTN : 10 $ SSI (30jrs)";
                        $valeuradhesion = 10;
                        break;
                    case 4:
                        $forfait = "FORFAIT APPEL + INTERNET MTN : 0.4 $ SSI (24h)";
                        $valeuradhesion = 0.4;
                        break;
    
                    default:
                        $forfait = "inconnue";
                        break;
                }
    
                if (!auth()->guest()) {
    
                    // Verification du compte avoirs du client en espèce
                    if(isset(DB::table('avoirs')->where('id_user', auth()->user()->id)->where('gainvirtuel', '>=', $valeuradhesion)->get()[0]->gainvirtuel))
                    {
                        // Effectuer le prélèvement 
                        $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
                        $soldeac = $soldeactuel - $valeuradhesion;
                        DB::table('avoirs')
                            ->where('id_user', auth()->user()->id)
                            ->update([
                            'gainvirtuel' => $soldeac
                            ]);
    
                        $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;
    
                        //debiter le compte admin
                        $recu=$compteadmin + $valeuradhesion;
    
                        //update la table
                        DB::table('systemadmins')
                                
                                ->update([
                                'compteavoirrecu' => $recu
                                ]);
    
                        Mtnmoov::create([
                            'IdUser' => auth()->user()->id, 
                            'NomUser' => auth()->user()->nom, 
                            'EmailUser' => auth()->user()->email, 
                            'CodePersoUser' => auth()->user()->codeperso, 
                            'Tel' => request('numero'), 
                            'MontantPayer' => $valeuradhesion, 
                            'libelle' => $forfait
                        ]);
    
                        //flash("Vous recevez un message de confirmation dans un instant.");
                        $message = "Vous ".auth()->user()->nom." (".auth()->user()->email.") avez payé ".$valeuradhesion." $ SSI pour ".$forfait." sur le numéro ".request('numero').".";
                        HistoriqueClient::saveHistorique($message, auth()->user()->id );
                        flash($message);
                        return Back();
                    }
                    else
                    {
                        flash("Votre compte est insuffisant pour effectuée cette opération")->error();
    
                        return Back();
                    }
                }
                else
                {
                    flash("Vous devez être connecté pour effectuée l'achat et payer les frais à partir de vos compte avoirs. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur MTN")->error();
                    return redirect('/connexion');
                }
    
            }
            
            if (request('lib') == "forfaitappel") {
    
                request()->validate([
                    'numero' => 'required|min:0',
                    ]);
                $forfait = "";
                $valeuradhesion = 0;
    
                switch (request('forfaitlib')) {
                    case 1:
                        $forfait = "FORFAIT APPEL MTN : 1 $ SSI (48h)";
                        $valeuradhesion = 1;
                        break;
                    case 2:
                        $forfait = "FORFAIT APPEL MTN : 2 $ SSI (07jrs)";
                        $valeuradhesion = 2;
                        break;
                    case 3:
                        $forfait = "FORFAIT APPEL MTN : 3 $ SSI (07jrs)";
                        $valeuradhesion = 3;
                        break;
                    case 6:
                        $forfait = "FORFAIT APPEL MTN : 5 $ SSI (30jrs)";
                        $valeuradhesion = 5;
                        break;
                    case 5:
                        $forfait = "FORFAIT APPEL MTN : 10 $ SSI (30jrs)";
                        $valeuradhesion = 10;
                        break;
                    case 4:
                        $forfait = "FORFAIT APPEL MTN : 0.4 $ SSI (24h)";
                        $valeuradhesion = 0.4;
                        break;
    
                    default:
                        $forfait = "inconnue";
                        break;
                }
    
                if (!auth()->guest()) {
    
                    // Verification du compte avoirs du client en espèce
                    if(isset(DB::table('avoirs')->where('id_user', auth()->user()->id)->where('gainvirtuel', '>=', $valeuradhesion)->get()[0]->gainvirtuel))
                    {
                        // Effectuer le prélèvement 
                        $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
                        $soldeac = $soldeactuel - $valeuradhesion;
                        DB::table('avoirs')
                            ->where('id_user', auth()->user()->id)
                            ->update([
                            'gainvirtuel' => $soldeac
                            ]);
    
                        $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;
    
                        //debiter le compte admin
                        $recu=$compteadmin + $valeuradhesion;
    
                        //update la table
                        DB::table('systemadmins')
                                
                                ->update([
                                'compteavoirrecu' => $recu
                                ]);
    
                        Mtnmoov::create([
                            'IdUser' => auth()->user()->id, 
                            'NomUser' => auth()->user()->nom, 
                            'EmailUser' => auth()->user()->email, 
                            'CodePersoUser' => auth()->user()->codeperso, 
                            'Tel' => request('numero'), 
                            'MontantPayer' => $valeuradhesion, 
                            'libelle' => $forfait
                        ]);
    
                        //flash("Vous recevez un message de confirmation dans un instant.");
                        $message = "Vous ".auth()->user()->nom." (".auth()->user()->email.") avez payé ".$valeuradhesion." $ SSI pour ".$forfait." sur le numéro ".request('numero').".";
                        HistoriqueClient::saveHistorique($message, auth()->user()->id );
                        flash($message);
                        return Back();
                    }
                    else
                    {
                        flash("Votre compte est insuffisant pour effectuée cette opération")->error();
    
                        return Back();
                    }
                }
                else
                {
                    flash("Vous devez être connecté pour effectuée l'achat et payer les frais à partir de vos compte avoirs. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur MTN")->error();
                    return redirect('/connexion');
                }
    
            }
    
    
            if (request('lib') == "internet") {
                request()->validate([
                    'numero' => 'required|min:0',
                    ]);
    
                $forfait = "";
                $valeuradhesion = 0;
    
                switch (request('forfaitlib')) {
                    case 11:
                        $forfait = "FORFAIT INTERNET MTN : 0.4 $ SSI (24h)";
                        $valeuradhesion = 0.4;
                        break;
                    case 12:
                        $forfait = "FORFAIT INTERNET MTN : 0.5 $ SSI (24h)";
                        $valeuradhesion = 0.5;
                        break;
                    case 13:
                        $forfait = "FORFAIT INTERNET MTN : 0.6 $ SSI (24h)";
                        $valeuradhesion = 0.6;
                        break;
                    case 1:
                        $forfait = "FORFAIT INTERNET MTN : 1 $ SSI (48h)";
                        $valeuradhesion = 1;
                        break;
                    case 2:
                        $forfait = "FORFAIT INTERNET MTN : 1 $ SSI (06jrs)";
                        $valeuradhesion = 1;
                        break;
                    case 3:
                        $forfait = "FORFAIT INTERNET MTN : 2 $ SSI (07jrs)";
                        $valeuradhesion = 2;
                        break;
                    case 4:
                        $forfait = "FORFAIT INTERNET MTN : 2 $ SSI (15jrs)";
                        $valeuradhesion = 2;
                        break;
                    case 5:
                        $forfait = "FORFAIT INTERNET MTN : 4 $ SSI (07jrs)";
                        $valeuradhesion = 4;
                        break;
                    case 6:
                        $forfait = "FORFAIT INTERNET MTN : 4 $ SSI (15jrs)";
                        $valeuradhesion = 4;
                        break;
    
                    case 7:
                        $forfait = "FORFAIT INTERNET MTN : 5 $ SSI (15jrs)";
                        $valeuradhesion = 5;
                        break;
                    case 8:
                        $forfait = "FORFAIT INTERNET MTN : 8 $ SSI (30jrs)";
                        $valeuradhesion = 8;
                        break;
                    case 9:
                        $forfait = "FORFAIT INTERNET MTN : 12 $ SSI (30jrs)";
                        $valeuradhesion = 12;
                        break;
                    case 10:
                        $forfait = "FORFAIT INTERNET MTN : 29 $ SSI (30jrs)";
                        $valeuradhesion = 29;
                        break;
                    default:
                        $forfait = "inconnue";
                        break;
                }
    
                if (!auth()->guest()) {
    
                    // Verification du compte avoirs du client en espèce
                    if(isset(DB::table('avoirs')->where('id_user', auth()->user()->id)->where('gainvirtuel', '>=', $valeuradhesion)->get()[0]->gainvirtuel))
                    {
                        // Effectuer le prélèvement 
                        $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
                        $soldeac = $soldeactuel - $valeuradhesion;
                        DB::table('avoirs')
                            ->where('id_user', auth()->user()->id)
                            ->update([
                            'gainvirtuel' => $soldeac
                            ]);
    
                        $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;
    
                        //debiter le compte admin
                        $recu=$compteadmin + $valeuradhesion;
    
                        //update la table
                        DB::table('systemadmins')
                                
                                ->update([
                                'compteavoirrecu' => $recu
                                ]);
    
                        Mtnmoov::create([
                            'IdUser' => auth()->user()->id, 
                            'NomUser' => auth()->user()->nom, 
                            'EmailUser' => auth()->user()->email, 
                            'CodePersoUser' => auth()->user()->codeperso, 
                            'Tel' => request('numero'), 
                            'MontantPayer' => $valeuradhesion, 
                            'libelle' => $forfait
                        ]);
    
                        //flash("Vous recevez un message de confirmation dans un instant.");
                        $message = "Vous ".auth()->user()->nom." (".auth()->user()->email.") avez payé ".$valeuradhesion." $ SSI pour ".$forfait." sur le numéro ".request('numero').".";
                        HistoriqueClient::saveHistorique($message, auth()->user()->id );
                        flash($message);
                        return Back();
                    }
                    else
                    {
                        flash("Votre compte est insuffisant pour effectuée cette opération")->error();
    
                        return Back();
                    }
                }
                else
                {
                    flash("Vous devez être connecté pour effectuée l'achat et payer les frais à partir de vos compte avoirs. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur MTN")->error();
                    return redirect('/connexion');
                }
            }
            
            if (request('lib') == "depot") {
    
                request()->validate([
                    'numero' => 'required|min:0',
                    'forfait' => 'required|min:0',
                    'nom' => 'required',
                    ]);
    
    
                $forfait = "Dépôt MTN ";
    
                $valeuradhesion = request('forfait');
    
                if (!auth()->guest()) {
    
                    // Verification du compte avoirs du client en espèce
                    if(isset(DB::table('avoirs')->where('id_user', auth()->user()->id)->where('gainvirtuel', '>=', $valeuradhesion)->get()[0]->gainvirtuel))
                    {
                        // Effectuer le prélèvement 
                        $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
                        $soldeac = $soldeactuel - $valeuradhesion;
                        DB::table('avoirs')
                            ->where('id_user', auth()->user()->id)
                            ->update([
                            'gainvirtuel' => $soldeac
                            ]);
    
                        $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;
    
                        //debiter le compte admin
                        $recu=$compteadmin + $valeuradhesion;
    
                        //update la table
                        DB::table('systemadmins')
                                
                                ->update([
                                'compteavoirrecu' => $recu
                                ]);
    
                        Mtnmoov::create([
                            'IdUser' => auth()->user()->id, 
                            'NomUser' => request('nom'), 
                            'EmailUser' => auth()->user()->email, 
                            'CodePersoUser' => auth()->user()->codeperso, 
                            'Tel' => request('numero'), 
                            'MontantPayer' => request('forfait'), 
                            'libelle' => $forfait,
                            'type' => "depot"
                        ]);

                        //flash("Vous recevez un message de confirmation dans un instant.");
                        $message = "Vous ".auth()->user()->nom." (".auth()->user()->email.") avez payé ".$valeuradhesion." 
                        $ SSI pour ".$forfait." sur le numéro ".request('numero').".";
                        HistoriqueClient::saveHistorique($message, auth()->user()->id );
                        flash($message);
                        return Back();
                    }
                    else
                    {
                        flash("Votre compte est insuffisant pour effectuée cette opération")->error();
    
                        return Back();
                    }
                }
                else
                {
                    flash("Vous devez être connecté pour effectuée le dépôt et payer les frais à partir de vos compte avoirs. 
                    Si vous ne possédez pas de compte, inscrivez-vous et revenez sur MTN")->error();
                    return redirect('/connexion');
                }
    
            }
            
            if (request('lib') == "p3") {
    
                $forfait = "Crédit P3";
    
                $valeuradhesion = request('forfait');
    
                if (!auth()->guest()) {
    
                    // Verification du compte avoirs du client en espèce
                    if(isset(DB::table('avoirs')->where('id_user', auth()->user()->id)->where('gainvirtuel', '>=', $valeuradhesion)->get()[0]->gainvirtuel))
                    {
                        // Effectuer le prélèvement 
                        $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
                        $soldeac = $soldeactuel - $valeuradhesion;
                        DB::table('avoirs')
                            ->where('id_user', auth()->user()->id)
                            ->update([
                            'gainvirtuel' => $soldeac
                            ]);
    
                        $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;
    
                        //debiter le compte admin
                        $recu=$compteadmin + $valeuradhesion;
    
                        //update la table
                        DB::table('systemadmins')
                                
                                ->update([
                                'compteavoirrecu' => $recu
                                ]);
    
                        Mtnmoov::create([
                            'IdUser' => auth()->user()->id, 
                            'NomUser' => auth()->user()->nom, 
                            'EmailUser' => auth()->user()->email, 
                            'CodePersoUser' => auth()->user()->codeperso, 
                            'Tel' => request('numero'), 
                            'MontantPayer' => request('forfait'), 
                            'libelle' => $forfait
                        ]);
    
                        //flash("Vous recevez un message de confirmation dans un instant.");
                        $message = "Vous ".auth()->user()->nom." ".auth()->user()->email." avez payé ".$valeuradhesion." $ SSI pour 
                        ".$forfait." sur le numéro ".request('numero').".";
                        HistoriqueClient::saveHistorique($message, auth()->user()->id );
                        flash($message);
                        return Back();
                    }
                    else
                    {
                        flash("Votre compte est insuffisant pour effectuée cette opération")->error();
    
                        return Back();
                    }
                }
                else
                {
                    flash("Vous devez être connecté pour effectuée l'pération P3 et payer les frais à partir de vos compte avoirs. 
                    Si vous ne possédez pas de compte, inscrivez-vous et revenez sur MTN")->error();
                    return redirect('/connexion');
                }
    
            }
        
        } else {
            flash("Numéro incorrect");
            return Back();
        }
    }

    // MOOV
    public function getmoov()
    { 
        return view('services_site.moov.moov');
    }

    public function setmoov(Request $request)
    {
        $num = substr(request('numero'), -8);

        $id_num = substr($num, -8, 2);

        if (InterfaceServiceProvider::verifie_moov($id_num) == 1) {
        
            if (request('lib') == "credit") {
    
                request()->validate([
                    'numero' => 'required|min:0',
                    'forfait' => 'required|min:0',
                    ]);
    
    
                $forfait = "Crédit MOOV";
    
                $valeuradhesion = request('forfait');
    
                if (!auth()->guest()) {
    
                    // Verification du compte avoirs du client en espèce
                    if(isset(DB::table('avoirs')->where('id_user', auth()->user()->id)->where('gainvirtuel', '>=', $valeuradhesion)->get()[0]->gainvirtuel))
                    {
                        // Effectuer le prélèvement 
                        $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
                        $soldeac = $soldeactuel - $valeuradhesion;
                        DB::table('avoirs')
                            ->where('id_user', auth()->user()->id)
                            ->update([
                            'gainvirtuel' => $soldeac
                            ]);
    
                        $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;
    
                        //debiter le compte admin
                        $recu=$compteadmin + $valeuradhesion;
    
                        //update la table
                        DB::table('systemadmins')
                                
                                ->update([
                                'compteavoirrecu' => $recu
                                ]);
    
                        Mtnmoov::create([
                            'IdUser' => auth()->user()->id, 
                            'NomUser' => auth()->user()->nom, 
                            'EmailUser' => auth()->user()->email, 
                            'CodePersoUser' => auth()->user()->codeperso, 
                            'Tel' => request('numero'), 
                            'MontantPayer' => request('forfait'), 
                            'libelle' => $forfait
                        ]);
    
                        //flash("Vous recevez un message de confirmation dans un instant.");
                        $message = "Vous ".auth()->user()->nom." (".auth()->user()->email.") avez payé "
                        .$valeuradhesion." $ SSI pour ".$forfait." sur le numéro ".request('numero').".";
                        HistoriqueClient::saveHistorique($message, auth()->user()->id );
                        flash($message);
                        
                        return Back();
                    }
                    else
                    {
                        flash("Votre compte est insuffisant pour effectuée cette opération")->error();
    
                        return Back();
                    }
                }
                else
                {
                    flash("Vous devez être connecté pour effectuée l'achat et payer les frais à partir de vos compte avoirs. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur MOOV")->error();
                    return redirect('/connexion');
                }
    
            }
    
            if (request('lib') == "pass") {
    
                request()->validate([
                    'numero' => 'required|min:0',
                    ]);
                $forfait = "";
                $valeuradhesion = 0;
    
                switch (request('forfaitlib')) {
                    case 1:
                        $forfait = "PASS BONUS MOOV : 1 $ SSI (48h)";
                        $valeuradhesion = 1;
                        break;
                    case 2:
                        $forfait = "PASS BONUS MOOV : 2 $ SSI (07jrs)";
                        $valeuradhesion = 2;
                        break;
                    case 3:
                        $forfait = "PASS BONUS MOOV : 3 $ SSI (07jrs)";
                        $valeuradhesion = 3;
                        break;
                    case 4:
                        $forfait = " PASS BONUS MOOV : 5 $ SSI (30jrs)";
                        $valeuradhesion = 5;
                        break;
                    case 5:
                        $forfait = "PASS BONUS MOOV : 10 $ SSI (30jrs)";
                        $valeuradhesion = 10;
                        break;
                    case 6:
                        $forfait = "PASS BONUS MOOV : 0.4 $ SSI (24h)";
                        $valeuradhesion = 0.4;
                        break;
                    case 7:
                        $forfait = "PASS BONUS MOOV : 0.5 $ SSI (24h)";
                        $valeuradhesion = 0.5;
                        break;
    
                    default:
                        $forfait = "inconnue";
                        break;
                }
    
                if (!auth()->guest()) {
    
                    // Verification du compte avoirs du client en espèce
                    if(isset(DB::table('avoirs')->where('id_user', auth()->user()->id)->where('gainvirtuel', '>=', $valeuradhesion)->get()[0]->gainvirtuel))
                    {
                        // Effectuer le prélèvement 
                        $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
                        $soldeac = $soldeactuel - $valeuradhesion;
                        DB::table('avoirs')
                            ->where('id_user', auth()->user()->id)
                            ->update([
                            'gainvirtuel' => $soldeac
                            ]);
    
                        $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;
    
                        //debiter le compte admin
                        $recu=$compteadmin + $valeuradhesion;
    
                        //update la table
                        DB::table('systemadmins')
                                
                                ->update([
                                'compteavoirrecu' => $recu
                                ]);
    
                        Mtnmoov::create([
                            'IdUser' => auth()->user()->id, 
                            'NomUser' => auth()->user()->nom, 
                            'EmailUser' => auth()->user()->email, 
                            'CodePersoUser' => auth()->user()->codeperso, 
                            'Tel' => request('numero'), 
                            'MontantPayer' => $valeuradhesion, 
                            'libelle' => $forfait
                        ]);
    
                        //flash("Vous recevez un message de confirmation dans un instant.");
                        $message = "Vous ".auth()->user()->nom." (".auth()->user()->email.") avez payé ".$valeuradhesion." $ SSI pour ".$forfait." sur le numéro ".request('numero').".";
                        HistoriqueClient::saveHistorique($message, auth()->user()->id );
                        flash($message);
                        return Back();
                    }
                    else
                    {
                        flash("Votre compte est insuffisant pour effectuée cette opération")->error();
    
                        return Back();
                    }
                }
                else
                {
                    flash("Vous devez être connecté pour effectuée l'achat et payer les frais à partir de vos compte avoirs. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur MOOV")->error();
                    return redirect('/connexion');
                }
    
            }
            
            if (request('lib') == "forfaitmoov") {
    
                request()->validate([
                    'numero' => 'required|min:0',
                    ]);
                $forfait = "";
                $valeuradhesion = 0;
    
                switch (request('forfaitlib')) {
                    case 1:
                        $forfait = "PASS BONUS + INTERNET MOOV : 1 $ SSI (48h)";
                        $valeuradhesion = 1;
                        break;
                    case 2:
                        $forfait = "PASS BONUS + INTERNET MOOV : 2 $ SSI (07jrs)";
                        $valeuradhesion = 2;
                        break;
                    case 3:
                        $forfait = "PASS BONUS + INTERNET MOOV : 3 $ SSI (07jrs)";
                        $valeuradhesion = 3;
                        break;
                    case 4:
                        $forfait = " PASS BONUS + INTERNET MOOV : 5 $ SSI (30jrs)";
                        $valeuradhesion = 5;
                        break;
                    case 5:
                        $forfait = "PASS BONUS + INTERNET MOOV : 10 $ SSI (30jrs)";
                        $valeuradhesion = 10;
                        break;
                    case 6:
                        $forfait = "PASS BONUS + INTERNET MOOV : 0.4 $ SSI (24h)";
                        $valeuradhesion = 0.4;
                        break;
                    case 7:
                        $forfait = "PASS BONUS + INTERNET MOOV : 0.5 $ SSI (24h)";
                        $valeuradhesion = 0.5;
                        break;
    
                    default:
                        $forfait = "inconnue";
                        break;
                }
    
                if (!auth()->guest()) {
    
                    // Verification du compte avoirs du client en espèce
                    if(isset(DB::table('avoirs')->where('id_user', auth()->user()->id)->where('gainvirtuel', '>=', $valeuradhesion)->get()[0]->gainvirtuel))
                    {
                        // Effectuer le prélèvement 
                        $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
                        $soldeac = $soldeactuel - $valeuradhesion;
                        DB::table('avoirs')
                            ->where('id_user', auth()->user()->id)
                            ->update([
                            'gainvirtuel' => $soldeac
                            ]);
    
                        $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;
    
                        //debiter le compte admin
                        $recu=$compteadmin + $valeuradhesion;
    
                        //update la table
                        DB::table('systemadmins')
                                
                                ->update([
                                'compteavoirrecu' => $recu
                                ]);
    
                        Mtnmoov::create([
                            'IdUser' => auth()->user()->id, 
                            'NomUser' => auth()->user()->nom, 
                            'EmailUser' => auth()->user()->email, 
                            'CodePersoUser' => auth()->user()->codeperso, 
                            'Tel' => request('numero'), 
                            'MontantPayer' => $valeuradhesion, 
                            'libelle' => $forfait
                        ]);
    
                        //flash("Vous recevez un message de confirmation dans un instant.");
                        $message = "Vous ".auth()->user()->nom." (".auth()->user()->email.") avez payé ".$valeuradhesion." $ SSI pour ".$forfait." sur le numéro ".request('numero').".";
                        HistoriqueClient::saveHistorique($message, auth()->user()->id );
                        flash($message);    
                        return Back();
                    }
                    else
                    {
                        flash("Votre compte est insuffisant pour effectuée cette opération")->error();
    
                        return Back();
                    }
                }
                else
                {
                    flash("Vous devez être connecté pour effectuée l'achat et payer les frais à partir de vos compte avoirs. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur MOOV")->error();
                    return redirect('/connexion');
                }
    
            }
    
            if (request('lib') == "forfait") {
                request()->validate([
                    'numero' => 'required|min:0',
                    ]);
    
                $forfait = "";
                $valeuradhesion = 0;
    
                switch (request('forfaitlib')) {
                    case 17:
                        $forfait = "FORFAIT INTERNET MOOV : 0.4 $ SSI (24h)";
                        $valeuradhesion = 0.4;
                        break;
                    case 18:
                        $forfait = "FORFAIT INTERNET MOOV : 0.5 $ SSI (24h)";
                        $valeuradhesion = 0.5;
                        break;
                    case 19:
                        $forfait = "FORFAIT INTERNET MOOV : 0.6 $ SSI (24h)";
                        $valeuradhesion = 0.6;
                        break;
                    case 1:
                        $forfait = "FORFAIT INTERNET MOOV : 1 $ SSI (48h)";
                        $valeuradhesion = 1;
                        break;
                    case 2:
                        $forfait = "FORFAIT INTERNET MOOV : 1 $ SSI (06jrs)";
                        $valeuradhesion = 1;
                        break;
                    case 3:
                        $forfait = "FORFAIT INTERNET MOOV : 2 $ SSI (07jrs)";
                        $valeuradhesion = 2;
                        break;
                    case 4:
                        $forfait = "FORFAIT INTERNET MOOV : 4 $ SSI (7jrs)";
                        $valeuradhesion = 4;
                        break;
                    case 5:
                        $forfait = "FORFAIT INTERNET MOOV : 4 $ SSI (30jrs)";
                        $valeuradhesion = 4;
                        break;
                    case 6:
                        $forfait = "FORFAIT INTERNET MOOV : 5 $ SSI (30jrs)";
                        $valeuradhesion = 5;
                        break;
    
                    case 7:
                        $forfait = "FORFAIT INTERNET MOOV : 8 $ SSI (30jrs)";
                        $valeuradhesion = 8;
                        break;
                    case 8:
                        $forfait = "FORFAIT INTERNET MOOV : 10 $ SSI (30jrs)";
                        $valeuradhesion = 10;
                        break;
                    case 9:
                        $forfait = "FORFAIT INTERNET MOOV : 12 $ SSI (30jrs)";
                        $valeuradhesion = 12;
                        break;
                    case 10:
                        $forfait = "FORFAIT INTERNET MOOV : 18 $ SSI (30jrs)";
                        $valeuradhesion = 18;
                        break;
                    case 11:
                        $forfait = "FORFAIT INTERNET MOOV : 30 $ SSI (illimité)";
                        $valeuradhesion = 30;
                        break;
                    case 12:
                        $forfait = "FORFAIT INTERNET MOOV : 40 $ SSI (illimité)";
                        $valeuradhesion = 40;
                        break;
                    case 13:
                        $forfait = "FORFAIT INTERNET MOOV : 50 $ SSI (illimité)";
                        $valeuradhesion = 50;
                        break;
                    case 14:
                        $forfait = "FORFAIT INTERNET MOOV : 60 $ SSI (illimité)";
                        $valeuradhesion = 60;
                        break;
                    case 15:
                        $forfait = "FORFAIT INTERNET MOOV : 100 $ SSI (illimité)";
                        $valeuradhesion = 100;
                        break;
                    case 16:
                        $forfait = "FORFAIT INTERNET MOOV : 150 $ SSI (illimité)";
                        $valeuradhesion = 150;
                        break;
    
                    default:
                        $forfait = "inconnue";
                        break;
                }
    
                if (!auth()->guest()) {
    
                    // Verification du compte avoirs du client en espèce
                    if(isset(DB::table('avoirs')->where('id_user', auth()->user()->id)->where('gainvirtuel', '>=', $valeuradhesion)->get()[0]->gainvirtuel))
                    {
                        // Effectuer le prélèvement 
                        $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
                        $soldeac = $soldeactuel - $valeuradhesion;
                        DB::table('avoirs')
                            ->where('id_user', auth()->user()->id)
                            ->update([
                            'gainvirtuel' => $soldeac
                            ]);
    
                        $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;
    
                        //debiter le compte admin
                        $recu=$compteadmin + $valeuradhesion;
    
                        //update la table
                        DB::table('systemadmins')
                                
                                ->update([
                                'compteavoirrecu' => $recu
                                ]);
    
                        Mtnmoov::create([
                            'IdUser' => auth()->user()->id, 
                            'NomUser' => auth()->user()->nom, 
                            'EmailUser' => auth()->user()->email, 
                            'CodePersoUser' => auth()->user()->codeperso, 
                            'Tel' => request('numero'), 
                            'MontantPayer' => $valeuradhesion, 
                            'libelle' => $forfait
                        ]);
    
                        //flash("Vous recevez un message de confirmation dans un instant.");
                        $message = "Vous ".auth()->user()->nom." (".auth()->user()->email.") avez payé ".$valeuradhesion." $ SSI pour ".$forfait." sur le numéro ".request('numero').".";
                        HistoriqueClient::saveHistorique($message, auth()->user()->id );
                        flash($message);
                        return Back();
                    }
                    else
                    {
                        flash("Votre compte est insuffisant pour effectuée cette opération")->error();
    
                        return Back();
                    }
                }
                else
                {
                    flash("Vous devez être connecté pour effectuée l'achat et payer les frais à partir de vos compte avoirs. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur MOOV")->error();
                    return redirect('/connexion');
                }
            }
            
            if (request('lib') == "depot") {
    
                request()->validate([
                    'numero' => 'required|min:0',
                    'forfait' => 'required|min:0',
                    'nom' => 'required',
                    ]);
    
    
                $forfait = "Dépôt MOOV";
    
                $valeuradhesion = request('forfait');
    
                if (!auth()->guest()) {
    
                    // Verification du compte avoirs du client en espèce
                    if(isset(DB::table('avoirs')->where('id_user', auth()->user()->id)->where('gainvirtuel', '>=', $valeuradhesion)->get()[0]->gainvirtuel))
                    {
                        // Effectuer le prélèvement 
                        $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainvirtuel;
                        $soldeac = $soldeactuel - $valeuradhesion;
                        DB::table('avoirs')
                            ->where('id_user', auth()->user()->id)
                            ->update([
                            'gainvirtuel' => $soldeac
                            ]);
    
                        $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;
    
                        //debiter le compte admin
                        $recu=$compteadmin + $valeuradhesion;
    
                        //update la table
                        DB::table('systemadmins')
                                
                                ->update([
                                'compteavoirrecu' => $recu
                                ]);
    
                        Mtnmoov::create([
                            'IdUser' => auth()->user()->id, 
                            'NomUser' => request('nom'), 
                            'EmailUser' => auth()->user()->email, 
                            'CodePersoUser' => auth()->user()->codeperso, 
                            'Tel' => request('numero'), 
                            'MontantPayer' => request('forfait'), 
                            'libelle' => $forfait,
                            'type' => "depot"
                        ]);
    
    
                        //flash("Vous recevez un message de confirmation dans un instant.");
                        $message = "Vous ".auth()->user()->nom." (".auth()->user()->email.") avez payé "
                        .$valeuradhesion." $ SSI pour ".$forfait." sur le numéro ".request('numero').".";
                        HistoriqueClient::saveHistorique($message, auth()->user()->id );
                        flash($message);
                        
                        return Back();
                    }
                    else
                    {
                        flash("Votre compte est insuffisant pour effectuée cette opération")->error();
    
                        return Back();
                    }
                }
                else
                {
                    flash("Vous devez être connecté pour effectuée le dépôt et payer les frais à partir de vos compte avoirs. 
                    Si vous ne possédez pas de compte, inscrivez-vous et revenez sur MOOV")->error();
                    return redirect('/connexion');
                }
    
            }

        } else {
            flash("Numéro incorrect");
            return Back();
        }
    }
    

 }