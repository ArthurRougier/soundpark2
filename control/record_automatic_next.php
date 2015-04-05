<?php

	include_once("../model/connect_sql.php");
	if(isset($_GET['trackId']) && isset($_GET['currentUser']))
	{
		
		$req = $bdd->prepare('SELECT ID FROM song WHERE trackId=?');
		$req->execute(array($_GET['trackId']));
		$IDsong=$req->fetch();

		$dateEcoute=time();

		$req = $bdd->prepare('INSERT INTO automatic_next (Id_Song, mail, date_listened) VALUES(:track, :listener, :dateOfListening)');
		$req->execute(array(
			'track' => $IDsong[0],
			'listener' => $_GET['currentUser'],
			'dateOfListening' => date('Y-m-d G-i-s',$dateEcoute)
			));
	}
?>