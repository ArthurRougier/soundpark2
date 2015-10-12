<?php
	include_once("connect_sql.php");
<<<<<<< HEAD
	$req = $bdd->query('SELECT curator.ID, pseudo, curator.genre, avatar_url, link, count(distinct like.ID) FROM curator, song, `like` WHERE like.ID_song = song.ID and song.ID_curator = curator.ID GROUP BY curator.ID, pseudo, genre, avatar_url, link');
=======
	$req = $bdd->query('SELECT curator.ID, pseudo, curator.genre, curator.avatar_url, link, count(distinct like.ID), count(distinct song.ID), user.email FROM user, curator, song, soundpark2.like WHERE like.ID_song = song.ID and song.ID_curator = curator.ID and user.id=curator.ID_user GROUP BY curator.ID, pseudo, genre, avatar_url, link');
	
>>>>>>> AdminBO
