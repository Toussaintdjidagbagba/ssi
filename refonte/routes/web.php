<?php

/*Site */
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/', 'IndexController@index')->name('index');
Route::get('/index', 'IndexController@index')->name('index');
Route::get('/article-{id}', 'IndexController@affichearticle')->name('article');

Route::get('/galerie','IndexController@galerie')->name('galerie');
Route::get('/evernement','IndexController@evernement')->name('evernement');
Route::get('/propos', 'IndexController@propos')->name('propos');
Route::get('/contact','IndexController@contact')->name('contact');
Route::post('/contact','IndexController@setcontact')->name('contactS'); 

//////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* Visiteur Authentification */
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/connexion', 'AuthentificationClientController@seconnecter')->name('seconnecter');
Route::post('/connexion', 'AuthentificationClientController@saveseconnecter')->name('seconnecterS');
Route::get('/inscription', 'AuthentificationClientController@inscription')->name('inscription');
Route::get('/inscription-monparrain-{parrain}', 'AuthentificationClientController@inscriptionlink')->name('inscriptionlink');
Route::post('/inscription', 'AuthentificationClientController@saveinscription')->name('inscriptionS');
Route::get('/validerpayement', 'AuthentificationClientController@validerpayement')->name('validerpayement');
Route::post('/validerpayement', 'AuthentificationClientController@traitementpayement')->name('validerpayementT');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* Visiteur Service */
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/canalplus', 'DemandeClientController@getcanalplus')->name('canalplus');
Route::post('/canalplus', 'DemandeClientController@setcanaplus')->name('canalplusS');

Route::get('/soneb', 'DemandeClientController@getsoneb')->name('soneb');
Route::post('/soneb', 'DemandeClientController@setsoneb')->name('sonebS');

Route::get('/sbee', 'DemandeClientController@getsbee')->name('sbee');
Route::post('/sbee-compteur-conventionnel', 'DemandeClientController@setsbee2')->name('sbee2S');
Route::post('/sbee-compteur-carte', 'DemandeClientController@setsbee1')->name('sbee1S');

Route::get('/mtn', 'DemandeClientController@getmtn')->name('mtnb');
Route::post('/mtn', 'DemandeClientController@setmtn')->name('mtnbS');

Route::get('/moov', 'DemandeClientController@getmoov')->name('moov');
Route::post('/moov', 'DemandeClientController@setmoov')->name('moovS');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::post('/activer', 'IndexController@valideinscription')->name('activer');
Route::get('/validerinscription-{id}', 'IndexController@valideinscription')->name('valideinscription');
Route::post('/validerinscription', 'IndexController@traitementinscription')->name('valideinscriptionT');
Route::post('/valideparrain', 'IndexController@continueinscription')->name('valideParrain');

Route::get('/reinitialisation', 'IndexController@getfogot')->name('fogot');
Route::post('/reinitialisation', 'IndexController@fogot')->name('fogotR');
Route::post('/message', 'IndexController@rfogot')->name('fogotRR');
Route::get('/reinitialisation/renvoyer', 'IndexController@getp')->name('p');
Route::post('/reinitialisation/valider', 'IndexController@setfogot')->name('fogotS');

/*
Route::get('/longrichform', 'IndexPrimeController@getlongrichform')->name('longrichform');
Route::post('/longrichform', 'IndexPrimeController@setlongrichform')->name('longrichformS');
Route::get('/healthform', 'IndexPrimeController@gethealthform')->name('healthform');
Route::post('/healthform', 'IndexPrimeController@sethealthform')->name('healthformS'); 

Route::get('/mtn-moov', 'IndexPrimeController@getmtn')->name('mtn');
Route::post('/mtn-moov', 'IndexPrimeController@setmtn')->name('mtnS');

*/



Route::get('/boutique-ssi', 'IndexPrimeController@getboutique')->name('boutique');
Route::get('/paiement-{id}', 'IndexPrimeController@paiementarticle')->name('paiementarticle');

Route::group([
	'middleware' => 'App\Http\Middleware\Auth' 

], function(){
    
    
    // Nouveau Admin
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    Route::get('/utilisateurs', 'ParametreController@dash_user')->name('NU');


    // Service validation achat $SSI
    Route::get('/demande-achat-$ssi', 'ServiceController@getdemandeachat')->name('achat$ssi');
    Route::get('/demande-servir-{id}', 'ServiceController@setservirachat')->name('achatservir');
    Route::get('/demande-echec-{id}', 'ServiceController@setechecachat')->name('achatechec');
    Route::get('/demande-supprimer-{id}', 'ServiceController@setdeleteachat')->name('deleteachat'); 


    // Service validation visa
    Route::get('/demande-visa', 'ServiceController@getdemandevisa')->name('getSRVISA');
    Route::get('/demande-visa-servir-{id}', 'ServiceController@setservirvisa')->name('Visaservir');
    Route::get('/demande-visa-echec-{id}', 'ServiceController@setechecvisa')->name('Visaechec');
    Route::get('/demande-visa-supprime-{id}', 'ServiceController@setdeletevisa')->name('Visadelete');

    // Service Canal+
    Route::get('/canal-recu:reference-{refrecu}', 'ServiceController@getcanalrecu')->name('canalrecu');
	Route::get('/services-canal', 'ServiceController@getcanalservice')->name('canalservice');
	Route::post('/canal-recu', 'ServiceController@setcanalrecu')->name('canalrecuS');
	Route::get('admin/delete-canals-{ref}', 'ServiceController@deletecanals')->name('deleteCa');

	// Service Soneb
	Route::get('/soneb-recu:reference-{refrecu}', 'ServiceController@getsonebrecu')->name('sonebrecu');
	Route::get('/services-soneb', 'ServiceController@getsonebservice')->name('sonebservice');
	Route::post('/soneb-recu', 'ServiceController@setsonebrecu')->name('sonebrecuS');
	Route::get('admin/delete-soneb-{ref}', 'ServiceController@deletesoneb')->name('deleteS');

	// Service SBEECARTE
	Route::get('/sbeecarte-recu:reference-{refrecu}', 'ServiceController@getsbeecarterecu')->name('sbeecarterecu');
	Route::get('/services-sbeecarte', 'ServiceController@getsbeecarteservice')->name('sbeecarteservice');
	Route::post('/sbeecarte-recu', 'ServiceController@setsbeecarterecu')->name('sbeecarterecuS');
	Route::get('admin/delete-sbeecarte-{ref}', 'ServiceController@deletesbeecarte')->name('deleteC');

	// Service SBEECONVENTIONNEL
	Route::get('/sbeeconventionnel-recu:reference-{refrecu}', 'ServiceController@getsbeeconventionnelrecu')->name('sbeeconventionnelrecu');
	Route::get('/services-sbeeconventionnel', 'ServiceController@getsbeeconventionnelservice')->name('sbeeconventionnelservice');
	Route::post('/sbeeconventionnel-recu', 'ServiceController@setsbeeconventionnelrecu')->name('sbeeconventionnelrecuS');
	Route::get('admin/delete-sbeeconventionnel-{ref}', 'ServiceController@deletesbeeconventionnel')->name('deleteCon');

	// Service MTN et MOOV
	Route::get('/services-mtnmoov', 'ServiceController@getmtnmoovservice')->name('mtnmoovservice');
	Route::post('/mtnmoov-recu', 'ServiceController@setmtnmoovrecu')->name('mtnmoovrecuS');
	Route::get('admin/delete-mtnmoov-{ref}', 'ServiceController@deletemtnmoov')->name('deleteS');
	
    

    ///////////////////////////////////////////////////////////////////////////////////////////////////////











    // Nouveau Client 
    ///////////////////////////////////////////////////////////////////////////////////////////////////////

	Route::post('/ajoutfilleul', 'MLMController@ajoutfilleul')->name('ajoutfilleul');
	Route::get('/ajoutfilleul', 'MLMController@getajoutfilleul')->name('ajoutfilleulG');

	///////////////////////////////////////////////////////////////////////////////////////////////////////	
















	// Service Client 
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    // Abonnement
	Route::post('/packs', 'DashboardClientController@setpack')->name('PackAbonnement');
	
	Route::get('/transfert', 'DashboardClientController@gettransfert')->name('transfert');
	Route::post('/transfert', 'DashboardClientController@settransfert')->name('transfertS');

	Route::get('/transfert-commissionsurvente-vers-gain-virtuel', 'DashboardClientController@getcvtovirtuel')->name('vte');
	Route::post('/transfert-commissionsurvente-vers-gain-virtuel', 'DashboardClientController@cvtovirtuel')->name('vteS');
	
	Route::get('/transfert-gain-commission-vente-vers-gain-espece', 'DashboardClientController@getconventiontoespece')->name('cte');
	Route::post('/transfert-gain-commission-vente-vers-gain-espece', 'DashboardClientController@conventiontoespece')->name('cteS');
	
	// Demande retrait
	Route::get('/retrait', 'DashboardClientController@getretrait')->name('retrait');
	
	Route::post('/retrait-mtn', 'DashboardClientController@setretraitmtn')->name('retraitmtnS');
	Route::post('/retrait-moov', 'DashboardClientController@setretraitmoov')->name('retraitmoovS');
	Route::post('/retrait-western', 'DashboardClientController@setretraitwestern')->name('retraitwesternS');
	Route::post('/retrait-gram', 'DashboardClientController@setretraitgram')->name('retraitgramS');
	Route::post('/retrait-perfect', 'DashboardClientController@setretraitperfect')->name('retraitperfectS');
	Route::post('/retrait-trust', 'DashboardClientController@setretraittrust')->name('retraittrustS');

	// Nature
	Route::get('/gain-nature', 'DashboardClientController@getnature')->name('nature');
	Route::get('/mes-gains-natures', 'DashboardClientController@getmesnatures')->name('mnature');

	Route::get('/profil', 'DashboardClientController@getprofil')->name('profil');
	Route::post('/profil', 'DashboardClientController@setprofil')->name('profilS');
	Route::post('/deconnexion', 'IndexController@sedeconnecter')->name('sedeconnecterS');
	Route::get('/dashboard', 'IndexController@clientdashboard')->name('dashboard');
	Route::get('/regle', 'IndexController@clientregle')->name('regle');
	Route::get('/formation', 'IndexController@clientformation')->name('formation');
	Route::post('/formation', 'IndexController@clientformationdelete')->name('formationS');
	Route::get('/gains', 'IndexController@clientgains')->name('gains');


	// Achat SSI 
	Route::post('/achat', 'DemandeClientController@setachat')->name('setac');

	// Demande de VISA 
    Route::post('/retraitvisa', 'DemandeClientController@setretraitvisa')->name('setSR');

	///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    // Opération Extra
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	Route::get('/genotp', 'OTPServiceController@sendotp')->name('genotp');

	///////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
    //------------------------------------------------------------------
    
    Route::get('/rechercher', 'IndexController@recherche')->name('search');
	Route::get('/code', 'IndexController@genecode')->name('genecode');
	/* Client */
	
	// Afficher demande retrait
	Route::get('/retraitmtn', 'RetraitController@getretraitmtn')->name('retraitmtn');
	Route::get('/retraitmoov', 'RetraitController@getretraitmoov')->name('retraitmoov');
	Route::get('/retraitwestern', 'RetraitController@getretraitwestern')->name('retraitwestern');
	Route::get('/retraitperfect', 'RetraitController@getretraitperfect')->name('retraitperfect');
	Route::get('/retraittrust', 'RetraitController@getretraittrust')->name('retraittrust');
	Route::get('/retraitgram', 'RetraitController@getretraitgram')->name('retraitgram');
	
	// Etablir recu
	Route::get('/mtn-recu:reference-{refrecu}', 'RetraitController@getrecumtn')->name('mtnrecu');
	Route::get('/moov-recu:reference-{refrecu}', 'RetraitController@getrecumoov')->name('moovrecu');
	Route::get('/perfect-recu:reference-{refrecu}', 'RetraitController@getrecuperfect')->name('perfectrecu');
	Route::get('/gram-recu:reference-{refrecu}', 'RetraitController@getrecugram')->name('gramrecu');
	Route::get('/trust-recu:reference-{refrecu}', 'RetraitController@getrecutrust')->name('trust');
	Route::get('/western-recu:reference-{refrecu}', 'RetraitController@getrecuwestern')->name('westernrecu');
	
	// Recu valider
	Route::post('/mtn-recu', 'RetraitController@setrecumtn')->name('mtnrecuS');
	Route::post('/moov-recu', 'RetraitController@setrecumoov')->name('moovrecuS');
	Route::post('/perfect-recu', 'RetraitController@setrecuperfect')->name('perfectrecuS');
	Route::post('/gram-recu', 'RetraitController@setrecugram')->name('gramrecuS');
	Route::post('/trust-recu', 'RetraitController@setrecutrust')->name('trustS');
	Route::post('/western-recu', 'RetraitController@setrecuwestern')->name('westernrecuS');
	
	// Delete Retrait
	Route::get('admin/delete-demanderetraitmtn-{ref}', 'RetraitController@deletemtn')->name('deleteMTN');
	Route::get('admin/delete-demanderetraitmoov-{ref}', 'RetraitController@deletemoov')->name('deleteMOOV');
	Route::get('admin/delete-demanderetraitwestern-{ref}', 'RetraitController@deletewesterns')->name('deletewestern');
	Route::get('admin/delete-demanderetraitgrams-{ref}', 'RetraitController@deletegrams')->name('deletegrams');
	Route::get('admin/delete-demanderetraitperfect-{ref}', 'RetraitController@deleteperfects')->name('deleteperfect');
	Route::get('admin/delete-demanderetraittrust-{ref}', 'RetraitController@deletetrust')->name('deleteTrust');
	
	Route::get('admin/historique', 'HistoriqueController@gethist')->name('histadmin');
	Route::get('admin/historique-client', 'HistoriqueController@getHistClientAuAdmin')->name('histadminclient');
	Route::get('historique', 'HistoriqueController@gethistclient')->name('histclient');


	/* Aministrateur */

	//Route::get('/mtnmoov-recu:reference-{refrecu}', 'IndexPrimeController@getmtnmoovrecu')->name('mtnmoovrecu');

	
	Route::get('/codeotp_v', 'IndexPrimeController@genecodeadminvirtuel')->name('genecodeV');
	Route::get('/codeotp_cv', 'IndexPrimeController@genecodeadmincv')->name('genecodeCV');
	Route::get('/admin/transfertgainvirtuel', 'IndexPrimeController@gettransfertgainvirtuel')->name('transfertgainvirtuel');
	Route::post('admin/transfertgainvirtuel', 'IndexPrimeController@settransfertgainvirtuel')->name('transfertgainvirtuelS');
	Route::get('/admin/prelevement_gainvirtuel', 'IndexPrimeController@getprelevementgainvirtuel')->name('prelevementgainvirtuel');
	Route::post('admin/prelevement_gainvirtuel', 'IndexPrimeController@setprelevementgainvirtuel')->name('prelevementgainvirtuelS');

/*
	Route::get('/longrich-recu:reference-{refrecu}', 'IndexPrimeController@getlongrichrecu')->name('longrichrecu');
	Route::get('/services-longrich', 'IndexPrimeController@getlongrichservice')->name('longrichservice');
	Route::post('/longrich-recu', 'IndexPrimeController@setlongrichrecu')->name('longrichrecuS');

	Route::get('/health-recu:reference-{refrecu}', 'IndexPrimeController@gethealthrecu')->name('healthrecu');
	Route::get('/services-health', 'IndexPrimeController@gethealthservice')->name('healthservice');
	Route::post('/health-recu', 'IndexPrimeController@sethealthrecu')->name('healthrecuS');

	Route::get('/longrichform', 'IndexPrimeController@getlongrichform')->name('longrichform');
	Route::post('/longrichform', 'IndexPrimeController@setlongrichform')->name('longrichformS');
	Route::get('/healthform', 'IndexPrimeController@gethealthform')->name('healthform');
	Route::post('/healthform', 'IndexPrimeController@sethealthform')->name('healthformS'); */

	Route::get('/admin/prelevement_commissionvente', 'IndexPrimeController@getprelevementcommissionvente')->name('prelevementCV');
	Route::post('/admin/prelevement_commissionvente', 'IndexPrimeController@setprelevementcommissionvente')->name('prelevementSCV');//fait
	Route::get('/admin/transfertadmin_commissionvente', 'IndexPrimeController@gettransfertadmincommissionvente')->name('transfertadminCV');
	Route::post('/admin/transfertadmin_commissionvente', 'IndexPrimeController@settransfertadmincommissionvente')->name('transfertadminSCV');
	
	Route::get('/admin/corbeille', 'CorbeilleController@getcorbeille')->name('corbeille');
	Route::get('/admin/restaurer/{ref}/{service}', 'CorbeilleController@setrestaurersoneb')->name('Scorbeille');
	Route::get('/admin/listecontact', 'IndexController@getlistecontact')->name('listecontact');
	Route::post('/admin/listecontact', 'IndexController@setlistecontact')->name('listecontactS');
	Route::get('/admin/repondre', 'IndexController@getrepondret')->name('repondre');
	Route::post('/admin/repondre', 'IndexController@setrepondre')->name('repondreS');
	Route::get('/admin/prelevement', 'IndexController@getprelevement')->name('prelevement');
	Route::post('/admin/prelevement', 'IndexController@setprelevement')->name('prelevementS');//fait
	Route::get('/admin/listeFilleuls', 'IndexController@listfilleuls')->name('listclient');
	Route::get('/admin/delete-Filleul-{id}', 'IndexController@deletefilleul')->name('deleteclient');
	Route::get('/codeotp', 'IndexController@genecodeadmin')->name('genecodeA');
	Route::get('/admin/transfertadmin', 'IndexController@gettransfertadmin')->name('transfertadmin');
	Route::post('/admin/transfertadmin', 'IndexController@settransfertadmin')->name('transfertadminS');
	Route::get('/admin/profiladmin', 'IndexController@getprofiladmin')->name('profiladmin');
	Route::post('admin/profiladmin', 'IndexController@setprofiladmin')->name('profiladminS');
	Route::get('/admin/dashboard', 'IndexController@admindashboard')->name('admin.dashboard');
	Route::post('/admin/ajoutfilleul', 'IndexController@ajoutfilleul')->name('nouveaufilleul');
	Route::get('/admin/ajoutfilleul', 'IndexController@getnouveaufilleul')->name('nouveaufilleulG');	
	Route::post('/admin/galerie', 'IndexController@setgalerie')->name('galerieS');
	Route::get('/admin/galerie', 'IndexController@getgalerie')->name('galerieG');
	Route::post('/admin/evernement', 'IndexController@setevernement')->name('evernementS');
	Route::get('/admin/evernement', 'IndexController@getevernement')->name('evernementG');
	Route::get('/accueil', 'IndexController@accueil')->name('admin.index');
	Route::get('/ajoutercours','IndexController@getajoutercours')->name('coursG');
	Route::post('/ajoutercours','IndexController@setajoutercours')->name('coursS');
	Route::post('/logout','IndexController@adminlogout')->name('admin.logout');
	Route::get('/logout','IndexController@adminlogout')->name('admin.logout');
	Route::get('/admin/activercompte', 'IndexController@activeraccount')->name('admin.active');


/*

    // Demande de $ SSI
    Route::post('/achat', 'ServiceController@setachat')->name('setac');
    Route::get('/demande-achat-$ssi', 'ServiceController@getdemandeachat')->name('achat$ssi');
    Route::get('/demande-servir-{id}', 'ServiceController@setservirachat')->name('achatservir');
    Route::get('/demande-echec-{id}', 'ServiceController@setechecachat')->name('achatechec');
    Route::get('/demande-supprimer-{id}', 'ServiceController@setdeleteachat')->name('deleteachat');
    
    // Demande de VISA 
    Route::post('/retraitvisa', 'ServiceController@setretraitvisa')->name('setSR');
    Route::get('/demande-visa', 'ServiceController@getdemandevisa')->name('getSRVISA');
    Route::get('/demande-visa-servir-{id}', 'ServiceController@setservirvisa')->name('Visaservir');
    Route::get('/demande-visa-echec-{id}', 'ServiceController@setechecvisa')->name('Visaechec');
    Route::get('/demande-visa-supprime-{id}', 'ServiceController@setdeletevisa')->name('Visadelete');
    
    //------------------------------------------------------------------
    
    Route::get('/rechercher', 'IndexController@recherche')->name('search');
	Route::get('/code', 'IndexController@genecode')->name('genecode');

	
	setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
    date_default_timezone_set('Africa/Porto-Novo');
                    
    $date1 = strftime('%d-%m-%Y');
                  
    $date2 = "25".strftime('-%m-%Y');
    $moisprochain = strftime('%m');
     $date3 = "1"."-".$moisprochain."-".strftime('%Y');
     $timestamp1 = strtotime($date1); 
     $timestamp2 = strtotime($date2);
     $timestamp3 = strtotime($date3);
     //if ($timestamp1 >= $timestamp2 || $timestamp1 == $timestamp3)
   // {
	// Demande retrait
	Route::get('/retrait', 'RetraitController@getretrait')->name('retrait');
	Route::post('/retrait', 'RetraitController@setretrait')->name('retraitS');

	Route::post('/retrait-mtn', 'RetraitController@setretraitmtn')->name('retraitmtnS');
	Route::post('/retrait-moov', 'RetraitController@setretraitmoov')->name('retraitmoovS');
	Route::post('/retrait-western', 'RetraitController@setretraitwestern')->name('retraitwesternS');
	Route::post('/retrait-gram', 'RetraitController@setretraitgram')->name('retraitgramS');
	Route::post('/retrait-perfect', 'RetraitController@setretraitperfect')->name('retraitperfectS');
	Route::post('/retrait-trust', 'RetraitController@setretraittrust')->name('retraittrustS');
   // }	
	// Afficher demande retrait
	Route::get('/retraitmtn', 'RetraitController@getretraitmtn')->name('retraitmtn');
	Route::get('/retraitmoov', 'RetraitController@getretraitmoov')->name('retraitmoov');
	Route::get('/retraitwestern', 'RetraitController@getretraitwestern')->name('retraitwestern');
	Route::get('/retraitperfect', 'RetraitController@getretraitperfect')->name('retraitperfect');
	Route::get('/retraittrust', 'RetraitController@getretraittrust')->name('retraittrust');
	Route::get('/retraitgram', 'RetraitController@getretraitgram')->name('retraitgram');
	
	// Etablir recu
	Route::get('/mtn-recu:reference-{refrecu}', 'RetraitController@getrecumtn')->name('mtnrecu');
	Route::get('/moov-recu:reference-{refrecu}', 'RetraitController@getrecumoov')->name('moovrecu');
	Route::get('/perfect-recu:reference-{refrecu}', 'RetraitController@getrecuperfect')->name('perfectrecu');
	Route::get('/gram-recu:reference-{refrecu}', 'RetraitController@getrecugram')->name('gramrecu');
	Route::get('/trust-recu:reference-{refrecu}', 'RetraitController@getrecutrust')->name('trust');
	Route::get('/western-recu:reference-{refrecu}', 'RetraitController@getrecuwestern')->name('westernrecu');
	
	// Recu valider
	Route::post('/mtn-recu', 'RetraitController@setrecumtn')->name('mtnrecuS');
	Route::post('/moov-recu', 'RetraitController@setrecumoov')->name('moovrecuS');
	Route::post('/perfect-recu', 'RetraitController@setrecuperfect')->name('perfectrecuS');
	Route::post('/gram-recu', 'RetraitController@setrecugram')->name('gramrecuS');
	Route::post('/trust-recu', 'RetraitController@setrecutrust')->name('trustS');
	Route::post('/western-recu', 'RetraitController@setrecuwestern')->name('westernrecuS');
	
	// Delete Retrait
	Route::get('admin/delete-demanderetraitmtn-{ref}', 'RetraitController@deletemtn')->name('deleteMTN');
	Route::get('admin/delete-demanderetraitmoov-{ref}', 'RetraitController@deletemoov')->name('deleteMOOV');
	Route::get('admin/delete-demanderetraitwestern-{ref}', 'RetraitController@deletewesterns')->name('deletewestern');
	Route::get('admin/delete-demanderetraitgrams-{ref}', 'RetraitController@deletegrams')->name('deletegrams');
	Route::get('admin/delete-demanderetraitperfect-{ref}', 'RetraitController@deleteperfects')->name('deleteperfect');
	Route::get('admin/delete-demanderetraittrust-{ref}', 'RetraitController@deletetrust')->name('deleteTrust');
	
	Route::get('admin/historique', 'HistoriqueController@gethist')->name('histadmin');
	Route::get('admin/historique-client', 'HistoriqueController@getHistClientAuAdmin')->name('histadminclient');
	Route::get('historique', 'HistoriqueController@gethistclient')->name('histclient');


	// Delete  Service
	Route::get('admin/delete-soneb-{ref}', 'IndexPrimeController@deletesoneb')->name('deleteS');
	Route::get('admin/delete-sbeeconventionnel-{ref}', 'IndexPrimeController@deletesbeeconventionnel')->name('deleteCon');
	Route::get('admin/delete-sbeecarte-{ref}', 'IndexPrimeController@deletesbeecarte')->name('deleteC');
	Route::get('admin/delete-canals-{ref}', 'IndexPrimeController@deletecanals')->name('deleteCa');
	Route::get('admin/delete-mtnmoov-{ref}', 'IndexPrimeController@deletemtnmoov')->name('deleteS');
   
	
	Route::get('/transfert-gain-commission-vente-vers-gain-espece', 'RetraitController@getconventiontoespece')->name('cte');
	Route::post('/transfert-gain-commission-vente-vers-gain-espece', 'RetraitController@conventiontoespece')->name('cteS');
	Route::get('/generer-code-transfert-gain-commission-vente-vers-gain-espece', 'RetraitController@gencodece')->name('genct');

	Route::get('/transfert-commissionsurvente-vers-gain-virtuel', 'RetraitController@getcvtoespece')->name('vte');
	Route::post('/transfert-commissionsurvente-vers-gain-virtuel', 'RetraitController@cvtoespece')->name('vteS');
	Route::get('/generer-code-transfert-commissionsurvente-vers-gain-virtuel', 'RetraitController@gencodeve')->name('genvte'); 
	
	
	Route::get('/transfert', 'IndexController@gettransfert')->name('transfert');
	Route::post('/transfert', 'IndexController@settransfert')->name('transfertS');
	Route::get('/profil', 'IndexController@getprofil')->name('profil');
	Route::post('/profil', 'IndexController@setprofil')->name('profilS');
	Route::post('/deconnexion', 'IndexController@sedeconnecter')->name('sedeconnecterS');
	Route::get('/dashboard', 'IndexController@clientdashboard')->name('dashboard');
	Route::get('/regle', 'IndexController@clientregle')->name('regle');
	Route::get('/formation', 'IndexController@clientformation')->name('formation');
	Route::post('/formation', 'IndexController@clientformationdelete')->name('formationS');
	
	Route::get('/Etape1', 'IndexController@clientmesfilleuls')->name('mesfilleuls');
	Route::get('/Etape2', 'IndexController@clientmesfilleuls2')->name('mesfilleuls2');
	Route::get('/Etape3', 'IndexController@clientmesfilleuls3')->name('mesfilleuls3');
	Route::get('/Etape4', 'IndexController@clientmesfilleuls4')->name('mesfilleuls4');
	Route::get('/Etape5', 'IndexController@clientmesfilleuls5')->name('mesfilleuls5');
	Route::get('/Etape6', 'IndexController@clientmesfilleuls6')->name('mesfilleuls6');
	Route::get('/Etape7', 'IndexController@clientmesfilleuls7')->name('mesfilleuls7');
	Route::get('/Etape8', 'IndexController@clientmesfilleuls8')->name('mesfilleuls8');
	

	Route::get('/gains', 'IndexController@clientgains')->name('gains');
	Route::post('/ajoutfilleul', 'IndexController@ajoutfilleul')->name('ajoutfilleul');
	Route::get('/ajoutfilleul', 'IndexController@getajoutfilleul')->name('ajoutfilleulG');

	/* Aministrateur 
	Route::get('/soneb-recu:reference-{refrecu}', 'IndexPrimeController@getsonebrecu')->name('sonebrecu');
	Route::get('/services-soneb', 'IndexPrimeController@getsonebservice')->name('sonebservice');
	Route::post('/soneb-recu', 'IndexPrimeController@setsonebrecu')->name('sonebrecuS');
	
	Route::get('/sbeecarte-recu:reference-{refrecu}', 'IndexPrimeController@getsbeecarterecu')->name('sbeecarterecu');
	Route::get('/services-sbeecarte', 'IndexPrimeController@getsbeecarteservice')->name('sbeecarteservice');
	Route::post('/sbeecarte-recu', 'IndexPrimeController@setsbeecarterecu')->name('sbeecarterecuS');


	Route::get('/sbeeconventionnel-recu:reference-{refrecu}', 'IndexPrimeController@getsbeeconventionnelrecu')->name('sbeeconventionnelrecu');
	Route::get('/services-sbeeconventionnel', 'IndexPrimeController@getsbeeconventionnelservice')->name('sbeeconventionnelservice');
	Route::post('/sbeeconventionnel-recu', 'IndexPrimeController@setsbeeconventionnelrecu')->name('sbeeconventionnelrecuS');

	Route::get('/canal-recu:reference-{refrecu}', 'IndexPrimeController@getcanalrecu')->name('canalrecu');
	Route::get('/services-canal', 'IndexPrimeController@getcanalservice')->name('canalservice');
	Route::post('/canal-recu', 'IndexPrimeController@setcanalrecu')->name('canalrecuS');
	
	Route::get('/longrich-recu:reference-{refrecu}', 'IndexPrimeController@getlongrichrecu')->name('longrichrecu');
	Route::get('/services-longrich', 'IndexPrimeController@getlongrichservice')->name('longrichservice');
	Route::post('/longrich-recu', 'IndexPrimeController@setlongrichrecu')->name('longrichrecuS');

	Route::get('/health-recu:reference-{refrecu}', 'IndexPrimeController@gethealthrecu')->name('healthrecu');
	Route::get('/services-health', 'IndexPrimeController@gethealthservice')->name('healthservice');
	Route::post('/health-recu', 'IndexPrimeController@sethealthrecu')->name('healthrecuS');

	//Route::get('/mtnmoov-recu:reference-{refrecu}', 'IndexPrimeController@getmtnmoovrecu')->name('mtnmoovrecu');
	Route::get('/services-mtnmoov', 'IndexPrimeController@getmtnmoovservice')->name('mtnmoovservice');
	Route::post('/mtnmoov-recu', 'IndexPrimeController@setmtnmoovrecu')->name('mtnmoovrecuS');

	
	Route::get('/codeotp_v', 'IndexPrimeController@genecodeadminvirtuel')->name('genecodeV');
	Route::get('/codeotp_cv', 'IndexPrimeController@genecodeadmincv')->name('genecodeCV');
	Route::get('/admin/transfertgainvirtuel', 'IndexPrimeController@gettransfertgainvirtuel')->name('transfertgainvirtuel');
	Route::post('admin/transfertgainvirtuel', 'IndexPrimeController@settransfertgainvirtuel')->name('transfertgainvirtuelS');
	Route::get('/admin/prelevement_gainvirtuel', 'IndexPrimeController@getprelevementgainvirtuel')->name('prelevementgainvirtuel');
	Route::post('admin/prelevement_gainvirtuel', 'IndexPrimeController@setprelevementgainvirtuel')->name('prelevementgainvirtuelS');

	Route::get('/longrichform', 'IndexPrimeController@getlongrichform')->name('longrichform');
	Route::post('/longrichform', 'IndexPrimeController@setlongrichform')->name('longrichformS');
	Route::get('/healthform', 'IndexPrimeController@gethealthform')->name('healthform');
	Route::post('/healthform', 'IndexPrimeController@sethealthform')->name('healthformS');

	Route::get('/admin/prelevement_commissionvente', 'IndexPrimeController@getprelevementcommissionvente')->name('prelevementCV');
	Route::post('/admin/prelevement_commissionvente', 'IndexPrimeController@setprelevementcommissionvente')->name('prelevementSCV');//fait
	Route::get('/admin/transfertadmin_commissionvente', 'IndexPrimeController@gettransfertadmincommissionvente')->name('transfertadminCV');
	Route::post('/admin/transfertadmin_commissionvente', 'IndexPrimeController@settransfertadmincommissionvente')->name('transfertadminSCV');
	
	Route::get('/admin/corbeille', 'CorbeilleController@getcorbeille')->name('corbeille');
	Route::get('/admin/restaurer/{ref}/{service}', 'CorbeilleController@setrestaurersoneb')->name('Scorbeille');
	
	Route::get('/admin/listecontact', 'IndexController@getlistecontact')->name('listecontact');
	Route::post('/admin/listecontact', 'IndexController@setlistecontact')->name('listecontactS');
	Route::get('/admin/repondre', 'IndexController@getrepondret')->name('repondre');
	Route::post('/admin/repondre', 'IndexController@setrepondre')->name('repondreS');
	Route::get('/admin/prelevement', 'IndexController@getprelevement')->name('prelevement');
	Route::post('/admin/prelevement', 'IndexController@setprelevement')->name('prelevementS');//fait
	Route::get('/admin/listeFilleuls', 'IndexController@listfilleuls')->name('listclient');
	Route::get('/admin/delete-Filleul-{id}', 'IndexController@deletefilleul')->name('deleteclient');
	Route::get('/codeotp', 'IndexController@genecodeadmin')->name('genecodeA');
	Route::get('/admin/transfertadmin', 'IndexController@gettransfertadmin')->name('transfertadmin');
	Route::post('/admin/transfertadmin', 'IndexController@settransfertadmin')->name('transfertadminS');
	Route::get('/admin/profiladmin', 'IndexController@getprofiladmin')->name('profiladmin');
	Route::post('admin/profiladmin', 'IndexController@setprofiladmin')->name('profiladminS');
	Route::get('/admin/dashboard', 'IndexController@admindashboard')->name('admin.dashboard');
	Route::post('/admin/ajoutfilleul', 'IndexController@ajoutfilleul')->name('nouveaufilleul');
	Route::get('/admin/ajoutfilleul', 'IndexController@getnouveaufilleul')->name('nouveaufilleulG');	
	Route::post('/admin/galerie', 'IndexController@setgalerie')->name('galerieS');
	Route::get('/admin/galerie', 'IndexController@getgalerie')->name('galerieG');
	Route::post('/admin/evernement', 'IndexController@setevernement')->name('evernementS');
	Route::get('/admin/evernement', 'IndexController@getevernement')->name('evernementG');
	Route::get('/accueil', 'IndexController@accueil')->name('admin.index');
	Route::get('/ajoutercours','IndexController@getajoutercours')->name('coursG');
	Route::post('/ajoutercours','IndexController@setajoutercours')->name('coursS');
	Route::post('/logout','IndexController@adminlogout')->name('admin.logout');
	Route::get('/logout','IndexController@adminlogout')->name('admin.logout');
	Route::get('/admin/activercompte', 'IndexController@activeraccount')->name('admin.active');*/
});