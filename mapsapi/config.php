<?php

	function connexionPDO()
	{
        $servname = '185.98.131.109';
        $dbname = 'sourc1440356_1lxzub';
        $user = 'sourc1440356';
        $pass = 'ocpdeusinp';

        try{
            $dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
            $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbco;
        }
        catch(PDOException $e){
            echo "Erreur : " . $e->getMessage();
        }

	}
?>