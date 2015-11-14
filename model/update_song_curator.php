<?php

	if((isset($_GET['songId']) OR isset($_POST['songId'])) AND (isset($_GET['songCuratorId']) OR isset($_POST['songCuratorId'])))
	{
		$songId 	= $_GET['songId'] ?: $_POST['songId'];
		$songCuratorId 	= $_GET['songCuratorId'] ?: $_POST['songCuratorId'];
		include_once('../model/connect_sql.php');
		$req = $bdd->prepare('UPDATE songNew SET ID_curator=? WHERE ID = ?') or die(print_r($bdd->errorInfo()));
		$req->execute(array(
			$songCuratorId,
			$songId
		));
		echo('success');
	}