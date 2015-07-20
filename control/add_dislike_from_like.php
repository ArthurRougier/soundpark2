<?php

	include_once("../model/connect_sql.php");
	if(isset($_GET['trackId']) && isset($_GET['currentUser']))
	{
		$req = $bdd->prepare('SELECT ID FROM song WHERE trackId = ?');
		$req->execute(array($_GET['trackId']));
		$Id = $req->fetch();
		$req = $bdd->prepare('SELECT ID FROM user WHERE email = ?');
		$req->execute(array($_GET['currentUser']));
		$idUser = $req->fetch();
		$req = $bdd->prepare('DELETE FROM `like` WHERE ID_song = ? AND ID_user = ?');
		$req->execute(array($Id[0], $idUser[0]));
		$req = $bdd->prepare('SELECT COUNT(*) FROM `like` WHERE ID_song = ?');
		$req->execute(array($Id[0]));
		$nbLikes = $req->fetch();
		echo($nbLikes[0]);
	}
	