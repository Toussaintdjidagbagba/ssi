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
    public function test(){
        SendMail::sendmailIndexController("emmanueldjidagbagba@gmail.com", "TEST", "TEST", "TEST");
        echo "Bon";
    }
	public function index()
    {

        $cours = DB::table('articlepdfs')->select('id','path', 'titre', 'prix', 'description')->get();

        $data = ['cours' => $cours];
        /*flash("Salut cher(e)s Homme de Succès
Pour des raisons de maintenance la plateforme SSI connaitra quelques dysfonctionnement cette semaine
Pour toutes préoccupations veuillez contacter le service client par WhatsApp.

Merci pour la compréhension");*/
        
        /*flash("Dans le but de mettre ajout les commissions relatives aux opérations des filleuls et l’accès aux services avec l’adhésion gratuite des services MTN, MOOV, CANAL PLUS, SBEE, SONEB et
        CARTE VISA ne pourront passer dans la période du Mardi 04 Janvier au Lundi 10 Janvier 2022 toutes fois les demandes en attente seront annulé et les dollars seront retourné dans les comptes respectives. <br> 
        Le service technique de la SSI vous remercie pour votre patience et votre compréhension et vous souhaites une bonne et heureuse année 2022."); */

        return view('mlm.accueil', $data);
    }

    public function accueil()
    {
        
        $cours = DB::table('articlepdfs')->select('id','path', 'titre', 'prix', 'description')->get();
 
        $data = ['cours' => $cours];
        /*flash("Salut cher(e)s Homme de Succès
Pour des raisons de maintenance la plateforme SSI connaitra quelques dysfonctionnement cette semaine
Pour toutes préoccupations veuillez contacter le service client par WhatsApp.

Merci pour la compréhension");*/
        /*flash("Dans le but de mettre ajout les commissions relatives aux opérations des filleuls et l’accès aux services avec l’adhésion gratuite des services MTN, MOOV, CANAL PLUS, SBEE, SONEB et
        CARTE VISA ne pourront passer dans la période du Mardi 04 Janvier au Lundi 10 Janvier 2022 toutes fois les demandes en attente seront annulé et les dollars seront retourné dans les comptes respectives. <br> 
        Le service technique de la SSI vous remercie pour votre patience et votre compréhension et vous souhaites une bonne et heureuse année 2022."); */

        return view('mlm.accueil', $data);
    }

    public function affichearticle()
    {
        $cour = DB::table('articlepdfs')->select('id', 'path', 'titre', 'prix', 'description')->where('id', request('id'))->get();

        $data = ['cour' => $cour];

        return view('mlm.Article', $data);
    }

    public function galerie()
    {
        $image = DB::table('galeries')->select('path', 'image', 'id_user')->get();

        $data = ['images' => $image];

        return view('mlm.galerie', $data);
    }

    public function evernement()
    {
        $image = DB::table('evenements')->select('path', 'image', 'date', 'lieu', 'heure', 'description', 'id_user')->get();

        $data = ['images' => $image];

        return view('mlm.evernement', $data);
    }

     public function propos()
    {
        return view('mlm.propos');
    }

    public function contact()
    {
        return view('mlm.contact');
    }

    public function setcontact()
    {
        $nom = request('name');
        $email = request('email');
        $tel = request('phone');
        $message = request('message');

        $mes = Notificationcontact::create([
            'Nom' => $nom, 
            'Email' => $email, 
            'Tel' => $tel, 
            'Message' => $message
        ]);
        //HistoriqueClient::saveHistorique($message, auth()->user()->id );
        $mes = "Message envoyé avec succès!!! Consulter votre mail dans un instant pour avoir la réponse à votre préoccupation. SSI vous remercie.";
        
        //HistoriqueClient::saveHistorique($mes, auth()->user()->id );
        flash($mes);
        return Back();
    }
}