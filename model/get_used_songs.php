<?php
	include_once("../model/connect_sql.php");
	//$req = $bdd->query('SELECT song.ID, pseudo, ID_playlist, type, artwork_url, song.genre, title, artist, trackId, permalink_url FROM song, curator WHERE song.ID_curator = curator.ID ORDER BY ID_playlist DESC');
	$req = $bdd->query('SELECT song.ID, pseudo, ID_playlist, title, artist, trackId, song.genre, permalink_url, trackId FROM song, curator WHERE song.ID_curator=curator.ID ORDER BY ID_playlist DESC');
	
