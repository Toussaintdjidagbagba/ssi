<?php

namespace App\Http\Controllers;

use App\HistoriqueClient;
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
			
		$valeuradhesionm = request('montant');

		$fraisajouter = IndexPrimeController::fraisssinouvelle($valeuradhesionm);

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

                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

              /*  // Commission sur vente pour client
	            $comv = $fraisajouter * 45 / 100;

	            $soldeactuel_comv = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gaincommissionvente;
	            $soldeac_comv = $soldeactuel_comv + $comv;
	            DB::table('avoirs')
	                ->where('id_user', auth()->user()->id)
	                ->update([
	                  'gaincommissionvente' => $soldeac_comv
	                ]);

                
	            // Commission sur vente pour admin
	            $comv_admin = $fraisajouter * 55 / 100;*/
	            //debiter le compte admin
                $recu=$compteadmin + $valeuradhesionm ;

                //update la table
                DB::table('systemadmins')
                        ->where('id_AdminPrincipal', 1)
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);

                $refid = IndexPrimeController::genref('sbeeconventiels');

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

		$fraisajouter = IndexPrimeController::fraisssinouvelle($valeuradhesionm);

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

                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

              /*  // Commission sur vente pour client
	            $comv = $fraisajouter * 45 / 100;

	            $soldeactuel_comv = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gaincommissionvente;
	            $soldeac_comv = $soldeactuel_comv + $comv;
	            DB::table('avoirs')
	                ->where('id_user', auth()->user()->id)
	                ->update([
	                  'gaincommissionvente' => $soldeac_comv
	                ]);

                
	            // Commission sur vente pour admin
	            $comv_admin = $fraisajouter * 55 / 100;
	            //debiter le compte admin*/
                $recu=$compteadmin + $valeuradhesionm ;

                //update la table
                DB::table('systemadmins')
                        ->where('id_AdminPrincipal', 1)
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);


                $refid = IndexPrimeController::genref('sbeecartes');

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
                        ->where('id_AdminPrincipal', 1)
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


                flash("Vous ".auth()->user()->nom." (".auth()->user()->email.") avez payé ".$valeuradhesion." $ SSI pour ".$forfait." sur le numéro ".request('numero').".");

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

		$valeuradhesionm = request('montant');

		$fraisajouter = IndexPrimeController::fraisssinouvelle($valeuradhesionm);

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

                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

              /*  // Commission sur vente pour client
	            $comv = $fraisajouter * 45 / 100;

	            $soldeactuel_comv = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gaincommissionvente;
	            $soldeac_comv = $soldeactuel_comv + $comv;
	            DB::table('avoirs')
	                ->where('id_user', auth()->user()->id)
	                ->update([
	                  'gaincommissionvente' => $soldeac_comv
	                ]);

                
	            // Commission sur vente pour admin
	            $comv_admin = $fraisajouter * 55 / 100; */
	            //debiter le compte admin 
                $recu=$compteadmin + $valeuradhesionm;

                //update la table
                DB::table('systemadmins')
                        ->where('id_AdminPrincipal', 1)
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);

                $refid = IndexPrimeController::genref('sonebs');

                
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
                flash("
                	Vous ".auth()->user()->nom." (".auth()->user()->email.") avez payer ".$valeuradhesion." $ SSI pour solder la facture de la SONEB. <br>
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

    
    ///////////////////////////////Longrich/////////////////////////////
    
    public function getlongrichrecu()
    {

        $demandes = DB::table('longriches')->where('RefRecu', request('refrecu'))->get()[0];

        $data = ['demande' => $demandes];
        return view('formrecu.formereculongrich', $data);

    }

    public function getlongrichservice()
    {
        $de = DB::table('longriches')->orderBy('RefRecu', 'DESC')->get();
        $data = ['demandes' => $de];
        return view('services.DemandeLongrich', $data);
    }

    public function setlongrichrecu(Request $request)
    {

        request()->validate([
            'lien' => 'required|string',
            'pass' => 'required|string',
            ]);

        setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');

        // Mise à jour dans la base de donnee
        DB::table('longriches')
                    ->where('RefRecu', request('refrecu'))
                    ->update([
                    'daterecu' => strftime('%A %d %B %Y à %H:%M'),
                    'modereglement' => request('modereglement'),
                    'libelle' => request('libelle'),
                    'lien' => request('lien'),
                    'pass' => request('pass'),
                    'Statut' => 'oui'
                    ]);

        $destinataire = request('mail');

        $sujet = "FACTURE SSI";

        $objet = "SSI : Facture ".request('libelle');

        // Envoie de recu
        IndexPrimeController::EnvoieRecuLONGRICH(
            $destinataire, 
            $sujet, 
            $objet,
            request('nom'),
            request('prenom'),
            request('CodePersoUser'),
            request('refrecu'),
            request('lien'),
            request('pass'),
            request('tel'),
            request('montant'),
            request('mail'),
            strftime('%A %d %B %Y à %H:%M'),
            request('modereglement'),
            request('libelle'),
            request('dateL'),
            request('pays'),
            request('pseudo')
        );

        flash('Recu envoyer avec succès!!!');

        return Back();

    }

    //////////////////////////////////////////////////////////////////////


    ///////////////////////////////Health/////////////////////////////

    
    public function gethealthrecu()
    {

        $demandes = DB::table('healths')->where('RefRecu', request('refrecu'))->get()[0];

        $data = ['demande' => $demandes];
        return view('formrecu.formerecuhealth', $data);

    }

    public function gethealthservice()
    {
        $de = DB::table('healths')->orderBy('RefRecu', 'DESC')->get();
        $data = ['demandes' => $de];
        return view('services.DemandeHealth', $data);
    }

    public function sethealthrecu(Request $request)
    {

        request()->validate([
            'lien' => 'required|string',
            'pass' => 'required|string',
            ]);

        setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');
        
        //$mont = $d->Montant - $d->FraisSSI;

        // Mise à jour dans la base de donnee
        DB::table('healths')
                    ->where('RefRecu', request('refrecu'))
                    ->update([
                    'daterecu' => strftime('%A %d %B %Y à %H:%M'),
                    'modereglement' => request('modereglement'),
                    'libelle' => request('libelle'),
                    'lien' => request('lien'),
                    'pass' => request('pass'),
                    'Statut' => 'oui'
                    ]);

        $destinataire = request('mail');

        $sujet = "FACTURE SSI";

        $objet = "SSI : Facture ".request('libelle');

        // Envoie de recu
        IndexPrimeController::EnvoieRecuHealth(
            $destinataire, 
            $sujet, 
            $objet,
            request('nom'),
            request('prenom'),
            request('CodePersoUser'),
            request('refrecu'),
            request('lien'),
            request('pass'),
            request('tel'),
            request('montant'),
            request('mail'),
            strftime('%A %d %B %Y à %H:%M'),
            request('modereglement'),
            request('libelle'),
            request('dateL'),
            request('pays'),
            request('pseudo')
        );
        
        flash('Recu envoyer avec succès!!!');

        return Back();

    }

    //////////////////////////////////////////////////////////////////////


    ///////////////////////////////MTN MOOV/////////////////////////////

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
        // Commission sur vente
        if($d->libelle == "Crédit P3")
            $comv = $d->MontantPayer * 0.4 / 100;
        else
            if($d->type == "depot")
                //$comv = $d->MontantPayer * 0.2 / 100;
                $comv = 0;
            else
	            $comv = $d->MontantPayer * 2 / 100;

	                $soldeactuel_comv = DB::table('avoirs')->where('id_user', $d->IdUser)->get()[0]->gaincommissionvente;
	                $soldeac_comv = $soldeactuel_comv + $comv;
	                DB::table('avoirs')
	                    ->where('id_user', $d->IdUser)
	                    ->update([
	                    'gaincommissionvente' => $soldeac_comv
	                    ]);
	                    
	   //dd($comv);
	                    
	   $message_reception = "Votre demande d'achat de forfait MTN/MOOV dont le montant est ".$d->MontantPayer." $ SSI est validé ";
        HistoriqueClient::saveHistorique($message_reception, $d->IdUser);
	                    
        return Back();
    }
    
    ////////////////////////////////////////////////////////////



	///////////////////////////////////SBEE CARTE///////////////////////

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
                    
        // Commission sur vente pour client
	            $comv = $d->FraisSSI * 45 / 100;

	            $soldeactuel_comv = DB::table('avoirs')->where('id_user', $d->IdUser)->get()[0]->gaincommissionvente;
	            $soldeac_comv = $soldeactuel_comv + $comv;
	            DB::table('avoirs')
	                ->where('id_user', $d->IdUser)
	                ->update([
	                  'gaincommissionvente' => $soldeac_comv
	                ]);

                // Débiter le compte de admin des 45% sortant
	            $comv_admin = $d->FraisSSI * 45 / 100;
	           $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirsortant;
	           $recu=$compteadmin + $comv_admin;

                //update la table
                DB::table('systemadmins')
                        ->where('id_AdminPrincipal', 1)
                        ->update([
                        'compteavoirsortant' => $recu
                        ]);     
                    

        $destinataire = request('mail');

        $sujet = "FACTURE SSI";

        $objet = "SSI : Facture ".request('libelle');

        // Envoie de recu
        IndexPrimeController::EnvoieRecuCREDITSBEE(
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
	////////////////////////////////////////////////////////////

	///////////////////////////////SBEE conventionnel/////////////////////////////
	public function getsbeeconventionnelrecu()
	{
	    $demandes = DB::table('sbeeconventiels')->where('RefRecu', request('refrecu'))->get()[0];

		$data = ['demande' => $demandes];
		return view('formrecu.formrecusbeeconventionnel', $data);

		//return view('mail.recusoneb');
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


        // Commission sur vente pour client
	            $comv = $d->FraisSSI * 45 / 100;

	            $soldeactuel_comv = DB::table('avoirs')->where('id_user', $d->IdUser)->get()[0]->gaincommissionvente;
	            $soldeac_comv = $soldeactuel_comv + $comv;
	            DB::table('avoirs')
	                ->where('id_user', $d->IdUser)
	                ->update([
	                  'gaincommissionvente' => $soldeac_comv
	                ]);

                // Débiter le compte de admin des 45% sortant
	            $comv_admin = $d->FraisSSI * 45 / 100;
	           $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirsortant;
	           $recu=$compteadmin + $comv_admin;

                //update la table
                DB::table('systemadmins')
                        ->where('id_AdminPrincipal', 1)
                        ->update([
                        'compteavoirsortant' => $recu
                        ]); 



        $destinataire = request('mail');

        $sujet = "FACTURE SSI";

        $objet = "SSI : Facture ".request('libelle');

        // Envoie de recu
        IndexPrimeController::EnvoieRecuSBEE(
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

	////////////////////////////////////////////////////

	///////////////////////////////SONEB/////////////////////////////
	
	public function getsonebrecu()
	{
	    $demandes = DB::table('sonebs')->where('RefRecu', request('refrecu'))->get()[0];

		$data = ['demande' => $demandes];
		return view('formrecu.formrecusoneb', $data);

		//return view('mail.recusoneb');
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
	            $comv = $d->FraisSSI * 45 / 100;

	            $soldeactuel_comv = DB::table('avoirs')->where('id_user', $d->IdUser)->get()[0]->gaincommissionvente;
	            $soldeac_comv = $soldeactuel_comv + $comv;
	            DB::table('avoirs')
	                ->where('id_user', $d->IdUser)
	                ->update([
	                  'gaincommissionvente' => $soldeac_comv
	                ]); 

                
	            // Débiter le compte de admin des 45% sortant
	            $comv_admin = $d->FraisSSI * 45 / 100;
	           $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirsortant;
	           $recu=$compteadmin + $comv_admin;

                //update la table
                DB::table('systemadmins')
                        ->where('id_AdminPrincipal', 1)
                        ->update([
                        'compteavoirsortant' => $recu
                        ]); 

        $destinataire = request('mail');

        $sujet = "FACTURE SSI";

        $objet = "SSI : Facture ".request('libelle');

        // Envoie de recu
        IndexPrimeController::EnvoieRecu(
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

	////////////////////////////////////////////////////////////
	

	///////////////////////////////CANAL PLUS/////////////////////////////
	
	public function getcanalrecu()
	{

	    $demandes = DB::table('canals')->where('RefRecu', request('refrecu'))->get()[0];

		$data = ['demande' => $demandes];
		return view('formrecu.formrecucanal', $data);

		//return view('mail.recusoneb');
	}

	public function setcanalrecu(Request $request)
	{

		if(isset(DB::table('canals')->where('RefRecu', request('refrecu'))->where('Statut', 'oui')->get()[0]))
            {flash('Recu déjà envoyer.');

        	return Back();}
        else{

		request()->validate([
            'reglement' => 'required|string',
            'dateespire' => 'required|date',
            ]);

		setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        date_default_timezone_set('Africa/Porto-Novo');
        
        $d = DB::table('canals')->where('RefRecu', request('refrecu'))->get()[0];

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

        
        // Commission sur vente
                $comv = request('montant') * 2 / 100;

                $soldeactuel_comv = DB::table('avoirs')->where('id_user', $d->IdUser)->get()[0]->gaincommissionvente;
                $soldeac_comv = $soldeactuel_comv + $comv;
                DB::table('avoirs')
                    ->where('id_user', $d->IdUser)
                    ->update([
                    'gaincommissionvente' => $soldeac_comv
                    ]);
        
        $destinataire = request('mail');

        $sujet = "FACTURE SSI";

        $objet = "SSI : Facture ".request('libelle');

        // Envoie de recu
        IndexPrimeController::EnvoieRecuCANAL(
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
		//return view('mail.recusoneb', $data);
	}

	public function getcanalservice()
	{
		$de = DB::table('canals')->where('Statut', '!=', 'sup')->orderBy('RefRecu', 'DESC')->get();
		$data = ['demandes' => $de];
		return view('services.DemandeCanal', $data);
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


	////////////////////////////////////////////////////////////
	


	public function genref($nametable)
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
		    $serie = IndexPrimeController::chaine($bond, $i, $newnombre);
		    return $serie;
		}
	}

	public function chaine($bond, $a, $newnombre)
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

                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;

                //debiter le compte admin
                $recu=$compteadmin + $valeurabonnementmois;

                //update la table
                DB::table('systemadmins')
                        ->where('id_AdminPrincipal', 1)
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);


                $refid = IndexPrimeController::genref('canals');

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
                        ->where('id_AdminPrincipal', 1)
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);

                setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                date_default_timezone_set('Africa/Porto-Novo');

                $refid = IndexPrimeController::genref('longriches');

                Longrich::create([
                    'IdUser' => auth()->user()->id, 
                    'NomUser' => auth()->user()->nom, 
                    'EmailUser' => auth()->user()->email, 
                    'TelUser' => auth()->user()->nom, 
                    'CodePersoUser' => auth()->user()->codeperso, 
                    'Nom' => request('nom'), 
                    'Prenom' => request('prenom'), 
                    'Email' => request('mail'), 
                    'Tel' => request('tel'), 
                    'pseudo' => request('pseudo'), 
                    'pays' => request('pays'), 
                    'dateL' => request('nais'), 
                    'MontantPayer' => $valeuradhesion, 


                    'RefRecu' => $refid, 
                    'date' => strftime('%A %d %B %Y à %H:%M')
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

		$valeuradhesion = 10;

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
                        ->where('id_AdminPrincipal', 1)
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);
                        
                setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                date_default_timezone_set('Africa/Porto-Novo');

                $refid = IndexPrimeController::genref('healths');

                Health::create([
                    'IdUser' => auth()->user()->id, 
                    'NomUser' => auth()->user()->nom, 
                    'EmailUser' => auth()->user()->email, 
                    'TelUser' => auth()->user()->nom, 
                    'CodePersoUser' => auth()->user()->codeperso, 
                    'Nom' => request('nom'), 
                    'Prenom' => request('prenom'), 
                    'Email' => request('mail'), 
                    'Tel' => request('tel'), 
                    'pseudo' => request('pseudo'), 
                    'pays' => request('pays'), 
                    'dateH' => request('nais'), 
                    'MontantPayer' => $valeuradhesion,
                    'RefRecu' => $refid, 
                    'date' => strftime('%A %d %B %Y à %H:%M')
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
                
                $message = "Vous avez transférer ".request('montant')." $ SSI à ". 
                    DB::table('users')->where('codeperso', 
                        request('id'))->get()[0]->prenom . " " . 
                    DB::table('users')->where('codeperso', 
                    request('id'))->get()[0]->nom." dont l'identifiant est : ".
                    DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso.". Transfert éffectuer avec succès.";
                Historique::saveHistorique( "E", $message, auth()->user()->id );
                $message_reception = "Vous avez reçu ".request('montant')." $ SSI ";
                HistoriqueClient::saveHistorique($message_reception, $iddest);
                flash($message);

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
                        $mg = "Opération effectuée avec succès. Vous avez prélever ".request('montant')." $ SSI du compte gain virtuel dont l'identifiant est ".request('id')." du ".$prenom." ".$nom;
                        Historique::saveHistorique("F", $mg, auth()->user()->id );
                        $message_reception = "Il vous a été prélevé ".request('montant')." $ SSI ";
                        HistoriqueClient::saveHistorique($message_reception, $idprel);
                        flash("Opération effectuée avec succès. Vous avez prélever ".request('montant')." $ SSI du compte gain virtuel dont l'identifiant est ".request('id')." du ".$prenom." ".$nom."");
                        return Back();               
            } else {
                Historique::saveHistorique("F", "Le solde du client est insuffisant pour cette opération", auth()->user()->id );
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


                $message = "Vous avez transférer ".request('montant')." $ SSI à ". DB::table('users')->where('codeperso', request('id'))->get()[0]->prenom . " " . DB::table('users')->where('codeperso', request('id'))->get()[0]->nom." dont l'identifiant est : ".DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso.". Transfert éffectuer avec succès.";
                Historique::saveHistorique( "C", $message, auth()->user()->id );
                $message_reception = "Vous avez reçu ".request('montant')." $ SSI ";
                HistoriqueClient::saveHistorique($message_reception, $iddest);
                flash($message);
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
                        
                        $m = "Opération effectuée avec succès. Vous avez prélever ".request('montant')." $ SSI du compte commission sur vente dont l'identifiant est ".request('id')." du ".$prenom." ".$nom;
                        Historique::saveHistorique("D", $m, auth()->user()->id );
                        $message_reception = "Il vous a été prélevé ".request('montant')." $ SSI ";
                        HistoriqueClient::saveHistorique($message_reception, $idprel);
                        flash("Opération effectuée avec succès. Vous avez prélever ".request('montant')." $ SSI du compte commission sur vente dont l'identifiant est ".request('id')." du ".$prenom." ".$nom."");
                        return Back();               
            } else {
                Historique::saveHistorique("D", "Le solde du client est insuffisant pour cette opération", auth()->user()->id );
                flash("Le solde du client est insuffisant pour cette opération")->error();
                return Back();
            }

        }else{
            flash("Vous n'êtes pas connecter")->error();
            return Back();
        }
        
    }
    
    public function fraisssinouvelle($value)
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

    public function fraisssi($value)
    {
    	// 5 000 f = 10 $ SSI
    	// 20 000 f = 40 $ SSI
    	// 50 000 f = 100 $ SSI
    	// 75 000 f = 150 $ SSI
    	// 100 000 f = 200 $ SSI
    	// 200 000 f = 400 $ SSI 
    	// 300 000 f = 600 $ SSI
    	// 500 000 f = 1 000 $ SSI
    	// 750 000 f = 1 500 $ SSI
    	// 1 000 000 f = 2 000 $ SSI
    	// 1 500 000 f = 3 000 $ SSI
    	// 2 000 000 f = 4 000 $ SSI

    	$valeurssi = 500;

    	if($value < (5001 / $valeurssi))
    		return (200 / $valeurssi);
    	else
    		if($value < (20001 / $valeurssi))
    			return (400 / $valeurssi);
    		else
    			if($value < (50001 / $valeurssi))
    				return (700 / $valeurssi);
    			else
    				if($value < (75001 / $valeurssi))
    					return (1000 / $valeurssi);
    				else
    					if($value < (100001 / $valeurssi))
    						return (1500 / $valeurssi);
    					else
    						if($value < (200001 / $valeurssi))
    							return (2000 / $valeurssi);
    						else
    							if($value < (300001 / $valeurssi))
    								return (3000 / $valeurssi);
    							else
    								if($value < (500001 / $valeurssi))
    									return (3500 / $valeurssi);
    								else
    									if($value < (750001 / $valeurssi))
    										return (5500 / $valeurssi);
    									else
    										if($value < (1000001 / $valeurssi))
    											return (7400 / $valeurssi);
    										else
    											if($value < (1500001 / $valeurssi))
    												return (11400 / $valeurssi);
    											else
    												if($value < (2000001 / $valeurssi))
    													return (14900 / $valeurssi);
    												else
    													return 0;
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

    public function EnvoieRecuCANAL($destinataire, $sujet, $objet, $nom, $prenom, $CodePersoUser, $refrecu, $Numerocarte, $WhatsApp, $montant, $mail, $Choisirformule, $dateespire, $totale, $daterecu, $modereglement, $libelle, $solderestant, $Dureenmois, $reglementnum)
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
            'montantf' => IndexPrimeController::conversionfcfa($montant),
            'totalef' => IndexPrimeController::conversionfcfa($totale),
            'solderestantf' => IndexPrimeController::conversionfcfa($solderestant)
        ];
        
        
        SendMail::sendrecucanal($destinataire, $Subject, $data);
    }

    
    public function EnvoieRecuHealth($destinataire, $sujet, $objet, $nom, $prenom, $CodePersoUser, $refrecu, $lien, $pass, $tel, $montant, $mail, $daterecu, $modereglement, $libelle, $dateH, $pays, $pseudo)
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
            'lien' => $lien, 
            'pass' => $pass, 
            'tel' => $tel, 
            'mail' => $mail, 
            'montant' => $montant, 
            'daterecu' => $daterecu, 
            'modereglement' =>  $modereglement, 
            'libelle' => $libelle, 
            'dateH' => $dateH, 
            'pays' => $pays,  
            'pseudo' => $pseudo,
            'montantf' => IndexPrimeController::conversionfcfa($montant)
        ];
        
        
        SendMail::sendrecuhealth($destinataire, $Subject, $data);
    }
    
    public function EnvoieRecuLONGRICH($destinataire, $sujet, $objet, $nom, $prenom, $CodePersoUser, $refrecu, $lien, $pass, $tel, $montant, $mail, $daterecu, $modereglement, $libelle, $dateL, $pays, $pseudo)
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
            'lien' => $lien, 
            'pass' => $pass, 
            'tel' => $tel, 
            'mail' => $mail, 
            'montant' => $montant, 
            'daterecu' => $daterecu, 
            'modereglement' =>  $modereglement, 
            'libelle' => $libelle, 
            'dateL' => $dateL, 
            'pays' => $pays,  
            'pseudo' => $pseudo,
            'montantf' => IndexPrimeController::conversionfcfa($montant)
        ];
        
        
        SendMail::sendreculongrich($destinataire, $Subject, $data);

    }

    public function EnvoieRecu($destinataire, $sujet, $objet, $nom, $prenom, $CodePersoUser, $refrecu, $police, $WhatsApp, $montant, $mail, $presentation, $FraisSSI, $totale, $daterecu, $modereglement, $libelle, $solderestant, $periode, $reglementnum)
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
            'montantf' => IndexPrimeController::conversionfcfa($montant),
            'FraisSSIf' => IndexPrimeController::conversionfcfa($FraisSSI),
            'totalef' => IndexPrimeController::conversionfcfa($totale),
            'solderestantf' => IndexPrimeController::conversionfcfa($solderestant)
        ];
        
        
        SendMail::sendrecusoneb($destinataire, $Subject, $data);
    }

	public function EnvoieRecuCREDITSBEE($destinataire, $sujet, $objet, $nom, $prenom, $CodePersoUser, $refrecu, $police, $WhatsApp, $total, $mail, $FraisSSI, $montant, $daterecu, $modereglement, $libelle, $solderestant, $sts, $entretien, $kwh, $reglementnum
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
            'montantf' => IndexPrimeController::conversionfcfa($montant),
            'FraisSSIf' => IndexPrimeController::conversionfcfa($FraisSSI),
            'totalf' => IndexPrimeController::conversionfcfa($total),
            'solderestantf' => IndexPrimeController::conversionfcfa($solderestant)
        ];
        
        
        SendMail::sendrecucreditsbee($destinataire, $Subject, $data);
    }

    public function EnvoieMail($destinataire, $message, $sujet, $objet)
    {

	    setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
	    date_default_timezone_set('Africa/Porto-Novo');

	    $JOUR = date("Y-m-d");  // Jour de l'envoi de l'email
	    $HEURE = date("H:i"); // Heure d'envoi de l'email

	    $Subject = "$sujet - $JOUR $HEURE";
	    
	    SendMail::sendmailIndexController($destinataire, $Subject, $message, $objet);

    }

    public function conversionfcfa($value)
    {
        //$val = floatval($value);
        return (double)$value * 500;
    }

}