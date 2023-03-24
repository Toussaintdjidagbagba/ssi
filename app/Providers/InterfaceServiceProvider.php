<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use App\Historique;
use App\HistoriqueClient;
use App\Articlepdf;
use App\Galerie;
use App\Evenement;
use App\Notificationcontact;
use App\User;
use App\Avoir;
use App\Models\ServiceModel;
use App\Etape;
use App\Mesformation;
use App\MoyenPayement;
use App\Niveau;
use App\Systemadmin; 
use App\Translationuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SendMail;

class InterfaceServiceProvider extends ServiceProvider
{
    
    public static function valPV($etp){
        return DB::table('etapes')->where('id', $etp)->first()->pv;
    }
    
    public static function LibelleRole($id)
    {
        $role = DB::table('roles')->where('idRole', $id)->first();
        if(isset($role->libelle))
            return $role->libelle;  
        return "";      
    }

    public static function sexe($sigle)
    {
        if ($sigle == 'M') return "Masculin";
        if ($sigle == 'F') return "Féminin";
    }

    public static function LibelleUser($id)
    {
        $user = DB::table('utilisateurs')->where('idUser', $id)->first();
        return $user->nom.' '.$user->prenom;        
    }
    
    public static function LibelleFilleul($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return $user->nom.' '.$user->prenom;        
    }
    
    public static function photoFilleul($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return $user->photo;        
    }
    
    public static function getoppnombre(){
        
        $nm = DB::table('servicemodels')->select("idS")->where("statut", 0)->where('destinataire', auth()->user()->id)->get();
        
        return count($nm);
    }
    
    public static function identiFilleul($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return $user->numidentite;        
    }

    public static function AllRole()
    {
        return DB::table('roles')->get();
    }

    public static function libmenu($id)
    {
        if ($id == 0) {
            return '';
        }else
        return DB::table('menus')->where('idMenu', $id)->first()->libelleMenu;
    }
    
    public static function recupactions($value)
    { 
        return DB::table('action_menus')->where('Menu', $value)->get();
    }

    public static function actionMenu($menu)
    {
        return DB::table('action_menus')->where('Menu', $menu)->get();
    }
    
    public static function AllHist()
    {
        return DB::table('historique_clients')->where('user_action', auth()->user()->id)->orderBy('id', 'desc')->paginate(3);
    }

    public static function libellePack($value)
    {
        return DB::table('packs')->where('id', $value)->first()->libelle;
    }

    public static function allPacks()
    {
        return DB::table('packs')->get();
    }
    
    public static function notif($lib){
        switch ($lib) {
            case "canal":
                $n = DB::table('canals')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
                return $n;
                break;
            case "mtnmoovceltiisnsiag":
                $n = DB::table('mtnmoovs')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
                return $n;
                break;
            case "achat":
                $n = DB::table('achatssis')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 0)->where('statut', '!=', 3)->get()[0]->attente;
                return $n;
                break;
            case "visa":
                $n = DB::table('retraitvisas')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 0)->where('Statut', '!=', 3)->get()[0]->attente;
                return $n;
                break;
            case "sbeecarte":
                $n = DB::table('sbeecartes')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
                return $n;
                break;
            case "sbeeconv":
                $n = DB::table('sbeeconventiels')->select(DB::raw('count(Statut) as attente'))->where('Statut', 'non')->where('Statut', '!=', 'sup')->get()[0]->attente;
                return $n;
                break;
            case "soneb":
                $n = DB::table('sonebs')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=' , 'Oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
                return $n;
                break;
            case "mtn":
                return DB::table('retraitmtns')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
                break;
            case "moov":
                return DB::table('retraitmoovs')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
                break;
            case "western":
                return DB::table('retraitwesterns')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
                break;
            case "perfect":
                return DB::table('retraitperfects')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
                break;
            case "trust":
                return DB::table('retraittrusts')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
                break;
            case "gram":
                return DB::table('retraitgrams')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
                break;
        }
        
        return 0;
    }

    public static function GetTaux($pack, $service, $user, $value=0)
    {
        // CVV Commission sur vente vers virtuel
        // TC transfert entre espèce
        // CVE Commission sur vente vers espèce
        // RMTN
        // SV Service Visa
        // RTRUST Retrait TRUST
        // SCANAL service canal
        // SSONEB service soneb
        // SMTNP3 service p3
        if ($service == "NSIAAUTO" && $user == "client") {
            if ($pack == 1) {
                return 1;
            }
            if ($pack == 2) {
                return 3.2;
            }
            return 0;
            //return 2;
        }
        
        if ($service == "NSIAGB" && $user == "client") {
            if ($pack == 1) {
                return 2;
            }
            if ($pack == 2) {
                return 18;
            }
            return 0;
            //return 2;
        }
        
        if ($service == "SNSIAG" && $user == "client") {
            return 0.4;
            //return 2;
        }

        if ($service == "TC" && $user == "client") {
            return 0;
            //return 2;
        }

        if ($service == "CVV" && $user == "client") {
            return 0;
        }

        if ($service == "CVE" && $user == "client") {
            return 0;
        }

        if ($service == "RMTN" && $user == "client") {
            return 5;
        }

        if ($service == "RMOOV" && $user == "client") {
            return 5;
        }

        if ($service == "RWESTERN" && $user == "client") {
            return 5;
        }

        if ($service == "RGRAM" && $user == "client") {
            return 5;
        }

        if ($service == "RPERFECT" && $user == "client") {
            return 5;
        }

        if ($service == "RTRUST" && $user == "client") {
            return 5;
        }

        if ($service == "SV" && $user == "client") {
            return 1;
        }

        if ($service == "SCANAL" && $user == "client") {
            if ($pack == 1) {
                return 0.5;
            }
            if ($pack == 2) {
                return 2;
            }
            if ($pack == 3) {
                return 4;
            }
            if ($pack == 4) {
                return 4;
            }
        }

        if ($service == "SSONEB" && $user == "client") {
            if ($pack == 1) {
                return 0.5;
            }
            if ($pack == 2) {
                return 35;
            }
            if ($pack == 3) {
                return 50;
            }
            if ($pack == 4) {
                return 75;
            }
        } 

        if ($service == "SSBEE" && $user == "client") {
            if ($pack == 1) {
                return 0.5;
            }
            if ($pack == 2) {
                return 35;
            }
            if ($pack == 3) {
                return 50;
            }
            if ($pack == 4) {
                return 75;
            }
        }

        if ($service == "SSBEECONVENTIONNEL" && $user == "client") {
            if ($pack == 1) {
                return 0.5;
            }
            if ($pack == 2) {
                return 35;
            }
            if ($pack == 3) {
                return 50;
            }
            if ($pack == 4) {
                return 75;
            }
        }

        if ($service == "SDVISA" && $user == "client") {
            if ($pack == 1) {
                return 0.5;
            }
            if ($pack == 2) {
                return 35;
            }
            if ($pack == 3) {
                return 50;
            }
            if ($pack == 4) {
                return 75;
            }
        }

        if ($service == "SMTNP3" && $user == "client") {
            if ($pack == 1) {
                return 0;
            }
            if ($pack == 2) {
                return 0.4;
            }
            if ($pack == 3) {
                return 0.4;
            }
            if ($pack == 4) {
                return 0.4;
            }
        }

        if ($service == "SMTNAUTRE" && $user == "client") {
            if ($pack == 1) {
                return 0.5;
            }
            if ($pack == 2) {
                return 2;
            }
            if ($pack == 3) {
                return 4;
            }
            if ($pack == 4) {
                return 4;
            }
        }

        if ($service == "SMTNDEPOT" && $user == "client") {
            if ($pack == 1) {
                return 0;
            }
            if ($pack == 2) {
                return 0;
            }
            if ($pack == 3) {
                return 0;
            }
            if ($pack == 4) {
                return 0;
            }
        }
        
        if ($service == "sretraitssi" && $user == "client"){
            $valeurssi = 500;

            $valeurfcfa = $value * $valeurssi;
    
            if ($valeurfcfa >= 1 && $valeurfcfa <=500) {
                return (40 / $valeurssi);
            } else {
                if ($valeurfcfa > 500 && $valeurfcfa <=5000) {
                    
                    return (95 / $valeurssi);
                } else {
                    if ($valeurfcfa > 5000 && $valeurfcfa <=10000)
                        return (170 / $valeurssi);
                    else
                        if ($valeurfcfa > 10000 && $valeurfcfa <=20000)
                            return (325 / $valeurssi);
                        else
                            if ($valeurfcfa > 20000 && $valeurfcfa <=50000)
                                return (650 / $valeurssi);
                            else
                                if ($valeurfcfa > 50000 && $valeurfcfa <=100000)
                                    return (950 / $valeurssi);
                                else
                                    if ($valeurfcfa > 100000 && $valeurfcfa <=200000)
                                        return (1900 / $valeurssi);
                                    else
                                        if ($valeurfcfa > 200000 && $valeurfcfa <=300000)
                                            return (2800 / $valeurssi);
                                        else
                                            if ($valeurfcfa > 300000 && $valeurfcfa <=500000)
                                                return (3250 / $valeurssi);
                                            else
                                                if ($valeurfcfa > 500000 && $valeurfcfa <=2000000)
                                                    return (4900 / $valeurssi);
                                                else
                                                    return (0);
                }
            }
        }
    }

    public static function genref($nametable)
    {
        $an = date('Y');
        if (!isset(DB::table($nametable)->orderBy('id', 'DESC')->get()[0]->RefRecu)) {
            return $an."00000000";
        }
        else
        {
            $dernier = DB::table($nametable)->orderBy('id', 'DESC')->get()[0]->RefRecu;
            $marqueserie = $an;
            $nombre = substr($dernier, 4, 11);
            $newnombre = $nombre + 1;
            $bond = 10; $i = 7;
            $serie = InterfaceServiceProvider::chaine($bond, $i, $newnombre);
            return $serie;
        }
    }

    public static function chaine($bond, $a, $newnombre)
    {
        $newch = date('Y');
        while ($newnombre >= $bond) {
            $bond = $bond * 10;
            $a = $a - 1;
        }

        $newchaine = date('Y');
        for ($i=0; $i < $a; $i++) { 
            $newchaine .= "0";
        }   
        $newchaine = $newchaine."".$newnombre;
        $newch = $newchaine;
        
        return $newch;
    }

    public static function conversionfcfa($value)
    { return $value * 500;}

    public static function genunique($table)
    {
        $rand = rand(1000,9999);
        $existance = DB::table($table)->where('reff', $rand)->get();
        if(isset($existance[0]->reff))
            InterfaceServiceProvider::genunique($table);
        else
            return $rand;
    }

    public static function inderminiterparrain($iduser, $montantcom, $montant, $pack, $service, $user)
    {
        //InterfaceServiceProvider::NiveauParrainControl($iduser);
        $parrain = DB::table('users')->where('id', $iduser)->first()->parrain;

        $id_parrain = DB::table('users')->where('codeunique', $parrain)->first()->id;
        
        $pack = DB::table('users')->where('codeunique', $parrain)->first()->Pack;
    
        if ($pack != 1) {

            if($pack != 2){
                // écrire la requete
                $compte = DB::table('avoirs')->where('id_user', $id_parrain)->first();
                $frais = ($montantcom * 10 / 100);
                $solde = $frais + $compte->gainespece;
        
                DB::table('avoirs')->where('id_user', $id_parrain)->update(['gainespece' => $solde]);
                
                //InterfaceServiceProvider::NiveauParrainControl($id_parrain);
                if(isset(session('utilisateur')->prenom))
                    $messagedest = "Vous avez reçu ".$frais." $ SSI comme commission sur vente de votre dernière opération"; //. session('utilisateur')->prenom . " " . session('utilisateur')->nom;
                else
                    $messagedest = "Vous avez reçu ".$frais." $ SSI comme commission sur vente de ". auth()->user()->prenom . " " . auth()->user()->nom;
                HistoriqueClient::saveHistorique($messagedest, $id_parrain );
            }
            if($pack == 2 && $service == "SINSCRIPTION"){
                //InterfaceServiceProvider::NiveauParrainControl($id_parrain);
                $filleul = DB::table('users')->where('id', session('iduser'))->first();
                $messagedest = "Vous avez reçu ".$montantcom." $ SSI comme commission sur vente pour l'inscription de ". $filleul->prenom . " " . $filleul->nom;
                HistoriqueClient::saveHistorique($messagedest, $id_parrain );
                
                if($id_parrain != 1){
                    $gparrain = DB::table('users')->where('id', $id_parrain)->first()->parrain;
                    $id_gparrain = DB::table('users')->where('codeunique', $gparrain)->first()->id;
                    $compte = DB::table('avoirs')->where('id_user', $id_gparrain)->first();
                    $frais = ($montantcom * 10 / 100);
                    $solde = $frais + $compte->gainespece;
                    DB::table('avoirs')->where('id_user', $id_gparrain)->update(['gainespece' => $solde]);
                    //InterfaceServiceProvider::NiveauParrainControl($id_gparrain);
                    $filleulp = DB::table('users')->where('id', $id_parrain)->first();
                    $messagedestg = "Vous avez reçu ".$frais." $ SSI comme commission sur vente de ". $filleulp->prenom . " " . $filleulp->nom;
                    HistoriqueClient::saveHistorique($messagedestg, $id_gparrain );
                }
                
            }else if($pack == 2 && $service != "SSBEE" && $service != "SSBEECONVENTIONNEL"){
                // écrire la requete
                $compte = DB::table('avoirs')->where('id_user', $id_parrain)->first();
                $frais = ($montant * 1 / 100);
                $solde = $frais + $compte->gainespece;
        
                DB::table('avoirs')->where('id_user', $id_parrain)->update(['gainespece' => $solde]);
                
                //InterfaceServiceProvider::NiveauParrainControl($id_parrain);
                if(isset(session('utilisateur')->prenom))
                    $messagedest = "Vous avez reçu ".$frais." $ SSI comme commission sur vente de votre dernière opération."; //. session('utilisateur')->prenom . " " . session('utilisateur')->nom;
                else
                    $messagedest = "Vous avez reçu ".$frais." $ SSI comme commission sur vente de ". auth()->user()->prenom . " " . auth()->user()->nom;
                HistoriqueClient::saveHistorique($messagedest, $id_parrain );
            }else{
                if ($pack == 2 && ($service == "SSBEE" || $service == "SSBEECONVENTIONNEL")) {
                    $compte = DB::table('avoirs')->where('id_user', $id_parrain)->first();
                    $frais = ($montantcom * 1 / 100);
                    $solde = $frais + $compte->gainespece;
            
                    DB::table('avoirs')->where('id_user', $id_parrain)->update(['gainespece' => $solde]);
                    
                    //InterfaceServiceProvider::NiveauParrainControl($id_parrain);
                    if(isset(session('utilisateur')->prenom))
                    
                        $messagedest = "Vous avez reçu ".$frais." SSI comme commission sur vente de votre dernière opération.";//. session('utilisateur')->prenom . " " . session('utilisateur')->nom;
                    else
                        $messagedest = "Vous avez reçu ".$frais." SSI comme commission sur vente de ". auth()->user()->prenom . " " . auth()->user()->nom;
                    HistoriqueClient::saveHistorique($messagedest, $id_parrain );
                }else{
                    if($service == "NSIA"){
                        $compte = DB::table('avoirs')->where('id_user', $id_parrain)->first();
                        $frais = ($montantcom * 1.1 / 100);
                        $solde = $frais + $compte->gainespece;
                
                        DB::table('avoirs')->where('id_user', $id_parrain)->update(['gainespece' => $solde]);
                        
                        //InterfaceServiceProvider::NiveauParrainControl($id_parrain);
                        if(isset(session('utilisateur')->prenom))
                        
                            $messagedest = "Vous avez reçu ".$frais." SSI comme commission sur vente de votre dernière opération.";//. session('utilisateur')->prenom . " " . session('utilisateur')->nom;
                        else
                            $messagedest = "Vous avez reçu ".$frais." SSI comme commission sur vente de ". auth()->user()->prenom . " " . auth()->user()->nom;
                        HistoriqueClient::saveHistorique($messagedest, $id_parrain );
                    }
                    else{
                        if($service == "NSIAGB"){
                            $compte = DB::table('avoirs')->where('id_user', $id_parrain)->first();
                            $frais = ($montantcom * 5 / 100);
                            $solde = $frais + $compte->gainespece;
                    
                            DB::table('avoirs')->where('id_user', $id_parrain)->update(['gainespece' => $solde]);
                            
                            //InterfaceServiceProvider::NiveauParrainControl($id_parrain);
                            if(isset(session('utilisateur')->prenom))
                            
                                $messagedest = "Vous avez reçu ".$frais." SSI comme commission sur vente de votre dernière opération.";
                            else
                                $messagedest = "Vous avez reçu ".$frais." SSI comme commission sur vente de ". auth()->user()->prenom . " " . auth()->user()->nom;
                            HistoriqueClient::saveHistorique($messagedest, $id_parrain );
                        }
                    }
                }
            }
        }
        return 0;
    }
    
    public static function NiveauParrainControl($id_user){
        $etape = DB::table('avoirs')->where('id_user', $id_user)->first()->etapeActuel + 1;
        
        $nombrepossible = DB::table('etapes')->where('id', $etape)->first()->pv * 10;
        
        $gcv = DB::table('avoirs')->where('id_user', $id_user)->first()->compv; 
        
        if(floor($gcv) == $nombrepossible) {
            // Tels personne vient de passé à l'étape supérieur
            // id, iduser, message, statut
            DB::table('avoirs')->where('id_user', $id_user)->update(['etapeActuel' =>  $etape]);
            
        }
        
        return 0;
    }
    
    public static function NiveauControl($id_user){
        $etape = DB::table('avoirs')->where('id_user', $id_user)->first()->etapeActuel + 1;
        
        $nombrepossible = DB::table('etapes')->where('id', $etape)->first()->pv * 10;
        
        $gcv = DB::table('avoirs')->where('id_user', $id_user)->first()->cvpv; 
        
        if(floor($gcv) == $nombrepossible) {
            // Tels personne vient de passé à l'étape supérieur
            // id, iduser, message, statut
            DB::table('avoirs')->where('id_user', $id_user)->update(['etapeActuel' =>  $etape]);
            
        }
        
        return 0;
    }
    
    public static function fraisssidepot(){
        return 0.5;
    }

    public static function fraisssinouvelle($value)
    {
        // 1 a 30.000f >>>>>>> 300f
        // 30.001f à 99.999f >>>>>>>> 1% du montant
        // 100.000f a plus >>>>>>>> 1000f

        $valeurssi = 500;

        $valeurfcfa = $value * $valeurssi;

        if ($valeurfcfa >= 1 && $valeurfcfa <=30000) {
            return (300 / $valeurssi);
        } else {
            if ($valeurfcfa > 30000 && $valeurfcfa <=99999) {
                
                return ($value * 1 / 100);
            } else {
                if ($valeurfcfa >= 100000)
                    return (1000 / $valeurssi);
                else
                    return 0;
            }
        }
    }               

    public static function generercodeunique()
    {
        $code_unique = rand(10000000, 99999999);

        if (InterfaceServiceProvider::verificationCodeUnique($code_unique) == 0) {
            return $code_unique;
        }
        else
        {
            InterfaceServiceProvider::generercodeunique();
        }
    }

    public static function verificationCodeUnique($value)
    {
        if (isset(DB::table('users')->select('codeunique')->where('codeunique', $value)->where('Pack', '!=', 1)->first()->codeunique)) {
            
            return DB::table('users')->select('codeunique')->where('codeunique', $value)->first()->codeunique;
            
        } else {
            return '0';
        }
    }

    public static function MailParrain($parrain)
    {
        return DB::table('users')
                    ->where('codeunique', $parrain)
                    ->get()[0]->email;
    }

    public static function GainCommissionVente_Actuel($id_parrain)
    {
        // Espèce est devenir commission vente
        return DB::table('avoirs')->select('gaincommissionvente')->where('id_user', $id_parrain)->get()[0]->gaincommissionvente;  
    }

    public static function NomParrain($code)
    {
        $t = DB::table('users')->select('nom', 'prenom')->where('codeunique', $code)->get();
        return $t[0]->nom." ".$t[0]->prenom; 
    }

    public static function AdminCompteRecu()
    {
        return DB::table('systemadmins')->select('compteavoirrecu')->get()[0]->compteavoirrecu;   
    }

    public static function VirtuelActuel($id_parrain)
    {
       return DB::table('avoirs')->select('gainvirtuel')->where('id_user', $id_parrain)->get()[0]->gainvirtuel; 
    }  

    public static function PourcentageFilleulEspece()
    {
        return DB::table('systemadmins')->select('pourcentagefilleulespece')->get()[0]->pourcentagefilleulespece;
    }

    public static function PourcentageFilleulVirtuel()
    {
        return DB::table('systemadmins')->select('pourcentagefilleulvirtuel')->get()[0]->pourcentagefilleulvirtuel;
    }

    public static function user_init($id, $trans)
    {
        $user_ini = Avoir::create([
                'gainvirtuel' => 0, 
                'gainespece' => 0,
                'gaincommissionvente' => 0, 
                'id_user' => $id,
                'translation_first' => $trans
            ]);

        return DB::table('avoirs')->select('id')->where('id_user', $id)->get()[0]->id;
    }

    public static function generercodeapprobation()
    {
        $code_unique = rand(10000, 99999);

        return 'appr'.$code_unique.'prou';
    }

    public static function genereridunique()
    {
        $id_unique = rand(10000000, 99999999);

        if (InterfaceServiceProvider::verificationIdUnique($id_unique) == 0) {
            return $id_unique;
        }
        else
        {
            InterfaceServiceProvider::genereridunique();
        }
    }

    public static function verificationIdUnique($value)
    {
        if (isset(DB::table('users')->select('codeperso')->where('codeperso', $value)->get()[0]->codeperso)) {
            
            return DB::table('users')->select('codeperso')->where('codeperso', $value)->get()[0]->codeperso;
            
        } else {
            return '0';
        }   
    }
    
    public static function sendotp(){
        $max = 10;
        if(auth()->guest())
            $max = 10;
        else{
            
    		$max = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
        }
		$data =  array("max" => $max);
        return $data;
    }
    
    public static function EnvoieMail($destinataire, $message, $sujet, $objet)
    {

		setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
		date_default_timezone_set('Africa/Porto-Novo');

		$JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
		$HEURE = date("H:i"); // Heure d'envoi de l'email

		$Subject = "$sujet - $JOUR $HEURE";
		
		SendMail::sendmailIndexController($destinataire, $Subject, $message, $objet);
	}

    public static function verifie_mtn($id_numero)
    {
        return 1; // Bon
        /*
        $table_numero_possible = [51,52,53,54,56,57,61,62,66,67,69,90,91,96,97];

        $v = 0;

        for ($i=0; $i < 15; $i++)
        {
            if ($id_numero == $table_numero_possible[$i])
                $v = 1;
        }

        if ($v <> 0)
            return 1; // Bon
        else 
            return 0; // Mauvais
        */
    }
    
    public static function verifie_celtiis($id_numero)
    {
        return 1; // Bon
        /*
        $table_numero_possible = [40];

        $v = 0;

        for ($i=0; $i < 1; $i++)
        {
            if ($id_numero == $table_numero_possible[$i])
                $v = 1;
        }

        if ($v <> 0)
            return 1; // Bon
        else 
            return 0; // Mauvais
            */
    }

    public static function verifie_moov($numero)
    {
        return 1; // Bon
        /*
        $table_numero_possible = [60,64,65,58,68,94,95,98,99];

            $v = 0;

        for ($i=0; $i < 9; $i++)
        {
            if ($numero == $table_numero_possible[$i])
                $v = 1;
        }

        if ($v <> 0)
            return 1; // Bon
        else 
            return 0; // Mauvais
        */
    }

    public static function EnvoieRecuCANAL($destinataire, $sujet, $objet, $nom, $prenom, $CodePersoUser, $refrecu, $Numerocarte, $WhatsApp, $montant, $mail, $Choisirformule, $dateespire, $totale, $daterecu, $modereglement, $libelle, $solderestant, $Dureenmois, $reglementnum)
    {

        setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');

        $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
        $HEURE = date("H:i"); // Heure d'envoi de l'email

        $Subject = "$sujet - $JOUR $HEURE";

        $data = [
            'destinataire' => $destinataire, 
            'sujet' => $sujet, 
            'objet' => $objet, 
            'nom' => $nom, 
            'prenom' => $prenom, 
            'CodePersoUser' => $CodePersoUser, 
            'refrecu' => $refrecu, 
            'dateespire' => $dateespire,
            'Numerocarte' => $Numerocarte, 
            'WhatsApp' => $WhatsApp, 
            'Choisirformule' => $Choisirformule, 
            'totale' => $totale,
            'mail' => $mail, 
            'montant' => $montant, 
            'daterecu' => $daterecu, 
            'modereglement' =>  $modereglement, 
            'libelle' => $libelle, 
            'solderestant' => $solderestant, 
            'Dureenmois' => $Dureenmois,  
            'reglementnum' => $reglementnum,
            'montantf' => InterfaceServiceProvider::conversionfcfa($montant),
            'totalef' => InterfaceServiceProvider::conversionfcfa($totale),
            'solderestantf' => InterfaceServiceProvider::conversionfcfa($solderestant)
        ];
        
        
        SendMail::sendrecucanal($destinataire, $Subject, $data);
    }

    public static function EnvoieRecu($destinataire, $sujet, $objet, $nom, $prenom, $CodePersoUser, $refrecu, $police, $WhatsApp, $montant, $mail, $presentation, $FraisSSI, $totale, $daterecu, $modereglement, $libelle, $solderestant, $periode, $reglementnum)
    {


        setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');

        $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
        $HEURE = date("H:i"); // Heure d'envoi de l'email

        $Subject = "$sujet - $JOUR $HEURE";

        $data = [
            'destinataire' => $destinataire, 
            'sujet' => $sujet, 
            'objet' => $objet, 
            'nom' => $nom, 
            'prenom' => $prenom, 
            'CodePersoUser' => $CodePersoUser, 
            'refrecu' => $refrecu, 
            'police' => $police, 
            'WhatsApp' => $WhatsApp, 
            'totale' => $totale, 
            'mail' => $mail, 
            'FraisSSI' => $FraisSSI, 
            'montant' => $montant, 
            'daterecu' => $daterecu, 
            'modereglement' =>  $modereglement, 
            'libelle' => $libelle, 
            'solderestant' => $solderestant, 
            'presentation' => $presentation,  
            'periode' => $periode, 
            'reglementnum' => $reglementnum,
            'montantf' => InterfaceServiceProvider::conversionfcfa($montant),
            'FraisSSIf' => InterfaceServiceProvider::conversionfcfa($FraisSSI),
            'totalef' => InterfaceServiceProvider::conversionfcfa($totale),
            'solderestantf' => InterfaceServiceProvider::conversionfcfa($solderestant)
        ];
        
        
        SendMail::sendrecusoneb($destinataire, $Subject, $data);
    }

    public static function EnvoieRecuCREDITSBEE($destinataire, $sujet, $objet, $nom, $prenom, $CodePersoUser, $refrecu, $police, $WhatsApp, $total, $mail, $FraisSSI, $montant, $daterecu, $modereglement, $libelle, $solderestant, $sts, $entretien, $kwh, $reglementnum
        )
    {    

        setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');

        $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
        $HEURE = date("H:i"); // Heure d'envoi de l'email

        $Subject = "$sujet - $JOUR $HEURE";

        $data = [
            'destinataire' => $destinataire, 
            'sujet' => $sujet, 
            'objet' => $objet, 
            'nom' => $nom, 
            'prenom' => $prenom, 
            'CodePersoUser' => $CodePersoUser, 
            'refrecu' => $refrecu, 
            'police' => $police, 
            'WhatsApp' => $WhatsApp, 
            'total' => $total, 
            'mail' => $mail, 
            'FraisSSI' => $FraisSSI, 
            'montant' => $montant, 
            'daterecu' => $daterecu, 
            'modereglement' =>  $modereglement, 
            'libelle' => $libelle, 
            'solderestant' => $solderestant, 
            'sts' => $sts, 
            'entretien' => $entretien, 
            'kwh' => $kwh, 
            'reglementnum' => $reglementnum,
            'montantf' => InterfaceServiceProvider::conversionfcfa($montant),
            'FraisSSIf' => InterfaceServiceProvider::conversionfcfa($FraisSSI),
            'totalf' => InterfaceServiceProvider::conversionfcfa($total),
            'solderestantf' => InterfaceServiceProvider::conversionfcfa($solderestant)
        ];
        
        
        SendMail::sendrecucreditsbee($destinataire, $Subject, $data);
    }
    
    public static function EnvoieRecuSBEE($destinataire, $sujet, $objet, $nom, $prenom, $CodePersoUser, $refrecu, $police, $WhatsApp, $montant, $mail, $presentation, $FraisSSI, $totale, $daterecu, $modereglement, $libelle, $solderestant, $periode, $reglementnum)
    {


        setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');

        $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
        $HEURE = date("H:i"); // Heure d'envoi de l'email

        $Subject = "$sujet - $JOUR $HEURE";

        $data = [
            'destinataire' => $destinataire, 
            'sujet' => $sujet, 
            'objet' => $objet, 
            'nom' => $nom, 
            'prenom' => $prenom, 
            'CodePersoUser' => $CodePersoUser, 
            'refrecu' => $refrecu, 
            'FraisSSI' => $FraisSSI,
            'police' => $police,
            'presentation' => $presentation, 
            'WhatsApp' => $WhatsApp, 
            'totale' => $totale,
            'mail' => $mail, 
            'montant' => $montant, 
            'daterecu' => $daterecu, 
            'modereglement' =>  $modereglement, 
            'libelle' => $libelle, 
            'solderestant' => $solderestant, 
            'periode' => $periode,  
            'reglementnum' => $reglementnum,
            'montantf' => InterfaceServiceProvider::conversionfcfa($montant),
            'totalef' => InterfaceServiceProvider::conversionfcfa($totale),
            'solderestantf' => InterfaceServiceProvider::conversionfcfa($solderestant),
            'FraisSSIf' => InterfaceServiceProvider::conversionfcfa($FraisSSI)
        ];
        
        
        SendMail::sendrecuconventionnel($destinataire, $Subject, $data);
    }
}

