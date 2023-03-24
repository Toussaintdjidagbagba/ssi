<?php

namespace App\Http\Controllers;

use App\Achatssi;
use App\Historique;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HistoriqueController extends Controller 
{
    public function gethist(){
        
        $hists = DB::table('historiques')->where('user_action', auth()->user()->id)->orderby('id', 'DESC')->get();
        
        return view("admin.historiqueTranslation", compact("hists"));
    }
    
    public function gethistclient(){
        $hists = DB::table('historique_clients')->where('user_action', auth()->user()->id)->orderby('id', 'DESC')->get();
        
        return view("client.historiqueTranslation", compact("hists"));
    }
    
    public function getHistClientAuAdmin(){
        
        $hists = DB::table('historique_clients')
        ->select("historique_clients.created_at as created_at", "historique_clients.libelle as libelle", 
        "users.codeperso as codeperso", "users.nom as nom", "users.prenom as prenom")
        ->join('users', 'users.id', '=', 'historique_clients.user_action');
        
        $search = "";

        if(request('rec') == 1){
            if(request('check') != "" && request('check') != null){
                $search = request('check');
                $id_usr = DB::table('users')->where('codeperso', request('check'))->first();
                if(isset($id_usr->id))
                {
                    $hists = $hists->where('user_action', $id_usr->id)->orderby('historique_clients.id', 'DESC')->paginate(50);
                }
                else
                    $hists = $hists->where('user_action', "")->orderby('historique_clients.id', 'DESC')->paginate(50);
                return view("admin.historiqueTranslationClient", compact('hists', 'search'));
            }else{
                $hists = $hists->orderby('historique_clients.id', 'DESC')->paginate(50);
                return view("admin.historiqueTranslationClient", compact('hists', 'search'));
            }
        }

        $hists = $hists->orderby('historique_clients.id', 'DESC')->paginate(50);
        
        return view("admin.historiqueTranslationClient", compact("hists", "search"));
    }
    
    
}