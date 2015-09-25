<?php

	include_once("../model/connect_sql.php");
	if(isset($_GET['songId']) && isset($_GET['currentUser']))
	{
		$idUser = $_GET['currentUser'];
		$idSong = $_GET['songId'];

		//on test si le son n'a pas déjà été liké par ce meme utilisateur
		$req = $bdd->prepare('SELECT like.ID FROM `like`, user, songNew WHERE like.ID_song = songNew.ID AND songNew.ID= ? AND like.ID_user = user.ID AND user.ID=?');
		$req->execute(array(
		$idSong,
		$idUser
		));
		if($req->fetch()) // cas ou le son avait été liké avant
		{

			//on supprime le like
			$req = $bdd->prepare('DELETE FROM `like` WHERE ID_song = ? AND ID_user = ?');
			$req->execute(array($idSong, $idUser));

		
			//on vient compter le nombre de dislikes du son en question pour vérifier que les sommes correspondent bien. 
			$req = $bdd->prepare('SELECT COUNT(*) FROM `dislike` WHERE ID_song = ?');
			$req->execute(array($idSong));
			$nbDislikes = $req->fetch();

			//on vient compter le nombre de likes du son en question pour vérifier que les sommes correspondent bien. 
			$req = $bdd->prepare('SELECT COUNT(*) FROM `like` WHERE ID_song = ?');
			$req->execute(array($idSong));
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
	