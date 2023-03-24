<?php

namespace App\Http\Controllers;

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

class IndexPrimeController extends Controller
{

	public function paiementarticle()
	{
		return "En cours de traitement";
	}

	public function getboutique()
	{
		$cours = DB::table('articlepdfs')->select('id','path', 'titre', 'prix', 'description')->get();

        	$data = ['cours' => $cours];
        
		return view('mlm.boutique', $data);
	}
	
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
			
		$valeuradhesion = request('montant');


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

                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

                //debiter le compte admin
                $recu=$compteadmin + request('montant');

                //update la table
                DB::table('systemadmins')
                        ->where('id_AdminPrincipal', auth()->user()->id)
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);


                $message = "
                	Facture SBEE :  
                	
                	Nom > ".request('nom')." ;
                	Prenom > ".request('prenom')." ;
                	Numéro Police du compteur > ".request('police')." ;
                	Numéro WhatsApp > ".request('numWha')." ;
                	Mail > ".request('mail')." ;
                	Présentation > ".request('presentation')." ;

                	Montant de la facture : ".$valeuradhesion;

				// Enregistrement la demande dans Notificationcontacts
				Notificationcontact::create([
					'Nom' => auth()->user()->nom, 
					'Email' => auth()->user()->email, 
					'Tel' => auth()->user()->tel, 
					'Message' => $message
				]);


                flash($valeuradhesion." $ SSI a été défalquer de votre compte avoirs pour payer votre facture.");

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
			
		$valeuradhesion = request('montant');


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

                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

                //debiter le compte admin
                $recu=$compteadmin + request('montant');

                //update la table
                DB::table('systemadmins')
                        ->where('id_AdminPrincipal', auth()->user()->id)
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);

                $message = "
                	Achat de crédit SBEE :  
                	
                	Nom > ".request('nom')." ;
                	Prenom > ".request('prenom')." ;
                	Police > ".request('police')." ;
                	Numéro WhatsApp > ".request('numWha')." ;
                	Email  > ".request('mail')." ;

                	Montant à créditer : ".$valeuradhesion;

				// Enregistrement la demande dans Notificationcontacts
				Notificationcontact::create([
					'Nom' => auth()->user()->nom, 
					'Email' => auth()->user()->email, 
					'Tel' => auth()->user()->tel, 
					'Message' => $message
				]);


                flash($valeuradhesion."$ SSI a été défalquer de votre compte avoirs pour l'achat sur le compteur à crédit.");

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
			flash("Vous devez être connecté pour effectuée votre achat à partir de vos compte avoirs. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur SBEE")->error();
            return redirect('/connexion');
		}

	}

	public function getmtn()
	{
		return view('admin.mtn');
	}

	public function setmtn(Request $request)
	{
		request()->validate([
            'numero' => 'required|min:0',
            'forfait' => 'required|min:0',
			]);

		$forfait = "";

		switch (request('forfaitlib')) {
			case 1:
				$forfait = "Crédit";
				break;
			case 2:
				$forfait = "Forfait Appel";
				break;
			case 3:
				$forfait = "Forfait Appel + Internet";
				break;
			case 4:
				$forfait = "Forfait Internet";
				break;

			default:
				$forfait = "inconnue";
				break;
		}



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

                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

                //debiter le compte admin
                $recu=$compteadmin + request('montant');

                //update la table
                DB::table('systemadmins')
                        ->where('id_AdminPrincipal', auth()->user()->id)
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);

                $message = "
                	MTN / MOOV :  
                	
                	Libelle > ".$forfait." ;
                	Montant > ".request('forfait')." ;
                	Numero > ".request('numero')." ;
                ";

				// Enregistrement la demande dans Notificationcontacts
				Notificationcontact::create([
					'Nom' => auth()->user()->nom, 
					'Email' => auth()->user()->email, 
					'Tel' => auth()->user()->tel, 
					'Message' => $message
				]);


                flash("Vous recevez un message de confirmation dans un instant.");

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
			flash("Vous devez être connecté pour effectuée l'achat et payer les frais à partir de vos compte avoirs. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur MTN ou MOOV")->error();
            return redirect('/connexion');
		}

	}

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

		$valeuradhesion = request('montant');


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

                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

                //debiter le compte admin
                $recu=$compteadmin + request('montant');

                //update la table
                DB::table('systemadmins')
                        ->where('id_AdminPrincipal', auth()->user()->id)
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);

                $message = "
                	Facture SONEB :  
                	
                	Nom > ".request('nom')." ;
                	Prenom > ".request('prenom')." ;
                	Numéro Police du compteur > ".request('police')." ;
                	Numéro WhatsApp > ".request('numWha')." ;
                	Mail > ".request('mail')." ;
                	Présentation > ".request('presentation')." ;

                	Montant de la SONEB : ".$valeuradhesion;

				// Enregistrement la demande dans Notificationcontacts
				Notificationcontact::create([
					'Nom' => auth()->user()->nom, 
					'Email' => auth()->user()->email, 
					'Tel' => auth()->user()->tel, 
					'Message' => $message
				]);


                flash("Le montant auquel s'élève votre facture sera prélever de votre compte avoir.");

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

	public function setcanaplus(Request $request)
	{
		request()->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'num' => 'required|min:0',
            'formule' => 'required|string',
            'mois' => 'required',
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

                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

                //debiter le compte admin
                $recu=$compteadmin + $valeurabonnementmois;

                //update la table
                DB::table('systemadmins')
                        ->where('id_AdminPrincipal', auth()->user()->id)
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);

                $message = "
                	Inscription pour Canal + :  
                	
                	Nom > ".request('nom')." ;
                	Prenom > ".request('prenom')." ;
                	Numéro abonner > ".request('num')." ;
                	Formule > ".$formule." ;
                	Mois > ".$mois." ;

                	Valeur abonnement défalquer ".$valeurabonnementmois." $ SSI payer avec succès

                ";

                
				// Enregistrement la demande dans Notificationcontacts
				Notificationcontact::create([
					'Nom' => auth()->user()->nom, 
					'Email' => auth()->user()->email, 
					'Tel' => auth()->user()->tel, 
					'Message' => $message
				]);

				flash($valeurabonnementmois." $ SSI est débiter de votre compte en virtuel pour l'abonnement canal + avec succès.");

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

	public function getcanalplus()
	{
		return view('admin.canalplus');
	}

	public function getlongrichform()
	{
		$pays = DB::table('pays')
            ->select('libelle')
            ->get();
        $data = ['pays' => $pays];
		return view('admin.longrichform', $data);
	}

	public function gethealthform()
	{
		$pays = DB::table('pays')
            ->select('libelle')
            ->get();
        $data = ['pays' => $pays];
		return view('admin.healthform', $data);
	}

	public function setlongrichform(Request $request)
	{
		request()->validate([
            'pseudo' => 'required|string',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'nais' => 'required|date',
            'pays' => 'required|string',
            'tel' => 'required', 
			'mail' => 'required|email',
			]);

		$valeuradhesion = 50;

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

                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

                //debiter le compte admin
                $recu=$compteadmin + request('montant');

                //update la table
                DB::table('systemadmins')
                        ->where('id_AdminPrincipal', auth()->user()->id)
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);

                $message = "
                	Inscription pour Longrich :  
                	
                	Pseudo > ".request('pseudo')." ;
                	Nom > ".request('nom')." ;
                	Prenom > ".request('prenom')." ;
                	Naissance > ".request('nais')." ;
                	Pays > ".request('pays')." ;
                	tel > ".request('tel')." ;
                	Email > ".request('mail')." ;

                	Coût d'adhésion 50 $ SSI payer avec succès

                ";

				// Enregistrement la demande dans Notificationcontacts
				Notificationcontact::create([
					'Nom' => auth()->user()->nom, 
					'Email' => auth()->user()->email, 
					'Tel' => auth()->user()->tel, 
					'Message' => $message
				]);


                flash("50 $ SSI est débiter de votre compte en virtuel pour l'inscription sur Longrich avec succès.");

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
			flash("Vous devez être connecté pour vous inscrire à Longrich et payer le coût d'adhésion à partir de vos compte avoirs. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur Longrich")->error();
            return redirect('/connexion');
		}

	}

	public function callUrl($url){
			$cmi = curl_multi_init();
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_multi_add_handle($cmi, $curl);
			
			do {
				curl_multi_exec($cmi, $running);
				//on attends quelques micro secondes puis on break la boucle.
				//comme ça on arrive a appeler l'url sans attendre la réponse  
				usleep(1000);
				break;
			} while ($running > 0);
			
			curl_multi_remove_handle($cmi, $curl);
			curl_multi_close($cmi);
		}


	public function del_injections_string($str) {
		if (get_magic_quotes_gpc()) {
			$val = mysqli_real_escape_string(stripslashes($str));	 
		} else {
			$val = mysqli_real_escape_string($str);	
		} 
		return $val;

		//mysql_real_escape_string
	}

	public function sethealthform(Request $request)
	{
		request()->validate([
            'pseudo' => 'required|string',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'nais' => 'required|date',
            'pays' => 'required|string',
            'tel' => 'required', 
			'mail' => 'required|email',
			]);

		$valeuradhesion = 50;

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

                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

                //debiter le compte admin
                $recu=$compteadmin + request('montant');

                //update la table
                DB::table('systemadmins')
                        ->where('id_AdminPrincipal', auth()->user()->id)
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);

                $message = "
                	Inscription pour Health :  
                	
                	Pseudo > ".request('pseudo')." ;
                	Nom > ".request('nom')." ;
                	Prenom > ".request('prenom')." ;
                	Naissance > ".request('nais')." ;
                	Pays > ".request('pays')." ;
                	tel > ".request('tel')." ;
                	Email > ".request('mail')." ;

                	Coût d'adhésion 10 $ SSI payer avec succès

                ";

				// Enregistrement la demande dans Notificationcontacts
				Notificationcontact::create([
					'Nom' => auth()->user()->nom, 
					'Email' => auth()->user()->email, 
					'Tel' => auth()->user()->tel, 
					'Message' => $message
				]);

                flash("10 $ SSI est débiter de votre compte en virtuel pour l'inscription sur Health avec succès.");

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
			flash("Vous devez être connecté pour vous inscrire à Health et payer le coût d'adhésion à partir de vos compte avoirs. Si vous ne possédez pas de compte, inscrivez-vous et revenez sur Health")->error();
            return redirect('/connexion');
		}
	}

	public function genecodeadminvirtuel()
    {
        // mail
        $otp = rand(100000, 999999);

        $message = "Code OTP Générer : ".$otp;

        $destinataire = auth()->user()->email;

        IndexPrimeController::EnvoieMail($destinataire, $message, "Accès", "");
        flash('Code OTP renvoyé sur votre boite mail !!!');
        $data = ['otp' => $otp];
        return view('admin.transfertgainvirtuel', $data);
    }

    public function genecodeadmincv()
    {
        // mail
        $otp = rand(100000, 999999);

        $message = "Code OTP Générer : ".$otp;

        $destinataire = auth()->user()->email;

        IndexPrimeController::EnvoieMail($destinataire, $message, "Accès", "");
        flash('Code OTP renvoyé sur votre boite mail !!!');
        $data = ['otp' => $otp];
        return view('admin.transfertcommissionvente', $data);
    }

	public function gettransfertgainvirtuel()
	{
		$otp = rand(100000, 999999);

        $message = "Code OTP Générer : ".$otp;

        $destinataire = auth()->user()->email;

        IndexPrimeController::EnvoieMail($destinataire, $message, "Accès", "");
        flash('Veuillez entrer le code OTP envoyé sur votre boite mail pour valider !!!');
        $data = ['otp' => $otp];
        return view('admin.transfertgainvirtuel', $data);
	}

	public function settransfertgainvirtuel(Request $request)
	{
		request()->validate([
            'id' => 'required',
            'montant' => 'required|min:0',
            'otp' => 'required' ]);

        //dd(request());
        
        
        if (request('otprecu') == "OTP")
        {
            flash("Veuillez générer OTP et saisir l'OTP envoyé par sur votre mail.")->error();
            return Back();
        }
        else
        {
			
        // Verifier l'existance de id
        if (isset(DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso)) {
            
            // verifie l'autorisation par otp

            if (request('otprecu') != request('otp')) {
                flash("L'autorisation par OTP incorrect! Veuillez verifier l'OTP envoyé par sur votre mail ou réeassayer.")->error();
                return Back();
            }
            else{
                
                // Alors update compte destinataire : incrementer
                $iddest = DB::table('users')->where('codeperso', request('id'))->get()[0]->id;
                $soldeactuel = DB::table('avoirs')->where('id_user', $iddest)->get()[0]->gainvirtuel;
                $soldeac = $soldeactuel + request('montant');
                DB::table('avoirs')
                    ->where('id_user', $iddest)
                    ->update([
                    'gainvirtuel' => $soldeac
                    ]);

                // Mettre a jour le compte admin
                $soldeactue = DB::table('systemadmins')->where('id_AdminPrincipal', auth()->user()->id)->get()[0]->compteavoirsortant;
                $soldea = $soldeactue + request('montant');
                DB::table('systemadmins')
                    ->where('id_AdminPrincipal', auth()->user()->id)
                    ->update([
                    'compteavoirsortant' => $soldea
                    ]);


                flash("Transfert éffectuer avec succès");

                $data = ['otp' => request('otprecu')];
                return view('admin.transfertcommissionvente', $data);
                //return Back();
            }
        } else {
            flash("L'identifiant n'existe pas");
            return Back();
        }
        }
	}

	public function getprelevementgainvirtuel()
	{
		return view('admin.prelevementcomptevirtuel'); 
	}

	public function setprelevementgainvirtuel(Request $request)
	{
		request()->validate([
            'id' => 'required',
            'montant' => 'required|min:0' ]);

        // Verifier si cest bien l'admin qui est connecté

        if(isset(DB::table('systemadmins')->where('id_AdminPrincipal', auth()->user()->id)->get()[0]->id_AdminPrincipal)){
            $idprel=DB::table('users')->where('codeperso', request('id'))->get()[0]->id;
            // recupérer gain user actuel
            $soldeactuel=DB::table('avoirs')->where('id_user', $idprel)->get()[0]->gainvirtuel;

            //verifier si son solde peut etre créditer
            if ($soldeactuel >= request('montant')) {
                
                // prelever de son compte

                $solde=$soldeactuel - request('montant');
                DB::table('avoirs')->where('id_user', $idprel)->update(['gainvirtuel'=>$solde]);

                //recuperer compte admin
                $soldeadmin = DB::table('systemadmins')->where('id_AdminPrincipal', auth()->user()->id)->get()[0]->compteavoirrecu;

                //debiter le compte admin
                $recu=$soldeadmin + request('montant');

                //update la table
                DB::table('systemadmins')
                        ->where('id_AdminPrincipal', auth()->user()->id)
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);
                        $nom = DB::table('users')->where('codeperso', request('id'))->get()[0]->nom;
                        $prenom = DB::table('users')->where('codeperso', request('id'))->get()[0]->prenom;
                        flash("Opération effectuée avec succès. Vous avez prélever ".request('montant')." $ SSI du compte gain virtuel dont l'identifiant est ".request('id')." du ".$prenom." ".$nom."");
                        return Back();               
            } else {
                flash("Le solde du client est insuffisant pour cette opération")->error();
                return Back();
            }

        }else{
            flash("Vous n'êtes pas connecter")->error();
            return Back();
        }
	}


	public function gettransfertadmincommissionvente()
    {
                // mail
        $otp = rand(100000, 999999);

        $message = "Code OTP Générer : ".$otp;

        $destinataire = auth()->user()->email;

        IndexPrimeController::EnvoieMail($destinataire, $message, "Accès", "");
        flash('Veuillez entrer le code OTP envoyé sur votre boite mail pour valider !!!');
        $data = ['otp' => $otp];
        return view('admin.transfertcommissionvente', $data);
    }

    public function settransfertadmincommissionvente(Request $request)
    {
        
        request()->validate([
            'id' => 'required',
            'montant' => 'required|min:0',
            'otp' => 'required' ]);

        //dd(request());
       //dd(request('montant'));
        
        if (request('otprecu') == "OTP")
        {
            flash("Veuillez générer OTP et saisir l'OTP envoyé par sur votre mail.")->error();
            return Back();
        }
        else
        {
			
        // Verifier l'existance de id
        if (isset(DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso)) {
            
            // verifie l'autorisation par otp

            if (request('otprecu') != request('otp')) {
                flash("L'autorisation par OTP incorrect! Veuillez verifier l'OTP envoyé par sur votre mail ou réeassayer.")->error();
                return Back();
            }
            else{
                
                // Alors update compte destinataire : incrementer
                $iddest = DB::table('users')->where('codeperso', request('id'))->get()[0]->id;
                $soldeactuel = DB::table('avoirs')->where('id_user', $iddest)->get()[0]->gaincommissionvente;
                $soldeac = $soldeactuel + request('montant');
                DB::table('avoirs')
                    ->where('id_user', $iddest)
                    ->update([
                    'gaincommissionvente' => $soldeac
                    ]);

                // Mettre a jour le compte admin
                $soldeactue = DB::table('systemadmins')->where('id_AdminPrincipal', auth()->user()->id)->get()[0]->compteavoirsortant;
                $soldea = $soldeactue + request('montant');
                DB::table('systemadmins')
                    ->where('id_AdminPrincipal', auth()->user()->id)
                    ->update([
                    'compteavoirsortant' => $soldea
                    ]);


                flash("Transfert éffectuer avec succès");

                $data = ['otp' => request('otprecu')];
                return view('admin.transfertcommissionvente', $data);
                //return Back();
            }
        } else {
            flash("L'identifiant n'existe pas");
            return Back();
        }
        }
        
    }
    
    // prelement sur commission vente
    public function getprelevementcommissionvente()
    {
        return view('admin.prelevementcommissionvente'); 
    }

    public function setprelevementcommissionvente(Request $request)
    {
        request()->validate([
            'id' => 'required',
            'montant' => 'required|min:0' ]);

        // Verifier si cest bien l'admin qui est connecté

        if(isset(DB::table('systemadmins')->where('id_AdminPrincipal', auth()->user()->id)->get()[0]->id_AdminPrincipal)){
            $idprel=DB::table('users')->where('codeperso', request('id'))->get()[0]->id;
            // recupérer gain user actuel
            $soldeactuel=DB::table('avoirs')->where('id_user', $idprel)->get()[0]->gaincommissionvente;

            //verifier si son solde peut etre créditer
            if ($soldeactuel >= request('montant')) {
                
                // prelever de son compte

                $solde=$soldeactuel - request('montant');
                DB::table('avoirs')->where('id_user', $idprel)->update(['gaincommissionvente'=>$solde]);

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
                        flash("Opération effectuée avec succès. Vous avez prélever ".request('montant')." $ SSI du compte commission sur vente dont l'identifiant est ".request('id')." du ".$prenom." ".$nom."");
                        return Back();               
            } else {
                flash("Le solde du client est insuffisant pour cette opération")->error();
                return Back();
            }

        }else{
            flash("Vous n'êtes pas connecter")->error();
            return Back();
        }
        
    }

    public function EnvoieMail($destinataire, $message, $sujet, $objet)
    {
        $controle = 0;

    $to = $destinataire; // Mettez l'email de réception
    $from = "ssi@sourcedusuccesinternational.com"; // Adresse email du destinataire de l'envoi

    $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
    $HEURE = date("H:i"); // Heure d'envoi de l'email

    $Subject = "$sujet - $JOUR $HEURE";
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

    }

}