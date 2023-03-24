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

class AutreController extends Controller
{
    public static function updateEtape(){
        $identifiant = 83945934;
        
        $id = DB::table('users')->where('codeperso', $identifiant)->first()->id;
        //dd($id);
        InterfaceServiceProvider::NiveauParrainControl($id);
        
        dd("Bon");
    }
}