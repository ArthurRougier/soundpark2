<?php

	if((isset($_GET['songId']) OR isset($_POST['songId'])) AND (isset($_GET['songGenreId']) OR isset($_POST['songGenreId'])))
	{
		$songId 	= $_GET['songId'] ?: $_POST['songId'];
		$songGenreId 	= $_GET['songGenreId'] ?: $_POST['songGenreId'];
		include_once('../model/connect_sql.php');
		$req = $bdd->prepare('UPDATE songNew SET ID_genre=? WHERE ID = ?') or die(print_r($bdd->errorInfo()));
		$req->execute(array(
			$songGenreId,
			$songId
		));
		echo('success');
	}