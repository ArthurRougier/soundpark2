<?php
	include_once("connect_sql.php");
	$req = $bdd->query('SELECT proposed_song.ID, pseudo, type, artwork_url, proposed_song.genre, title, artist, trackId, permalink_url FROM proposed_song, curator WHERE proposed_song.ID_curator = curator.ID AND proposed_song.treated = 1 ORDER BY date_add DESC');
	
	
	
