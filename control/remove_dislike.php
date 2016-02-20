<?php

	include_once("../model/connect_sql.php");

	if(isset($_GET['songId']) && isset($_GET['currentUser']))
	{	
		
		$idUser = $_GET['currentUser'];
		$idSong = $_GET['songId'];

		// on vient tester si l'utilisateur n'avait pas disliké le son en question
		$req = $bdd->prepare('SELECT dislike.ID FROM `dislike`, user, songNew WHERE dislike.ID_song = songNew.ID AND songNew.ID = ? AND dislike.ID_user = user.ID AND user.ID=?');
		$req->execute(array(
			$idSong,
			$idUser
			));

		if($req->fetch()) // cas ou l'utilisateur avait disliké
		{

			//on supprime le dislike
			$req = $bdd->prepare('DELETE FROM `dislike` WHERE ID_song = ? AND ID_user = ?');
			$req->execute(array($idSong, $idUser));

			
			//on vient compter le nombre de like du son en question pour vérifier que les sommes correspondent bien. 
			$req = $bdd->prepare('SELECT COUNT(*) FROM `like` WHERE ID_song = ?');
			$req->execute(array($idSong));
			$nbLikes = $req->fetch();

			//on vient compter le nombre de dislikes du son en question pour vérifier que les sommes correspondent bien. 
			$req = $bdd->prepare('SELECT COUNT(*) FROM `dislike` WHERE ID_song = ?');
			$req->execute(array($idSong));
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

	
	