<?php 

namespace App\Http\Controllers;

use App\HistoriqueClient;
use App\Historique;
use App\Mtnmoov;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MOOVController extends Controller 
{
	public function getmoov()
	{ 
		return view('services_site.moov.moov');
	}

	public function setmoov(Request $request)
	{
		$num = substr(request('numero'), -8);

		$id_num = substr($num, -8, 2);

		if (MOOVController::verifie_moov($id_num) == 1) {
		
		
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
    
    	                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;
    
    	                //debiter le compte admin
    	                $recu=$compteadmin + $valeuradhesion;
    
    	                //update la table
    	                DB::table('systemadmins')
    	                        ->where('id_AdminPrincipal', auth()->user()->id)
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
    
    	              /*  // Commission sur vente
    	                $comv = $valeuradhesion * 2 / 100;
    
    	                $soldeactuel_comv = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gaincommissionvente;
    	                $soldeac_comv = $soldeactuel_comv + $comv;
    	                DB::table('avoirs')
    	                    ->where('id_user', auth()->user()->id)
    	                    ->update([
    	                    'gaincommissionvente' => $soldeac_comv
    	                    ]);*/
    
    
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
    
    	                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;
    
    	                //debiter le compte admin
    	                $recu=$compteadmin + $valeuradhesion;
    
    	                //update la table
    	                DB::table('systemadmins')
    	                        ->where('id_AdminPrincipal', auth()->user()->id)
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
    
    	              /*  // Commission sur vente
    	                $comv = $valeuradhesion * 2 / 100;
    
    	                $soldeactuel_comv = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gaincommissionvente;
    	                $soldeac_comv = $soldeactuel_comv + $comv;
    	                DB::table('avoirs')
    	                    ->where('id_user', auth()->user()->id)
    	                    ->update([
    	                    'gaincommissionvente' => $soldeac_comv
    	                    ]);*/
    
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
    
    	                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;
    
    	                //debiter le compte admin
    	                $recu=$compteadmin + $valeuradhesion;
    
    	                //update la table
    	                DB::table('systemadmins')
    	                        ->where('id_AdminPrincipal', auth()->user()->id)
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
    
    	             /*   // Commission sur vente
    	                $comv = $valeuradhesion * 2 / 100;
    
    	                $soldeactuel_comv = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gaincommissionvente;
    	                $soldeac_comv = $soldeactuel_comv + $comv;
    	                DB::table('avoirs')
    	                    ->where('id_user', auth()->user()->id)
    	                    ->update([
    	                    'gaincommissionvente' => $soldeac_comv
    	                    ]);*/
    
    
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
    
    	                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;
    
    	                //debiter le compte admin
    	                $recu=$compteadmin + $valeuradhesion;
    
    	                //update la table
    	                DB::table('systemadmins')
    	                        ->where('id_AdminPrincipal', auth()->user()->id)
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
    
    	              /*  // Commission sur vente
    	                $comv = $valeuradhesion * 2 / 100;
    
    	                $soldeactuel_comv = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gaincommissionvente;
    	                $soldeac_comv = $soldeactuel_comv + $comv;
    	                DB::table('avoirs')
    	                    ->where('id_user', auth()->user()->id)
    	                    ->update([
    	                    'gaincommissionvente' => $soldeac_comv
    	                    ]);*/
    
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
    
    	                $compteadmin = DB::table('systemadmins')->where('id_AdminPrincipal', 1)->get()[0]->compteavoirrecu;
    
    	                //debiter le compte admin
    	                $recu=$compteadmin + $valeuradhesion;
    
    	                //update la table
    	                DB::table('systemadmins')
    	                        ->where('id_AdminPrincipal', auth()->user()->id)
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
    
    	              /*  // Commission sur vente
    	                $comv = $valeuradhesion * 2 / 100;
    
    	                $soldeactuel_comv = DB::table('avoirs')->where('id_user', auth()->user()->id)->get()[0]->gaincommissionvente;
    	                $soldeac_comv = $soldeactuel_comv + $comv;
    	                DB::table('avoirs')
    	                    ->where('id_user', auth()->user()->id)
    	                    ->update([
    	                    'gaincommissionvente' => $soldeac_comv
    	                    ]);*/
    
    
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

	public function verifie_moov($numero)
	{
	    return 1; // Bon
		
		/*
		$table_numero_possible = [60,63,58,64,65,68,94,95,98,99];

			$v = 0;

		for ($i=0; $i < 10; $i++)
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
	
}

 ?>