<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	if(isset($_GET['url']) AND isset($_GET['trackId']))
	{
		$trackId 	= $_GET['trackId'];
		$url 		= urldecode($_GET['url']);


		$songCuratorId 	= $_GET['songCuratorId'] ?: $_POST['songCuratorId'];
		include_once('../model/connect_sql.php');
		$req = $bdd->prepare('UPDATE song SET permalink_url=? WHERE trackId = ?') or die(print_r($bdd->errorInfo()));
		$req->execute(array(
			$url,
			$trackId
		));
		echo('success');
	}