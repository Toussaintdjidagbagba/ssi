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
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // 
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
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

    public static function GetTaux($pack, $service, $user)
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

        if ($service == "TC" && $user == "client") {
            return 2;
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
                return 0;
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
                return 0;
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

    public static function inderminiterparrain($iduser, $montant, $pack, $service, $user)
    {
        InterfaceServiceProvider::NiveauParrainControl($iduser);
        $parrain = DB::table('users')->where('id', $iduser)->first()->parrain;

        $id_parrain = DB::table('users')->where('codeunique', $parrain)->first()->id;
        
        $pack = DB::table('users')->where('codeunique', $parrain)->first()->Pack;
        
        if($pack != 1){
            // écrire la requete
            $compte = DB::table('avoirs')->where('id_user', $id_parrain)->first();
            $frais = ($montant * 10 / 100);
            $solde = $frais + $compte->gainespece;
    
            DB::table('avoirs')->where('id_user', $id_parrain)->update(['gainespece' => $solde]);
            
            InterfaceServiceProvider::NiveauParrainControl($id_parrain);
            $messagedest = "Vous avez reçu ".$frais." $ SSI comme commission sur vente de ". auth()->user()->prenom . " " . auth()->user()->nom;
    
            HistoriqueClient::saveHistorique($messagedest, $id_parrain );
        }
        return 0;
    }
    
    public static function NiveauParrainControl($id_user){
        $etape = DB::table('avoirs')->where('id_user', $id_user)->first()->etapeActuel + 1;
        
        $nombrepossible = DB::table('etapes')->where('id', $etape)->first()->pv * 10;
        
        $gcv = DB::table('avoirs')->where('id_user', $id_user)->first()->gaincommissionvente; 
        
        if($gcv == $nombrepossible) {
            // Tels personne vient de passé à l'étape supérieur
            // id, iduser, message, statut
            DB::table('avoirs')->where('id_user', $id_user)->update(['etapeActuel' =>  $etape + 1]);
            
        }
        
        return 0;
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
        if (isset(DB::table('users')->select('codeunique')->where('codeunique', $value)->first()->codeunique)) {
            
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
        $table_numero_possible = [51,52,53,54,56,61,62,66,67,69,90,91,96,97];

        $v = 0;

        for ($i=0; $i < 14; $i++)
        {
            if ($id_numero == $table_numero_possible[$i])
                $v = 1;
        }

        if ($v <> 0)
            return 1; // Bon
        else 
            return 0; // Mauvais
    }

    public static function verifie_moov($numero)
    {
        $table_numero_possible = [60,64,65,68,94,95,98,99];

            $v = 0;

        for ($i=0; $i < 8; $i++)
        {
            if ($numero == $table_numero_possible[$i])
                $v = 1;
        }

        if ($v <> 0)
            return 1; // Bon
        else 
            return 0; // Mauvais
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
    
    public function EnvoieRecuSBEE($destinataire, $sujet, $objet, $nom, $prenom, $CodePersoUser, $refrecu, $police, $WhatsApp, $montant, $mail, $presentation, $FraisSSI, $totale, $daterecu, $modereglement, $libelle, $solderestant, $periode, $reglementnum)
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
            'montantf' => IndexPrimeController::conversionfcfa($montant),
            'totalef' => IndexPrimeController::conversionfcfa($totale),
            'solderestantf' => IndexPrimeController::conversionfcfa($solderestant),
            'FraisSSIf' => IndexPrimeController::conversionfcfa($FraisSSI)
        ];
        
        
        SendMail::sendrecuconventionnel($destinataire, $Subject, $data);
    }
    
    
}

