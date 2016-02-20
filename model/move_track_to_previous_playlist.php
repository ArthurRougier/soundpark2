<?php
	if((isset($_GET['songId']) OR isset($_POST['songId'])))
	{
		$songId 	= $_GET['songId'] ?: $_POST['songId'];
		include_once('connect_sql.php');
		$req = $bdd->prepare('SELECT ID_playlist FROM songNew WHERE ID = ?');
		$req->execute(array($songId));
		$currentPlaylist = 0;
		if($result = $req->fetch())
		{
			$currentPlaylist = $result[0];
			$nextPlaylist = $currentPlaylist - 1;
			$req = $bdd->prepare('UPDATE songNew SET ID_playlist= ? WHERE ID = ?');
			$req->execute(array($nextPlaylist, $songId));
			echo('success');
		}
	}
