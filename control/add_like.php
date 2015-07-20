<?php

	include_once("../model/connect_sql.php");

	if(isset($_GET['trackId']) && isset($_GET['currentUser']))
	{	
		//on test si le son n'a pas déjà été liké par ce meme utilisateur, histoire d'éviter de réenregistrer un like si c'est le cas
		$req = $bdd->prepare('SELECT like.ID FROM `like`, user, song WHERE like.ID_song = song.ID AND song.trackId = ? AND like.ID_user = user.ID AND user.ID=?');
		$req->execute(array(
		$_GET['trackId'],
		$_GET['currentUser']
		));
		if($req->fetch())
		{
			echo('erreur, son deja liké par cet utilisateur');
		}
		else
		{
			// on vient tester si l'utilisateur n'avait pas disliké le son en question
			$req = $bdd->prepare('SELECT dislike.ID FROM `dislike`, user, song WHERE dislike.ID_song = song.ID AND song.trackId = ? AND dislike.ID_user = user.ID AND user.ID=?');
			$req->execute(array(
				$_GET['trackId'],
				$_GET['currentUser']
				));

			if($req->fetch()) // cas ou l'utilisateur avait disliké
			{
				
				//on va chercher l'ID du son en question
				$req = $bdd->prepare('SELECT ID FROM song WHERE trackId = ?');
				$req->execute(array($_GET['trackId']));
				$Id = $req->fetch();

				//on va chercher l'ID de l'utilisateur qui à liké
				$idUser = $_GET['currentUser'];

				//on supprime le dislike
				$req = $bdd->prepare('DELETE FROM `dislike` WHERE ID_song = ? AND ID_user = ?');
				$req->execute(array($Id[0], $idUser));

				//on ajoute le like
				$req = $bdd->prepare('INSERT INTO `like`(ID_song, ID_user, date) VALUES(?, ?, NOW())');
				$req->execute(array($Id[0], $idUser));

				//on vient compter le nombre de like du son en question pour vérifier que les sommes correspondent bien. 
				$req = $bdd->prepare('SELECT COUNT(*) FROM `like` WHERE ID_song = ?');
				$req->execute(array($Id[0]));
				$nbLikes = $req->fetch();

				//on vient compter le nombre de dislikes du son en question pour vérifier que les sommes correspondent bien. 
				$req = $bdd->prepare('SELECT COUNT(*) FROM `dislike` WHERE ID_song = ?');
				$req->execute(array($Id[0]));
				$nbDislikes = $req->fetch();

				echo('likes: '.$nbLikes[0].' dislikes : '.$nbDislikes[0]);	
				
			}
			else // si l'utilisateur n'avait pas disliké le son auparavant
			{
				
				//on va chercher l'ID du son en question
				$req = $bdd->prepare('SELECT ID FROM song WHERE trackId = ?');
				$req->execute(array($_GET['trackId']));
				$Id = $req->fetch();

				//on va chercher l'ID de l'utilisateur qui à liké
				$idUser = $_GET['currentUser'];

				//on ajoute le like
				$req = $bdd->prepare('INSERT INTO `like`(ID_song, ID_user, date) VALUES(?, ?, NOW())');
				$req->execute(array($Id[0], $idUser));

				//on vient compter le nombre de like du son en question pour vérifier que les sommes correspondent bien. 
				$req = $bdd->prepare('SELECT COUNT(*) FROM `like` WHERE ID_song = ?');
				$req->execute(array($Id[0]));
				$nbLikes = $req->fetch();
				echo($nbLikes[0]);
				
			}
		}
	}
	else
	{
		echo('il manque le trackid ou le currentuser');
	}

	
	