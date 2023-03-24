<?php 
namespace App\Http\Controllers;

use App\HistoriqueClient;
use App\Historique;
use App\Mtnmoov;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MTNController extends Controller 
{
	public function getmtn()
	{
		return view('services_site.mtn.mtn');
	}

	public function setmtn(Request $request)
	{
		$num = substr(request('numero'), -8);
		
		
		$id_num = substr($num, -8, 2);

		if (MTNController::verifie_mtn($id_num) == 1) {
		
		
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

	public function verifie_mtn($id_numero)
	{
	    return 1; // Bon
	    
	    /*
		$table_numero_possible = [50,51,52,53,54,56,57,59,61,62,66,67,69,90,91,96,97];

		$v = 0;

		for ($i=0; $i < 17; $i++)
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
}

 ?>