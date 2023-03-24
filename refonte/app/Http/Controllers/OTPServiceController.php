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

        $destinataire = auth()->user()->email;

        InterfaceServiceProvider::EnvoieMail($destinataire, $message, "Accès", "");

        Session::put('otprecu', $otp);

        return "Un code vous est été envoyé dans votre boîte mail.";
    }

}