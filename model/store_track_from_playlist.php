<?php 
	if(isset($_GET['songId']) OR isset($_POST['songId']))
	{
		include_once("../model/connect_sql.php");
		$songId = $_GET['songId'] ?: $_POST['songId'];
		$req = $bdd->prepare('UPDATE songNew SET ID_playlist=0 WHERE ID = ?') or die(print_r($bdd->errorInfo()));
		$req->execute(array(
			$songId
		));
		echo('success');
	}

		