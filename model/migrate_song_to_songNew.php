<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

	include_once('../model/connect_sql.php');

	$req1 = $bdd->query('SELECT ID_curator, ID_playlist, occ1, occ2, permalink_url FROM song');

	$song = array();
	$i = 0;
	while($result = $req1->fetch())
	{
		//$song[$i] = array("ID_curator"=>$result['ID_curator'], "ID_playlist"=>$result['ID_playlist'], "ID_occasion1"=>$result['occ1'], "ID_occasion2"=>$result['occ2'], "url"=>$result['permalink_url']);

		$req = $bdd->prepare(
			'INSERT INTO `songNew` (`ID_curator`, `ID_playlist`, `ID_occasion1`, `ID_occasion2`, `url`, `date_add`, `treated`) 
			VALUES (?, ?, ?, ?, ?, NOW(), 1)'
			) or die(print_r($bdd->errorInfo()));

		$req->execute(array(
			$result['ID_curator'],
			$result['ID_playlist'],
			$result['occ1'],
			$result['occ2'],
			$result['permalink_url']
		));
		$i++;

		print_r('ala    ');
	}