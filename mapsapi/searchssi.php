<?php

include 'config.php';

/**
*
* Variable : $donnees 
* Type : json encode
*
*/
$donnees = $_GET['datassi'];
$donnesskey = $_GET['cle'];
/**
	*
	* Variable : $donnee 
	* Type : json decode
	*
	*/
$connexion = connexionPDO();

try{
	if ($donnees == "ssiapp") {
		$query = "SELECT * FROM agences WHERE agences.description like '%".$donnesskey."%';";

		$result = $connexion->query($query);
	    
		$data = $result->fetchAll();

	    $sortie = json_encode(array("error" => false, "allagences" => $data));

		echo "$sortie";
		
	} else {
		$sortie = json_encode(array("error" => true, "allagences" => ""));
		echo "$sortie";
	}
}
catch(PDOException $e){
    var_dump($e);
    $sortie = json_encode(array("error" => true, "allagences" => ""));
	echo "$sortie";
}

// https://sourcedusuccesinternational.com/mapsapi/getallagence.php?datassi=ssiapp&cle=<mot>
