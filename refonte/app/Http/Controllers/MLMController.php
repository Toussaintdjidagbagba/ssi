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

class MLMController extends Controller
{
	public function getajoutfilleul()
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
        return view('client.ajoutfilleul', $data);
    }

    public function ajoutfilleul()
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

        //dd(request());

        if (request('password') != request('passwordbis')) {
            flash("Mot de passe incorrect! Veuillez vérifier")->error();
            return Back();
        }
        
        $temp_id = array("0");

        $code_pays = '';
        if (isset(DB::table('pays')->select('code')->where('libelle', request('pays'))->get()[0]->code)) {
            $code_pays = DB::table('pays')->select('code')->where('libelle', request('pays'))->get()[0]->code;
        }

        // Verification si parrain existe

        $exit = InterfaceServiceProvider::verificationCodeUnique(request('parrain'));

        // Préparation du compte du filleul
        $cocher = request('cocherparrain');

        //dd($exit);
        if ($exit != "0" && isset($cocher)) {
                flash("Veuillez entrer soit  votre code parrain ou choisir 'Pas de code de parrainage'.")->error();
                return Back();
            }

        if ($exit != "0" || isset($cocher)) {
            // C'est bon
            // Le code de parrainage est bon
            
            $parrain = 0;

            if (isset($cocher)) { // Verification sur checkbox est true 
                // Si oui donner le code parrainage de l'administrateur

                // Code de parrainage de l'admin
                $parrain = DB::table('systemadmins')->select('codeparrainadmin')->where('Admin', 'oui')->get()[0]->codeparrainadmin;
            }
            else
            {
                $parrain = request('parrain');
            }

            // Combien de compte à creer

            $nombreCompte = 0;

            switch (request('pack')) {
                case '10 $ SSI':
                    $nombreCompte = 1;
                    break;
                case '60 $ SSI':
                    $nombreCompte = 6;
                    break;
                case '620 $ SSI':
                    $nombreCompte = 62;
                    break;
                case '5100 $ SSI':
                    $nombreCompte = 510;
                    break;
                default:
                    flash('Erreur système. Code M1.')->error();
                    return Back();
                    break;
            }

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



            // Boucle for 
            // nomuser varie = pseudo+i
            for ($i=0; $i < $nombreCompte; $i++) { 
                
                //echo $i;
                if ($i == 0) {
                   $temp_ps = '';
                } else {
                   $temp_ps = $i + 1;
                }

                $temp_pseudo = $pseudo_filleul.''.$temp_ps;
                //echo $i;

            // Si code parrain est de l'admin alors passe

            $var_type = DB::table('users')->select('type')->where('codeunique', $parrain)->get()[0]->type;

            if ($var_type == "admin") {
                // Générer un code Unique comme code de parrainage pour filleul

                $code_unique = InterfaceServiceProvider::generercodeunique();

                $code_id_unique = InterfaceServiceProvider::genereridunique();

                $paiement_id = DB::table('moyen_payements')->select('id')->where('libelle', request('payement'))->get()[0]->id;

                
                if (!isset(DB::table('users')
                            ->where('email', request('mail'))
                            ->where('nomuser', $temp_pseudo)
                            ->get()[0]->nomuser)) {

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
                        'moyendepayement' => $paiement_id
                    ]);

                    $users_id = DB::table('users')
                            ->where('email', request('mail'))
                            ->where('nomuser', $temp_pseudo)
                            ->get()[0]->id;

                    //$data = [
                      //  'id_user' => $users_id
                    //];

                    array_push($temp_id, $users_id);

                    /* IndexController::EnvoieMail(request('mail'), "https://sourcedusuccesinternational.com/validerpayement", "Validation de compte sur SSI", "Cliquez sur le lien suivant pour finaliser votre inscription");                    
                    
                        flash("Demander à votre filleul de consulter sa boite mail pour valider le paiement et valider son inscription");
                        return Back(); */
                 }
                else
                {
                    flash("Le pseudo existe déjà pour ce mail... Veuillez vous connecter ou cliquer sur mot de passe oublié si vous ne sourvenez pas.")->error();
                    return Back();

                }
            }
            else
            {// si non verifier le nombre de filleul ou d'etape du parrain
                $var_id_parrain = DB::table('users')->select('id')->where('codeunique', $parrain)->get()[0]->id;

                // Vérification du nombre de filleul trouver
                $filleul = DB::table('users')
                     ->select(DB::raw('count(*) as user_count'))
                     ->where('parrain', $parrain)
                     ->get()[0]->user_count;
                    
                    // Verification de l'etape actuel du parrain

                    $etape_actuel = IndexController::Etape_ActuelParrain($var_id_parrain);

                    if($etape_actuel > 8)
                    {

                        // Veuillez demander un nouveau code de parrainage

                        $data = [
                            'id1' => $temp_id,
                            'payerf' => request('payerf'),
                            'position_actuel' => $temp_ps,
                            'nom' => request('nom'),
                            'prenom' => request('prenom'),
                            'sexe'=> request('sexe'), 
                            'tel' => $code_pays.''.request('tel'), 
                            'compteactive' => "non",
                            'email' => request('mail'),
                            'password' => request('password'),
                            'pseudo' => $pseudo_filleul,
                            'moyendepayement' => $paiement_id,
                            'compteacreer' => $nombreCompte
                        ];
 
                        return view('authentification.valideparrain', $data);
                    }
                    else
                    {
                    // Laisser passer

                        $code_unique = InterfaceServiceProvider::generercodeunique();

                        $code_id_unique = InterfaceServiceProvider::genereridunique();

                        $paiement_id = DB::table('moyen_payements')->select('id')->where('libelle', request('payement'))->get()[0]->id;
                        
                        if (!isset(DB::table('users')
                            ->where('email', request('mail'))
                            ->where('nomuser', $temp_pseudo)
                            ->get()[0]->nomuser)) {
                        
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
                        'moyendepayement' => $paiement_id
                        ]);

                        $users_id = DB::table('users')
                                ->where('email', request('mail'))
                                ->where('nomuser', $temp_pseudo)
                                ->get()[0]->id;

                        array_push($temp_id, $users_id);

                        }
                        else
                        {
                            flash("Le pseudo existe déjà pour ce mail... Veuillez vous connecter ou cliquer sur mot de passe oublié si vous ne sourvenez pas.")->error();
                            return Back();

                        }
                    }
                }
            }
                        // Envoie mail d'approbation
                        $mailparrain = InterfaceServiceProvider::MailParrain($parrain);
                        $codeapprobation = InterfaceServiceProvider::generercodeapprobation();
                        IndexController::EnvoieMail($mailparrain, "Donnez à ".request('prenom')." ".request('nom')." ce code d'approbation : ".$codeapprobation." pour qu'il autorise son l'inscription de ".$nombreCompte." compte(s). Rassurez-vous d'avoir le minimum dans votre compte avoir", "Approbation de compte sur SSI", "Donner l'accord à un filleul de défalquer de votre compte pour s'inscrire");


                        $result = json_encode([
                            'id_user' => $temp_id,
                            'nombrefois' => $nombreCompte,
                            'approbation' => $codeapprobation  
                        ]);

                        $data = [
                            'idres' => $result
                        ];
                        
                        // recuperer le premier id
                        return view('authentification.approbation', $data);
                        
        }
        else
        {   // renvoyer un message disant que le code de parrainage est inconnue et aucune option n'est cocher.

            flash("Le code de parrainage est inconnue et aucune option n'est cocher. Veuillez vérifier")->error();
            return Back();
        }
    }
}