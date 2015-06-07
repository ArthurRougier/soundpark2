<?php
	
	if(isset($_COOKIE['current_user']))
	{
		$req = $bdd->prepare('SELECT artwork_url, artist, title, pseudo, trackId, permalink_url FROM song, curator, `like` WHERE song.ID_curator = curator.ID AND song.ID = `like`.ID_song and `like`.ID_user = ? ORDER BY song.id DESC');
		$req->execute(array($_COOKIE['current_user']));
	}


	