<?php
	include_once('connect_sql.php');
	$req = $bdd->prepare('SELECT like.ID FROM `like`, user, song WHERE like.ID_song = song.ID AND song.trackId = ? AND like.ID_user = user.ID AND user.ID=?');
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