<?php

namespace App\Http\Controllers;

use App\Achatssi;
use App\Historique;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CorbeilleController extends Controller 
{
    
    
    public function getcorbeille()
    {
        $sbeecarte = []; $sbeeconventiel = []; $soneb = [];
        $soneb = DB::table('sonebs') 
            ->select('RefRecu', 'CodePersoUser as identifiant')
            ->where('Statut', 'sup')->orderby("RefRecu", "DESC")
            ->get();
        $sbeeconventiel = DB::table('sbeeconventiels') 
            ->select('RefRecu', 'CodePersoUser as identifiant')
            ->where('Statut', 'sup')->orderby("RefRecu", "DESC")
            ->get();
        $sbeecarte = DB::table('sbeecartes') 
            ->select('RefRecu', 'CodePersoUser as identifiant')
            ->where('Statut', 'sup')->orderby("RefRecu", "DESC")
            ->get(); 
        return view('admin.corbeille', compact("soneb", "sbeeconventiel", "sbeecarte"));
    }
    
    public function setrestaurersoneb(Request $request){
        //dd(request("ref"));
        $tables = CorbeilleController::tableService(request('service'));
        DB::table($tables)
            ->where('RefRecu', request("ref"))
            ->update([
                'compteactive' => "non"
            ]);
            
        flash("Restaurer avec succes.");
        return Back();
    }
    
    public function tableService($name){
        switch($name) {
            case('soneb'):
                return "sonebs";
                break;
            case('sbeefacture'):
                return "sbeeconventiels";
                break;
            case('sbeecarte'):
                return "sbeecartes";
                break;
            default:
                return "inconnu";
        }
    }
    
}