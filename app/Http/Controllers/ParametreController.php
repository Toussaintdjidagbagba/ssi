<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ParametreController extends Controller
{
    
    public function dash_user()
    {
        return view('admin.dash_utilisateur');
    }


    /**************** Galerie *****************************/

    public function getgalerie()
    {
        return view('admin.creergalerie');   
    }

    public function setgalerie()
    {
        request()->validate([
            'img' => ['required', 'mimes:png'],
           'titre' => 'required',
        ]);
       // dd(request());
        $path = request('img')->store('img', 'public');

        $image = './img';

        $article = Galerie::create([
            'path' => $path,
            'image' => request('titre'), 
            'id_user' => auth()->user()->id
        ]);

        flash('Ajout avec succès!!!');
        return Back();

    }

    /**************** Evernement *****************************/
    public function getevernement()
    {
        return view('admin.creerevernement');   
    }

    public function setevernement()
    {
        request()->validate([
            
           'theme' => 'required',
           'lieu' => 'required',
           'date' => 'required',
           'heure' => 'required',
           'description' => 'required',
           
        ]);

        $article = Evenement::create([
            'path' => "1",
            'image' => request('theme'),
            'date' => request('date'), 
            'lieu' => request('lieu'), 
            'heure' => request('heure'), 
            'description' => request('description'),
        ]);

        flash('Conférence créer avec succès!!!');
        return Back();
    }



    /**************** Contact*****************************/
    public function getlistecontact()
    {
        $contacts=DB::table('notificationcontacts')->orderBy('id', 'DESC')->get();
        $data=['contacts'=>$contacts];
        return view ('admin.listecontact',$data);
    }

    public function setlistecontact()
    {
        $cont = DB::table('notificationcontacts')->where('id', request('id'))->first();
        
        return view('admin.repondre', compact('cont'));
    }

    public function setrepondre()
    {
        request()->validate([
            'reponse' => 'required|string'
            ]);

        $message = request('reponse');
        $message .= "<br>";
        $message .= "<br>";

        $sujet = "Réponse de la Source du Succès International ";
        $objet = "";
        $email = request('email');

        // Mise à jour de la base de donnee
        DB::table('notificationcontacts')
                        ->where('id', request('id'))
                        ->update([
                        'Reponse' => request('reponse')
                        ]);
        DB::table('notificationcontacts')
                        ->where('id', request('id'))
                        ->update([
                        'Statut' => "oui"
                        ]);

        return Back();
    }
}
