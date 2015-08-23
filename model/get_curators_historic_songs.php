<?php
	session_start();
	include_once("../model/connect_sql.php");
	

	$req= $bdd->prepare('SELECT song.ID, COUNT(like.ID), title, artist, genre, permalink_url, trackId FROM `like`, song WHERE like.ID_song=song.ID AND song.ID_curator=? GROUP BY like.ID_song ORDER BY COUNT(like.ID) DESC');
	$req->execute(array($_SESSION['id_curator']));


	//$req= $bdd->prepare('SELECT ID, title, artist, genre, permalink_url, trackId FROM song WHERE ID_curator=? ORDER BY ID_playlist DESC');
	//$req->execute(array($_SESSION['id_curator']));

	
