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

class BoutiqueController extends Controller 
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

}