<?php

namespace App\Http\Controllers;

use DB;
use App\Historique;
use App\HistoriqueClient;
use Illuminate\Http\Request;
use App\Providers\InterfaceServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SendMail;

class OTPServiceController extends Controller
{

    public static function sendotp()
    {
        $otp = rand(100000, 999999);

        $message = "Code OTP Générer : ".$otp;
        
        if(isset(session('utilisateur')->idUser))
            $destinataire = session('utilisateur')->mail;
        else
            $destinataire = auth()->user()->email;

        InterfaceServiceProvider::EnvoieMail($destinataire, $message, "Accès", "");

        Session::put('otprecu', $otp);

        return "Un code vous est été envoyé dans votre boîte mail.";
    }
    
    public static function sendotpreinitia()
    {
        $otp = rand(10000000, 99999999);

        $message = "Code OTP pour réinitialiser votre mot de passe : ".$otp;
        
        $pseudo = htmlspecialchars(trim(request("pseudo")));
        $codeperso = htmlspecialchars(trim(request("identi")));
        
        $id = DB::table('users')->where('nomuser', $pseudo)->where('codeperso', $codeperso)->first();
        
        if(isset($id->id)){
            
            if($id->email != ""){
                Session::put('otpreini', $otp);
                InterfaceServiceProvider::EnvoieMail($id->email, $message, "Réinitialisation mot de passe SSI", "");
                $string = $id->email;
                $emaill = $string[0].$string[1].$string[2]."********".substr($string, -10);
                return "Confirmer que c'est bien votre email ".$emaill." en renseignant le code otp envoyer ici : ";
            }else{
                return 2;
            }
            
        }else{
            return 1;
        }
    }
    
    public static function setotpreinitia(){
        
        if(request('otp') == session('otpreini')){
            return 0;
        }else{
            return 4;
        }
    }
    
    public static function setreinitia(){
        
        if( request('psdo') != "" && request('mdp') != ""){
            
            DB::table('users')->where('codeperso', request('psdo'))->update(['password' => bcrypt(request('mdp'))]);
            return 0;
        }else{
            return 4;
        }
    }
    
    public static function checkpv(){
        if( request('pseudo') != ""){
            
            $tr = DB::table('users')->where('codeperso', request('pseudo'))->first();
            
            if(isset($tr->id)){
                $pv = DB::table('users')->where('codeperso', request('pseudo'))->where('Role', 4)->first();
                
                if(isset($pv->id)){
                    if(auth()->user()->confirme == 0 && request('service') != "achat")
                        return 5;
                    elseif(auth()->user()->id == $pv->id)
                        return 6;
                    else
                        return "Veillez confirmer le Nom de votre point de vente ou  Distributeur de Zone : ".$pv->nomuser;
                }else{
                    
                    if(request('service') == "achat"){
                        $pv = DB::table('users')->where('codeperso', request('pseudo'))->where('Role', 5)->first();
                        if(isset($pv->id)){
                            if(auth()->user()->id == $pv->id)
                                return 6;
                            else
                                return "Veillez confirmer le Nom de votre Distributeur de Zone : ".$pv->nomuser;
                        }else return 7;
                    }else
                        return 3;
                }
                
            }else{
                return 2;
            }
        }else{
            return 1;
        }
    }
    
    public static function checkpseudo(){
        
        if( request('pseudo') != ""){
            
            $tr = DB::table('users')->where('codeperso', request('pseudo'))->first();
            
            if(isset($tr->id)){
                return "Veuillez confirmé le nom du destinataire : ".$tr->nom." ".$tr->prenom;
            }else{
                return 2;
            }
        }else{
            return 1;
        }
    }
    
    public static function verfdest(Request $reqp) {
        
        $info = DB::table('users')->where('codeperso', $reqp->id)->first();
        
        if(isset($info->id))
            return $info->nom.' '.$info->prenom;
        return "N'existe pas";
    }

}