<?php
	session_start();
	include_once("connect_sql.php");
	
	$req= $bdd->prepare('SELECT proposed_song.ID, pseudo, type, artwork_url, proposed_song.genre, title, artist, trackId, permalink_url FROM proposed_song, curator WHERE proposed_song.ID_curator = curator.ID AND proposed_song.ID_curator=? AND proposed_song.treated = FALSE ORDER BY date_add DESC');
	$req->execute(array($_SESSION['id_curator']));

	
