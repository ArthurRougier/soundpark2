<?php
	if(isset($_COOKIE['current_user']) && isset($_POST['curatorName']))
	{
		include_once('../model/connect_sql.php');
		$req=$bdd->prepare('UPDATE user SET type=2 WHERE user.ID = ? ');
		$req->execute(array($_COOKIE['current_user']));

		$req = $bdd->prepare('SELECT picture_url FROM facebook_account WHERE ID_user = ?');
		$req->execute(array($_COOKIE['current_user']));
		if($result = $req->fetch())
		{
			$pictureUrl = $result[0];
		}
		else
		{
			$pictureUrl = 'none';
		}
		
		$req = $bdd->prepare('INSERT INTO curator(ID_user, pseudo, genre, avatar_url) VALUES (?, ?, "1", ?)') or die(print_r($bdd->errorInfo()));
		$req->execute(array(
			$_COOKIE['current_user'],
			$_POST['curatorName'],
			$pictureUrl
		));

		header('location: ../view/curator_index.php');
	}
