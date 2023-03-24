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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    private $code = 0;
    
    public function recherche(Request $request)
    {
        $mot_cle = request('motcle');
        
        $client = DB::table('users')
    		->join('avoirs', 'users.id', '=', 'avoirs.id_user', 'left outer') 
    		->where('type', 'client')
    		->where('users.compteactive', '!=', 'sup')
    		->where('nom', 'like', '%' . $mot_cle . '%')
    		->select('users.Pack', 'users.id', 'users.compteactive' ,'users.nom', 'users.prenom', 'users.codeperso', 'users.codeunique', 'users.parrain', 'users.parrainindirect', 'users.created_at as created', 'avoirs.gainespece', 'avoirs.gainvirtuel', 'avoirs.gaincommissionvente')
    		->orderBy('users.created_at', 'DESC')
    		->paginate(10);
    		
    	if(!isset($client[0]->codeperso))
    	{
    	    $client = DB::table('users')
    		->join('avoirs', 'users.id', '=', 'avoirs.id_user', 'left outer') 
    		->where('type', 'client')
    		->where('users.compteactive', '!=', 'sup')
    		->where('prenom', 'like', '%' . $mot_cle . '%')
    		->select('users.Pack', 'users.id', 'users.compteactive' ,'users.nom', 'users.prenom', 'users.codeperso', 'users.codeunique', 'users.parrain', 'users.parrainindirect', 'users.created_at as created', 'avoirs.gainespece', 'avoirs.gainvirtuel', 'avoirs.gaincommissionvente')
    		->orderBy('users.created_at', 'DESC')
    		->paginate(10);
    		
    		if(!isset($client[0]->codeperso))
    	    {
    	        $client = DB::table('users')
            		->join('avoirs', 'users.id', '=', 'avoirs.id_user', 'left outer') 
            		->where('type', 'client')
            		->where('users.compteactive', '!=', 'sup')
            		->where('codeperso', 'like', '%' . $mot_cle . '%')
            		->select('users.Pack', 'users.id', 'users.compteactive' ,'users.nom', 'users.prenom', 'users.codeperso', 'users.codeunique', 'users.parrain', 'users.parrainindirect', 'users.created_at as created', 'avoirs.gainespece', 'avoirs.gainvirtuel', 'avoirs.gaincommissionvente')
            		->orderBy('users.created_at', 'DESC')
            		->paginate(10);
            		
    	        if(!isset($client[0]->codeperso))
    	        {
    	            $client = DB::table('users')
            		->join('avoirs', 'users.id', '=', 'avoirs.id_user', 'left outer') 
            		->where('type', 'client')
            		->where('users.compteactive', '!=', 'sup')
            		->where('nomuser', 'like', '%' . $mot_cle . '%')
            		->select('users.Pack', 'users.id', 'users.compteactive' ,'users.nom', 'users.prenom', 'users.codeperso', 'users.codeunique', 'users.parrain', 'users.parrainindirect', 'users.created_at as created', 'avoirs.gainespece', 'avoirs.gainvirtuel', 'avoirs.gaincommissionvente')
            		->orderBy('users.created_at', 'DESC')
            		->paginate(10);
            		
            	    if(!isset($client[0]->codeperso))
    	            {
    	                $client = DB::table('users')
                    		->join('avoirs', 'users.id', '=', 'avoirs.id_user', 'left outer') 
                    		->where('type', 'client')
                    		->where('users.compteactive', '!=', 'sup')
                    		->where('codeunique', 'like', '%' . $mot_cle . '%')
                    		->select('users.Pack', 'users.id', 'users.compteactive' ,'users.nom', 'users.prenom', 'users.codeperso', 'users.codeunique', 'users.parrain', 'users.parrainindirect', 'users.created_at as created', 'avoirs.gainespece', 'avoirs.gainvirtuel', 'avoirs.gaincommissionvente')
                    		->orderBy('users.created_at', 'DESC')
                    		->paginate(10);
                    		
                    	    if(!isset($client[0]->codeperso))
            	            {
            	                $data = ['clients' => $client];
    	                        return view('admin.listclient', $data);
            	            }
            	            else
            	            {
            	                $data = ['clients' => $client];
    	                        return view('admin.listclient', $data);
            	            }
    	                
    	            }
    	            else
    	            {
    	                $data = ['clients' => $client];
    	                return view('admin.listclient', $data);    
    	            }
    	        }
    	        else
    	        {
    	            $data = ['clients' => $client];
    	            return view('admin.listclient', $data);
    	        }
    	    }
    	    else
    	    {
    	        $data = ['clients' => $client];
    	        return view('admin.listclient', $data);
    	    }
    	}
    	else
    	{
    	    $data = ['clients' => $client];
    	    return view('admin.listclient', $data);
    	}
    }
    
    public function listfilleuls()
    {
    	$client = DB::table('users')
    		->join('avoirs', 'users.id', '=', 'avoirs.id_user', 'left outer') 
    		->where('type', 'client')
    		->where('users.compteactive', '!=', 'sup')
    		->select('users.Pack', 'users.id', 'users.compteactive','users.nomuser' ,'users.nom', 'users.prenom', 'users.codeperso', 'users.codeunique', 'users.parrain', 'users.parrainindirect', 'users.created_at as created', 'avoirs.gainespece', 'avoirs.gainvirtuel', 'avoirs.gaincommissionvente')
    		->orderBy('users.created_at', 'DESC')
    		->paginate(20);
    	$data = ['clients' => $client];
    	
        return view('admin.listclient', $data);
    }
    
    public function deletefilleul(){
        
        //dd(request("id"));
        //DB::table("users")->where('id', request("id"))->delete();
        DB::table('users')
                    ->where('id', request("id"))
                    ->update([
                    'compteactive' => "sup"
                    ]);
        
        flash("Filleul supprimer avec succès!"); 
        return Back();
    }

    /* Setter et getteur */

    public function get_code()
    {
        return $this->code;
    }

    public function set_code($nombre)
    {
        $this->code = $nombre;
    }

    public function genecode()
    {
        // mail
        $otp = rand(100000, 999999);

        $message = "Code OTP Générer : ".$otp;

        $destinataire = auth()->user()->email;

        IndexController::EnvoieMail($destinataire, $message, "Accès", "");
        flash('Code OTP envoyé sur votre boite mail !!!');
        $data = ['otp' => $otp];
        return view('client.transfert', $data);
    }

    public function img(Request $request)
    {
        return '<center style=""> <img src="'. $request->root().'/img/logo.jpeg " /> </center>';
    }
    public function gettransfert()
    {
                // mail
        $otp = rand(100000, 999999);

        $message = "Code OTP Générer : ".$otp;

        $destinataire = auth()->user()->email;

        //IndexController::EnvoieMail($destinataire, $message, "Accès", "");
        //flash('Code OTP envoyé sur votre boite mail !!!');
        $data = ['otp' => "OTP"];
        return view('client.transfert', $data);
    }


    public function settransfert(Request $request)
    {
        request()->validate([
            'id' => 'required',
            'montant' => 'required|min:0',
            'otp' => 'required']);
            
            
        if (request('otprecu') == "OTP")
        {
        	flash("Veuillez générer OTP et saisir l'OTP envoyé par sur votre mail.")->error();
        	$data = ['otp' => "OTP"];
        	return view('client.transfert', $data);
        }
        else
        {

        // Verifier l'existance de id
        if (isset(DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso)) {
            
            // verifie l'autorisation par otp

            if (request('otprecu') != request('otp')) {
                flash("L'autorisation par OTP incorrect! Veuillez verifier l'OTP envoyé par sur votre mail ou réeassayer.")->error();
                $data = ['otp' => "OTP"];
        		return view('client.transfert', $data);
            }
            else
            {
            // Verifier le compte actuel du parrain au traver du montant

            $soldeactuel = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gainespece;
            $montantnet = request('montant');
			$fraisretrait = $montantnet * 0.03;
			$montantvalider = $montantnet + $fraisretrait;
            //dd($soldeactuel < request('montant'));
            if ($soldeactuel < $montantvalider) {
                flash("Votre solde est insuffissant!!");
                $data = ['otp' => "OTP"];
        		return view('client.transfert', $data);
            } else {
                // Alors update compte expediteur : decrementer
                $soldeac = $soldeactuel - $montantvalider;
                DB::table('avoirs')
                    ->where('id_user', auth()->user()->id)
                    ->update([
                    'gainespece' => $soldeac
                    ]);
                    
                //debiter le compte admin de 3% comme frais sur retrait
                $compteadmint = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

                $recut=$compteadmint + $fraisretrait;
    
                    //update la table
                DB::table('systemadmins')
                    ->where('id_AdminPrincipal', 1)
                    ->update([
                    'compteavoirrecu' => $recut
                ]);

                // Alors update compte destinataire : incrementer
                $iddest = DB::table('users')->where('codeperso', request('id'))->get()[0]->id;
                $soldeactuel = DB::table('avoirs')->where('id_user', $iddest)->get()[0]->gainespece;
                $soldeac = $soldeactuel + request('montant');
                DB::table('avoirs')
                    ->where('id_user', $iddest)
                    ->update([
                        'gainespece' => $soldeac
                        ]);
                        
                $message = "Vous avez transféré ".request('montant')." $ SSI à ". DB::table('users')->where('codeperso', request('id'))->get()[0]->prenom . " 
                " . DB::table('users')->where('codeperso', request('id'))->get()[0]->nom." dont l'identifiant est :
                    ".DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso.". Frais du transfert ".$fraisretrait.". Transfert effectué avec succès.";
                HistoriqueClient::saveHistorique($message, auth()->user()->id );
                flash($message);
                $data = ['otp' => "OTP"];
        		return view('client.transfert', $data);
            }
            }
        } else {
            flash("L'identifiant n'existe pas")->error();
            $data = ['otp' => "OTP"];
        	return view('client.transfert', $data);
        }
       }
    }

    public function getprofil()
    {
        $users = DB::table('users')
                     ->where('id', auth()->user()->id)
                     ->get();
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

            DB::table('users')
            ->where('id', auth()->user()->id)
            ->update([
            'nom' => request('nom'),
            'prenom' =>request('prenom'),
            'sexe' =>request('sexe'),
            'tel' =>request('tel') 
            ]);
            
            $users = DB::table('users')
                     ->where('id', auth()->user()->id)
                     ->get();
            $data = ['users' => $users];
        return view('client.profil', $data);    
        
    }

    public function genecodeadmin()
    {
        // mail
        $otp = rand(100000, 999999);

        $message = "Code OTP Générer : ".$otp;

        $destinataire = auth()->user()->email;

        IndexController::EnvoieMail($destinataire, $message, "Accès", "");
        flash('Code OTP envoyé sur votre boite mail !!!');
        $data = ['otp' => $otp];
        return view('admin.transfertadmin', $data);
    }

    public function gettransfertadmin()
    {
                // mail
        $otp = rand(100000, 999999);

        $message = "Code OTP Générer : ".$otp;

        $destinataire = auth()->user()->email;

        //IndexController::EnvoieMail($destinataire, $message, "Accès", "");
        //flash('Code OTP envoyé sur votre boite mail !!!');
        $data = ['otp' => "OTP"];
        return view('admin.transfertadmin', $data);
    }

    public function settransfertadmin(Request $request)
    {
        
        request()->validate([
            'id' => 'required',
            'montant' => 'required|min:0',
            'otp' => 'required' ]);

        //dd(request());
        
        if (request('otprecu') == "OTP")
        {
        	flash("Veuillez générer OTP et saisir l'OTP envoyé par sur votre mail.")->error();
        	$data = ['otp' => "OTP"];
        return view('admin.transfertadmin', $data);
        }
        else
        {

        // Verifier l'existance de id
        if (isset(DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso)) {
            
            // verifie l'autorisation par otp

            if (request('otprecu') != request('otp')) {
                flash("L'autorisation par OTP incorrect! Veuillez verifier l'OTP envoyé par sur votre mail ou réeassayer.")->error();
                $data = ['otp' => "OTP"];
        return view('admin.transfertadmin', $data);
            }
            else{
                
                // Alors update compte destinataire : incrementer
                $iddest = DB::table('users')->where('codeperso', request('id'))->get()[0]->id;
                $soldeactuel = DB::table('avoirs')->where('id_user', $iddest)->get()[0]->gainespece;
                $soldeac = $soldeactuel + request('montant');
                DB::table('avoirs')
                    ->where('id_user', $iddest)
                    ->update([
                    'gainespece' => $soldeac
                    ]);

                // Mettre a jour le compte admin
                $soldeactue = DB::table('systemadmins')->where('id_AdminPrincipal', auth()->user()->id)->get()[0]->compteavoirsortant;
                $soldea = $soldeactue + request('montant');
                DB::table('systemadmins')
                    ->where('id_AdminPrincipal', auth()->user()->id)
                    ->update([
                    'compteavoirsortant' => $soldea
                    ]);

                $message = "Vous avez transférer ".request('montant')." $ SSI à ". DB::table('users')->where('codeperso', request('id'))->get()[0]->prenom . " " . DB::table('users')->where('codeperso', request('id'))->get()[0]->nom." dont l'identifiant est : ".DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso.". Transfert éffectuer avec succès.";
                
                Historique::saveHistorique( "A", $message, auth()->user()->id );
                $message_reception = "Vous avez reçu ".request('montant')." $ SSI ";
                HistoriqueClient::saveHistorique($message_reception, $iddest);
                flash($message);
                $data = ['otp' => "OTP"];
        return view('admin.transfertadmin', $data);
            }
        } else {
            flash("L'identifiant n'existe pas");
            $data = ['otp' => "OTP"];
        return view('admin.transfertadmin', $data);
        }
        }
        
    }

    public function getprofiladmin()
    {
        $users = DB::table('users')
                     ->where('id', auth()->user()->id)
                     ->get();
        $data = ['users' => $users];
        return view('admin.profiladmin', $data);
    }

    public function setprofiladmin(Request $request)
    {
        request()->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'sexe' => 'required',
            'tel' => 'required' ]);

            DB::table('users')
            ->where('id', auth()->user()->id)
            ->update([
            'nom' => request('nom'),
            'prenom' =>request('prenom'),
            'sexe' =>request('sexe') ,
            'tel' =>request('tel') 
            ]);

            $users = DB::table('users')
                     ->where('id', auth()->user()->id)
                     ->get();
            $data = ['users' => $users];
        return view('admin.profiladmin', $data);
    }


    /* Les méthodes clients */
    public function index()
    {

        $cours = DB::table('articlepdfs')->select('id','path', 'titre', 'prix', 'description')->get();

        $data = ['cours' => $cours];
        
        /*flash("Dans le but de mettre ajout les commissions relatives aux opérations des filleuls et l’accès aux services avec l’adhésion gratuite des services MTN, MOOV, CANAL PLUS, SBEE, SONEB et
CARTE VISA ne pourront passer dans la période du Mardi 04 Janvier au Lundi 10 Janvier 2022 toutes fois les demandes en attente seront annulé et les dollars seront retourné dans les comptes respectives. <br> 
Le service technique de la SSI vous remercie pour votre patience et votre compréhension et vous souhaites une bonne et heureuse année 2022."); */

        return view('mlm.accueil', $data);
    }

    public function accueil()
    {
        
        $cours = DB::table('articlepdfs')->select('id','path', 'titre', 'prix', 'description')->get();
 
        $data = ['cours' => $cours];
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
        HistoriqueClient::saveHistorique($message, auth()->user()->id );
        $mes = "Message envoyé avec succès!!! Consulter votre mail dans un instant pour avoir la réponse à votre préoccupation. SSI vous remercie.";
        
        HistoriqueClient::saveHistorique($mes, auth()->user()->id );
        flash($mes);
        return Back();
    }

    public function galerie()
    {
        $image = DB::table('galeries')->select('path', 'image', 'id_user')->get();

        $data = ['images' => $image];

        return view('mlm.galerie', $data);
    }

    public function getgalerie()
    {
        return view('admin.creergalerie');   
    }

    public function setgalerie()
    {
        request()->validate([
            'img' => ['required', 'mimes:png'],
           'titre' => 'required',
        ]);
       // dd(request());
        $path = request('img')->store('img', 'public');

        $image = './img';

        $article = Galerie::create([
            'path' => $path,
            'image' => request('titre'), 
            'id_user' => auth()->user()->id
        ]);

        flash('Ajout avec succès!!!');
        return Back();

    }

    public function getlistecontact()
    {
        $contacts=DB::table('notificationcontacts')->orderBy('id', 'DESC')->get();
        $data=['contacts'=>$contacts];
        return view ('admin.listecontact',$data);
    }

    public function setlistecontact()
    {
        $data = [
            'id' => request('id'),
            'email' => request('email'), 
            'message' => request('message')
        ];
        return view('admin.repondre', $data);
    }

    public function setrepondre()
    {
        request()->validate([
            'reponse' => 'required|string'
            ]);

        // Envoie de reponse au client

        $message = request('reponse');
                        $message .= "<br>";
                        $message .= "<br>";

                        $sujet = "Réponse de la Source du Succès International ";
                        $objet = "";
                        $email = request('email');
        //IndexController::EnvoieMailConnexion($email, $message, $sujet, $objet);

        // Mise à jour de la base de donnee
        DB::table('notificationcontacts')
                        ->where('id', request('id'))
                        ->update([
                        'Reponse' => request('reponse')
                        ]);
        DB::table('notificationcontacts')
                        ->where('id', request('id'))
                        ->update([
                        'Statut' => "oui"
                        ]);

        return Back();
    }

    //prelevement d'un compte client 

    public function getprelevement()
    {
        return view('admin.prelevement');
    }

    public function setprelevement(Request $request)
    {
        request()->validate([
            'id' => 'required',
            'montant' => 'required|min:0' ]);

        // Verifier si cest bien l'admin qui est connecté

        if(isset(DB::table('systemadmins')->where('id_AdminPrincipal', auth()->user()->id)->get()[0]->id_AdminPrincipal)){
            $idprel=DB::table('users')->where('codeperso', request('id'))->get()[0]->id;
            // recupérer gain user actuel
            $soldeactuel=DB::table('avoirs')->where('id_user', $idprel)->get()[0]->gainespece;

            //verifier si son solde peut etre créditer
            if ($soldeactuel >= request('montant')) {
                
                // prelever de son compte

                $solde=$soldeactuel - request('montant');
                DB::table('avoirs')->where('id_user', $idprel)->update(['gainespece'=>$solde]);

                //recuperer compte admin
                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', auth()->user()->id)->get()[0]->compteavoirrecu;

                //debiter le compte admin
                $recu=$compteadmin + request('montant');

                //update la table
                DB::table('systemadmins')
                        ->where('id_AdminPrincipal', auth()->user()->id)
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);
                        $nom = DB::table('users')->where('codeperso', request('id'))->get()[0]->nom;
                        $prenom = DB::table('users')->where('codeperso', request('id'))->get()[0]->prenom;
                        
                        $m = "Opération effectuée avec succès. Vous avez prélever ".request('montant')." $ SSI du compte dont l'identifiant est ".request('id')." du ".$prenom." ".$nom;
                        Historique::saveHistorique( "B", $m, auth()->user()->id );
                        $message_reception = "Il vous a été prélevé ".request('montant')." $ SSI ";
                        HistoriqueClient::saveHistorique($message_reception, $idprel);
                        flash("Opération effectuée avec succès. Vous avez prélever ".request('montant')." $ SSI du compte dont l'identifiant est ".request('id')." du ".$prenom." ".$nom."");
                        
                        return Back();               
            } else {
                Historique::saveHistorique( "B", "Le solde du client est insuffisant pour cette opération", auth()->user()->id );
                flash("Le solde du client est insuffisant pour cette opération")->error();
                return Back();
            }

        }else{
            flash("Vous n'êtes pas connecter")->error();
            return Back();
        }
        
    }

    public function evernement()
    {
        $image = DB::table('evenements')->select('path', 'image', 'date', 'lieu', 'heure', 'description', 'id_user')->get();

        $data = ['images' => $image];

        return view('mlm.evernement', $data);
    }

    public function getevernement()
    {
        return view('admin.creerevernement');   
    }

    public function setevernement()
    {
         request()->validate([
            
           'theme' => 'required',
           'lieu' => 'required',
           'date' => 'required',
           'heure' => 'required',
           'description' => 'required',
           
        ]);

        //$path = request('img')->store('evenement', 'public');

       // $image = './img';

        // Ensuite, ajoute public comme second paramètre du store
        //$path = request('image')->store('img', 'public');
        // Pour afficher image 
        // <img src="/storage/{{$path}}"> 
        // Pour afficher un lien vers pdf
        // <a href="/storage/{{$path}}"> Name PDF </a> 

        $article = Evenement::create([
            'path' => "1",
            'image' => request('theme'),
            'date' => request('date'), 
            'lieu' => request('lieu'), 
            'heure' => request('heure'), 
            'description' => request('description'),  
            'id_user' => auth()->user()->id
        ]);

        flash('Conférence créer avec succès!!!');
        return Back();
    }

    public function propos()
    {
        return view('mlm.propos');
    }

    public function seconnecter()
    {
        return view('authentification.login');
    }

    public function clientdashboard()
    {
        $type = auth()->user()->type;

        if ($type == "client") {
            $gains = DB::table('avoirs')->select('gainvirtuel', 'gainespece', 'gaincommissionvente', 'id_user')->where('id_user', auth()->user()->id)->get();

            $users = DB::table('users')
                     ->where('parrain', auth()->user()->codeunique)
                     ->where('users.compteactive', '!=', 'sup')
                     ->orderBy('created_at', 'DESC')
                     ->get();

            $filleuladmin = DB::table('niveaux')->select('nombredefilleul', 'id_user')->where('id_user', auth()->user()->id)->orderBy('id_etape', 'DESC')->get();

            $etapeactuel = DB::table('avoirs')->select('etapeActuel')->where('id_user', auth()->user()->id)->get()[0]->etapeActuel;

            $data = ['etape' => $etapeactuel, 'gains' => $gains, 'filleuls' => $users ,'filleuladmin' => $filleuladmin];
            return view('client.dashboard', $data);
        }
        if ($type == "admin") {

            $gains = DB::table('avoirs')->select('gainvirtuel', 'gainespece', 'gaincommissionvente', 'id_user')->where('id_user', auth()->user()->id)->get();

            $compterecu = DB::table('systemadmins')->select('compteavoirrecu', 'compteavoirsortant')->where('id_AdminPrincipal', auth()->user()->id)->get();

             $users = DB::table('users')
                     ->select(DB::raw('count(*) as user_count'))
                     ->where('type', 'client')
                     ->where('users.compteactive', '!=', 'sup')
                     ->get()[0]->user_count;
            $filleuladmin = DB::table('niveaux')->select('nombredefilleul', 'id_user')->where('id_user', auth()->user()->id)->get();

            $userslist = DB::table('users')
                     ->where('parrain', auth()->user()->codeunique)
                     ->get();
                     
            // RETRAIT 
            $notiftrust =  DB::table('retraittrusts')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('statut', '!=', 'sup')->get()[0]->attente;
            $notifwestern =  DB::table('retraitwesterns')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('statut', '!=', 'sup')->get()[0]->attente;
            $notifgram =  DB::table('retraitgrams')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('statut', '!=', 'sup')->get()[0]->attente;
            $notifmoov =  DB::table('retraitmoovs')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('statut', '!=', 'sup')->get()[0]->attente;
            $notifmtn =  DB::table('retraitmtns')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('statut', '!=', 'sup')->get()[0]->attente;
            $notifperfect =  DB::table('retraitperfects')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('statut', '!=', 'sup')->get()[0]->attente;
            $notifvisas =  DB::table('retraitvisas')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            // SERVICES
                     
            $notifcanals =  DB::table('canals')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            
            $notifachats =  DB::table('achatssis')->select(DB::raw('count(statut) as attente'))->where('Statut', '!=', '0')->where('Statut', '!=', 'sup')->get()[0]->attente;

            //$notiflongriches =  DB::table('longriches')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;

            $notifmtnmoovs =  DB::table('mtnmoovs')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;

            $notifsbeecartes =  DB::table('sbeecartes')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;

            $notifsbeeconventiels =  DB::table('sbeeconventiels')->select(DB::raw('count(Statut) as attente'))->where('Statut', 'non')->where('Statut', '!=', 'sup')->get()[0]->attente;

            $notifsonebs =  DB::table('sonebs')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=', 'Oui')->where('Statut', '!=', 'sup')->get()[0]->attente;

            $data = ['gains' => $gains, 'compterecu' => $compterecu, 'filleuls' => $userslist, 'all' => $users, 'filleuladmin' => $filleuladmin, 'ncanals' => $notifcanals, 
            'nachats' => $notifachats, 'nmtnmoovs' => $notifmtnmoovs, 
            'nbeecartes' => $notifsbeecartes, 'nbeeconventiels' => $notifsbeeconventiels, 'nsonebs' => $notifsonebs, 'ntrusts' => $notiftrust, 'nwesterns' => $notifwestern, 'ngrams' => $notifgram,
            'nmoovs' => $notifmoov,'nmtns' => $notifmtn,'nperfects' => $notifperfect, 'nvisas' => $notifvisas];
            return view('admin.dashboard', $data);
        }
    }

    public function admindashboard()
    {
        
        $type = auth()->user()->type;

        if ($type == "client") {
            $gains = DB::table('avoirs')->select('gainvirtuel', 'gainespece', 'gaincommissionvente', 'id_user')->where('id_user', auth()->user()->id)->get();

             $filleuladmin = DB::table('niveaux')->select('nombredefilleul', 'id_user')->where('id_user', auth()->user()->id)->orderBy('id_etape', 'DESC')->get();

             $users = DB::table('users')
                     ->where('parrain', auth()->user()->codeunique)
                     ->where('users.compteactive', '!=', 'sup')
                     ->get();

            $etapeactuel = DB::table('niveaux')->select('etapeActuel')->where('id_user', auth()->user()->id)->get()[0]->etapeActuel;

            $data = ['etape' => $etapeactuel, 'gains' => $gains, 'filleuls' => $users, 'filleuladmin' => $filleuladmin];
            return view('client.dashboard', $data);
        }
        if ($type == "admin") {
            $gains = DB::table('avoirs')->select('gainvirtuel', 'gainespece', 'gaincommissionvente', 'id_user')->where('id_user', auth()->user()->id)->get();
            $compterecu = DB::table('systemadmins')->select('compteavoirrecu', 'compteavoirsortant')->where('id_AdminPrincipal', auth()->user()->id)->get();
            $users = DB::table('users')
                     ->select(DB::raw('count(*) as user_count'))
                     ->where('type', 'client')
                     ->where('users.compteactive', '!=', 'sup')
                     ->get()[0]->user_count;
            $filleuladmin = DB::table('niveaux')->select('nombredefilleul', 'id_user')->where('id_user', auth()->user()->id)->get();
            $userslist = DB::table('users')
                     ->where('parrain', auth()->user()->codeunique)
                     ->get();
                     
            // RETRAIT 
            $notiftrust =  DB::table('retraittrusts')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            $notifwestern =  DB::table('retraitwesterns')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            $notifgram =  DB::table('retraitgrams')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            $notifmoov =  DB::table('retraitmoovs')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            $notifmtn =  DB::table('retraitmtns')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            $notifperfect =  DB::table('retraitperfects')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            $notifvisas =  DB::table('retraitvisas')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            
            // SERVICES
                     
            $notifcanals =  DB::table('canals')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            
            $notifachats =  DB::table('achatssis')->select(DB::raw('count(statut) as attente'))->where('Statut', '!=', '0')->where('Statut', '!=', 'sup')->get()[0]->attente;

            //$notiflongriches =  DB::table('longriches')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;

            $notifmtnmoovs =  DB::table('mtnmoovs')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;

            $notifsbeecartes =  DB::table('sbeecartes')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;

            $notifsbeeconventiels =  DB::table('sbeeconventiels')->select(DB::raw('count(Statut) as attente'))->where('Statut', 'non')->where('Statut', '!=', 'sup')->get()[0]->attente;

            $notifsonebs =  DB::table('sonebs')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=' , 'Oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
                     
            $data = ['gains' => $gains, 'compterecu' => $compterecu, 'filleuls' => $userslist, 'all' => $users, 'filleuladmin' => $filleuladmin, 'ncanals' => $notifcanals, 
            'nachats' => $notifachats, 'nmtnmoovs' => $notifmtnmoovs, 'nbeecartes' => $notifsbeecartes, 
            'nbeeconventiels' => $notifsbeeconventiels, 'nsonebs' => $notifsonebs, 'ntrusts' => $notiftrust, 'nwesterns' => $notifwestern, 'ngrams' => $notifgram,
            'nmoovs' => $notifmoov,'nmtns' => $notifmtn,'nperfects' => $notifperfect, 'nvisas' => $notifvisas];

            return view('admin.dashboard', $data);
        } 
    }

    public function clientregle()
    {
        return view('client.regle');
    }

    public function clientformation()
    {
        // recuperation de la base de donnée
        $formation = DB::table('mesformations')->select('id','titre', 'doc', 'id_user')->get();

        $data = ['formations' => $formation];
        return view('client.formation', $data);
    }

    public function clientformationdelete()
    {
        DB::table('mesformations')->where('id', request('id'))->delete();

        flash("Mail envoyé!!!");
        return Back();
        
    }

    public function print_filleul($mesfilleuls, $ouf, $oufs, $position, $pos)
    {
        if ($pos == "oui") {
            // Gauche
            for ($i=0; $i < count($mesfilleuls); $i++) { 
                
                  if ($position == $mesfilleuls[$i]->codeperso) {
                    //$mesfilleuls[$i]->id
                    for ($a=0; $a < count($oufs); $a++) { 
                      if ($oufs[$a]->id_user == $mesfilleuls[$i]->id) {
                        //if($position == "57007169")
                        //dd($mesfilleuls[$i]->id);
                        // $oufs[$a]->PositionGauche
                        foreach($mesfilleuls as $filleul){
                          if($filleul->codeperso == $oufs[$a]->PositionGauche){
                              $filleul = [
                                'nomuser' => $filleul->nomuser,
                                'codeperso' => $filleul->codeperso,
                                'email' => $filleul->email 
                                ];

                                return $filleul;
                              //echo "<center> $filleul->nomuser (  $filleul->codeperso  ) <br> $filleul->email  <br> || <br> ||</center>";
                              break;
                          }
                        }
                      }

                    } 
                  }     
                }
        } else {
            // Droite
                for ($i=0; $i < count($mesfilleuls); $i++) { 
                  if ($position == $mesfilleuls[$i]->codeperso) {
                    //$mesfilleuls[$i]->id
                    for ($a=0; $a < count($oufs); $a++) { 
                      if ($oufs[$a]->id_user == $mesfilleuls[$i]->id) {
                        // $oufs[$a]->PositionGauche
                        foreach($mesfilleuls as $filleul){
                          if($filleul->codeperso == $oufs[$a]->PositionDroite){
                              $filleul = [
                                'nomuser' => $filleul->nomuser,
                                'codeperso' => $filleul->codeperso,
                                'email' => $filleul->email 
                                ];

                                return $filleul;
                              break;
                          }
                        }
                      }

                    } 
                  } 
                }
        }
    }

    /*  ****** 1 ********* */
    public function clientmesfilleuls()
    {

        $moi = DB::table('users')->select('id', 'email', 'codeunique', 'nomuser', 'codeperso')->where('id', auth()->user()->id)->get();

        $mesfilleuls = DB::table('users')
            ->select('id', 'email', 'nomuser', 'codeperso')
            ->get();

        $ouf = DB::table('niveaux')->select('id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe')
                    ->where('id_user', auth()->user()->id)
                    ->get();

        $oufs = DB::table('niveaux')->select('id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe')->get();

        $filleulg = "";
        $aa = "A";
        if ($ouf[0]->PositionGauche != $aa) {
            $filleulg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[0]->PositionGauche, "oui");
        }
        $filleuld = "";
        if ($ouf[0]->PositionGauche != $aa) {
            $filleuld = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[0]->PositionGauche, "non");
        }
        $filleuldg = "";
        
        
        if ($ouf[0]->PositionDroite != $aa) {
            //dd($ouf[0]->id_etape);
            $filleuldg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[0]->PositionDroite, "oui");
            //dd($filleuldg);
        }
        
        $filleuldd = "";
        if ($ouf[0]->PositionDroite != $aa) {
            $filleuldd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[0]->PositionDroite, "non");
        }
        //dd($filleuldg);

        $data = [
            'moi' => $moi,
            'mesfilleuls' => $mesfilleuls,
            'ouf' => $ouf,
            'filleulg' => $filleulg,
            'filleuld' => $filleuld,
            'filleuldg' => $filleuldg,
            'filleuldd' => $filleuldd,
            'oufs' => $oufs
        ];

        return view('client.mesfilleuls', $data);
    }

    /*  ****** 2 ********* */
    public function clientmesfilleuls2()
    {

        $niveau = DB::table('niveaux')->where('id_user', auth()->user()->id)
                                      ->where('id_etape',2)
                                      ->get();
        if (isset($niveau[0]->id_user)) {
            
            $moi = DB::table('users')->select('id', 'email', 'codeunique', 'nomuser', 'codeperso')->where('id', auth()->user()->id)->get();

            $mesfilleuls = DB::table('users')
                ->select('id', 'email', 'nomuser', 'codeperso')
                ->get();

            // Level 1
            $ouf = DB::table('niveaux')->select('id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe')
                        ->where('id_user', auth()->user()->id)
                        ->get();
            //dd($ouf);
            //dd($ouf[1]->PositionGauche);

            $oufs = DB::table('niveaux')->select('id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe')->get();

            // Level 2
            $filleulg = "";
            $aa = "A";
            $codepersog = "";
            if ($ouf[1]->PositionGauche != $aa) {
                    // identifiant de mon gauche
                $filleulg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[1]->PositionGauche, "oui");
                if (isset($filleulg))
                    $codepersog = $filleulg['codeperso'];
            }
            $filleuld = "";
            $codepersod = "";
            if ($ouf[1]->PositionGauche != $aa) {
                $filleuld = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[1]->PositionGauche, "non");
                if (isset($filleuld))
                    $codepersod = $filleuld['codeperso'];
            }
            $filleuldg = "";
            $codepersodg = "";
            
            //$boole = $ouf[1]->PositionDroite <> $aa;
            //dd($boole);
            if ($ouf[1]->PositionDroite != $aa) {
                $filleuldg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[1]->PositionDroite, "oui");
                if (isset($filleuldg))
                    $codepersodg = $filleuldg['codeperso'];
            }
            
            $filleuldd = "";
            $codepersodd = "";
            if ($ouf[1]->PositionDroite != $aa) {
                $filleuldd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[1]->PositionDroite, "non");
                if (isset($filleuldd))
                    $codepersodd = $filleuldd['codeperso'];
            }

            // Level 3

            $filleulggg = "";
            if (isset($codepersog)) {
                $filleulggg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersog, "oui");
            }
            $filleulggd = "";
            if (isset($codepersog)) {
                $filleulggd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersog, "non");
            }
            $filleulgdg = "";
            if (isset($codepersod)) {
                $filleulgdg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersod, "oui");
            }
            $filleulgdd = "";
            if (isset($codepersod)) {
                $filleulgdd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersod, "non");
            }
            $filleuldgg = "";
            if (isset($codepersodg)) {
                $filleuldgg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodg, "oui");
            }
            $filleuldgd = "";
            if (isset($codepersodg)) {
                $filleuldgd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodg, "non");
            }
            $filleulddg = "";
            if (isset($codepersodd)) {
                $filleulddg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodd, "oui");
            }
            $filleulddd = "";
            if (isset($codepersodd)) {
                $filleulddd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodd, "non");
            }


            $data = [
                'moi' => $moi,
                'mesfilleuls' => $mesfilleuls,
                'ouf' => $ouf,
                'filleulg' => $filleulg,
                'filleuld' => $filleuld,
                'filleuldg' => $filleuldg,
                'filleuldd' => $filleuldd,
                'filleulggg' => $filleulggg,
                'filleulggd' => $filleulggd,
                'filleulgdg' => $filleulgdg,
                'filleulgdd' => $filleulgdd,
                'filleuldgg' => $filleuldgg,
                'filleuldgd' => $filleuldgd,
                'filleulddg' => $filleulddg,
                'filleulddd' => $filleulddd,
                'oufs' => $oufs
            ];

            return view('client.etape2', $data);

        } else {
            $data = [
                'non' => 'non'
            ];

            return view('client.etape2', $data);
        }
    }

    /*  ****** 3 ********* */
    public function clientmesfilleuls3()
    {
        $niveau = DB::table('niveaux')->where('id_user', auth()->user()->id)
                                      ->where('id_etape', 3)
                                      ->get();
        if (isset($niveau[0]->id_user)) {
            
            $moi = DB::table('users')->select('id', 'email', 'codeunique', 'nomuser', 'codeperso')->where('id', auth()->user()->id)->get();

            $mesfilleuls = DB::table('users')
                ->select('id', 'email', 'nomuser', 'codeperso')
                ->get();

            // Level 1
            $ouf = DB::table('niveaux')->select('id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe')
                        ->where('id_user', auth()->user()->id)
                        ->get();
            //dd($ouf);
            //dd($ouf[1]->PositionGauche);

            $oufs = DB::table('niveaux')->select('id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe')->get();

            // Level 2
            $filleulg = "";
            $aa = "A";
            $codepersog = "";
            if ($ouf[2]->PositionGauche != $aa) {
                    // identifiant de mon gauche
                $filleulg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[2]->PositionGauche, "oui");
                if (isset($filleulg))
                    $codepersog = $filleulg['codeperso'];
            }
            $filleuld = "";
            $codepersod = "";
            if ($ouf[2]->PositionGauche != $aa) {
                $filleuld = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[2]->PositionGauche, "non");
                if (isset($filleuld))
                    $codepersod = $filleuld['codeperso'];
            }
            $filleuldg = "";
            $codepersodg = "";
            
            //$boole = $ouf[1]->PositionDroite <> $aa;
            //dd($boole);
            if ($ouf[2]->PositionDroite != $aa) {
                $filleuldg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[2]->PositionDroite, "oui");
                if (isset($filleuldg))
                    $codepersodg = $filleuldg['codeperso'];
            }
            
            $filleuldd = "";
            $codepersodd = "";
            if ($ouf[2]->PositionDroite != $aa) {
                $filleuldd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[2]->PositionDroite, "non");
                if (isset($filleuldd))
                    $codepersodd = $filleuldd['codeperso'];
            }

            // Level 3

            $filleulggg = "";
            if (isset($codepersog)) {
                $filleulggg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersog, "oui");
            }
            $filleulggd = "";
            if (isset($codepersog)) {
                $filleulggd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersog, "non");
            }
            $filleulgdg = "";
            if (isset($codepersod)) {
                $filleulgdg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersod, "oui");
            }
            $filleulgdd = "";
            if (isset($codepersod)) {
                $filleulgdd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersod, "non");
            }
            $filleuldgg = "";
            if (isset($codepersodg)) {
                $filleuldgg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodg, "oui");
            }
            $filleuldgd = "";
            if (isset($codepersodg)) {
                $filleuldgd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodg, "non");
            }
            $filleulddg = "";
            if (isset($codepersodd)) {
                $filleulddg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodd, "oui");
            }
            $filleulddd = "";
            if (isset($codepersodd)) {
                $filleulddd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodd, "non");
            }


            $data = [
                'moi' => $moi,
                'mesfilleuls' => $mesfilleuls,
                'ouf' => $ouf,
                'filleulg' => $filleulg,
                'filleuld' => $filleuld,
                'filleuldg' => $filleuldg,
                'filleuldd' => $filleuldd,
                'filleulggg' => $filleulggg,
                'filleulggd' => $filleulggd,
                'filleulgdg' => $filleulgdg,
                'filleulgdd' => $filleulgdd,
                'filleuldgg' => $filleuldgg,
                'filleuldgd' => $filleuldgd,
                'filleulddg' => $filleulddg,
                'filleulddd' => $filleulddd,
                'oufs' => $oufs
            ];

            return view('client.etape3', $data);

        } else {
            $data = [
                'non' => 'non'
            ];

            return view('client.etape3', $data);
        }
    }

    /*  ****** 4 ********* */
    public function clientmesfilleuls4()
    {

        $niveau = DB::table('niveaux')->where('id_user', auth()->user()->id)
                                      ->where('id_etape', 4)
                                      ->get();
        if (isset($niveau[0]->id_user)) {
            
            $moi = DB::table('users')->select('id', 'email', 'codeunique', 'nomuser', 'codeperso')->where('id', auth()->user()->id)->get();

            $mesfilleuls = DB::table('users')
                ->select('id', 'email', 'nomuser', 'codeperso')
                ->get();

            // Level 1
            $ouf = DB::table('niveaux')->select('id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe')
                        ->where('id_user', auth()->user()->id)
                        ->get();
            //dd($ouf);
            //dd($ouf[1]->PositionGauche);

            $oufs = DB::table('niveaux')->select('id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe')->get();

            // Level 2
            $filleulg = "";
            $aa = "A";
            $codepersog = "";
            if ($ouf[3]->PositionGauche != $aa) {
                    // identifiant de mon gauche
                $filleulg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[3]->PositionGauche, "oui");
                if (isset($filleulg))
                    $codepersog = $filleulg['codeperso'];
            }
            $filleuld = "";
            $codepersod = "";
            if ($ouf[3]->PositionGauche != $aa) {
                $filleuld = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[3]->PositionGauche, "non");
                if (isset($filleuld))
                    $codepersod = $filleuld['codeperso'];
            }
            $filleuldg = "";
            $codepersodg = "";
            
            //$boole = $ouf[1]->PositionDroite <> $aa;
            //dd($boole);
            if ($ouf[3]->PositionDroite != $aa) {
                $filleuldg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[3]->PositionDroite, "oui");
                if (isset($filleuldg))
                    $codepersodg = $filleuldg['codeperso'];
            }
            
            $filleuldd = "";
            $codepersodd = "";
            if ($ouf[3]->PositionDroite != $aa) {
                $filleuldd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[3]->PositionDroite, "non");
                if (isset($filleuldd))
                    $codepersodd = $filleuldd['codeperso'];
            }

            // Level 3

            $filleulggg = "";
            if (isset($codepersog)) {
                $filleulggg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersog, "oui");
            }
            $filleulggd = "";
            if (isset($codepersog)) {
                $filleulggd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersog, "non");
            }
            $filleulgdg = "";
            if (isset($codepersod)) {
                $filleulgdg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersod, "oui");
            }
            $filleulgdd = "";
            if (isset($codepersod)) {
                $filleulgdd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersod, "non");
            }
            $filleuldgg = "";
            if (isset($codepersodg)) {
                $filleuldgg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodg, "oui");
            }
            $filleuldgd = "";
            if (isset($codepersodg)) {
                $filleuldgd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodg, "non");
            }
            $filleulddg = "";
            if (isset($codepersodd)) {
                $filleulddg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodd, "oui");
            }
            $filleulddd = "";
            if (isset($codepersodd)) {
                $filleulddd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodd, "non");
            }


            $data = [
                'moi' => $moi,
                'mesfilleuls' => $mesfilleuls,
                'ouf' => $ouf,
                'filleulg' => $filleulg,
                'filleuld' => $filleuld,
                'filleuldg' => $filleuldg,
                'filleuldd' => $filleuldd,
                'filleulggg' => $filleulggg,
                'filleulggd' => $filleulggd,
                'filleulgdg' => $filleulgdg,
                'filleulgdd' => $filleulgdd,
                'filleuldgg' => $filleuldgg,
                'filleuldgd' => $filleuldgd,
                'filleulddg' => $filleulddg,
                'filleulddd' => $filleulddd,
                'oufs' => $oufs
            ];

            return view('client.etape4', $data);

        } else {
            $data = [
                'non' => 'non'
            ];

            return view('client.etape4', $data);
        }
    }

    /*  ****** 5 ********* */
    public function clientmesfilleuls5()
    {

        $niveau = DB::table('niveaux')->where('id_user', auth()->user()->id)
                                      ->where('id_etape', 5)
                                      ->get();
        if (isset($niveau[0]->id_user)) {
            
            $moi = DB::table('users')->select('id', 'email', 'codeunique', 'nomuser', 'codeperso')->where('id', auth()->user()->id)->get();

            $mesfilleuls = DB::table('users')
                ->select('id', 'email', 'nomuser', 'codeperso')
                ->get();

            // Level 1
            $ouf = DB::table('niveaux')->select('id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe')
                        ->where('id_user', auth()->user()->id)
                        ->get();
            //dd($ouf);
            //dd($ouf[1]->PositionGauche);

            $oufs = DB::table('niveaux')->select('id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe')->get();

            // Level 2
            $filleulg = "";
            $aa = "A";
            $codepersog = "";
            if ($ouf[4]->PositionGauche != $aa) {
                    // identifiant de mon gauche
                $filleulg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[4]->PositionGauche, "oui");
                if (isset($filleulg))
                    $codepersog = $filleulg['codeperso'];
            }
            $filleuld = "";
            $codepersod = "";
            if ($ouf[4]->PositionGauche != $aa) {
                $filleuld = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[4]->PositionGauche, "non");
                if (isset($filleuld))
                    $codepersod = $filleuld['codeperso'];
            }
            $filleuldg = "";
            $codepersodg = "";
            
            //$boole = $ouf[1]->PositionDroite <> $aa;
            //dd($boole);
            if ($ouf[4]->PositionDroite != $aa) {
                $filleuldg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[4]->PositionDroite, "oui");
                if (isset($filleuldg))
                    $codepersodg = $filleuldg['codeperso'];
            }
            
            $filleuldd = "";
            $codepersodd = "";
            if ($ouf[4]->PositionDroite != $aa) {
                $filleuldd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[4]->PositionDroite, "non");
                if (isset($filleuldd))
                    $codepersodd = $filleuldd['codeperso'];
            }

            // Level 3

            $filleulggg = "";
            if (isset($codepersog)) {
                $filleulggg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersog, "oui");
            }
            $filleulggd = "";
            if (isset($codepersog)) {
                $filleulggd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersog, "non");
            }
            $filleulgdg = "";
            if (isset($codepersod)) {
                $filleulgdg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersod, "oui");
            }
            $filleulgdd = "";
            if (isset($codepersod)) {
                $filleulgdd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersod, "non");
            }
            $filleuldgg = "";
            if (isset($codepersodg)) {
                $filleuldgg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodg, "oui");
            }
            $filleuldgd = "";
            if (isset($codepersodg)) {
                $filleuldgd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodg, "non");
            }
            $filleulddg = "";
            if (isset($codepersodd)) {
                $filleulddg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodd, "oui");
            }
            $filleulddd = "";
            if (isset($codepersodd)) {
                $filleulddd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodd, "non");
            }


            $data = [
                'moi' => $moi,
                'mesfilleuls' => $mesfilleuls,
                'ouf' => $ouf,
                'filleulg' => $filleulg,
                'filleuld' => $filleuld,
                'filleuldg' => $filleuldg,
                'filleuldd' => $filleuldd,
                'filleulggg' => $filleulggg,
                'filleulggd' => $filleulggd,
                'filleulgdg' => $filleulgdg,
                'filleulgdd' => $filleulgdd,
                'filleuldgg' => $filleuldgg,
                'filleuldgd' => $filleuldgd,
                'filleulddg' => $filleulddg,
                'filleulddd' => $filleulddd,
                'oufs' => $oufs
            ];

            return view('client.etape5', $data);

        } else {
            $data = [
                'non' => 'non'
            ];

            return view('client.etape5', $data);
        }
    }

    /*  ****** 6 ********* */
    public function clientmesfilleuls6()
    {

        $niveau = DB::table('niveaux')->where('id_user', auth()->user()->id)
                                      ->where('id_etape', 6)
                                      ->get();
        if (isset($niveau[0]->id_user)) {
            
            $moi = DB::table('users')->select('id', 'email', 'codeunique', 'nomuser', 'codeperso')->where('id', auth()->user()->id)->get();

            $mesfilleuls = DB::table('users')
                ->select('id', 'email', 'nomuser', 'codeperso')
                ->get();

            // Level 1
            $ouf = DB::table('niveaux')->select('id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe')
                        ->where('id_user', auth()->user()->id)
                        ->get();
            //dd($ouf);
            //dd($ouf[1]->PositionGauche);

            $oufs = DB::table('niveaux')->select('id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe')->get();

            // Level 2
            $filleulg = "";
            $aa = "A";
            $codepersog = "";
            if ($ouf[5]->PositionGauche != $aa) {
                    // identifiant de mon gauche
                $filleulg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[5]->PositionGauche, "oui");
                if (isset($filleulg))
                    $codepersog = $filleulg['codeperso'];
            }
            $filleuld = "";
            $codepersod = "";
            if ($ouf[5]->PositionGauche != $aa) {
                $filleuld = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[5]->PositionGauche, "non");
                if (isset($filleuld))
                    $codepersod = $filleuld['codeperso'];
            }
            $filleuldg = "";
            $codepersodg = "";
            
            //$boole = $ouf[1]->PositionDroite <> $aa;
            //dd($boole);
            if ($ouf[5]->PositionDroite != $aa) {
                $filleuldg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[5]->PositionDroite, "oui");
                if (isset($filleuldg))
                    $codepersodg = $filleuldg['codeperso'];
            }
            
            $filleuldd = "";
            $codepersodd = "";
            if ($ouf[5]->PositionDroite != $aa) {
                $filleuldd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[5]->PositionDroite, "non");
                if (isset($filleuldd))
                    $codepersodd = $filleuldd['codeperso'];
            }

            // Level 3

            $filleulggg = "";
            if (isset($codepersog)) {
                $filleulggg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersog, "oui");
            }
            $filleulggd = "";
            if (isset($codepersog)) {
                $filleulggd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersog, "non");
            }
            $filleulgdg = "";
            if (isset($codepersod)) {
                $filleulgdg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersod, "oui");
            }
            $filleulgdd = "";
            if (isset($codepersod)) {
                $filleulgdd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersod, "non");
            }
            $filleuldgg = "";
            if (isset($codepersodg)) {
                $filleuldgg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodg, "oui");
            }
            $filleuldgd = "";
            if (isset($codepersodg)) {
                $filleuldgd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodg, "non");
            }
            $filleulddg = "";
            if (isset($codepersodd)) {
                $filleulddg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodd, "oui");
            }
            $filleulddd = "";
            if (isset($codepersodd)) {
                $filleulddd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodd, "non");
            }


            $data = [
                'moi' => $moi,
                'mesfilleuls' => $mesfilleuls,
                'ouf' => $ouf,
                'filleulg' => $filleulg,
                'filleuld' => $filleuld,
                'filleuldg' => $filleuldg,
                'filleuldd' => $filleuldd,
                'filleulggg' => $filleulggg,
                'filleulggd' => $filleulggd,
                'filleulgdg' => $filleulgdg,
                'filleulgdd' => $filleulgdd,
                'filleuldgg' => $filleuldgg,
                'filleuldgd' => $filleuldgd,
                'filleulddg' => $filleulddg,
                'filleulddd' => $filleulddd,
                'oufs' => $oufs
            ];

            return view('client.etape6', $data);

        } else {
            $data = [
                'non' => 'non'
            ];

            return view('client.etape6', $data);
        }
    }

    /*  ****** 7 ********* */
    public function clientmesfilleuls7()
    {

        $niveau = DB::table('niveaux')->where('id_user', auth()->user()->id)
                                      ->where('id_etape', 7)
                                      ->get();
        if (isset($niveau[0]->id_user)) {
            
            $moi = DB::table('users')->select('id', 'email', 'codeunique', 'nomuser', 'codeperso')->where('id', auth()->user()->id)->get();

            $mesfilleuls = DB::table('users')
                ->select('id', 'email', 'nomuser', 'codeperso')
                ->get();

            // Level 1
            $ouf = DB::table('niveaux')->select('id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe')
                        ->where('id_user', auth()->user()->id)
                        ->get();
            //dd($ouf);
            //dd($ouf[1]->PositionGauche);

            $oufs = DB::table('niveaux')->select('id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe')->get();

            // Level 2
            $filleulg = "";
            $aa = "A";
            $codepersog = "";
            if ($ouf[6]->PositionGauche != $aa) {
                    // identifiant de mon gauche
                $filleulg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[6]->PositionGauche, "oui");
                if (isset($filleulg))
                    $codepersog = $filleulg['codeperso'];
            }
            $filleuld = "";
            $codepersod = "";
            if ($ouf[6]->PositionGauche != $aa) {
                $filleuld = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[6]->PositionGauche, "non");
                if (isset($filleuld))
                    $codepersod = $filleuld['codeperso'];
            }
            $filleuldg = "";
            $codepersodg = "";
            
            //$boole = $ouf[1]->PositionDroite <> $aa;
            //dd($boole);
            if ($ouf[6]->PositionDroite != $aa) {
                $filleuldg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[6]->PositionDroite, "oui");
                if (isset($filleuldg))
                    $codepersodg = $filleuldg['codeperso'];
            }
            
            $filleuldd = "";
            $codepersodd = "";
            if ($ouf[6]->PositionDroite != $aa) {
                $filleuldd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[6]->PositionDroite, "non");
                if (isset($filleuldd))
                    $codepersodd = $filleuldd['codeperso'];
            }

            // Level 3

            $filleulggg = "";
            if (isset($codepersog)) {
                $filleulggg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersog, "oui");
            }
            $filleulggd = "";
            if (isset($codepersog)) {
                $filleulggd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersog, "non");
            }
            $filleulgdg = "";
            if (isset($codepersod)) {
                $filleulgdg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersod, "oui");
            }
            $filleulgdd = "";
            if (isset($codepersod)) {
                $filleulgdd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersod, "non");
            }
            $filleuldgg = "";
            if (isset($codepersodg)) {
                $filleuldgg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodg, "oui");
            }
            $filleuldgd = "";
            if (isset($codepersodg)) {
                $filleuldgd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodg, "non");
            }
            $filleulddg = "";
            if (isset($codepersodd)) {
                $filleulddg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodd, "oui");
            }
            $filleulddd = "";
            if (isset($codepersodd)) {
                $filleulddd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodd, "non");
            }


            $data = [
                'moi' => $moi,
                'mesfilleuls' => $mesfilleuls,
                'ouf' => $ouf,
                'filleulg' => $filleulg,
                'filleuld' => $filleuld,
                'filleuldg' => $filleuldg,
                'filleuldd' => $filleuldd,
                'filleulggg' => $filleulggg,
                'filleulggd' => $filleulggd,
                'filleulgdg' => $filleulgdg,
                'filleulgdd' => $filleulgdd,
                'filleuldgg' => $filleuldgg,
                'filleuldgd' => $filleuldgd,
                'filleulddg' => $filleulddg,
                'filleulddd' => $filleulddd,
                'oufs' => $oufs
            ];

            return view('client.etape7', $data);

        } else {
            $data = [
                'non' => 'non'
            ];

            return view('client.etape7', $data);
        }
    }

    /*  ****** 8 ********* */
    public function clientmesfilleuls8()
    {
        $niveau = DB::table('niveaux')->where('id_user', auth()->user()->id)
                                      ->where('id_etape', 8)
                                      ->get();
        if (isset($niveau[0]->id_user)) {
            
            $moi = DB::table('users')->select('id', 'email', 'codeunique', 'nomuser', 'codeperso')->where('id', auth()->user()->id)->get();

            $mesfilleuls = DB::table('users')
                ->select('id', 'email', 'nomuser', 'codeperso')
                ->get();

            // Level 1
            $ouf = DB::table('niveaux')->select('id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe')
                        ->where('id_user', auth()->user()->id)
                        ->get();
            //dd($ouf);
            //dd($ouf[1]->PositionGauche);

            $oufs = DB::table('niveaux')->select('id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe')->get();

            // Level 2
            $filleulg = "";
            $aa = "A";
            $codepersog = "";
            if ($ouf[7]->PositionGauche != $aa) {
                    // identifiant de mon gauche
                $filleulg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[7]->PositionGauche, "oui");
                if (isset($filleulg))
                    $codepersog = $filleulg['codeperso'];
            }
            $filleuld = "";
            $codepersod = "";
            if ($ouf[7]->PositionGauche != $aa) {
                $filleuld = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[7]->PositionGauche, "non");
                if (isset($filleuld))
                    $codepersod = $filleuld['codeperso'];
            }
            $filleuldg = "";
            $codepersodg = "";
            
            //$boole = $ouf[1]->PositionDroite <> $aa;
            //dd($boole);
            if ($ouf[7]->PositionDroite != $aa) {
                $filleuldg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[7]->PositionDroite, "oui");
                if (isset($filleuldg))
                    $codepersodg = $filleuldg['codeperso'];
            }
            
            $filleuldd = "";
            $codepersodd = "";
            if ($ouf[7]->PositionDroite != $aa) {
                $filleuldd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $ouf[7]->PositionDroite, "non");
                if (isset($filleuldd))
                    $codepersodd = $filleuldd['codeperso'];
            }

            // Level 3

            $filleulggg = "";
            if (isset($codepersog)) {
                $filleulggg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersog, "oui");
            }
            $filleulggd = "";
            if (isset($codepersog)) {
                $filleulggd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersog, "non");
            }
            $filleulgdg = "";
            if (isset($codepersod)) {
                $filleulgdg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersod, "oui");
            }
            $filleulgdd = "";
            if (isset($codepersod)) {
                $filleulgdd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersod, "non");
            }
            $filleuldgg = "";
            if (isset($codepersodg)) {
                $filleuldgg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodg, "oui");
            }
            $filleuldgd = "";
            if (isset($codepersodg)) {
                $filleuldgd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodg, "non");
            }
            $filleulddg = "";
            if (isset($codepersodd)) {
                $filleulddg = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodd, "oui");
            }
            $filleulddd = "";
            if (isset($codepersodd)) {
                $filleulddd = IndexController::print_filleul($mesfilleuls, $ouf, $oufs, $codepersodd, "non");
            }


            $data = [
                'moi' => $moi,
                'mesfilleuls' => $mesfilleuls,
                'ouf' => $ouf,
                'filleulg' => $filleulg,
                'filleuld' => $filleuld,
                'filleuldg' => $filleuldg,
                'filleuldd' => $filleuldd,
                'filleulggg' => $filleulggg,
                'filleulggd' => $filleulggd,
                'filleulgdg' => $filleulgdg,
                'filleulgdd' => $filleulgdd,
                'filleuldgg' => $filleuldgg,
                'filleuldgd' => $filleuldgd,
                'filleulddg' => $filleulddg,
                'filleulddd' => $filleulddd,
                'oufs' => $oufs
            ];

            return view('client.etape8', $data);

        } else {
            $data = [
                'non' => 'non'
            ];

            return view('client.etape8', $data);
        }
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

    public function adminlogout()
    {
        auth()->logout();
        return redirect('/connexion');   
    }

    public function get_ip() {
        // IP si internet partagé
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        // IP derrière un proxy
        elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        // Sinon : IP normale
        else {
            return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
        }
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
                
                if (IndexController::users(request('mail'))) {

                    $email = DB::table('users')
                            ->select('email')
                            ->where('nomuser', request('mail'))
                            ->get()[0]->email;

                    //$sujet = "Connexion réussi!!!";
                    //$objet = "Vous etre connecté à votre compte SSI";
                    //IndexController::EnvoieMail($email, "", $sujet, $objet);

                    return redirect('/admin/dashboard');    
                }
                if (!IndexController::users(request('mail'))) {

                    $email = DB::table('users')
                            ->select('email')
                            ->where('nomuser', request('mail'))
                            ->get()[0]->email;

                    //$sujet = "Connexion réussi!!!";
                    //$objet = "Vous etre connecté à votre compte SSI";
                    //IndexController::EnvoieMail($email, "", $sujet, $objet);

                    return redirect('/dashboard');    
                }                
            }
            else
            {
            
                // Envoie mail d'approbation
                $parrain = DB::table('users')->select('parrain')->where('id', auth()->user()->id)->get()[0]->parrain;
                        $mailparrain = IndexController::MailParrain($parrain);
                        $codeapprobation = IndexController::generercodeapprobation();
                        IndexController::EnvoieMail($mailparrain, "Donnez lui ce code d'approbation : ".$codeapprobation." pour qu'il autorise son l'inscription. <br> Rassurez-vous d'avoir le minimum dans votre compte avoir", "Approbation de compte sur SSI", "Donner l'accord à un filleul de défalquer de votre compte pour s'incrire");

                        $result = json_encode([
                            'id_user' => auth()->user()->id,
                            'nombrefois' => 0,
                            'ap' => 1,
                            'approbation' => $codeapprobation  
                        ]);

                        $data = [
                            'idres' => $result
                        ];
                        
                return view('authentification.approbation', $data);
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
                    
                    if (IndexController::usersid(request('mail'))) {
                    
                        $email = DB::table('users')
                            ->select('email')
                            ->where('codeperso', request('mail'))
                            ->get()[0]->email;

                        //$sujet = "Connexion réussi!!!";
                        //$objet = "Vous etre connecté à votre compte SSI";
                        //IndexController::EnvoieMail($email, "", $sujet, $objet);

                        return redirect('/admin/dashboard');    
                    }
                    if (!IndexController::usersid(request('mail'))) {
             
                        $email = DB::table('users')
                            ->select('email')
                            ->where('codeperso', request('mail'))
                            ->get()[0]->email;


                           //$sujet = "Connexion réussi!!!";
                           //$objet = "Vous etre connecté à votre compte SSI";
                           //IndexController::EnvoieMail($email, "", $sujet, $objet);
                        return redirect('/dashboard');    
                    }                
                }
                else
                {
                    // Envoie mail d'approbation
                		$parrain = DB::table('users')->select('parrain')->where('id', auth()->user()->id)->get()[0]->parrain;
                        $mailparrain = IndexController::MailParrain($parrain);
                        $codeapprobation = IndexController::generercodeapprobation();
                        IndexController::EnvoieMail($mailparrain, "Donnez lui ce code d'approbation : ".$codeapprobation." pour qu'il autorise son l'inscription. <br> Rassurez-vous d'avoir le minimum dans votre compte avoir", "Approbation de compte sur SSI", "Donner l'accord à un filleul de défalquer de votre compte pour s'incrire");

                        $result = json_encode([
                            'id_user' => auth()->user()->id,
                            'nombrefois' => 0,
                            'ap' => 1,
                            'approbation' => $codeapprobation  
                        ]);

                        $data = [
                            'idres' => $result
                        ];
                        
                		return view('authentification.approbation', $data);
                }

            }
        }
        return Back()->withInput()->withErrors([
                    'mail' => 'Veuillez vérifier le pseudo ou identifiant code',
                    'password' => 'Veuillez vérifier le mot de passe'
                ]);
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

    public function sedeconnecter(Request $request)
    {
        auth()->logout();
        return redirect('/connexion');
    }

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
            
        $pack = "";

        $data = ['mps' => $mps, 'pays' => $pays, 'monnaie' => $monnaie, "pack" => $pack];

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
        $pack = "";
        $data = ['mps' => $mps, 'pays' => $pays, 'monnaie' => $monnaie, 'link'=> request('parrain'), "pack" => $pack];

        return view('authentification.register', $data);   
    }


    public function getfogot()
    {
        return view('authentification.passwords.getmail');
    }

    public function fogot(Request $request)
    {

        request()->validate([
            'mail' => 'required|string|email|max:255',
            'codeperso' => 'required'
        ]);

        // Générer message
        $string = "";
        $universal_key = 12;

        $user_ramdom_key = 
    "(aLABbC0cEd1[eDf2FghR3ij4kYXQl5Um-OPn6pVq7rJs8*tuW9I+vGwxHTy#)K]ZM_S";
        srand((double)microtime()*time());
        for($i=0; $i<$universal_key; $i++) {
        $string .= $user_ramdom_key[rand()%strlen($user_ramdom_key)];
        }

        // Envoie de mail
        $message = $string;

        IndexController::EnvoieMail(request('mail'), $message, "Réinitialisation de mot de passe de l'identifiant".request('codeperso')." :", "Réinitialiser votre mot de passe en renseignant l'information qui suit dans le site");
        // Recuperer d'abord l'adresse email depuis une fenetre
        flash("Mail envoyé!!!");
        $data = ['mail'=> request('mail'), 'message'=> $message, 'codeperso' => request('codeperso')];
        return view('authentification.passwords.forgot-password', $data);
    }

    public function rfogot()
    {
        IndexController::EnvoieMail(request('mail'), request('message'), "Réinitialisation de mot de passe", "Réinitialiser votre mot de passe en renseignant l'information qui suit dans le site");
        // Recuperer d'abord l'adresse email depuis une fenetre
        flash("Mail renvoyé!!!");
        $data = ['mail'=> request('mail'), 'message'=> request('message')];
        return Back();
        //return view('authentification.passwords.forgot-password', $data);   
    }

    public function setfogot(Request $request)
    {
        request()->validate([
            'password' => 'required',
            'passwordbis' => 'required',
            'mes' =>'required'
        ]);

        if (request('password') != request('passwordbis')) {
            flash("Erreur!!! Mot de passe incorrect. Veuillez verifier les mots de passe")->error();
            $data = ['mail'=> request('mail'), 'message'=> request('message'), 'codeperso' => request('codeperso')];
            return view('authentification.passwords.forgot-password', $data);
        }


        $mail = request('mail');
        //dd($mail);
        if ($mail != "") {
            
            if (request('mes') != request('message')) {
                //dd(request('message'));
                flash("Les informations ne sont pas correct.")->error();
                $data = ['mail'=> request('mail'), 'message'=> request('message'), 'codeperso' => request('codeperso')];
                return view('authentification.passwords.forgot-password', $data);
                //return Back();
            }
            else
            {
                $mdp = DB::table('users')
                    ->where('email', request('mail'))
                    ->where('codeperso', request('codeperso'))
                    ->update(['password' => bcrypt(request('password'))]);

                return redirect('/connexion');
            }
        }
        else
        {
            flash("Erreur!!! Votre session à expirer. Veuillez réeassayer la réinitialisation")->error();
            $data = ['mail'=> request('mail'), 'message'=> request('message'), 'codeperso' => request('codeperso')];
            return view('authentification.passwords.forgot-password', $data);
        }

        //flash("Les informations ne sont pas correct.");
        //return Back();
    }

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

        $data = ['mps' => $mps, 'pays' => $pays, 'monnaie' => $monnaie];
        return view('client.ajoutfilleul', $data);
    }

    public function getnouveaufilleul()
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

        $data = ['mps' => $mps, 'pays' => $pays, 'monnaie' => $monnaie];
        return view('admin.nouveaufilleul', $data);
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

        $exit = IndexController::verificationCodeUnique(request('parrain'));

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

                $code_unique = IndexController::generercodeunique();

                $code_id_unique = IndexController::genereridunique();

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

                        $code_unique = IndexController::generercodeunique();

                        $code_id_unique = IndexController::genereridunique();

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
                        $mailparrain = IndexController::MailParrain($parrain);
                        $codeapprobation = IndexController::generercodeapprobation();
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


    public function saveinscription(Request $request)
    {

        //dd(request('pack'));

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
        
        $temp_id = array("0");

        
        //$codep = DB::table('pays')->select('code')->where('libelle', request('pays'))->get()[0]->code;
        $code_pays = '';
        if (isset(DB::table('pays')->select('code')->where('libelle', request('pays'))->get()[0]->code)) {
            $code_pays = DB::table('pays')->select('code')->where('libelle', request('pays'))->get()[0]->code;
        }

        // Verification si parrain existe

        $exit = IndexController::verificationCodeUnique(request('parrain'));

        // Préparation du compte du filleul
        //$cocher = request('cocherparrain');

        //dd($exit);
        if ($exit != "0" && request('cocherparrain')) {
                flash("Veuillez entrer soit  votre code parrain ou choisir 'Pas de code de parrainage'.")->error();
                return Back();
            }

        if ($exit != "0" || request('cocherparrain')) {
            // C'est bon
            // Le code de parrainage est bon

            

            $parrain = 0;

            if (request('cocherparrain')) { // Verification sur checkbox est true 
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
                if ($i == 0) {
                   $temp_ps = '';
                } else {
                   $temp_ps = $i + 1;
                }

                $temp_pseudo = $pseudo_filleul.''.$temp_ps;
                //echo $i;

                // Si code parrain est de l'admin alors passe

                $var_type = DB::table('users')
                    ->select('type')
                    ->where('codeunique', $parrain)
                    ->get()[0]->type;


                if ($var_type == "admin") {
                
                    // Générer un code Unique comme code de parrainage

                    $code_unique = IndexController::generercodeunique();
                    
                    $code_id_unique = IndexController::genereridunique();

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
                else
                {// si non. je ne suis pas administrateur
                    //verifier le nombre de filleul ou d'etape du parrain
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

                        //$parrain = DB::table('systemadmins')->select('codeparrainadmin')->where('Admin', 'oui')->get()[0]->codeparrainadmin;

                        //flash("Le parrain à atteint le seuil maximal. Veuillez lui demandé ou cocher l'option inconnue pour construire son nouveau réseau.")->error();
                        //return Back();
                    }
                    else
                    {
                        // Laisser passer

                        $code_unique = IndexController::generercodeunique();

                        $code_id_unique = IndexController::genereridunique();

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
                        $mailparrain = IndexController::MailParrain($parrain);
                        $codeapprobation = IndexController::generercodeapprobation();

                        $mes = "Donnez à ".request('prenom')." ".request('nom')." ce code d'approbation : ".$codeapprobation." pour qu'il autorise son l'inscription de ".$nombreCompte." compte(s).  Rassurez-vous d'avoir le minimum dans votre compte avoir";
                        
                        IndexController::EnvoieMail($mailparrain, $mes, "Approbation de compte sur SSI", "Donner l'accord à un filleul de défalquer de votre compte pour s'inscrire");

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

            // Si le parrain atteint les  8 etapes alors impossible de continuer
        }
        else
        {   // renvoyer un message disant que le code de parrainage est inconnue et aucune option n'est cocher.

            flash("Le code de parrainage est inconnue et aucune option n'est cocher. Veuillez vérifier")->error();
            return Back();
        }
    }


    public function continueinscription(Request $request)
    {

        // Verification si parrain existe

        $exit = IndexController::verificationCodeUnique(request('parrain'));
        $temp_id = request('id1');
        // Préparation du compte du filleul
        $cocher = request('cocherparrain');

        if ($exit != "0" || isset($cocher)) {
            // C'est bon
            // Le code de parrainage est bon

            if ($exit != "0" && isset($cocher)) {
                flash("Veuillez entrer soit  votre code parrain ou choisir 'Pas de code de parrainage'.")->error();
                return Back();
            }

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

            $nombreCompte = request('compteacreer');

            // Variable initialiser retour
            $data = [
                        'id_user' => 1,
                        'nombrefois' => 1
                    ];

            $pseudo_filleul = request('pseudo');

            // Boucle for 
            // nomuser varie = pseudo+i
            $depart = request('position_actuel') - 1;
            for ($i=$depart; $i < $nombreCompte; $i++) { 
               if ($i == 0) {
                   $temp_ps = '';
                } else {
                   $temp_ps = $i + 1;
                }

                $temp_pseudo = $pseudo_filleul.''.$temp_ps;

                // Si code parrain est de l'admin alors passe

                $var_type = DB::table('users')->select('type')->where('codeunique', $parrain)->get()[0]->type;


                if ($var_type == "admin") {
                
                    // Générer un code Unique comme code de parrainage

                    $code_unique = IndexController::generercodeunique();
                    
                    $code_id_unique = IndexController::genereridunique();

                    $paiement_id = DB::table('moyen_payements')->select('id')->where('libelle', request('payement'))->get()[0]->id;

                    if (!isset(DB::table('users')
                                ->where('email', request('mail'))
                                ->where('nomuser', $temp_pseudo)
                                ->get()[0]->nomuser)) {

                        $create = User::create([
                            'nom' => request('nom'),
                            'prenom' => request('prenom'),
                            'sexe'=> request('sexe'),
                            'tel' => request('tel'),
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
                            'moyendepayement' => request('moyendepayement')
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
                else
                {// si non. je ne suis pas administrateur
                    //verifier le nombre de filleul ou d'etape du parrain
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
                            'tel' => request('tel'),
                            'compteactive' => "non",
                            'email' => request('mail'),
                            'password' => request('password'),
                            'pseudo' => $pseudo_filleul,
                            'moyendepayement' => request('moyendepayement'),
                            'compteacreer' => $nombreCompte
                        ];
 
                        return view('authentification.valideparrain', $data);

                        //$parrain = DB::table('systemadmins')->select('codeparrainadmin')->where('Admin', 'oui')->get()[0]->codeparrainadmin;

                        //flash("Le parrain à atteint le seuil maximal. Veuillez lui demandé ou cocher l'option inconnue pour construire son nouveau réseau.")->error();
                        //return Back();
                    }
                    else
                    {
                        // Laisser passer

                        $code_unique = IndexController::generercodeunique();

                        $code_id_unique = IndexController::genereridunique();

                        $paiement_id = DB::table('moyen_payements')->select('id')->where('libelle', request('payement'))->get()[0]->id;
                        
                        if (!isset(DB::table('users')
                                ->where('email', request('mail'))
                                ->where('nomuser', $temp_pseudo)
                                ->get()[0]->nomuser)) {
                            
                        $create = User::create([
                            'nom' => request('nom'),
                            'prenom' => request('prenom'),
                            'sexe'=> request('sexe'), 
                            'tel' => request('tel'),
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
                        $mailparrain = IndexController::MailParrain($parrain);
                        $codeapprobation = IndexController::generercodeapprobation();
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
                            /*           
                            if (request('payerf') == 'NON'){
                                return view('authentification.effectuerpayement', $data);
                            }
                            else
                            {
                                return view('authentification.approbation', $data);
                            } */  


            // Si le parrain atteint les  8 etapes alors impossible de continuer
        }
        else
        {   // renvoyer un message disant que le code de parrainage est inconnue et aucune option n'est cocher.

            flash("Le code de parrainage est inconnue et aucune option n'est cocher. Veuillez vérifier")->error();
            //return Back();
        }
    }

    public function generercodeapprobation()
    {
        $code_unique = rand(10000, 99999);

        return 'appr'.$code_unique.'prou';
    }

    public function MailParrain($parrain)
    {
    //dd($parrain);
        return DB::table('users')
                    ->where('codeunique', $parrain)
                    ->get()[0]->email;
    }

    public function activeraccount()
    {
        return view('admin.activercompte');
    }

    // Valider payement à partir de l'API de transaction

    public function valideinscription()
    {
        $id = request('id');
        $act = request('active');
        if (isset($act)) {
            if(!isset(DB::table('users')
                    ->where('codeperso', $id)
                    ->get()[0]->id))
            {
                flash("Le filleul portant l'identifiant saisir n'existe pas");
                return Back();
            }
            else
            {
                $id = DB::table('users')
                    ->where('codeperso', $id)
                    ->get()[0]->id;
            }
        }
        
        $active = DB::table('users')->select('compteactive')->where('id', $id)->get()[0]->compteactive;

        if ($active == "non") {
			
		$codeunique_parrain = IndexController::mon_parrain($id);

        //dd($codeunique_parrain);
        $id_parrain = IndexController::id_mon_parrain($codeunique_parrain);

        // Verification de l'etape actuel du parrain

        $etape_actuel = IndexController::Etape_ActuelParrain($id_parrain);

        // Code parrain de l'administrateur du site

        $code_parrain_admin = IndexController::Code_Parrain_Admin();

        if ($etape_actuel > 8) {
            // Mon parrain n'est plus capable de me prendre comme filleul
            // Je beneficie du code parrain de l'administrateur du site

            $codeunique_parrain = $code_parrain_admin;

            // Mise à jour dans la table du client

            DB::table('users')
                ->where('id', $id_user)
                ->update(['codeunique' => $codeunique_parrain]);

			// Actualiser l'etape actuel du parrain
                    $id_parrain = IndexController::id_mon_parrain($codeunique_parrain);
                    $etape_actuel = IndexController::Etape_ActuelParrain($id_parrain);
     
        }

        $trans = '';
        if (isset($_GET['transaction_id'])) {
            $trans = $_GET['transaction_id'];
        }

        // Initialisation du compte avoir de l'utilisateur

        $id_avoirs = IndexController::user_init($id, $trans);



        $id_user = $id;

        $valeur_payer = 10;

        // Premiere translation du filleul

        //IndexController::first_Translation($id_user, $id_avoirs, $trans, $valeur_payer);

        // Premiere etapes consiste a mettre a jour les filleuls

        // Recuperer le parrain enregistrer pour l'utilisateur
        //dd($id_user);

        // Deuxieme etapes a mettre a jour les gains

        // Les pourcentage definir du systeme

        $pourcentageespece = IndexController::PourcentageFilleulEspece();

        $pourcentagevirtuel = IndexController::PourcentageFilleulVirtuel();

        // Calcule de la valeur en %

        $gain_espece = $valeur_payer * ($pourcentageespece / 100);

        $gain_virtuel = $valeur_payer * ($pourcentagevirtuel / 100);

        // alors le parrain beneficie de ces valeurs

        $gainsespece_actuel = IndexController::VirtuelActuel($id_parrain);

        $gainsespece_actuel_mise_a_jour = $gainsespece_actuel + $gain_espece;
        DB::table('avoirs')
                    ->where('id_user', $id_parrain)
                    ->update(['gainvirtuel' => $gainsespece_actuel_mise_a_jour]);

        $gainsvirtuel_actuel = IndexController::VirtuelEspece($id_parrain);

        $gainsvirtuel_actuel_mise_a_jour = $gainsvirtuel_actuel + $gain_virtuel;
        DB::table('avoirs')
                    ->where('id_user', $id_parrain)
                    ->update(['gainespece' => $gainsvirtuel_actuel_mise_a_jour]);

        // ajouter gain d'etape pour chaque filleul qui vient
		if ($etape_actuel == 1) {
			$valeurajout = IndexController::ValeurAjouterEtape($etape_actuel);
			$possiblefilleul = IndexController::FilleulPossible($etape_actuel);
			$gainsespece_actuel = IndexController::VirtuelEspece($id_parrain);

			$gainsespece_actuel_mise_a_jour = $gainsespece_actuel + ($valeurajout / $possiblefilleul);
			DB::table('avoirs')
					->where('id_user', $id_parrain)
					->update(['gainespece' => $gainsespece_actuel_mise_a_jour]);
		}
		
        // Compte de l'administrateur
        $gainsadmin_actuel = IndexController::AdminCompteRecu();

        $gainsadmin_actuel_mise_a_jour = $gainsadmin_actuel + $valeur_payer;
        DB::table('systemadmins')
                    ->where('Admin', 'oui')
                    ->update(['compteavoirrecu' => $gainsadmin_actuel_mise_a_jour]);
					
		$gaindebiter = DB::table('systemadmins')
                                            ->select('compteavoirsortant')
											->where('Admin', 'oui')
                                            ->get()[0]->compteavoirsortant;

                                        $gaindebiterm = $gaindebiter + $valeur_payer;
                                        DB::table('systemadmins')
                                            ->where('Admin', 'oui')
                                            ->update(['compteavoirsortant' => $gaindebiterm]);

        

        $niv = Niveau::create([
            'nombredefilleul' => 0, 
            'id_user' => $id_user,
            'id_etape' => 1,
            'PositionGauche' => "A", 
            'PositionDroite' => "A",
           'id_equipe' => IndexController::EquipeParrain($id_parrain)
        ]);

                $u = DB::table('users')
                    ->select('nom', 'prenom', 'sexe', 'email', 'codeunique', 'nomuser', 'codeperso', 'parrain')
                    ->where('id', $id_user)
                    ->get();

                    // Mise à jour dans l'arbre

                $codeperso = $u[0]->codeperso;
                $monParrain = $u[0]->parrain;

                //AdminController::newfilleulFile($codeperso, $monParrain);

                // Activer le compte

        DB::table('users')
                ->where('id', $id_user)
                ->update(['compteactive' => 'oui']);

        $nomparrain = IndexController::NomParrain($u[0]->parrain);
                    $destinataire = $u[0]->email;
					/*
					$message  = "Monsieur Madame, <br> <b>".$u[0]->prenom." ".$u[0]->nom.",</b> votre compte est validé. <br> <br> Bienvenu à la <b>Source du Succès International.<b> <br> 
                     <br>Votre code de parrainage est la suivante : ".$u[0]->codeunique." <br><br>
                     Le nom de votre parrain est : ".$nomparrain." <br> <br>
                     Votre lien de parrainage est : http://sourcedusuccesinternational.com/inscription-monparrain-".$u[0]->codeunique." <br> <br>
                     Vous pouvez vous connecter grace à l'identifiant suivante ".$u[0]->codeperso." ou à votre pseudo ".$u[0]->nomuser." <br> <br>
                     Connectez-vous à votre compte en cliquant sur ce lien <a href=\"http://sourcedusuccesinternational.com/connexion\"> Se connecter </a>";
                
                     
                   IndexController::EnvoieMail($destinataire, $message, "Compte crée avec succes", ""); */

                   $data = [
                        'nom' => $u[0]->nom,
                        'prenom' => $u[0]->prenom,
                        'codeunique' => $u[0]->codeunique,
                        'nomparrain' => $nomparrain,
                        'codeperso' => $u[0]->codeperso,
                        'nomuser' => $u[0]->nomuser
                    ];

                    setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                    date_default_timezone_set('Africa/Porto-Novo');

                    $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
                    $HEURE = date("H:i"); // Heure d'envoi de l'email

                    $Subject = "Compte crée avec succès - $JOUR $HEURE";

                    SendMail::sendmailValidation($destinataire, $Subject, $data);

        $act = request('active');
        if (isset($act)) {
                flash("Le compte du filleul activé avec succès!!!");
                return Back();
        }
        }
        $act = request('active');
        if (isset($act)) {
                flash("Le compte du filleul est déjà activé!!!");
                return Back();
        }

        return view('authentification.validerregister');
    }


    /* Des methodes pour la validation */

    public function AdminCompteSortant()
    {
        return DB::table('systemadmins')->select('compteavoirsortant')->where('Admin', 'oui')->get()[0]->compteavoirsortant;   
    }

    public function AdminCompteRecu()
    {
        return DB::table('systemadmins')->select('compteavoirrecu')->where('Admin', 'oui')->get()[0]->compteavoirrecu;   
    }

    public function VirtuelActuel($id_parrain)
    {
       return DB::table('avoirs')->select('gainvirtuel')->where('id_user', $id_parrain)->get()[0]->gainvirtuel; 
    }  

    public function VirtuelEspece($id_parrain)
    {
        // Espèce est devenir commission vente
        return DB::table('avoirs')->select('gaincommissionvente')->where('id_user', $id_parrain)->get()[0]->gaincommissionvente;  
    }

    public function PourcentageFilleulEspece()
    {
        return DB::table('systemadmins')->select('pourcentagefilleulespece')->where('Admin', 'oui')->get()[0]->pourcentagefilleulespece;
    }

    public function PourcentageFilleulVirtuel()
    {
        return DB::table('systemadmins')->select('pourcentagefilleulvirtuel')->where('Admin', 'oui')->get()[0]->pourcentagefilleulvirtuel;
    }

    public function ValeurAjouterEtape($etape)
    {
        return DB::table('etapes')->select('ValeurAjouter')->where('id', $etape)->get()[0]->ValeurAjouter;
    }

    public function FilleulPossible($etape)
    {
        return DB::table('etapes')->select('NombrePossible')->where('id', $etape)->get()[0]->NombrePossible;
    }

    public function NbrefilleulActuel($id_user)
    {
        return DB::table('niveaux')->select('nombredefilleul')->where('id_user', $id_user)->orderBy('id_etape', 'DESC')->get()[0]->nombredefilleul;
    }

    public function TypeParrain($valeur)
    {
        return DB::table('users')->select('type')->where('codeunique', $valeur)->get()[0]->type;
    }

    public function Code_Parrain_Admin()
    {
        return DB::table('systemadmins')->select('codeparrainadmin')->where('Admin', 'oui')->get()[0]->codeparrainadmin;
    }

    public function user_init($id, $trans)
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

    public function first_Translation($user, $avoirs, $trans, $valeur_payer)
    {
        $user_ini = Translationuser::create([
                'id_user' => $user, 
                'id_avoir' => $avoirs,
                'translation_id' => $trans, 
                'montantrecu' => 0, 
                'montantenvoye' => $valeur_payer
            ]);

        return 0;
    }

    public function mon_parrain($id)
    {
        return DB::table('users')->select('parrain')->where('id', $id)->get()[0]->parrain;
    }

    public function id_mon_parrain($codeunique)
    {
        return DB::table('users')->select('id')->where('codeunique', $codeunique)->get()[0]->id;  
    }

    public function NomParrain($code)
    {
        $t = DB::table('users')->select('nom', 'prenom')->where('codeunique', $code)->get();
        return $t[0]->nom." ".$t[0]->prenom; 
    }

    public function Etape_ActuelParrain($id_parrain)
    {

        //dd($id_parrain);
        return DB::table('niveaux')->select('id_etape')->where('id_user', $id_parrain)->orderBy('id_etape', 'DESC')->get()[0]->id_etape; 
    }

    /* End Methode */

    public function traitementinscription()
    {

        // Avant d'enregistrer le filleul

        // Verifier le message de retour de kkiapaye

        // Enregistrer l'information dans une table translaction par exemple.

        $parrain = "00000001";
        // Vérification du parrain
        $var_id_parrain = DB::table('users')->select('id')->where('codeunique', $parrain)->get()[0]->id;

        // Vérification de l'etape du parrain
        $etape_actuel = DB::table('niveaux')->select('id_etape')->where('id_user', $var_id_parrain)->get()[0]->id_etape;

        // Nombre de filleul possible pour cette etape
        $nombre_filleul_possible = DB::table('etapes')->select('NombrePossible')->where('id', $etape_actuel)->get()[0]->NombrePossible;

        // Vérification du nombre de filleul trouver
        $filleul = DB::table('users')
                ->select(DB::raw('count(*) as user_count'))
                ->where('parrain', $parrain)
                ->get()[0]->user_count;

        // Incrémenter le compte des avoirs du parrain de
        // 500 dans gain en espece et 500 dans gain virtuel et somme dans somme

        // Enregistrer dans la table niveaux : le nombre de filleul
        // id_user et id_etape

        // Activer compte filleul
    }

    public function validerpayement()
    {
        return view('authentification.effectuerpayement');
    }

    public function traitementpayement()
    {
        $idres = request('idres');
        $valeur = json_decode($idres, true);
        //dd($valeur['id_user'][0]);

        $approbation = $valeur['approbation'];

        if (isset($approbation) && $approbation != "" && isset($idres) && $idres != "")
        {
            $tableiduserc = $valeur['id_user'];
            $nombrefoisc = $valeur['nombrefois'];
        if ($nombrefoisc == 0) {
                $nombrefoisc = 1;
            }
            $useriduc = 0;
            $tempoui = 0;
            $tempnon = 0;
            $temp_user = array("0");
            for ($t=0; $t < $nombrefoisc; $t++) {
                 $iter = $t + 1;
                if (isset($valeur['ap']) && $valeur['ap'] == 1) {
                    //$iteration = $iteration - 1;
                    $useriduc = $tableiduserc;
                }
                else{
                    $useriduc = $tableiduserc[$iter];
                }

                if (isset(DB::table('niveaux')->select('id_user')->where('id_user', $useriduc)->get()[0]->id_user) &&
            isset(DB::table('avoirs')->select('id_user')->where('id_user', $useriduc)->get()[0]->id_user)) {
                    
                    $tempoui += 1;

                } else {
                    if ($tempoui > 0) {
                        array_push($temp_user, DB::table('users')->select('codeperso')->where('id', $useriduc)->get()[0]->codeperso);
                    }
                    $tempnon += 1;
                }
            }

            if ($tempoui != 0) {
                // redirection
                if($tempnon == 0 && $tempoui == 1){
                    return view('authentification.login');
                }
                else
                {
                    if (count($temp_user) > 1) {
                        $data = ['identifiants' => $temp_user];
                        return view('authentification.existance', $data);
                    }
                    else
                        return view('authentification.login');       
                    
                }
            } else 
			{
                //dd("True");

        // Verification de l'approbation 
        if ($approbation == request('parraincode')) {
            
            $tableiduser = $valeur['id_user'];
            $nombrefois = $valeur['nombrefois'];
        if ($nombrefois == 0) {
                $nombrefois = 1;
            }
            $useridu = 0;
            for ($i=0; $i < $nombrefois; $i++) {
                 $iteration = $i + 1;
                if ( isset($valeur['ap']) && $valeur['ap'] == 1) {
                    //$iteration = $iteration - 1;
                    $useridu = $valeur['id_user'];
                }
                else{
                    $useridu = $tableiduser[$iteration];
                }

                //dd($valeur['ap']);
                	
                	$active = DB::table('users')->select('compteactive')->where('id', $useridu)->get()[0]->compteactive;

                if ($active == "non") {

                $codeunique_parrain = IndexController::mon_parrain($useridu);

                //dd($codeunique_parrain);
                $id_parrain = IndexController::id_mon_parrain($codeunique_parrain);

                // Verification de l'etape actuel du parrain

                $etape_actuel = IndexController::Etape_ActuelParrain($id_parrain);

                // Code parrain de l'administrateur du site

                $code_parrain_admin = IndexController::Code_Parrain_Admin();

                if ($etape_actuel > 8) {
                    // Mon parrain n'est plus capable de me prendre comme filleul
                    // Je beneficie du code parrain de l'administrateur du site

                    $codeunique_parrain = $code_parrain_admin;

                    // Mise à jour dans la table du client

                    DB::table('users')
                        ->where('id', $id_user)
                        ->update(['codeunique' => $codeunique_parrain]);

                    // Actualiser l'etape actuel du parrain
                    $id_parrain = IndexController::id_mon_parrain($codeunique_parrain);
                    $etape_actuel = IndexController::Etape_ActuelParrain($id_parrain);
     
                }
                    
                /* Défalquer le nombre de fois du compte à crée dans le compte du parrain */
                
                //Verifier si le solde du parrain suffit
                //$pa = DB::table('users')->select('parrain')->where('id', $useridu)->get()[0]->parrain;
                $pa = $codeunique_parrain;
                
                $id_pa = DB::table('users')->select('id')->where('codeunique', $pa)->get()[0]->id;
                
                $verifsolde = DB::table('avoirs')->select('gainespece')->where('id_user', $id_pa)->get()[0]->gainespece;

               if ($verifsolde >= 10) {
                                $soldea = $verifsolde - 10;
                                DB::table('avoirs')
                                    ->where('id_user', $id_pa)
                                    ->update(['gainespece' => $soldea]);
                                } else {
                                    if (!isset(DB::table('systemadmins')
                                            ->select('id_AdminPrincipal')
                                            ->where('id_AdminPrincipal', $id_pa)
                                            ->get()[0]->id_AdminPrincipal)) {
                                        return view('authentification.echec');
                                    }
                                    else
                                    {
                                        $gaindebiter = DB::table('systemadmins')
                                            ->select('compteavoirsortant')
                                            ->where('id_AdminPrincipal', $id_pa)
                                            ->get()[0]->compteavoirsortant;

                                        $gaindebiterm = $gaindebiter + 10;
                                        DB::table('systemadmins')
                                            ->where('id_AdminPrincipal', $id_pa)
                                            ->update(['compteavoirsortant' => $gaindebiterm]);
                                    }
                                }


                /* Methode de validation */

                $id = $useridu;

                $trans = '';
                if (isset($_GET['transaction_id'])) {
                    $trans = $_GET['transaction_id'];
                }

                // Initialisation du compte avoir de l'utilisateur

                $id_avoirs = IndexController::user_init($id, $trans);

                $id_user = $id;

                $valeur_payer = 10;

                // Premiere translation du filleul

                //IndexController::first_Translation($id_user, $id_avoirs, $trans, $valeur_payer);

                // Premiere etapes consiste a mettre a jour les filleuls

                // Recuperer le parrain enregistrer pour l'utilisateur
                //dd($id_user);

                /*

                $codeunique_parrain = IndexController::mon_parrain($id_user);

                //dd($codeunique_parrain);
                $id_parrain = IndexController::id_mon_parrain($codeunique_parrain);

                // Verification de l'etape actuel du parrain

                $etape_actuel = IndexController::Etape_ActuelParrain($id_parrain);

                // Code parrain de l'administrateur du site

                $code_parrain_admin = IndexController::Code_Parrain_Admin();

                if ($etape_actuel > 8) {
                    // Mon parrain n'est plus capable de me prendre comme filleul
                    // Je beneficie du code parrain de l'administrateur du site

                    $codeunique_parrain = $code_parrain_admin;

                    // Mise à jour dans la table du client

                    DB::table('users')
                        ->where('id', $id_user)
                        ->update(['codeunique' => $codeunique_parrain]);        
                } */

                // Verification du code parrain 
                /*

                $typeparrain = IndexController::TypeParrain($codeunique_parrain);

                if ($typeparrain == "admin") {
                    // Recuperer id parrain

                    $id_parrain = IndexController::id_mon_parrain($codeunique_parrain);

                    $nbrefilleul = IndexController::NbrefilleulActuel($id_parrain);

                    $etp = DB::table('niveaux')->select('id_etape')->where('id_user', $id_parrain)->orderBy('id_etape', 'DESC')->get()[0]->id_etape;

                    $nbrefilleul_mise_a_jour = $nbrefilleul + 1;

                    DB::table('niveaux')
                        ->where('id_user', $id_parrain)
                         ->where('id_etape', $etp)
                        ->update(['nombredefilleul' => $nbrefilleul_mise_a_jour]);
                }
                else
                {
                    // verification du nombre possible pour le l'etape actuel du parrain dans la table etape

                    $nombrepossible = IndexController::FilleulPossible($etape_actuel);

                    $nbrefilleul = IndexController::NbrefilleulActuel($id_parrain);

                    $etp = DB::table('niveaux')->select('id_etape')->where('id_user', $id_parrain)->orderBy('id_etape', 'DESC')->get()[0]->id_etape;

                    if ($nbrefilleul < $nombrepossible) {
                        $nbrefilleul_mise_a_jour = $nbrefilleul + 1;

                        DB::table('niveaux')
                            ->where('id_user', $id_parrain)
                            ->where('id_etape', $etp)
                            ->update(['nombredefilleul' => $nbrefilleul_mise_a_jour]);    
                    }
                    else
                    {
                        if ($nbrefilleul == $nombrepossible) {
                            
                            // Augmente etape de +1
                            $etape_actuel_mise_a_jour = $etape_actuel + 1;
                            $etape_actuel = $etape_actuel + 1;
                            /*
                            DB::table('niveaux')
                            ->where('id_user', $id_parrain)
                            ->orderBy('id_etape', 'DESC')
                            ->update(['id_etape' => $etape_actuel_mise_a_jour]);
                            */
                            // Une etape valider; une valeur ajouter sur gain en espece

                            // Ajouter gain etape à chaque fois.
                            /*
                            // Recuperer valeur ajouter de l'etape valider
                            $valeurajout = IndexController::ValeurAjouterEtape($etape_actuel);

                            $gainsespece_actuel = IndexController::VirtuelActuel($id_parrain);

                            $gainsespece_actuel_mise_a_jour = $gainsespece_actuel + $valeurajout;
                            DB::table('avoirs')
                                        ->where('id_user', $id_parrain)
                                        ->update(['gainespece' => $gainsespece_actuel_mise_a_jour]); /*   

                            // Bravo!!!!!!!!!!!!!!!!!!!!!!!
                            // Une etape franchise

                            // Mail si possible     

                            // initialiser nombrefilleul a 1
                            $nbrefilleul_mise_a_jour = 1;
                            /*
                            DB::table('niveaux')
                                ->where('id_user', $id_parrain)
                                ->orderBy('id_etape', 'DESC')
                                ->update(['nombredefilleul' => $nbrefilleul_mise_a_jour]);  /*
                        }
                        // En cas de probleme
                    }
                } */

                // Deuxieme etapes a mettre a jour les gains

                // Les pourcentage definir du systeme

                $pourcentageespece = IndexController::PourcentageFilleulEspece();

                $pourcentagevirtuel = IndexController::PourcentageFilleulVirtuel();

                // Calcule de la valeur en %

                $gain_espece = $valeur_payer * ($pourcentageespece / 100);

                $gain_virtuel = $valeur_payer * ($pourcentagevirtuel / 100);

                // alors le parrain beneficie de ces valeurs

                $gainsvirtuel_actuel = IndexController::VirtuelActuel($id_parrain);
        
                $gainsvirtuel_actuel_mise_a_jour = $gainsvirtuel_actuel + $gain_virtuel;
                DB::table('avoirs')
                            ->where('id_user', $id_parrain)
                            ->update(['gainvirtuel' => $gainsvirtuel_actuel_mise_a_jour]);

                // Espece est devenir gain commissionvente
                $gaincommissionvente_actuel = IndexController::VirtuelEspece($id_parrain);
        
                $gaincommissionvente_actuel_mise_a_jour = $gaincommissionvente_actuel + $gain_espece;
                DB::table('avoirs')
                            ->where('id_user', $id_parrain)
                            ->update(['gaincommissionvente' => $gaincommissionvente_actuel_mise_a_jour]);

                /*
                // ajouter gain d'etape pour chaque filleul qui vient

                if ($etape_actuel == 1) {
                    $valeurajout = IndexController::ValeurAjouterEtape($etape_actuel);
                    $possiblefilleul = IndexController::FilleulPossible($etape_actuel);
                    $gainsespece_actuel = IndexController::VirtuelEspece($id_parrain);

                    $gainsespece_actuel_mise_a_jour = $gainsespece_actuel + ($valeurajout / $possiblefilleul);
                    DB::table('avoirs')
                            ->where('id_user', $id_parrain)
                            ->update(['gainespece' => $gainsespece_actuel_mise_a_jour]);
                } */

                // Compte de l'administrateur
                $gainsadmin_actuel = IndexController::AdminCompteRecu();

                $gainsadmin_actuel_mise_a_jour = $gainsadmin_actuel + $valeur_payer;
                DB::table('systemadmins')
                            ->where('Admin', 'oui')
                            ->update(['compteavoirrecu' => $gainsadmin_actuel_mise_a_jour]);

                $niv = Niveau::create([
                    'nombredefilleul' => 0, 
                    'id_user' => $id_user,
                    'id_etape' => 1,
                    'PositionGauche' => "A", 
                    'PositionDroite' => "A",
                    'id_equipe' => IndexController::EquipeParrain($id_pa)
                ]);



                $u = DB::table('users')
                    ->select('nom', 'prenom', 'sexe', 'email', 'codeunique', 'nomuser', 'codeperso', 'parrain')
                    ->where('id', $id_user)
                    ->get();

                    // Mise à jour dans l'arbre

                $codeperso = $u[0]->codeperso;
                $monParrain = $u[0]->parrain;

                //AdminController::newfilleulFile($codeperso, $monParrain);

                // Activer le compte

                DB::table('users')
                        ->where('id', $id_user)
                        ->update(['compteactive' => 'oui']);

                    $nomparrain = IndexController::NomParrain($u[0]->parrain);
                    $destinataire = $u[0]->email;
                
                    $data = [
                        'nom' => $u[0]->nom,
                        'prenom' => $u[0]->prenom,
                        'codeunique' => $u[0]->codeunique,
                        'nomparrain' => $nomparrain,
                        'codeperso' => $u[0]->codeperso,
                        'nomuser' => $u[0]->nomuser
                    ];

                    setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                    date_default_timezone_set('Africa/Porto-Novo');

                    $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
                    $HEURE = date("H:i"); // Heure d'envoi de l'email

                    $Subject = "Compte crée avec succès - $JOUR $HEURE";

                    SendMail::sendmailValidation($destinataire, $Subject, $data);

                   }
                /* End moethode de validation */
            }
            
            $donner = ['nom' => $u[0]->nom, 'prenom' => $u[0]->prenom, 'id' => $u[0]->codeperso, 'nomuser' => $u[0]->nomuser, 'sponsor' => $nomparrain];
            return view('authentification.validerregister', $donner);

        } else {
            flash("Le code saisir est incorrect. Veuillez vérifier")->error();
            //return Back();

            $data = [
                'idres' => $idres
            ];
                        
            // recuperer le premier id
            return view('authentification.approbation', $data);
        }
        
        }
        } else {
            return view('authentification.login');
        }
    }

    public function EquipeParrain($id_pa)
    {
        $codeparrainsystem = DB::table('systemadmins')
                    ->select('codeparrainadmin')
                    ->where('Admin', 'oui')
                    ->get()[0]->codeparrainadmin;

        $etape_pa = DB::table('niveaux')->select('id_etape')->where('id_user', $id_pa)->get()[0]->id_etape;

        if($id_pa == $codeparrainsystem)
            return 1;
        else
            return DB::table('niveaux')->select('id_equipe')
                ->where('id_user', $id_pa)
                ->where('id_etape', $etape_pa)
                ->get()[0]->id_equipe;
    }

    public function getajoutercours()
    {
        return view('admin.upload_cours');   
    }

    public function setajoutercours()
    {
        request()->validate([
            'cours' => ['required', 'mimes:pdf'],
            'cout' => 'required',
            'titre' => 'required',
            'description' => 'required'
        ]);

        $path = request('cours')->store('cours', 'public');

        $image = './img';

        //$b = IndexController::extract($path, './img', 'png');

        // Ensuite, ajoute public comme second paramètre du store
        //$path = request('image')->store('img', 'public');
        // Pour afficher image 
        // <img src="/storage/{{$path}}"> 
        // Pour afficher un lien vers pdf
        // <a href="/storage/{{$path}}"> Name PDF </a> 

        $article = Articlepdf::create([
            'path' => $path,
            'image' => $image,
            'titre' => request('titre'),
            'prix' => request('cout'),
            'description' => request('description')
        ]);

        flash('Ajout avec succès!!!');
        return Back();

    }

    const FORMAT_JPG = 'jpg';
    const FORMAT_PNG = 'png';

    /**
     * @param string $source      source filepath
     * @param string $destination destination filepath
     * @param string $format      destination format
     *
     * @return bool
     */
    public function extract($source, $destination, $format = self::FORMAT_PNG)
    {
        if (!extension_loaded('Imagick')) {
            return false;
        }

        $imagick = new \Imagick($source . '[0]');
        $imagick->setFormat($format);

        return $imagick->writeImage($destination);
    }

    public function verificationCodeUnique($value)
    {
        if (isset(DB::table('users')->select('codeunique')->where('codeunique', $value)->get()[0]->codeunique)) {
            
            return DB::table('users')->select('codeunique')->where('codeunique', $value)->get()[0]->codeunique;
            
        } else {
            return '0';
        }
    }

    public function generercodeunique()
    {
        $code_unique = rand(10000000, 99999999);

        if (IndexController::verificationCodeUnique($code_unique) == 0) {
            return $code_unique;
        }
        else
        {
            IndexController::generercodeunique();
        }
    }

    public function verificationIdUnique($value)
    {
        if (isset(DB::table('users')->select('codeperso')->where('codeperso', $value)->get()[0]->codeperso)) {
            
            return DB::table('users')->select('codeperso')->where('codeperso', $value)->get()[0]->codeperso;
            
        } else {
            return '0';
        }   
    }

    public function genereridunique()
    {
        $id_unique = rand(10000000, 99999999);

        if (IndexController::verificationIdUnique($id_unique) == 0) {
            return $id_unique;
        }
        else
        {
            IndexController::genereridunique();
        }
    }

    public function create()
    {
        //$pdf = app('Fpdf');


        //return view('admins.PDFOM');

        //return PDF::loadFile(public_path().'../resources/views/admins/PDFOM')->save('/path-to/my_stored_file.pdf')->stream('download.pdf');

        //$data = ['title' => 'Welcome to OM'];
        //$pdf = PDF::loadView('admins.PDFOM', $data);
        //$pdf = App::make('dompdf.wrapper');

        //create pdf document
        $pdf = app('Fpdf');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(40,10,'Hello World!');
        $pdf->Output('F', 'test.PDF');
        //save file
        //Storage::put('',$pdf->Output('F', 'tous.pdf'));

        /* Exemple sur site debut */
        /*
        use Illuminate\Support\Facades\Storage;

        //create pdf document
        $pdf = app('Fpdf');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(40,10,'Hello World!');

        //save file
        Storage::put($pdf->Output('S'));
        */
        /* Exemple sur site */



        //$html = "";

        //$pdf->loadHTML($pdf);
        //return $pdf->stream();

        //return $pdf->download('tom.pdf');
    }


    private $request;

    public function getRequest()
    {
        //return IndexController::$request;
        return Session::get('request');
    }

    public function setRequest($value)
    {
        //$this->request = $value;
        Session::put('request', $value);
    }

    public function image(Request $request)
    {

        $p = '<center style=""> <img src="'.$request->root().'/img/logo.jpeg " /> </center> \n';

        IndexController::setRequest($p);
    }
    
    public function sms()
    {
    	IndexController::EnvoieMailConnexion("emmanueldjidagbagba@gmail.com", "", "", "");
    }

    public static function EnvoieMailConnexion($destinataire, $message, $sujet, $objet)
    {
    
    $controle = 0;

    $to = $destinataire; // Mettez l'email de réception
    $from = "ssi@sourcedusuccesinternational.com"; // Adresse email du destinataire de l'envoi

    setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
    date_default_timezone_set('Africa/Porto-Novo');

    $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
    $HEURE = date("H:i"); // Heure d'envoi de l'email

    $Subject = "$sujet - $JOUR $HEURE";
    $mail_Data = "";
    $mail_Data .= " <br>\n";
    $mail_Data .= " <br>\n";
    $mail_Data .= " <br>\n";
    $mail_Data .= " \n";
    $mail_Data .= " <br>\n";
    $mail_Data .= " <center> <h1 style=\"color : #25599C;\"> La Source du Succès International </h1> </center> <br>";
    $mail_Data .= '<center style=""> <img src="http://sourcedusuccesinternational.com/logo.jpeg" style="width: 250px; height: 350px"/> </center>';
    $mail_Data .= "<h2> $objet </h2> ";
    $mail_Data .= " <br>";
    $mail_Data .= " <h3> </h3>  $message ";
    $mail_Data .= " <br>";
    $mail_Data .= " <br> ";
    $mail_Data .= " Si vous n'avez pas une idée du message, veuillez ignorer ou supprimer ce message.  <br>";
    $mail_Data .= " <br>";
    $mail_Data .= " \n";
    $mail_Data .= " \n";
    $headers  = "MIME-Version: 1.0 \n";
    $headers .= "Content-type: text/html; charset=utf-8 \n";
    $headers .= "From: $from  \n";
    $headers .= "Disposition-Notification-To: $from  \n";

   // Message de Priorité haute
   // -------------------------
   $headers .= "X-Priority: 1  \n";
   $headers .= "X-MSMail-Priority: High \n";

   $CR_Mail = TRUE;

   $CR_Mail = @mail($to, $Subject, $mail_Data, $headers);
 
   if ($CR_Mail === FALSE)   
        $controle = 1;
        //echo " ### CR_Mail=$CR_Mail - Erreur envoi mail \n";
   else                      
        $controle = 0;
        //echo " *** CR_Mail=$CR_Mail - Mail envoyé \n";  

    // Controle du success

    //if ($controle != 0) echo "Succes..."; else echo "Echec...";

    }

    public function EnvoieMail($destinataire, $message, $sujet, $objet)
    {

    setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
    date_default_timezone_set('Africa/Porto-Novo');

    $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
    $HEURE = date("H:i"); // Heure d'envoi de l'email

    $Subject = "$sujet - $JOUR $HEURE";

    SendMail::sendmailIndexController($destinataire, $Subject, $message, $objet);

    /*

    $mail_Data = "";
    $mail_Data .= " <br>\n";
    $mail_Data .= " <br>\n";
    $mail_Data .= " <br>\n";
    $mail_Data .= " \n";
    $mail_Data .= " <br>\n";
    $mail_Data .= " <center> <h1 style=\"color : #25599C;\"> La Source du Succès International </h1> </center> <br><br><br>\n";
    $mail_Data .= '<center style=""> <img src="http://sourcedusuccesinternational.com/logo.jpeg" style="width: 250px; height: 350px"/> </center> ';
    $mail_Data .= "<h2> $objet </h2> \n";
    $mail_Data .= " <br>\n";
    $mail_Data .= " <h3> </h3>  $message \n";
    $mail_Data .= " <br>\n";
    $mail_Data .= " <br> \n";
    $mail_Data .= " Si vous ne savez pas l'origine du message, veuillez ignorer ou supprimer ce message.  \n";
    $mail_Data .= " \n";
    $mail_Data .= " \n";
    $mail_Data .= " \n";
    $headers  = "MIME-Version: 1.0 \n";
    $headers .= "Content-type: text/html; charset=utf-8 \n";
    $headers .= "From: $from  \n";
    $headers .= "Disposition-Notification-To: $from  \n";

   // Message de Priorité haute
   // -------------------------
   $headers .= "X-Priority: 1  \n";
   $headers .= "X-MSMail-Priority: High \n";

   $CR_Mail = TRUE;

   $CR_Mail = @mail($to, $Subject, $mail_Data, $headers);
 
   if ($CR_Mail === FALSE)   
        $controle = 1;
        //echo " ### CR_Mail=$CR_Mail - Erreur envoi mail \n";
   else                      
        $controle = 0;
        //echo " *** CR_Mail=$CR_Mail - Mail envoyé \n";  

    // Controle du success

    //if ($controle != 0) echo "Succes..."; else echo "Echec...";
    */
    } 
}
  