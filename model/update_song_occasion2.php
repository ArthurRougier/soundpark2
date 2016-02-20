<?php

	if((isset($_GET['songId']) OR isset($_POST['songId'])) AND (isset($_GET['songOccasion2Id']) OR isset($_POST['songOccasion2Id'])))
	{
		$songId 	= $_GET['songId'] ?: $_POST['songId'];
		$songOccasion2Id 	= $_GET['songOccasion2Id'] ?: $_POST['songOccasion2Id'];
		include_once('../model/connect_sql.php');
		$req = $bdd->prepare('UPDATE songNew SET ID_occasion2=? WHERE ID = ?') or die(print_r($bdd->errorInfo()));
		$req->execute(array(
			$songOccasion2Id,
			$songId
		));
		echo('success');
	}