<?php
	include_once('connect_sql.php');
	if(isset($_COOKIE['current_user']))
	{
		$req = $bdd->prepare('SELECT like.ID FROM `like`, user, songNew WHERE like.ID_song = songNew.ID AND songNew.ID = ? AND like.ID_user = user.ID AND user.ID=?');
		$req->execute(array(
			$_GET['songId'],
			$_COOKIE['current_user']
			));
		if($req->fetch())
		{
			echo('TRUE');
		}
		else
		{
			echo('FALSE');
		}
	}
	else
	{
		$req = $bdd->prepare('SELECT like.ID FROM `like`, user, songNew WHERE like.ID_song = songNew.ID AND songNew.ID = ? AND like.ID_user = user.ID AND user.ID=?');
		$req->execute(array(
			$_GET['songId'],
			$_GET['currentUser']
			));
		if($req->fetch())
		{
			echo('TRUE');
		}
		else
		{
			echo('FALSE');
		}
	}
	