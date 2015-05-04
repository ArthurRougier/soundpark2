<?php

	include_once("../model/connect_sql.php");
	if(isset($_GET['trackId']) && isset($_GET['currentUser']))
	{
		$idUser = $_GET['currentUser'];

		//on test si le son n'a pas déjà été liké par ce meme utilisateur
		$req = $bdd->prepare('SELECT like.ID FROM soundpark2.like, user, song WHERE like.ID_song = song.ID AND song.trackId = ? AND like.ID_user = user.ID AND user.ID=?');
		$req->execute(array(
		$_GET['trackId'],
		$idUser
		));
		if($req->fetch()) // cas ou le son avait été liké avant
		{
			//on va chercher l'ID du son en question
			$req = $bdd->prepare('SELECT ID FROM song WHERE trackId = ?');
			$req->execute(array($_GET['trackId']));
			$Id = $req->fetch();

			//on supprime le like
			$req = $bdd->prepare('DELETE FROM soundpark2.like WHERE ID_song = ? AND ID_user = ?');
			$req->execute(array($Id[0], $idUser));

		
			//on vient compter le nombre de dislikes du son en question pour vérifier que les sommes correspondent bien. 
			$req = $bdd->prepare('SELECT COUNT(*) FROM soundpark2.dislike WHERE ID_song = ?');
			$req->execute(array($Id[0]));
			$nbDislikes = $req->fetch();

			//on vient compter le nombre de likes du son en question pour vérifier que les sommes correspondent bien. 
			$req = $bdd->prepare('SELECT COUNT(*) FROM soundpark2.like WHERE ID_song = ?');
			$req->execute(array($Id[0]));
			$nbLikes = $req->fetch();
			echo('likes: '.$nbLikes[0].' dislikes : '.$nbDislikes[0]);	

		}
		else // cas ou le son n'avait pas été liké avant
		{
			echo('pas de like a supprimer');
		}

			
	}
	else
	{
		echo('il manque le trackid ou le currentuser');
	}
	