<?php

namespace App\Http\Controllers;

use DB;

class MethodeSuppController extends Controller 
{
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


}