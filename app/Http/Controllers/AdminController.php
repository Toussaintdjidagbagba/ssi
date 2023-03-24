<?php

namespace App\Http\Controllers;
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
use App\Equipe;
use App\Systemadmin;
use App\Translationuser;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

	//public function __construct()
    //{
        
    //}

	public static function mon_parrain($id)
    {
        return DB::table('users')->select('parrain')->where('id', $id)->get()[0]->parrain;
    }

    public static function id_mon_parrain($codeunique)
    {
    	//if(!isset(DB::table('users')->select('id')->where('codeunique', $codeunique)->get()[0]->id))
    	
        return DB::table('users')->select('id')->where('codeunique', $codeunique)->get()[0]->id;  
    }

    public static function id_mon_parraingauche($codeperso)
    {
    	return DB::table('users')->select('id')->where('codeperso', $codeperso)->get()[0]->id;
    }
    
	public static function id_mon_parraindroite($codeperso)
	{
		return DB::table('users')->select('id')->where('codeperso', $codeperso)->get()[0]->id;
	}

    public static function id($codeperso)
    {
    	return DB::table('users')->select('id')->where('codeperso', $codeperso)->get()[0]->id;
    }

    public static function EquipeParrain($id_parrain)
    {
    	$etape_pa = DB::table('niveaux')->select('id_etape')->where('id_user', $id_parrain)->get()[0]->id_etape;
    	return DB::table('niveaux')->select('id_equipe')
    			->where('id_user', $id_parrain)
    			->where('id_etape', $etape_pa)
    			->get()[0]->id_equipe; 
    }

    public static function V_Gauche($id_parrain, $equipeparrain)
    {
    	$etape_pa = DB::table('niveaux')->select('id_etape')->where('id_user', $id_parrain)->get()[0]->id_etape;
    	$rec = DB::table('niveaux')
    			->select('PositionGauche')
    			->where('id_user', $id_parrain)
    			->where('id_etape', $etape_pa)
    			->where('id_equipe', $equipeparrain)
    			->get()[0]->PositionGauche;

    	if ($rec == "A") {
    		return "oui";
    	}
    	else
    	{
    		return $rec;
    	}
    }

    public static function V_Droite($id_parrain, $equipeparrain)
    {
    	$etape_pa = DB::table('niveaux')->select('id_etape')->where('id_user', $id_parrain)->get()[0]->id_etape;
    	$rec = DB::table('niveaux')
    			->select('PositionDroite')
    			->where('id_user', $id_parrain)
    			->where('id_etape', $etape_pa)
    			->where('id_equipe', $equipeparrain)
    			->get()[0]->PositionDroite;

    	if ($rec == "A") {
    		return "oui";
    	}
    	else
    	{
    		return $rec;
    	}
    }

    public static function P_Gauche($id_parrain, $equipeparrain)
    {
    	return DB::table('niveaux')
    				->select('PositionGauche')
    				->where('id_user', $id_parrain)
    				->where('id_equipe', $equipeparrain)
    				->get()[0]->PositionGauche;
    }

    public static function P_Droite($id_parrain, $equipeparrain)
    {
    	return DB::table('niveaux')
    				->select('PositionDroite')
    				->where('id_user', $id_parrain)
    				->where('id_equipe', $equipeparrain)
    				->get()[0]->PositionDroite;
    }

    public static function parrainfernean($codeperso)
    {
    	return DB::table('users')->select('codeunique')->where('codeperso', $codeperso)->get()[0]->codeunique;
    }

    public static function ValeurAjouterEtap($etape)
    {
        return DB::table('etapes')->select('ValeurAjouter')->where('id', $etape)->get()[0]->ValeurAjouter;
    }

    public static function FilleulPossibl($etape)
    {
        return DB::table('etapes')->select('NombrePossible')->where('id', $etape)->get()[0]->NombrePossible;
    }

    public static function VirtuelEspec($id_parrain)
    {
        return DB::table('avoirs')->select('gainespece')->where('id_user', $id_parrain)->get()[0]->gainespece;  
    }

    public static function Etape_ActuelParrai($id_parrain)
    {

        //dd($id_parrain);
        return DB::table('niveaux')->select('id_etape')->where('id_user', $id_parrain)->orderBy('id_etape', 'DESC')->get()[0]->id_etape; 
    }

    private $G = "oui";
	private $D = "non";
	private $i = 0;

	private $G_parrain = "";    

	public static function newfilleulFile($codeperso, $monParrain, $G_parrain = "", $G = "oui", $D = "non", $i = 0)
	{
		if($i == 0)
		{
			$G_parrain = $monParrain;
		//	AdminController::set_G_parrain($id_parrain);
			//$this->G_parrain = $id_parrain;
		}

		$codeparrainsystem = DB::table('systemadmins')
					->select('codeparrainadmin')
					->where('Admin', 'oui')
					->get()[0]->codeparrainadmin;

		$id_parrain = AdminController::id_mon_parrain($monParrain);

		// Pour garder le parrain principal
		
		$equipeparrain = AdminController::EquipeParrain($id_parrain);

		if ($monParrain == $codeparrainsystem) {
			AdminController::nouveauequipe($codeperso);
		} 
		else 
		{

		//$id = AdminController::id($codeperso);

		//$monParrain = AdminController::mon_parrain($id);
		//$id_parrain = AdminController::id_mon_parrain($monParrain);

		// Pour garder le parrain principal
		

		//$equipeparrain = AdminController::EquipeParrain($id_parrain);

		//  verification si parrain à gauche est vide

		if(AdminController::V_Gauche($id_parrain, $equipeparrain) == "oui") {
			
			DB::table('niveaux')
		            ->where('id_user', $id_parrain)
		            ->update(['PositionGauche' => $codeperso]);

		    // Mise à jour du nombre de filleule pour le parrain
		    $nombrefilleule = DB::table('niveaux')
		    					->select('nombredefilleul', 'id_etape')
		    					->where('id_user', $id_parrain)
		    					->orderBy('id_etape', 'DESC')
		    					->get();
		    $nmbr = $nombrefilleule[0]->nombredefilleul + 1;
		    $etp = $nombrefilleule[0]->id_etape;
		    DB::table('niveaux')
		            ->where('id_user', $id_parrain)
		            ->where('id_etape', $etp)
		            ->update(['nombredefilleul' => $nmbr]);
		}
		else
		{
			//  verification si parrain à droite est vide
			if (AdminController::V_Droite($id_parrain, $equipeparrain) == "oui") {
				DB::table('niveaux')
		            ->where('id_user', $id_parrain)
		            ->update(['PositionDroite' => $codeperso]);

		        // Mise à jour du nombre de filleule pour le parrain
			    $nombrefilleule = DB::table('niveaux')
			    					->select('nombredefilleul', 'id_etape')
			    					->where('id_user', $id_parrain)
			    					->orderBy('id_etape', 'DESC')
			    					->get();
			    $nmbr = $nombrefilleule[0]->nombredefilleul + 1;
		    	$etp = $nombrefilleule[0]->id_etape;
			    DB::table('niveaux')
			            ->where('id_user', $id_parrain)
			            ->where('id_etape', $etp)
			            ->update(['nombredefilleul' => $nmbr]);

			} 
			else 
			{

				// Je possède un parrain indirect de la gauche
				$monParrainGauche = AdminController::P_Gauche($id_parrain, $equipeparrain);

				//$parrain = AdminController::get_G_parrain();

				$parrain = $G_parrain;

				$id_parrain = AdminController::id_mon_parraingauche($monParrainGauche);

				//  verification si parrain à gauche est vide
				if (AdminController::V_Gauche($id_parrain, $equipeparrain) == "oui") {
			
					DB::table('niveaux')
			            ->where('id_user', $id_parrain)
			            ->update(['PositionGauche' => $codeperso]);

			        // Mon parrain indirect est de gauche

			        // recuperer le code unique du parrain pour inscrire en tant que parrain indirect
			        $P_codeunique = DB::table('users')
			        					->select('codeunique')
			        					->where('id', $id_parrain)
			        					->get()[0]->codeunique;

			        DB::table('users')
				            ->where('codeperso', $codeperso)
				            ->update(['parrainindirect' => $P_codeunique]);

					// Mise à jour du nombre de filleule pour le parrain
				    $idp = AdminController::id_mon_parrain($parrain);
				    $nombrefilleule = DB::table('niveaux')
				    					->select('nombredefilleul', 'id_etape')
				    					->where('id_user', $idp)
				    					->orderBy('id_etape', 'DESC')
				    					->get();
				    $nmbr = $nombrefilleule[0]->nombredefilleul + 1;
		    		$etp = $nombrefilleule[0]->id_etape;
				    DB::table('niveaux')
				            ->where('id_user', $idp)
				            ->where('id_etape', $etp)
				            ->update(['nombredefilleul' => $nmbr]);

				    //Verification si parrain indirect reçoi son gain d'etape si succes et que son nombre de filleul inclemente
	
				    $etape_actuel = AdminController::Etape_ActuelParrai($id_parrain);
				    $valeurajout = AdminController::ValeurAjouterEtap($etape_actuel);
						        $possiblefilleul = AdminController::FilleulPossibl($etape_actuel);
						        $gainsespece_actuel = AdminController::VirtuelEspec($id_parrain);

						        $gainsespece_actuel_mise_a_jour = $gainsespece_actuel + ($valeurajout / $possiblefilleul);
						        DB::table('avoirs')
						                ->where('id_user', $id_parrain)
						                ->update(['gainespece' => $gainsespece_actuel_mise_a_jour]);

						        $nombrefilleule = DB::table('niveaux')
							    					->select('nombredefilleul', 'id_etape')
							    					->where('id_user', $id_parrain)
							    					->orderBy('id_etape', 'DESC')
							    					->get();
							    $nmbr = $nombrefilleule[0]->nombredefilleul + 1;
		    					$etp = $nombrefilleule[0]->id_etape;
							    DB::table('niveaux')
							            ->where('id_user', $id_parrain)
							            ->where('id_etape', $etp)
							            ->update(['nombredefilleul' => $nmbr]);
				}
				else
				{
					//  verification si parrain à droite est vide
					if (AdminController::V_Droite($id_parrain, $equipeparrain) == "oui") {
						DB::table('niveaux')
				            ->where('id_user', $id_parrain)
				            ->update(['PositionDroite' => $codeperso]);

				        // Mon parrain indirect est de droite

				        // recuperer le code unique du parrain pour inscrire en tant que parrain indirect
				        $P_codeunique = DB::table('users')
				        					->select('codeunique')
				        					->where('id', $id_parrain)
				        					->get()[0]->codeunique;

				        DB::table('users')
					            ->where('codeperso', $codeperso)
					            ->update(['parrainindirect' => $P_codeunique]);

						// Mise à jour du nombre de filleule pour le parrain
					    $idp = AdminController::id_mon_parrain($parrain);
					    $nombrefilleule = DB::table('niveaux')
					    					->select('nombredefilleul', 'id_etape')
					    					->where('id_user', $idp)
					    					->orderBy('id_etape', 'DESC')
					    					->get();
					    $nmbr = $nombrefilleule[0]->nombredefilleul + 1;
		    			$etp = $nombrefilleule[0]->id_etape;
					    DB::table('niveaux')
					            ->where('id_user', $idp)
					            ->where('id_etape', $etp)
					            ->update(['nombredefilleul' => $nmbr]);

					    //Verification si parrain indirect reçoi son gain d'etape si succes et que son nombre de filleul inclemente
					    $etape_actuel = AdminController::Etape_ActuelParrai($id_parrain);
					    $valeurajout = AdminController::ValeurAjouterEtap($etape_actuel);
						        $possiblefilleul = AdminController::FilleulPossibl($etape_actuel);
						        $gainsespece_actuel = AdminController::VirtuelEspec($id_parrain);

						        $gainsespece_actuel_mise_a_jour = $gainsespece_actuel + ($valeurajout / $possiblefilleul);
						        DB::table('avoirs')
						                ->where('id_user', $id_parrain)
						                ->update(['gainespece' => $gainsespece_actuel_mise_a_jour]);

						        $nombrefilleule = DB::table('niveaux')
							    					->select('nombredefilleul', 'id_etape')
							    					->where('id_user', $id_parrain)
							    					->orderBy('id_etape', 'DESC')
							    					->get();
							    $nmbr = $nombrefilleule[0]->nombredefilleul + 1;
		    					$etp = $nombrefilleule[0]->id_etape;
							    DB::table('niveaux')
							            ->where('id_user', $id_parrain)
							            ->where('id_etape', $etp)
							            ->update(['nombredefilleul' => $nmbr]);

					} else {

						// Je possède un parrain indirect de la droite
						$id_parrain = AdminController::id_mon_parrain($G_parrain);
						
						$monParrainDroite = AdminController::P_Droite($id_parrain, $equipeparrain);

						$id_parrain = AdminController::id_mon_parraindroite($monParrainDroite);

						//  verification si parrain à gauche est vide
						if (AdminController::V_Gauche($id_parrain, $equipeparrain) == "oui") {
					
							DB::table('niveaux')
					            ->where('id_user', $id_parrain)
					            ->update(['PositionGauche' => $codeperso]);

					            // Mon parrain indirect est de gauche

						        // recuperer le code unique du parrain pour inscrire en tant que parrain indirect
						        $P_codeunique = DB::table('users')
						        					->select('codeunique')
						        					->where('id', $id_parrain)
						        					->get()[0]->codeunique;

						        DB::table('users')
							            ->where('codeperso', $codeperso)
							            ->update(['parrainindirect' => $P_codeunique]);

								// Mise à jour du nombre de filleule pour le parrain
							    $idp = AdminController::id_mon_parrain($parrain);
							    $nombrefilleule = DB::table('niveaux')
							    					->select('nombredefilleul', 'id_etape')
							    					->where('id_user', $idp)
							    					->orderBy('id_etape', 'DESC')
							    					->get();
							    $nmbr = $nombrefilleule[0]->nombredefilleul + 1;
		    					$etp = $nombrefilleule[0]->id_etape;
							    DB::table('niveaux')
							            ->where('id_user', $idp)
							            ->where('id_etape', $etp)
							            ->update(['nombredefilleul' => $nmbr]);

							    //Verification si parrain indirect reçoi son gain d'etape si succes et que son nombre de filleul inclemente
							    $etape_actuel = AdminController::Etape_ActuelParrai($id_parrain);
							    $valeurajout = AdminController::ValeurAjouterEtap($etape_actuel);
						        $possiblefilleul = AdminController::FilleulPossibl($etape_actuel);
						        $gainsespece_actuel = AdminController::VirtuelEspec($id_parrain);

						        $gainsespece_actuel_mise_a_jour = $gainsespece_actuel + ($valeurajout / $possiblefilleul);
						        DB::table('avoirs')
						                ->where('id_user', $id_parrain)
						                ->update(['gainespece' => $gainsespece_actuel_mise_a_jour]);

						        $nombrefilleule = DB::table('niveaux')
							    					->select('nombredefilleul', 'id_etape')
							    					->where('id_user', $id_parrain)
							    					->orderBy('id_etape', 'DESC')
							    					->get();
							    $nmbr = $nombrefilleule[0]->nombredefilleul + 1;
		    					$etp = $nombrefilleule[0]->id_etape;
							    DB::table('niveaux')
							            ->where('id_user', $id_parrain)
							            ->where('id_etape', $etp)
							            ->update(['nombredefilleul' => $nmbr]);
						}
						else
						{
							//  verification si parrain à droite est vide
							if (AdminController::V_Droite($id_parrain, $equipeparrain) == "oui") {
								DB::table('niveaux')
						            ->where('id_user', $id_parrain)
						            ->update(['PositionDroite' => $codeperso]);

						        // Mon parrain indirect est de gauche

						        // recuperer le code unique du parrain pour inscrire en tant que parrain indirect
						        $P_codeunique = DB::table('users')
						        					->select('codeunique')
						        					->where('id', $id_parrain)
						        					->get()[0]->codeunique;

						        DB::table('users')
							            ->where('codeperso', $codeperso)
							            ->update(['parrainindirect' => $P_codeunique]);

								// Mise à jour du nombre de filleule pour le parrain
							    $idp = AdminController::id_mon_parrain($parrain);
							    $nombrefilleule = DB::table('niveaux')
							    					->select('nombredefilleul', 'id_etape')
							    					->where('id_user', $idp)
							    					->orderBy('id_etape', 'DESC')
							    					->get();
							    $nmbr = $nombrefilleule[0]->nombredefilleul + 1;
		    					$etp = $nombrefilleule[0]->id_etape;
							    DB::table('niveaux')
							            ->where('id_user', $idp)
							            ->where('id_etape', $etp)
							            ->update(['nombredefilleul' => $nmbr]);

							    //Verification si parrain indirect reçoi son gain d'etape si succes et que son nombre de filleul inclemente
							    $etape_actuel = AdminController::Etape_ActuelParrai($id_parrain);
						        $valeurajout = AdminController::ValeurAjouterEtap($etape_actuel);
						        $possiblefilleul = AdminController::FilleulPossibl($etape_actuel);
						        $gainsespece_actuel = AdminController::VirtuelEspec($id_parrain);

						        $gainsespece_actuel_mise_a_jour = $gainsespece_actuel + ($valeurajout / $possiblefilleul);
						        DB::table('avoirs')
						                ->where('id_user', $id_parrain)
						                ->update(['gainespece' => $gainsespece_actuel_mise_a_jour]);

						        $nombrefilleule = DB::table('niveaux')
							    					->select('nombredefilleul', 'id_etape')
							    					->where('id_user', $id_parrain)
							    					->orderBy('id_etape', 'DESC')
							    					->get();
							    $nmbr = $nombrefilleule[0]->nombredefilleul + 1;
		    					$etp = $nombrefilleule[0]->id_etape;
							    DB::table('niveaux')
							            ->where('id_user', $id_parrain)
							            ->where('id_etape', $etp)
							            ->update(['nombredefilleul' => $nmbr]);

							} else {
								// Parrain plein à l'étape 1
								if ($G == "oui") {
									$m = $i + 1;
									//dd(AdminController::P_Gauche($id_parrain, $equipeparrain, $G_parrain));
									$monParrain = AdminController::parrainfernean(AdminController::P_Gauche($id_parrain, $equipeparrain, $G_parrain));
									//dd($monParrain);
									AdminController::newfilleulFile($codeperso, $monParrain, "non", "oui", $m);
									
								} else {
									$m = $i + 1;
									$monParrain = AdminController::parrainfernean(AdminController::P_Droite($id_parrain, $equipeparrain, $G_parrain));
									AdminController::newfilleulFile($codeperso, $monParrain, "oui", "non", $m);
									
								}
							}
						}
					}
				}
			}
		}
		}
		// Actualiser les etapes

		//dd($G_parrain);

		// Parrain actuel
		$Parrainactuel = $G_parrain;

		$idp = AdminController::id_mon_parrain($Parrainactuel);

		// Etape actuel du parrain
		$P_etape = DB::table('niveaux')
					->select('id_etape')
					->where('id_user', $idp)
					->orderBy('id_etape', 'DESC')
					->get()[0]->id_etape;
 
 		// Nombre de filleule dans cette etape

		$P_nombrefilleul = DB::table('niveaux')
					->select('nombredefilleul')
					->where('id_user', $idp)
					->orderBy('id_etape', 'DESC')
					->get()[0]->nombredefilleul;

		// Verification du nombre acceptable dans cette etape

		AdminController::Actualiser($idp, $P_etape, $P_nombrefilleul, $equipeparrain);

		// Etape == 9 Alors passe à la retraite


		// si $Parrainactuel == 8 alors vas-y vers 9 indiquant retraite
				if (count(DB::table('niveaux')->where('id_user', $Parrainactuel)->get()) == 9) {
					// verifier 
					// inserrer dans la table retraite

					$retraite = Retraite::create([
						'nmbrfilleulerejoint' => 0,
						'id_equipe' => $id_equipe, 
						'id_user' => $Parrainactuel
					]); 

					//renboursement des frais de retraite

					$parrainbene = DB::table('retraites')
									->where('nmbrfilleulerejoint', '<', 14)
									->where('id_equipe',  $id_equipe)
									->get();

					// envoyer 20000$ à chaque compte et increment nmbrfillleulrejoint

					for ($i=0; $i < count($parrainbene); $i++) { 
						
						$nombreactuelf = $parrainbene[$i]->nmbrfilleulerejoint;

						$id_filleul = DB::table('users')
										->where('id', $parrainbene[$i]->id_user)
										->get()[0]->id;
						
						// son acompte avoir actuel

						$compte = DB::table('avoirs')
									->where('id_user', $id_filleul)
									->get()[0]->gainespece;

						// Mise à jour de son compte de 20000$
						$comptem = $compte + 20000;
						DB::table('avoirs')
		                    ->where('id_user', $id_filleul)
		                    ->update(['gainespece' => $comptem]);

		                // nombre actuel
		                $nmbr = DB::table('retraites')
									->where('id_user', $id_filleul)
									->get()[0]->nmbrfilleulerejoint;
		                // Mise du nombre filleul rejoint
						$nmbrm = $nmbr + 1;
						DB::table('retraites')
		                    ->where('id_user', $id_filleul)
		                    ->update(['nmbrfilleulerejoint' => $nmbrm]);                
					}
 		}
		
	}

	public static function Actualiser($Parrainactuel, $P_etape, $P_nombrefilleul, $equipeparrain)
	{
		if (DB::table('etapes')
				->select('NombrePossible')
				->where('id', $P_etape)
				->get()[0]->NombrePossible == $P_nombrefilleul
			) {
			
			// Poussez vers l'etape superieur

			// code unique de l'actuel parrain
			$P_codeq = DB::table('users')
			        	->select('codeunique')
			        	->where('id', $Parrainactuel)
			        	->get()[0]->codeunique;

			// recuperation de code unique du chef de l'equipe
			$CodepersoChefEquipe = DB::table('equipes')
				->select('chefequipe')
				->where('id', $equipeparrain)
				->get()[0]->chefequipe;

			// recuperer id_user du chef de l'equipe
			$id_userchef = DB::table('users')
							->select('id')
							->where('codeperso', $CodepersoChefEquipe)
							->get()[0]->id;

			if ($id_userchef == $Parrainactuel) {
				// Creer une nouvel etape pour l'equipe ainsi que moi meme
				$P_newetape = $P_etape + 1;
				// var id_equipe = equipeparrain
				// var id_etape = P_newetape
				// var id_user = Parrainactuel
				// var nombrefilleul = 0

				$niveau = Niveau::create([
						'nombredefilleul' => 0, 
						'id_user' => $Parrainactuel, 
						'id_etape' => $P_newetape, 
						'PositionGauche' => "A", 
						'PositionDroite' => "A", 
						'id_equipe' => $equipeparrain
					]);

			} else {

				// Creer une nouvel etape pour l"equipe ainsi que moi meme

				$P_newetape = $P_etape + 1;
				// var id_equipe = equipeparrain
				// var id_etape = P_newetape
				// var id_user = Parrainactuel
				// var nombrefilleul = 0

				$niveau = Niveau::create([
						'nombredefilleul' => 0, 
						'id_user' => $Parrainactuel, 
						'id_etape' => $P_newetape, 
						'PositionGauche' => "A", 
						'PositionDroite' => "A", 
						'id_equipe' => $equipeparrain
					]);

				// informer ensuite le superieur de l'etape suivant que je suis à l'etape superieur

				// recuperer la liste de tout ceux qui sont à l'etape superieure dans l'ordre acs de l'arriver

				$list_parrain = DB::table('niveaux')
								->where('id_etape', $P_newetape)
								->where('id_equipe', $equipeparrain)
								->orderBy('created_at', 'asc')
								->get();

				// Verification de filleul direct à gauche ou à droite pour inscrire le nouveau parrain

				for ($i=0; $i < count($list_parrain); $i++) { 
					
					$id_parrain = $list_parrain[$i]->id_user;

					if (AdminController::V_Gauche($id_parrain, $equipeparrain) == "oui") {
			
						DB::table('niveaux')
					            ->where('id_user', $id_parrain)
					            ->where('id_etape', $P_newetape)
					            ->update(['PositionGauche' => $P_codeq]);

					    // Mise à jour du nombre de filleule pour le parrain
					    $nombrefilleule = DB::table('niveaux')
					    					->select('nombredefilleul')
					    					->where('id_user', $id_parrain)
					    					->where('id_etape', $P_newetape)
					    					->get()[0]->nombredefilleul;
					    $nmbr = $nombrefilleule + 1;
					    DB::table('niveaux')
					            ->where('id_user', $id_parrain)
					            ->where('id_etape', $P_newetape)
					            ->update(['nombredefilleul' => $nmbr]);
					    break;
					}
					else
					{
						//  verification si parrain à droite est vide
						if (AdminController::V_Droite($id_parrain, $equipeparrain) == "oui") {
							DB::table('niveaux')
					            ->where('id_user', $id_parrain)
					            ->where('id_etape', $P_newetape)
					            ->update(['PositionDroite' => $P_codeq]);

					        // Mise à jour du nombre de filleule pour le parrain
						    $nombrefilleule = DB::table('niveaux')
						    					->select('nombredefilleul')
						    					->where('id_user', $id_parrain)
						    					->where('id_etape', $P_newetape)
						    					->get()[0]->nombredefilleul;
						    $nmbr = $nombrefilleule + 1;
						    DB::table('niveaux')
						            ->where('id_user', $id_parrain)
						            ->where('id_etape', $P_newetape)
						            ->update(['nombredefilleul' => $nmbr]);
						    break;
						}
					}
				}

				// reparcourru la liste pour voir si un parrain est pret à aller à l'etape superieur
				// si oui 

				for ($i=0; $i < count($list_parrain); $i++) {
					
					$id_parrain = $list_parrain[$i]->id_user;

								// Parrain actuel
					$Parrainactuel = $id_parrain;

					// Etape actuel du parrain
					$P_etape = DB::table('niveaux')
								->select('id_etape')
								->where('id_user', $Parrainactuel)
								->orderBy('id_etape', 'desc')
								->get()[0]->id_etape;
			 
			 		// Nombre de filleule dans cette etape

					$P_nombrefilleul = DB::table('niveaux')
								->select('nombredefilleul')
								->where('id_user', $Parrainactuel)
								->orderBy('id_etape', 'desc')
								->get()[0]->nombredefilleul;

					if (DB::table('etapes')
							->select('NombrePossible')
							->where('id', $P_etape)
							->get()[0]->NombrePossible == $P_nombrefilleul

						) {

						AdminController::Actualiser($Parrainactuel, $P_etape, $P_nombrefilleul, $equipeparrain);
					}
				}

			}
			
		}
	}	

	public static function nouveauequipe($newfilleul)
	{
		// Create new equipe
		$testequipe = Equipe::create([
			'nom' => '', 
			'chefequipe' => $newfilleul
		]);

		$idequipe = DB::table('equipes')
					->select('id')
					->where('chefequipe', $newfilleul)
					->get()[0]->id;

		// Create position
		//$createnewequipe = Position::create([
		//	'S' => $newfilleul,
		//	'G'=> 'A',
		//	'D'=> 'A'
		//]);

		//$idposition = DB::table('positions')
		//			->select('id')
		//			->where('S', $newfilleul)
		//			->get()[0]->id;
		
		// Mise a jour niveaux
		//		DB::table('niveaux')
          //          ->where('id_user', $newfilleul)
            //        ->update(['id_position' => $idposition]);
                DB::table('niveaux')
                    ->where('id_user', $newfilleul)
                    ->update(['id_equipe' => $idequipe]);

		//verifier la ligne 1928 pour avoir une liste d'etape au lieu de mettre a jour
		
	}
}

?>