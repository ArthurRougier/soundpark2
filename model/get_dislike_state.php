<?php
	include_once('connect_sql.php');
	$req = $bdd->prepare('SELECT dislike.ID FROM `dislike`, user, song WHERE dislike.ID_song = song.ID AND song.trackId = ? AND dislike.ID_user = user.ID AND user.ID=?');
	$req->execute(array(
		$_GET['trackId'],
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