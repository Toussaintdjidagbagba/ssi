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

class AuthentificationClientController extends Controller
{
    public function seconnecter(){return view('authentification.login');}

    public function inscription()
    {
        $mps = DB::table('moyen_payements')
        ->select('libelle')
        ->get();

        $monnaie = DB::table('systemadmins')
        ->select('Monnaie')
        ->get();

        $pays = DB::table('pays')
        ->select('libelle')
        ->get();

        $pack = DB::table('packs')
        ->get();

        $data = ['mps' => $mps, 'pays' => $pays, 'monnaie' => $monnaie, 'pack' => $pack];

        return view('authentification.register', $data);   
    }

    public function inscriptionlink() 
    {
        $mps = DB::table('moyen_payements')
        ->select('libelle')
        ->get();

        $monnaie = DB::table('systemadmins')
        ->select('Monnaie')
        ->get();

        $pays = DB::table('pays')
        ->select('libelle')
        ->get();

        $pack = DB::table('packs')
        ->get();

        $data = ['mps' => $mps, 'pays' => $pays, 'monnaie' => $monnaie, 'link'=> request('parrain'), 'pack' => $pack];

        return view('authentification.register', $data);   
    }


    public function saveseconnecter(Request $request)
    {

        request()->validate([
            'mail' => 'required|string|max:255',
            'password' => 'required'
        ]);

        $resultat = auth()->attempt([
            'nomuser' => request('mail'),
            'password' => request('password')
        ]);

        if ($resultat) {

            $activation = DB::table('users')
            ->select('compteactive')
            ->where('nomuser', request('mail'))
            ->get()[0]->compteactive;

            if ($activation == "oui") {
                if (AuthentificationClientController::users(request('mail'))) {
                    return redirect('/admin/dashboard');    
                }
                if (!AuthentificationClientController::users(request('mail'))) {
                    return redirect('/dashboard');    
                }                
            }
            else
            {
                $parrain = DB::table('users')->select('parrain')->where('id', auth()->user()->id)->get()[0]->parrain;
                $mailparrain = InterfaceServiceProvider::MailParrain($parrain);
                $pack = auth()->user()->Pack;
                if ($pack == 1) { // 1 pour Pack Visiteur 0 $ SSI
                    $mes = "Donnez à ".auth()->user()->prenom." ".auth()->user()->nom." ce code d'approbation : ".auth()->user()->Approbation." afin que M/Mme ".request('nom')." puisse valider son inscription.";

                    InterfaceServiceProvider::EnvoieMail($mailparrain, $mes, "Approbation de compte sur SSI", "Donner l'accord à un filleul de valider son inscription");
                }else{
                    $mes = "Donnez à ".auth()->user()->prenom." ".auth()->user()->nom." ce code d'approbation : ".auth()->user()->Approbation." afin que M/Mme ".auth()->user()->nom." autorise son l'inscription.  Rassurez-vous d'avoir le minimum dans votre compte avoir";

                    InterfaceServiceProvider::EnvoieMail($mailparrain, $mes, "Approbation de compte sur SSI", "Donner l'accord à un filleul de défalquer de votre compte pour s'inscrire");
                }

                Session::put('iduser', auth()->user()->id);

                return view('authentification.approbation');

            }

        } else {

            $resultat = auth()->attempt([
                'codeperso' => request('mail'),
                'password' => request('password')
            ]);

            if ($resultat) {

                $activation = DB::table('users')
                ->select('compteactive')
                ->where('codeperso', request('mail'))
                ->get()[0]->compteactive;

                if ($activation == "oui") {
                    if (AuthentificationClientController::usersid(request('mail'))) {
                        return redirect('/admin/dashboard');    
                    }
                    if (!AuthentificationClientController::usersid(request('mail'))) {
                        return redirect('/dashboard');    
                    }                
                }
                else
                {
                    $parrain = DB::table('users')->select('parrain')->where('id', auth()->user()->id)->get()[0]->parrain;
                    $mailparrain = InterfaceServiceProvider::MailParrain($parrain);
                    $pack = auth()->user()->Pack;
                    if ($pack == 1) { // 1 pour Pack Visiteur 0 $ SSI
                        $mes = "Donnez à ".auth()->user()->prenom." ".auth()->user()->nom." ce code d'approbation : ".auth()->user()->Approbation." afin que M/Mme ".request('nom')." puisse valider son inscription.";

                        InterfaceServiceProvider::EnvoieMail($mailparrain, $mes, "Approbation de compte sur SSI", "Donner l'accord à un filleul de valider son inscription");
                    }else{
                        $mes = "Donnez à ".auth()->user()->prenom." ".auth()->user()->nom." ce code d'approbation : ".auth()->user()->Approbation." afin que M/Mme ".auth()->user()->nom." autorise son l'inscription.  Rassurez-vous d'avoir le minimum dans votre compte avoir";

                        InterfaceServiceProvider::EnvoieMail($mailparrain, $mes, "Approbation de compte sur SSI", "Donner l'accord à un filleul de défalquer de votre compte pour s'inscrire");
                    }

                    Session::put('iduser', auth()->user()->id);

                    return view('authentification.approbation');

                }
            }
        }
        return Back()->withInput()->withErrors([
            'mail' => 'Veuillez vérifier le pseudo ou identifiant code',
            'password' => 'Veuillez vérifier le mot de passe'
        ]);
    }

    public function saveinscription(Request $request)
    {
        request()->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'pays' => 'required|max:255',
            'tel' => 'required|int',
            'mail' => 'required|string|email|max:255',
            'educ' => 'required|max:255',
            'sexe' => 'required|max:10',
            'parrain' => 'max:8',
            'pseudo' => 'required|string|max:255',
            'password' => 'required',
            'passwordbis' => 'required',
            'pack' => 'required',
            'payerf' =>'required',
        ]);

        if (request('password') != request('passwordbis')) {
            flash("Mot de passe incorrect! Veuillez vérifier")->error();
            return Back();
        }
        
        //$codep = DB::table('pays')->select('code')->where('libelle', request('pays'))->get()[0]->code;
        $code_pays = '';
        if (isset(DB::table('pays')->select('code')->where('libelle', request('pays'))->get()[0]->code)) {
            $code_pays = DB::table('pays')->select('code')->where('libelle', request('pays'))->get()[0]->code;
        }

        // Verification si parrain existe

        $exit = InterfaceServiceProvider::verificationCodeUnique(request('parrain'));

        // Préparation du compte du filleul
        //$cocher = request('cocherparrain');

        //dd($exit);
        if ($exit != "0" && request('cocherparrain')) {
            flash("Veuillez entrer soit le code du parrain ou choisissez 'Pas de code de parrainage'.")->error();
            return Back();
        }

        if ($exit != "0" || request('cocherparrain')) {
            $parrain = 0;
            if (request('cocherparrain')) { // Verification sur checkbox est true 
                // Si oui donner le code parrainage de l'administrateur
                // Code de parrainage de l'admin
                $parrain = DB::table('systemadmins')->select('codeparrainadmin')->first()->codeparrainadmin;
            }
            else
            {
                $parrain = request('parrain');
            }
            
            $pack = request('pack');

            //  Payer  par parrain
            if (request('payerf') == 'NON'){
                flash("Vous n'avez que le choix de vous fait payer par votre parrain actuel")->error();
                return Back();
            }

            // Variable initialiser retour
            $data = [
                'id_user' => 1,
                'nombrefois' => 1,
                'approbation' => ''
            ];

            $pseudo_filleul = request('pseudo');

            $temp_pseudo = $pseudo_filleul;


                        // Envoie mail d'approbation
            $mailparrain = InterfaceServiceProvider::MailParrain($parrain);
            $codeapprobation = InterfaceServiceProvider::generercodeapprobation();

                    // Générer un code Unique comme code de parrainage
            $code_unique = InterfaceServiceProvider::generercodeunique();

            $code_id_unique = InterfaceServiceProvider::genereridunique();

            $paiement_id = DB::table('moyen_payements')->select('id')->where('libelle', request('payement'))->get()[0]->id;
            
            //dd($codeapprobation);

            if (!isset(DB::table('users')->where('email', request('mail'))->where('nomuser', $temp_pseudo)->get()[0]->nomuser)) {
                $create = User::create([
                    'nom' => request('nom'),
                    'prenom' => request('prenom'),
                    'sexe'=> request('sexe'), 
                    'tel' => $code_pays.''.request('tel'), 
                    'compteactive' => "non",
                    'email' => request('mail'),
                    'password' => bcrypt(request('password')), 
                    'type' => "client",
                    'codeunique' => $code_unique, 
                    'otp' => '',
                    'nomuser' => $temp_pseudo,
                    'codeperso' => $code_id_unique,
                    'compteavoir' => '',
                    'parrain' => $parrain,
                    'Pack' => $pack,
                    'Approbation' => $codeapprobation,
                    'moyendepayement' => $paiement_id
                ]);                       
            }
            else
            {
                flash("Le pseudo existe déjà pour ce mail... Veuillez vous connecter ou cliquer sur mot de passe oublié si vous ne sourvenez pas.")->error();
                return Back();

            }

            if ($pack == 1) { // 1 pour Pack Visiteur 0 $ SSI
                $mes = "Donnez à ".request('prenom')." ".request('nom')." ce code d'approbation : ".$codeapprobation." afin que M/Mme ".request('nom')." puisse valider son inscription.";

                InterfaceServiceProvider::EnvoieMail($mailparrain, $mes, "Approbation de compte sur SSI", "Donner l'accord à un filleul de valider son inscription");
            }else{
                $mes = "Donnez à ".request('prenom')." ".request('nom')." ce code d'approbation : ".$codeapprobation." afin que M/Mme ".request('nom')." autorise son l'inscription.  Rassurez-vous d'avoir le minimum dans votre compte avoir";

                InterfaceServiceProvider::EnvoieMail($mailparrain, $mes, "Approbation de compte sur SSI", "Donner l'accord à un filleul de défalquer de votre compte pour s'inscrire");
            }

            $users_id = DB::table('users')->where('email', request('mail'))->where('nomuser', $temp_pseudo)->get()[0]->id;

            Session::put('iduser', $users_id);

            return view('authentification.approbation');

            // Si le parrain atteint les  8 etapes alors impossible de continuer
        }
        else
        {
            flash("Le code de parrainage est inconnue et aucune option n'est cocher. Veuillez vérifier")->error();
            return Back();
        }
    }

    public function validerpayement()
    {
        return view('authentification.effectuerpayement');
    }

    public function traitementpayement()
    {
        if (session('iduser') != null && session('iduser') != "") {
            $iduser = session('iduser');

            $data_user = DB::table('users')->where('id', $iduser)->first();

            $approbation = $data_user->Approbation;

            if ($approbation == request('parraincode')) {

                $active = DB::table('users')->select('compteactive')->where('id', $iduser)->first()->compteactive;

                if ($active == "non") {

                    //Verifier si le solde du parrain suffit et valider
                    $pa = DB::table('users')->select('parrain')->where('id', $iduser)->get()[0]->parrain;

                    $id_pa = DB::table('users')->select('id')->where('codeunique', $pa)->get()[0]->id;

                    $verifsolde = DB::table('avoirs')->select('gainespece')->where('id_user', $id_pa)->get()[0]->gainespece;

                    $valeur_a_payer = DB::table('packs')->where('id', $data_user->Pack)->first()->valeur;

                    if ($verifsolde >= $valeur_a_payer) {
                        $soldea = $verifsolde - $valeur_a_payer;
                        DB::table('avoirs')
                        ->where('id_user', $id_pa)
                        ->update(['gainespece' => $soldea]);
                    } 
                    else 
                    {
                        if (!isset(DB::table('systemadmins')
                            ->select('id_AdminPrincipal')
                            ->where('id_AdminPrincipal', $id_pa)
                            ->get()[0]->id_AdminPrincipal)) 
                        {
                            flash("Le solde du parrain est insuffisant.")->error();
                            return Back();
                        }
                        else
                        {
                            flash("Patienter pendant que l'administrateur vérifie le compte et vous active.")->error();
                            return Back();
                        }
                    }

                    // Procédure d'activation

                    // Initialisation du compte avoir de l'utilisateur

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

                    $gaincommissionvente_actuel_mise_a_jour = $gaincommissionvente_actuel + $gain_espece;
                    DB::table('avoirs')
                    ->where('id_user', $id_pa)
                    ->update(['gaincommissionvente' => $gaincommissionvente_actuel_mise_a_jour]);

                    // Compte de l'administrateur
                    $gainsadmin_actuel = InterfaceServiceProvider::AdminCompteRecu();

                    $gainsadmin_actuel_mise_a_jour = $gainsadmin_actuel + $valeur_a_payer;
                    DB::table('systemadmins')->update(['compteavoirrecu' => $gainsadmin_actuel_mise_a_jour]);


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

            }else{
                flash("Le code saisir est incorrect. Veuillez vérifier")->error();
                return Back();
            }

        } else {
            // Erreur ID n'existe pas
            return redirect('/');
        }
    }

    public function users($value)
    {
        // Verification du type de l'utilisateur
        $var = DB::table('users')
        ->select('type')
        ->where('nomuser', $value)
        ->get()[0]->type;

        if ($var == "admin") {
            return true;
        }
        if ($var == "client") {
            return false;
        }
    }

    public function usersid($value)
    {
        // Verification du type de l'utilisateur
        $var = DB::table('users')
        ->select('type')
        ->where('codeperso', $value)
        ->get()[0]->type;

        if ($var == "admin") {
            return true;
        }
        if ($var == "client") {
            return false;
        }
    }


}