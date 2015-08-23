<?php

	include_once ('../model/connect_sql.php');

	$path=$_SERVER['PHP_SELF'];
	$pageCourante=basename($path);

	if ($pageCourante=="admin_index.php" OR $pageCourante=="admin_songs_history.php")
	{
		$req33 = $bdd->prepare('SELECT name FROM song, occasions WHERE occ1=ID_occasion AND ID=?');
		$req33->execute(array($trackList[0]));
		$songOccasion=$req33->fetch();


		$req34 = $bdd->prepare('SELECT name FROM song, occasions WHERE occ2=ID_occasion AND ID=?');
		$req34->execute(array($trackList[0]));
		$songOccasion2=$req34->fetch();
	}
	else
	{
		$req33 = $bdd->prepare('SELECT name FROM proposed_song, occasions WHERE occ1=ID_occasion AND ID=?');
		$req33->execute(array($trackList[0]));
		$songOccasion=$req33->fetch();


		$req34 = $bdd->prepare('SELECT name FROM proposed_song, occasions WHERE occ2=ID_occasion AND ID=?');
		$req34->execute(array($trackList[0]));
		$songOccasion2=$req34->fetch();
	}