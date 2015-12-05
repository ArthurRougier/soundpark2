<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include_once("../model/connect_sql.php");
	if(isset($_GET['songId']) && isset($_COOKIE['current_user']))
	{
		$songId = $_GET['songId'];
		$currentUser = $_COOKIE['current_user'];

		$req = $bdd->prepare('INSERT INTO automatic_next (Id_Song, mail, date_listened) VALUES(:track, :listener, NOW())');
		$req->execute(array(
			'track' => $songId,
			'listener' => $currentUser
			));

		echo "success";
	}
?>