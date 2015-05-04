<?php

	include_once("../model/connect_sql.php");

	if(isset($_GET['trackId']) && isset($_GET['currentUser']))
	{	
		
		$idUser = $_GET['currentUser'];

		// on vient tester si l'utilisateur n'avait pas disliké le son en question
		$req = $bdd->prepare('SELECT dislike.ID FROM soundpark2.dislike, user, song WHERE dislike.ID_song = song.ID AND song.trackId = ? AND dislike.ID_user = user.ID AND user.ID=?');
		$req->execute(array(
			$_GET['trackId'],
			$idUser
			));

		if($req->fetch()) // cas ou l'utilisateur avait disliké
		{
			
			//on va chercher l'ID du son en question
			$req = $bdd->prepare('SELECT ID FROM song WHERE trackId = ?');
			$req->execute(array($_GET['trackId']));
			$Id = $req->fetch();

			//on supprime le dislike
			$req = $bdd->prepare('DELETE FROM soundpark2.dislike WHERE ID_song = ? AND ID_user = ?');
			$req->execute(array($Id[0], $idUser));

			
			//on vient compter le nombre de like du son en question pour vérifier que les sommes correspondent bien. 
			$req = $bdd->prepare('SELECT COUNT(*) FROM soundpark2.like WHERE ID_song = ?');
			$req->execute(array($Id[0]));
			$nbLikes = $req->fetch();

			//on vient compter le nombre de dislikes du son en question pour vérifier que les sommes correspondent bien. 
			$req = $bdd->prepare('SELECT COUNT(*) FROM soundpark2.dislike WHERE ID_song = ?');
			$req->execute(array($Id[0]));
			$nbDislikes = $req->fetch();

			echo('likes: '.$nbLikes[0].' dislikes : '.$nbDislikes[0]);	
			
		}
		else // si l'utilisateur n'avait pas disliké le son auparavant
		{
			
			echo('error, son deja disliké');
			
		}
		
	}
	else
	{
		echo('il manque le trackid ou le currentuser');
	}

	
	