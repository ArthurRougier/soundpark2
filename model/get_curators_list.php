<?php
	include_once("connect_sql.php");
	$req = $bdd->query('SELECT curator.ID, pseudo, curator.genre, avatar_url, link, count(distinct like.ID) FROM curator, song, `like` WHERE like.ID_song = song.ID and song.ID_curator = curator.ID GROUP BY curator.ID, pseudo, genre, avatar_url, link');
