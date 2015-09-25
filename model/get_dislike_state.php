<?php
	include_once('connect_sql.php');
	$req = $bdd->prepare('SELECT dislike.ID FROM `dislike`, user, songNew WHERE dislike.ID_song = songNew.ID AND songNew.ID = ? AND dislike.ID_user = user.ID AND user.ID=?');
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