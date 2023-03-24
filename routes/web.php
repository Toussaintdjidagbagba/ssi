<?php
Route::get('/upd', 'DashboardClientController@updatepv')->name('oup');

/*Site */
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


Route::get('/mails','MLMController@test')->name('tesmaol');

Route::get('/', 'MLMController@index')->name('index');
Route::get('/index', 'MLMController@index')->name('index');
Route::get('/article-{id}', 'MLMController@affichearticle')->name('article');

Route::get('/galerie','MLMController@galerie')->name('galerie');
Route::get('/evernement','MLMController@evernement')->name('evernement');
Route::get('/propos', 'MLMController@propos')->name('propos');
Route::get('/contact','MLMController@contact')->name('contact');

Route::post('/contact','MLMController@setcontact')->name('contactS');
Route::get('/maint', function()
{
	return view('vendor.error.100');
});


Route::get('/politique', function(){
  return view('mlm.polique');      
})->name('politique');


//////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* Visiteur Authentification */
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/connexion', 'AuthentificationClientController@seconnecter')->name('seconnecter');
Route::post('/connexion', 'AuthentificationClientController@saveseconnecter')->name('seconnecterS');
Route::get('/inscription', 'AuthentificationClientController@inscription')->name('inscription');
Route::get('/inscription-monsponsor-{parrain}', 'AuthentificationClientController@inscriptionlink')->name('inscriptionlink');
Route::post('/inscription', 'AuthentificationClientController@saveinscription')->name('inscriptionS');
Route::get('/validerpayement', 'AuthentificationClientController@validerpayement')->name('validerpayement');
Route::post('/validerpayement', 'AuthentificationClientController@traitementpayement')->name('validerpayementT');

Route::get('/reinitialisation', 'AuthentificationClientController@getfogot')->name('fogot');
Route::post('/reinitialisation', 'AuthentificationClientController@fogot')->name('fogotR');

Route::get('/otpreini', 'OTPServiceController@sendotpreinitia')->name('genotpreini');
Route::get('/otpreiniset', 'OTPServiceController@setotpreinitia')->name('setotpreini');
Route::get('/reiniset', 'OTPServiceController@setreinitia')->name('setreini');
Route::get('/checkpseudo', 'OTPServiceController@checkpseudo')->name('setcheckpseudo');
Route::get('/checkpv', 'OTPServiceController@checkpv')->name('setcheckpv');


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

Route::get('/celtiis', 'DemandeClientController@getceltiis')->name('celttisb');
Route::post('/celtiis', 'DemandeClientController@setceltiis')->name('celttisS');

Route::get('/moov', 'DemandeClientController@getmoov')->name('moov');
Route::post('/moov', 'DemandeClientController@setmoov')->name('moovS');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////


Route::get('/validerinscription-{id}', 'IndexController@valideinscription')->name('valideinscription');
Route::post('/validerinscription', 'IndexController@traitementinscription')->name('valideinscriptionT');
Route::post('/valideparrain', 'IndexController@continueinscription')->name('valideParrain');



Route::get('/boutique-ssi', 'BoutiqueController@getboutique')->name('boutique');
Route::get('/paiement-{id}', 'BoutiqueController@paiementarticle')->name('paiementarticle');

Route::group([
	'middleware' => 'App\Http\Middleware\Auth' 

], function(){
    
	// Service Client 
    ///////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('/deconnexionnclient', 'DashboardClientController@logout')->name('client.logout');
	
	// Abonnement
	Route::post('/packs', 'DashboardClientController@setpack')->name('PackAbonnement');

	Route::get('/transfert', 'DashboardClientController@gettransfert')->name('transfert');
	Route::post('/transfert', 'DashboardClientController@settransfert')->name('transfertS');
	
	Route::get('/transfertgv', 'DashboardClientController@gettransfertgv')->name('transfertgv');
	Route::post('/transfertgv', 'DashboardClientController@settransfertgv')->name('transfertgvS');

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
	Route::post('/deconnexion', 'DashboardClientController@sedeconnecter')->name('sedeconnecterS');
	Route::get('/dashboard', 'DashboardClientController@clientdashboard')->name('dashboard');
	Route::get('/filleul-client', 'DashboardClientController@filleulclient')->name('dfc');
	Route::get('/filleul-vendeur', 'DashboardClientController@filleulvendeur')->name('dfv');
	Route::get('/regle', 'DashboardClientController@clientregle')->name('regle');
	Route::get('/formation', 'DashboardClientController@clientformation')->name('formation');
	Route::post('/formation', 'DashboardClientController@clientformationdelete')->name('formationS');
	Route::get('/gains', 'DashboardClientController@clientgains')->name('gains');

    // Achat SSI depuis un point de vente
    Route::get('/achat-ssi-point-de-vente', 'DashboardClientController@achatssipv')->name('aspv');
    Route::post('/achat-ssi-point-de-vente', 'DashboardClientController@setachatssipv')->name('saspv');
    
    // Retraire SSI depuis un point de vente
    Route::get('/retrait-ssi-point-de-vente', 'DashboardClientController@retraitssipv')->name('rspv');
    Route::post('/retrait-ssi-point-de-vente', 'DashboardClientController@setretraitssipv')->name('srspv');
    
    // Opération SSI Point de vente
    Route::get('operation-ssi', 'DashboardClientController@getopp')->name('oppssi');
    Route::post('operation-ssi', 'DashboardClientController@setopp')->name('soppssi');
    Route::post('supprimer-operation-ssi', 'DashboardClientController@delopp')->name('doppssi');

	// Achat SSI 
	Route::post('/achat', 'DemandeClientController@setachat')->name('setac');
	
	// Nsia vie
	Route::post('/nsia-gbodjekwo', 'DemandeClientController@setnsiagbodjekwo')->name('setng');

    // Nsia non vie
	Route::get('/nsia-automobile', 'DashboardClientController@getnonvieass')->name('getna');
	Route::post('/nsia-automobie', 'DashboardClientController@setnonvieass')->name('setna');
	Route::post('/validation-nsia-automobie', 'DashboardClientController@setnonvieassval')->name('setnaval');

	// Demande de VISA
    Route::post('/retraitvisa', 'DemandeClientController@setretraitvisa')->name('setSR');

    // Historique dans compte client
    Route::get('historique', 'HistoriqueController@gethistclient')->name('histclient');

	///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    // Opération Extra
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	Route::get('/genotp', 'OTPServiceController@sendotp')->name('genotp');
	
	Route::get('/verifdestinataire-{id}', 'OTPServiceController@verfdest')->name('verfdest');

	///////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
    //------------------------------------------------------------------
    
    
	Route::get('/code', 'IndexController@genecode')->name('genecode');
});































 




Route::get('/cach',function () 
{
    Artisan::call('Config:cache');
});

Route::get('/level-connexion', 'LoginController@login')->name('login');
Route::post('/level-connexion', 'LoginController@authenticate')->name('loginS');

Route::fallback(function() {
   return view('vendor.error.404');
});

Route::group([
    'middleware' => 'App\Http\Middleware\Autorisation' 
 
], function(){
	Route::get('/mot-de-passe-oublié', 'LoginController@passmodif')->name('pass');
	Route::get('/deconnexionn', 'LoginController@logout')->name('logout');

	Route::get('/admin/profiladmin', 'LoginController@getprofiladmin')->name('profiladmin');
	Route::post('admin/profiladmin', 'LoginController@setprofiladmin')->name('profiladminS');
	
	//////////////////////////////////** Message **/////////////////////////////////////////////////////////////////
	Route::get('/listmessages', 'MessageController@getme')->name('GMI');
	Route::post('/listmessages', 'MessageController@setme')->name('MeI_add');
	Route::get('/delete-messages-{id}', 'MessageController@delme')->name('DMI');
	Route::get('/modif-messages-{id}', 'MessageController@getmodifme')->name('MTMI');
	Route::post('/modif-messages', 'MessageController@setmodifme')->name('SMLI');
	
	///////////////////////////////////** Utilisateur **///////////////////////////////////////////////////////////

	Route::get('/dashboardadmin', 'GestionnaireController@dash')->name('dashboardadm');
	Route::get('/utilisateur', 'UtilisateurController@getuser')->name('GU');
	Route::post('/utilisateur', 'UtilisateurController@adduser')->name('setuser');
	Route::get('/delete-utilisateur-{id}', 'UtilisateurController@deleteuser')->name('DU');
	Route::get('/reinitialiser-utilisateur-{id}', 'UtilisateurController@reinitialiseruser')->name('RU');
	Route::get('/desactivé-utilisateur-{id}', 'UtilisateurController@desactiveuser')->name('DSU');
	Route::get('/activé-utilisateur-{id}', 'UtilisateurController@activeuser')->name('ATU');
	Route::get('/modif-utilisateur-{id}', 'UtilisateurController@getmodifyuser')->name('MTU');
	Route::post('/modif-utilisateur', 'UtilisateurController@modifyuser')->name('MTUS');

	//////////////////////////////////** Rôle **/////////////////////////////////////////////////////////////////
	Route::get('/listroles', 'RoleController@listrole')->name('GR');
	Route::post('/roles', 'RoleController@addrole')->name('AR');
	Route::get('/modif-roles-{id}', 'RoleController@getmodifrole')->name('MTR');
	Route::get('/delete-roles-{id}', 'RoleController@deleterole')->name('DR');
	Route::get('/menu-roles-{id}', 'RoleController@getmenurole')->name('MRR');
	Route::post('/menu-roles', 'RoleController@setmenurole')->name('MenuAttr');
	Route::post('/modif-roles', 'RoleController@modifrole')->name('SRL');

	//////////////////////////////////** Menu **/////////////////////////////////////////////////////////////////
	Route::get('/listmenus', 'MenuController@getmenu')->name('GM');
	Route::post('/listmenus', 'MenuController@setmenu')->name('Menu_add');
	Route::get('/delete-menu-{id}', 'MenuController@delmenu')->name('DM');
	Route::get('/modif-menu-{id}', 'MenuController@getmodifmenu')->name('MTM');
	Route::post('/modif-menu', 'MenuController@setmodifmenu')->name('SML');
	Route::post('/action-menu', 'MenuController@setactionmenu')->name('Actionsave');
	Route::get('/action-menu-{id}', 'MenuController@getactionmenu')->name('ActionGet');


	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// Opération Extra
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	Route::get('/genotp-admin', 'OTPServiceController@sendotp')->name('genotp-admin');

	///////////////////////////////////////////////////////////////////////////////////////////////////////


    // Nouveau Admin
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    Route::get('/utilisateurs', 'ParametreController@dash_user')->name('NU');

    Route::get('/updateEtape', 'AutreController@updateEtape')->name('upd');


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
    Route::get('/canal-{refrecu}', 'ServiceController@getcanalrecu')->name('canalrecu');
	Route::get('/services-canal', 'ServiceController@getcanalservice')->name('canalservice');
	Route::post('/canal-recu', 'ServiceController@setcanalrecu')->name('canalrecuS');
	Route::get('/deleteCanals-{ref}', 'ServiceController@deletecanals')->name('deleteCa');

	// Service Soneb
	Route::get('/soneb-{refrecu}', 'ServiceController@getsonebrecu')->name('sonebrecu');
	Route::get('/services-soneb', 'ServiceController@getsonebservice')->name('sonebservice');
	Route::post('/soneb-recu', 'ServiceController@setsonebrecu')->name('sonebrecuS');
	Route::get('/sonebd-{ref}', 'ServiceController@deletesoneb')->name('deleteSoneb');
	Route::post('/sonebrejet', 'ServiceController@rejetsoneb')->name('rejetSoneb');

	// Service SBEECARTE
	Route::get('/sbeecarte-{refrecu}', 'ServiceController@getsbeecarterecu')->name('sbeecarterecu');
	Route::get('/services-sbeecarte', 'ServiceController@getsbeecarteservice')->name('sbeecarteservice');
	Route::post('/sbeecarte-recu', 'ServiceController@setsbeecarterecu')->name('sbeecarterecuS');
	Route::get('/deleteSCa-{ref}', 'ServiceController@deletesbeecarte')->name('deleteC');

	// Service SBEECONVENTIONNEL
	Route::get('/sbeeconventionnel-{refrecu}', 'ServiceController@getsbeeconventionnelrecu')->name('sbeeconventionnelrecu');
	Route::get('/services-sbeeconventionnel', 'ServiceController@getsbeeconventionnelservice')->name('sbeeconventionnelservice');
	Route::post('/sbeeconventionnel-recu', 'ServiceController@setsbeeconventionnelrecu')->name('sbeeconventionnelrecuS');
	Route::get('/deleteSC-{ref}', 'ServiceController@deletesbeeconventionnel')->name('deleteCon');

	// Service MTN et MOOV
	Route::get('/services-mtnmoov', 'ServiceController@getmtnmoovservice')->name('mtnmoovservice');
	Route::get('/mtnmoovrecu-{id}', 'ServiceController@setmtnmoovrecu')->name('mtnmoovrecuS');
	Route::get('/deletemtnmoov-{ref}', 'ServiceController@deletemtnmoov')->name('deleteS');
	
	// Service NSIA
	Route::get('/services-nsia', 'ServiceController@getnsiaservice')->name('nsiaservice');
	Route::get('/deletensia-{ref}', 'ServiceController@deletensia')->name('deleteNSIA');
	Route::post('/validation-automobile', 'ServiceController@vautonsia')->name('nsiaserviceV');
	Route::post('/montant-automobile', 'ServiceController@mautonsia')->name('nsiaserviceM');
	Route::get('/services-nsia-vie', 'ServiceController@getnsiagservice')->name('nsiavieservice');
	Route::post('/validation-gbodjekwo', 'ServiceController@setnsiagservice')->name('nsiavieserviceV');
	Route::get('/deletensiavie-{ref}', 'ServiceController@deletensiavie')->name('deleteNSIAVie');

	// Formation
	Route::get('/ajoutercours','ServiceController@getajoutercours')->name('coursG');
	Route::post('/ajoutercours','ServiceController@setajoutercours')->name('coursS');
	
	// Agences
	Route::get('/ajouteragence','ServiceController@getagence')->name('coursAg');
	Route::post('/ajouteragence','ServiceController@setagence')->name('coursAgS');
	Route::get('/modifagence-{id}','ServiceController@getmodifagence')->name('coursMg');
	Route::post('/modifagence','ServiceController@setmodifagence')->name('coursSMg');
	Route::get('/supprimeragence-{id}','ServiceController@deleteagence')->name('coursSAg');


	// Activaction filleul
	Route::get('/admin/activercompte', 'ServiceController@activeraccount')->name('admin.active'); 
	Route::post('/activer', 'ServiceController@validefilleulinscription')->name('activer');
	
	// Opération MLM : Transfert vers un compte filleul
	Route::get('/admin/transfertadmin', 'OperationMLM@gettransfertadmin')->name('transfertadmin');
	Route::post('/admin/transfertadmin', 'OperationMLM@settransfertadmin')->name('transfertadminS');

	// Opération MLM : Retrait du compte filleul
	Route::get('/admin/prelevement', 'OperationMLM@getprelevement')->name('prelevement');
	Route::post('/admin/prelevement', 'OperationMLM@setprelevement')->name('prelevementS');

	// Opération MLM : Transfert vers commission vente de filleul
	Route::get('/admin/transfertadmin_commissionvente', 'OperationMLM@gettransfertadmincommissionvente')->name('transfertadminCV');
	Route::post('/admin/transfertadmin_commissionvente', 'OperationMLM@settransfertadmincommissionvente')->name('transfertadminSCV');

	// Opération MLM : Retrait de commission vente de filleul
	Route::get('/admin/prelevement_commissionvente', 'OperationMLM@getprelevementcommissionvente')->name('prelevementCV');
	Route::post('/admin/prelevement_commissionvente', 'OperationMLM@setprelevementcommissionvente')->name('prelevementSCV');

	// Opération MLM : Transfert vers gain virtuel de filleul
	Route::get('/admin/transfertgainvirtuel', 'OperationMLM@gettransfertgainvirtuel')->name('transfertgainvirtuel');
	Route::post('admin/transfertgainvirtuel', 'OperationMLM@settransfertgainvirtuel')->name('transfertgainvirtuelS');

	// Opération MLM : Retrait de gain virtuel de filleul
	Route::get('/admin/prelevement_gainvirtuel', 'OperationMLM@getprelevementgainvirtuel')->name('prelevementgainvirtuel');
	Route::post('admin/prelevement_gainvirtuel', 'OperationMLM@setprelevementgainvirtuel')->name('prelevementgainvirtuelS');

	// Opération MLM : Historique admin
	Route::get('admin/historique', 'HistoriqueController@gethist')->name('histadmin');

	// Opération MLM : Historique des clients
	Route::get('admin/historique-client', 'HistoriqueController@getHistClientAuAdmin')->name('histadminclient');

	// Retrait MTN
	Route::get('/retraitmtn', 'RetraitController@getretraitmtn')->name('retraitmtn');
	Route::get('/mtnrecu-{refrecu}', 'RetraitController@getrecumtn')->name('mtnrecu');
	Route::post('/mtn-recu', 'RetraitController@setrecumtn')->name('mtnrecuS');
	Route::get('/delete-demanderetraitmtn-{ref}', 'RetraitController@deletemtn')->name('deleteMTN');
    
	// Retrait GRAM
	Route::get('/retraitgram', 'RetraitController@getretraitgram')->name('retraitgram');
	Route::get('/gramrecu-{refrecu}', 'RetraitController@getrecugram')->name('gramrecu');
	Route::post('/gram-recu', 'RetraitController@setrecugram')->name('gramrecuS');
	Route::get('/delete-demanderetraitgrams-{ref}', 'RetraitController@deletegrams')->name('deletegrams');

	// Retrait MOOV
	Route::get('/retraitmoov', 'RetraitController@getretraitmoov')->name('retraitmoov');
	Route::get('/moovrecu-{refrecu}', 'RetraitController@getrecumoov')->name('moovrecu');
	Route::post('/moov-recu', 'RetraitController@setrecumoov')->name('moovrecuS');
	Route::get('/delete-demanderetraitmoov-{ref}', 'RetraitController@deletemoov')->name('deleteMOOV');

	// Retrait Perfect
    Route::get('/retraitperfect', 'RetraitController@getretraitperfect')->name('retraitperfect');
    Route::get('/perfectrecu-{refrecu}', 'RetraitController@getrecuperfect')->name('perfectrecu');
    Route::post('/perfect-recu', 'RetraitController@setrecuperfect')->name('perfectrecuS');
    Route::get('/delete-demanderetraitperfect-{ref}', 'RetraitController@deleteperfects')->name('deleteperfect');

    // Retrait Trust
    Route::get('/retraittrust', 'RetraitController@getretraittrust')->name('retraittrust');
    Route::get('/trustrecu-{refrecu}', 'RetraitController@getrecutrust')->name('trust');
    Route::post('/trust-recu', 'RetraitController@setrecutrust')->name('trustS');
    Route::get('/delete-demanderetraittrust-{ref}', 'RetraitController@deletetrust')->name('deleteTrust');

    // Retrait Western
    Route::get('/retraitwestern', 'RetraitController@getretraitwestern')->name('retraitwestern');
    Route::get('/westernrecu-{refrecu}', 'RetraitController@getrecuwestern')->name('westernrecu');
	Route::post('/western-recu', 'RetraitController@setrecuwestern')->name('westernrecuS');
	Route::get('/delete-demanderetraitwestern-{ref}', 'RetraitController@deletewesterns')->name('deletewestern');
	
	// Parametre Galerie
	Route::post('/admin-galerie', 'ParametreController@setgalerie')->name('galerieS');
	Route::get('/admin-galerie', 'ParametreController@getgalerie')->name('galerieG');

	// Parametre evernement
	Route::post('/admin-evernement', 'ParametreController@setevernement')->name('evernementS');
	Route::get('/admin-evernement', 'ParametreController@getevernement')->name('evernementG');

	// Parametre Contact
	Route::get('/listecontact', 'ParametreController@getlistecontact')->name('listecontact');
	Route::get('/listecontact-{id}', 'ParametreController@setlistecontact')->name('listecontactS');
	Route::post('/admin-repondre', 'ParametreController@setrepondre')->name('repondreS');

	// Liste des filleuls

    Route::get('/admin-modifie-client-{id}', 'GestionnaireController@getfilleul')->name('gclient');
    Route::post('/admin-modifie-client', 'GestionnaireController@setfilleul')->name('Sclient');
	Route::get('/admin-listeFilleuls', 'GestionnaireController@listfilleuls')->name('listclient');
	Route::get('/admin-listeFilleuls-vendeur', 'GestionnaireController@listfilleulsvendeur')->name('listvendeur');
	Route::get('/admin-delete-Filleul-{id}', 'GestionnaireController@deletefilleul')->name('deleteclient');
	Route::get('/admin-rechercher', 'GestionnaireController@recherche')->name('search');
	Route::get('/admin-rechercher-vendeur', 'GestionnaireController@recherchevendeur')->name('searchv');
	
	Route::get('/valideprofil', 'GestionnaireController@validefilleul')->name('vpl');


    ///////////////////////////////////////////////////////////////////////////////////////////////////////
	
	


});