<?php 
namespace App\Http\Controllers;

use DB;
use App\Historique;
use App\HistoriqueClient;
use Illuminate\Http\Request;
use App\Providers\InterfaceServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SendMail;

/**
 * 
 */
class OperationMLM extends Controller
{

	public function gettransfertadmin()
    {
        return view('admin.transfertadmin'); 
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

                if (session('otprecu') != request('otp')) {
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
                    $soldeactue = DB::table('systemadmins')->get()[0]->compteavoirsortant;
                    $soldea = $soldeactue + request('montant');
                    DB::table('systemadmins')
                        ->update([
                            'compteavoirsortant' => $soldea
                        ]);

                    $message = "Vous avez transférer ".request('montant')." $ SSI à ". DB::table('users')->where('codeperso', request('id'))->get()[0]->prenom . " " . DB::table('users')->where('codeperso', request('id'))->get()[0]->nom." dont l'identifiant est : ".DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso.". Transfert éffectuer avec succès.";
                    
                    Historique::saveHistorique( "A", $message, session('utilisateur')->idUser );
                    $message_reception = "Vous avez reçu ".request('montant')." $ SSI ";
                    HistoriqueClient::saveHistorique($message_reception, $iddest);
                    flash($message);
                    return view('admin.transfertadmin');
                }
            } else {
                flash("L'identifiant n'existe pas");
                
                return view('admin.transfertadmin');
            }
        }
        
    }

    public function getprelevement()
    {
        return view('admin.prelevement');
    }

    public function setprelevement(Request $request)
    {
        request()->validate([
            'id' => 'required',
            'montant' => 'required|min:0' ]);

            $idprel=DB::table('users')->where('codeperso', request('id'))->get()[0]->id;
            // recupérer gain user actuel
            $soldeactuel=DB::table('avoirs')->where('id_user', $idprel)->get()[0]->gainespece;

            //verifier si son solde peut etre créditer
            if ($soldeactuel >= request('montant')) {
                
                // prelever de son compte

                $solde=$soldeactuel - request('montant');
                DB::table('avoirs')->where('id_user', $idprel)->update(['gainespece'=>$solde]);

                //recuperer compte admin
                $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;

                //debiter le compte admin
                $recu=$compteadmin + request('montant');

                //update la table
                DB::table('systemadmins')
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);
                        $nom = DB::table('users')->where('codeperso', request('id'))->get()[0]->nom;
                        $prenom = DB::table('users')->where('codeperso', request('id'))->get()[0]->prenom;
                        
                        $m = "Opération effectuée avec succès. Vous avez prélever ".request('montant')." $ SSI du compte dont l'identifiant est ".request('id')." du ".$prenom." ".$nom;
                        Historique::saveHistorique( "B", $m, session('utilisateur')->idUser );
                        $message_reception = "Il vous a été prélevé ".request('montant')." $ SSI ";
                        HistoriqueClient::saveHistorique($message_reception, $idprel);
                        flash("Opération effectuée avec succès. Vous avez prélever ".request('montant')." $ SSI du compte dont l'identifiant est ".request('id')." du ".$prenom." ".$nom."");
                        
                        return Back();               
            } else {
                Historique::saveHistorique( "B", "Le solde du client est insuffisant pour cette opération", session('utilisateur')->idUser );
                flash("Le solde du client est insuffisant pour cette opération")->error();
                return Back();
            }
    }

    public function gettransfertadmincommissionvente()
    {
        return view('admin.transfertcommissionvente');
    }

    public function settransfertadmincommissionvente(Request $request)
    {
        
        request()->validate([
            'id' => 'required',
            'montant' => 'required|min:0',
            'otp' => 'required' ]);
 
        // Verifier l'existance de id
        if (isset(DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso)) {
            
            // verifie l'autorisation par otp

            if (session('otprecu') != request('otp')) {
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
                $soldeactue = DB::table('systemadmins')->get()[0]->compteavoirsortant;
                $soldea = $soldeactue + request('montant');
                DB::table('systemadmins')
                    ->update([
                    'compteavoirsortant' => $soldea
                    ]);


                $message = "Vous avez transférer ".request('montant')." $ SSI à ". DB::table('users')->where('codeperso', request('id'))->get()[0]->prenom . " " . DB::table('users')->where('codeperso', request('id'))->get()[0]->nom." dont l'identifiant est : ".DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso.". Transfert éffectuer avec succès.";
                Historique::saveHistorique( "C", $message, session('utilisateur')->idUser );
                $message_reception = "Vous avez reçu ".request('montant')." $ SSI ";
                HistoriqueClient::saveHistorique($message_reception, $iddest);
                flash($message);
                return view('admin.transfertcommissionvente');
                //return Back();
            }
        } else {
            flash("L'identifiant n'existe pas");
            return Back();
        }     
    }

    public function getprelevementcommissionvente()
    {
        return view('admin.prelevementcommissionvente'); 
    }

    public function setprelevementcommissionvente(Request $request)
    {
        request()->validate([
            'id' => 'required',
            'montant' => 'required|min:0' ]);

            $idprel=DB::table('users')->where('codeperso', request('id'))->get()[0]->id;
            // recupérer gain user actuel
            $soldeactuel=DB::table('avoirs')->where('id_user', $idprel)->get()[0]->gaincommissionvente;

            //verifier si son solde peut etre créditer
            if ($soldeactuel >= request('montant')) {
                
                // prelever de son compte

                $solde=$soldeactuel - request('montant');
                DB::table('avoirs')->where('id_user', $idprel)->update(['gaincommissionvente'=>$solde]);

                //recuperer compte admin
                $compteadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;

                //debiter le compte admin
                $recu=$compteadmin + request('montant');

                //update la table
                DB::table('systemadmins')
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);
                        $nom = DB::table('users')->where('codeperso', request('id'))->get()[0]->nom;
                        $prenom = DB::table('users')->where('codeperso', request('id'))->get()[0]->prenom;
                        
                        $m = "Opération effectuée avec succès. Vous avez prélever ".request('montant')." $ SSI du compte commission sur vente dont l'identifiant est ".request('id')." du ".$prenom." ".$nom;
                        Historique::saveHistorique("D", $m, session('utilisateur')->idUser );
                        $message_reception = "Il vous a été prélevé ".request('montant')." $ SSI ";
                        HistoriqueClient::saveHistorique($message_reception, $idprel);
                        flash("Opération effectuée avec succès. Vous avez prélever ".request('montant')." $ SSI du compte commission sur vente dont l'identifiant est ".request('id')." du ".$prenom." ".$nom."");
                        return Back();               
            } else {
                Historique::saveHistorique("D", "Le solde du client est insuffisant pour cette opération", session('utilisateur')->idUser );
                flash("Le solde du client est insuffisant pour cette opération")->error();
                return Back();
            }
    }

    public function gettransfertgainvirtuel()
    {
        return view('admin.transfertgainvirtuel');
    }

    public function settransfertgainvirtuel(Request $request)
    {
        request()->validate([
            'id' => 'required',
            'montant' => 'required|min:0',
            'otp' => 'required' ]);
 
        // Verifier l'existance de id
        if (isset(DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso)) {
            
            // verifie l'autorisation par otp

            if (session('otprecu') != request('otp')) {
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
                $soldeactue = DB::table('systemadmins')->get()[0]->compteavoirsortant;
                $soldea = $soldeactue + request('montant');
                DB::table('systemadmins')
                    ->update([
                    'compteavoirsortant' => $soldea
                    ]);
                
                $message = "Vous avez transférer ".request('montant')." $ SSI à ". 
                    DB::table('users')->where('codeperso', 
                        request('id'))->get()[0]->prenom . " " . 
                    DB::table('users')->where('codeperso', 
                    request('id'))->get()[0]->nom." dont l'identifiant est : ".
                    DB::table('users')->where('codeperso', request('id'))->get()[0]->codeperso.". Transfert éffectuer avec succès.";
                Historique::saveHistorique( "E", $message, session('utilisateur')->idUser);
                $message_reception = "Vous avez reçu ".request('montant')." $ SSI ";
                HistoriqueClient::saveHistorique($message_reception, $iddest);
                flash($message);

                return view('admin.transfertcommissionvente');
            }
        } else {
            flash("L'identifiant n'existe pas");
            return Back();
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

            $idprel=DB::table('users')->where('codeperso', request('id'))->get()[0]->id;
            // recupérer gain user actuel
            $soldeactuel=DB::table('avoirs')->where('id_user', $idprel)->get()[0]->gainvirtuel;

            //verifier si son solde peut etre créditer
            if ($soldeactuel >= request('montant')) {
                
                // prelever de son compte

                $solde=$soldeactuel - request('montant');
                DB::table('avoirs')->where('id_user', $idprel)->update(['gainvirtuel'=>$solde]);

                //recuperer compte admin
                $soldeadmin = DB::table('systemadmins')->get()[0]->compteavoirrecu;

                //debiter le compte admin
                $recu=$soldeadmin + request('montant');

                //update la table
                DB::table('systemadmins')
                        ->update([
                        'compteavoirrecu' => $recu
                        ]);
                        $nom = DB::table('users')->where('codeperso', request('id'))->get()[0]->nom;
                        $prenom = DB::table('users')->where('codeperso', request('id'))->get()[0]->prenom;
                        $mg = "Opération effectuée avec succès. Vous avez prélever ".request('montant')." $ SSI du compte gain virtuel dont l'identifiant est ".request('id')." du ".$prenom." ".$nom;
                        Historique::saveHistorique("F", $mg, session('utilisateur')->idUser );
                        $message_reception = "Il vous a été prélevé ".request('montant')." $ SSI ";
                        HistoriqueClient::saveHistorique($message_reception, $idprel);
                        flash("Opération effectuée avec succès. Vous avez prélever ".request('montant')." $ SSI du compte gain virtuel dont l'identifiant est ".request('id')." du ".$prenom." ".$nom."");
                        return Back();               
            } else {
                Historique::saveHistorique("F", "Le solde du client est insuffisant pour cette opération", session('utilisateur')->idUser);
                flash("Le solde du client est insuffisant pour cette opération")->error();
                return Back();
            }

    }

}

 ?>