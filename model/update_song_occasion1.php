<?php

	if((isset($_GET['songId']) OR isset($_POST['songId'])) AND (isset($_GET['songOccasion1Id']) OR isset($_POST['songOccasion1Id'])))
	{
		$songId 	= $_GET['songId'] ?: $_POST['songId'];
		$songOccasion1Id 	= $_GET['songOccasion1Id'] ?: $_POST['songOccasion1Id'];
		include_once('../model/connect_sql.php');
		$req = $bdd->prepare('UPDATE songNew SET ID_occasion1=? WHERE ID = ?') or die(print_r($bdd->errorInfo()));
		$req->execute(array(
			$songOccasion1Id,
			$songId
		));
		echo('success');
	}