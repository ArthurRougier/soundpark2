<?php 
	if(isset($_GET['songId']) AND isset($_GET['playlistId']))
	{
		include_once("../model/connect_sql.php");

		$songId = $_GET['songId'];
		$playlistId = $_GET['playlistId'];

		$req = $bdd->prepare('UPDATE songNew SET ID_playlist=?, treated=1 WHERE ID = ?') or die(print_r($bdd->errorInfo()));
		$req->execute(array(
			$playlistId,
			$songId
		));
		echo('success');
	}

		
