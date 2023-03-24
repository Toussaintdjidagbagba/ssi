<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
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
use Illuminate\Support\Facades\Session;

class GestionnaireController extends Controller
{
    // Tableau de bord
    public function dash() 
    {
    	    $compterecu = DB::table('systemadmins')->select('compteavoirrecu', 'compteavoirsortant')->get();
            $usersCLIENT = DB::table('users')
                     ->select(DB::raw('count(*) as user_count'))
                     ->where('type', 'client')
                     ->where('Pack', 1)
                     ->where('users.compteactive', '!=', 'sup')
                     ->get()[0]->user_count;
            
            $usersVENDEUR = DB::table('users')
                     ->select(DB::raw('count(*) as user_count'))
                     ->where('type', 'client')
                     ->where('Pack', 2)
                     ->where('users.compteactive', '!=', 'sup')
                     ->get()[0]->user_count;

            // RETRAIT 
            $notiftrust =  DB::table('retraittrusts')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            $notifwestern =  DB::table('retraitwesterns')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            $notifgram =  DB::table('retraitgrams')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            $notifmoov =  DB::table('retraitmoovs')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            $notifmtn =  DB::table('retraitmtns')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            $notifperfect =  DB::table('retraitperfects')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            $notifvisas =  DB::table('retraitvisas')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 0)->where('Statut', '!=', 3)->get()[0]->attente;
            
            // SERVICES
                     
            $notifcanals =  DB::table('canals')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
            
            $notifachats =  DB::table('achatssis')->select(DB::raw('count(statut) as attente'))->where('statut', '!=', 0)->where('statut', '!=', 3)->get()[0]->attente;

            //$notiflongriches =  DB::table('longriches')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;

            $notifmtnmoovs =  DB::table('mtnmoovs')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;

            $notifsbeecartes =  DB::table('sbeecartes')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=', 'oui')->where('Statut', '!=', 'sup')->get()[0]->attente;

            $notifsbeeconventiels =  DB::table('sbeeconventiels')->select(DB::raw('count(Statut) as attente'))->where('Statut', 'non')->where('Statut', '!=', 'sup')->get()[0]->attente;

            $notifsonebs =  DB::table('sonebs')->select(DB::raw('count(Statut) as attente'))->where('Statut', '!=' , 'Oui')->where('Statut', '!=', 'sup')->get()[0]->attente;
                     
            $data = [ 'compterecu' => $compterecu, 'allclient' => $usersCLIENT, 'allvendeur' => $usersVENDEUR, 'ncanals' => $notifcanals, 
            'nachats' => $notifachats, 'nmtnmoovs' => $notifmtnmoovs, 'nbeecartes' => $notifsbeecartes, 
            'nbeeconventiels' => $notifsbeeconventiels, 'nsonebs' => $notifsonebs, 'ntrusts' => $notiftrust, 'nwesterns' => $notifwestern, 'ngrams' => $notifgram,
            'nmoovs' => $notifmoov,'nmtns' => $notifmtn,'nperfects' => $notifperfect, 'nvisas' => $notifvisas];

        return view('admin.dashboard', $data);
    }
    
    // Liste des filleuls Vendeur
    public function listfilleulsvendeur()
    {
        $client = DB::table('users')
            ->join('avoirs', 'users.id', '=', 'avoirs.id_user', 'left outer') 
            ->select( 'avoirs.cvpv', 'avoirs.compv', 'avoirs.etapeActuel', 'users.Pack', 'users.id', 'users.tel', 'users.compteactive','users.nomuser' ,'users.nom', 'users.prenom', 'users.codeperso', 'users.codeunique', 'users.parrain', 'users.parrainindirect', 'users.created_at as created', 'avoirs.gainespece', 'avoirs.gainvirtuel', 'avoirs.gaincommissionvente')
            ->where('type', 'client')
            ->where('users.compteactive', '!=', 'sup')
            ->where('users.Pack', 2)
            ->orderBy('users.created_at', 'DESC')
            ->paginate(1000);
        $data = ['clients' => $client];
        
        return view('admin.listevendeur', $data);
    }
    
    public function recherchevendeur(Request $request)
    {
        $mot_cle = request('motcle');
        
        $client = DB::table('users')
            ->join('avoirs', 'users.id', '=', 'avoirs.id_user', 'left outer') 
            ->select( 'avoirs.cvpv', 'avoirs.compv', 'avoirs.etapeActuel', 'users.Pack', 'users.id', 'users.tel', 'users.compteactive' ,'users.nom', 'users.prenom', 'users.codeperso', 'users.codeunique', 'users.parrain', 'users.parrainindirect', 'users.created_at as created', 'avoirs.gainespece', 'avoirs.gainvirtuel', 'avoirs.gaincommissionvente')
            ->where('type', 'client')
            ->where('users.Pack', 2)
            ->where('users.compteactive', '!=', 'sup')
            ->whereRaw(" (nom like '%".$mot_cle."%' or prenom like '%".$mot_cle."%' or codeunique like '%".$mot_cle."%' or nomuser like '%".$mot_cle."%' or codeperso like '%".$mot_cle."%') ")
            ->orderBy('users.created_at', 'DESC')
            ->get();
       $data = ['clients' => $client];
       return view('admin.listevendeur', $data);
    }

    // Liste des filleuls
    public function listfilleuls()
    {
        $client = DB::table('users')
            ->join('avoirs', 'users.id', '=', 'avoirs.id_user', 'left outer') 
            ->select( 'avoirs.cvpv', 'avoirs.compv', 'avoirs.etapeActuel', 'users.Pack', 'users.id', 'users.tel', 'users.compteactive','users.nomuser' ,'users.nom', 'users.prenom', 'users.codeperso', 'users.codeunique', 'users.parrain', 'users.parrainindirect', 'users.created_at as created', 'avoirs.gainespece', 'avoirs.gainvirtuel', 'avoirs.gaincommissionvente')
            ->where('type', 'client')
            ->where('users.compteactive', '!=', 'sup')
            ->where('users.Pack', 1)
            ->orderBy('users.created_at', 'DESC')
            ->paginate(1000);
        $data = ['clients' => $client];
        
        return view('admin.listclient', $data);
    }

    public function deletefilleul(){
        DB::table('users')
                    ->where('id', request("id"))
                    ->update([
                    'compteactive' => "sup"
                    ]);
        
        flash("Filleul supprimer avec succès!"); 
        return Back();
    }
    
    public function getfilleul(Request $request){
        $users = DB::table('users')->where('id', $request->id)->first();
        
        return view('admin.client', compact('users'));
    }
    
    public function setfilleul(Request $request){
        //dd(request('role'));
        $users = DB::table('users')->where("id", request('id'))->first();
       
        DB::table('users')
            ->where('id', $users->id)
            ->update([
            'nom' => request('nom'),
            'prenom' =>request('prenom'),
            'email' =>request('mail'),
            'tel' =>request('tel'),
            'numidentite' => request('numide'),
            'Role' => request('role'),
            ]);
            
        flash('Profil du filleul '.request('nom').' mise à jour avec succès.');
        
        return Back();
    }
    
    public function recherche(Request $request)
    {
        $mot_cle = request('motcle');
        
        $client = DB::table('users')
            ->join('avoirs', 'users.id', '=', 'avoirs.id_user', 'left outer') 
            ->select( 'avoirs.cvpv', 'users.Pack', 'users.id', 'users.tel', 'users.compteactive' ,'users.nom', 'users.prenom', 'users.codeperso',
            'users.codeunique', 'users.parrain', 'users.parrainindirect', 'users.created_at as created', 'avoirs.gainespece', 'avoirs.gainvirtuel', 'avoirs.gaincommissionvente', 'avoirs.compv', 'avoirs.etapeActuel')
            ->where('type', 'client')
            ->where('users.Pack', 1)
            ->where('users.compteactive', '!=', 'sup')
            ->whereRaw(" (nom like '%".$mot_cle."%' or prenom like '%".$mot_cle."%' or codeunique like '%".$mot_cle."%' or nomuser like '%".$mot_cle."%' or codeperso like '%".$mot_cle."%') ")
            ->orderBy('users.created_at', 'DESC')
            ->get();
       $data = ['clients' => $client];
       return view('admin.listclient', $data);
    }
    
    public static function validefilleul(Request $request){
        
        if(DB::table('users')->where('id', $request->uset)->first()->confirme == 0){
            DB::table('users')->where('id', $request->uset)->update(['confirme' => 1]);
            HistoriqueClient::saveHistorique("Votre identité est validé.", $request->uset );
            $destinataire = DB::table('users')->where('id', $request->uset)->first()->email;
            InterfaceServiceProvider::EnvoieMail($destinataire, "Votre identité est validé.", "Votre identité est validé.", "");
            return "Profil valider avec succès.";
        }else{
            DB::table('users')->where('id', $request->uset)->update(['confirme' => 0]);
            HistoriqueClient::saveHistorique("Votre identité est invalidé.", $request->uset );
            $destinataire = DB::table('users')->where('id', $request->uset)->first()->email;
            InterfaceServiceProvider::EnvoieMail($destinataire, "Votre identité est invalidé.", "Votre identité est invalidé.", "");
            return "Profil invalider avec succès.";
        }
    }


    public function recherchexc(Request $request)
    {
        $mot_cle = request('motcle');
        
        $client = DB::table('users')
            ->join('avoirs', 'users.id', '=', 'avoirs.id_user', 'left outer') 
            ->where('type', 'client')
            ->where('users.compteactive', '!=', 'sup')
            ->where('nom', 'like', '%' . $mot_cle . '%')
            ->select('users.Pack', 'users.id', 'users.compteactive' ,'users.nom', 'users.prenom', 'users.codeperso', 'users.codeunique', 'users.parrain', 'users.parrainindirect', 'users.created_at as created', 'avoirs.gainespece', 'avoirs.gainvirtuel', 'avoirs.gaincommissionvente')
            ->orderBy('users.created_at', 'DESC')
            ->paginate(10);
            
        if(!isset($client[0]->codeperso))
        {
            $client = DB::table('users')
            ->join('avoirs', 'users.id', '=', 'avoirs.id_user', 'left outer') 
            ->where('type', 'client')
            ->where('users.compteactive', '!=', 'sup')
            ->where('prenom', 'like', '%' . $mot_cle . '%')
            ->select('users.Pack', 'users.id', 'users.compteactive' ,'users.nom', 'users.prenom', 'users.codeperso', 'users.codeunique', 'users.parrain', 'users.parrainindirect', 'users.created_at as created', 'avoirs.gainespece', 'avoirs.gainvirtuel', 'avoirs.gaincommissionvente')
            ->orderBy('users.created_at', 'DESC')
            ->paginate(10);
            
            if(!isset($client[0]->codeperso))
            {
                $client = DB::table('users')
                    ->join('avoirs', 'users.id', '=', 'avoirs.id_user', 'left outer') 
                    ->where('type', 'client')
                    ->where('users.compteactive', '!=', 'sup')
                    ->where('codeperso', 'like', '%' . $mot_cle . '%')
                    ->select('users.Pack', 'users.id', 'users.compteactive' ,'users.nom', 'users.prenom', 'users.codeperso', 'users.codeunique', 'users.parrain', 'users.parrainindirect', 'users.created_at as created', 'avoirs.gainespece', 'avoirs.gainvirtuel', 'avoirs.gaincommissionvente')
                    ->orderBy('users.created_at', 'DESC')
                    ->paginate(10);
                    
                if(!isset($client[0]->codeperso))
                {
                    $client = DB::table('users')
                    ->join('avoirs', 'users.id', '=', 'avoirs.id_user', 'left outer') 
                    ->where('type', 'client')
                    ->where('users.compteactive', '!=', 'sup')
                    ->where('nomuser', 'like', '%' . $mot_cle . '%')
                    ->select('users.Pack', 'users.id', 'users.compteactive' ,'users.nom', 'users.prenom', 'users.codeperso', 'users.codeunique', 'users.parrain', 'users.parrainindirect', 'users.created_at as created', 'avoirs.gainespece', 'avoirs.gainvirtuel', 'avoirs.gaincommissionvente')
                    ->orderBy('users.created_at', 'DESC')
                    ->paginate(10);
                    
                    if(!isset($client[0]->codeperso))
                    {
                        $client = DB::table('users')
                            ->join('avoirs', 'users.id', '=', 'avoirs.id_user', 'left outer') 
                            ->where('type', 'client')
                            ->where('users.compteactive', '!=', 'sup')
                            ->where('codeunique', 'like', '%' . $mot_cle . '%')
                            ->select('users.Pack', 'users.id', 'users.compteactive' ,'users.nom', 'users.prenom', 'users.codeperso', 'users.codeunique', 'users.parrain', 'users.parrainindirect', 'users.created_at as created', 'avoirs.gainespece', 'avoirs.gainvirtuel', 'avoirs.gaincommissionvente')
                            ->orderBy('users.created_at', 'DESC')
                            ->paginate(10);
                            
                            if(!isset($client[0]->codeperso))
                            {
                                $data = ['clients' => $client];
                                return view('admin.listclient', $data);
                            }
                            else
                            {
                                $data = ['clients' => $client];
                                return view('admin.listclient', $data);
                            }
                        
                    }
                    else
                    {
                        $data = ['clients' => $client];
                        return view('admin.listclient', $data);    
                    }
                }
                else
                {
                    $data = ['clients' => $client];
                    return view('admin.listclient', $data);
                }
            }
            else
            {
                $data = ['clients' => $client];
                return view('admin.listclient', $data);
            }
        }
        else
        {
            $data = ['clients' => $client];
            return view('admin.listclient', $data);
        }
    }

}
