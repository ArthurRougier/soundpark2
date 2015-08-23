<?php

	include_once ('../model/connect_sql.php');
	
	$path=$_SERVER['PHP_SELF'];
	$pageCourante=basename($path);

	if ($pageCourante=="admin_index.php")
	{	
		$req22 = $bdd->prepare('SELECT name FROM song, genres WHERE genre=ID_genre AND ID=?');
		$req22->execute(array($trackList[0]));
		$songGenre=$req22->fetch();
	}
	else
	{
		$req23 = $bdd->prepare('SELECT name FROM proposed_song, genres WHERE genre=ID_genre AND ID=?');
		$req23->execute(array($trackList[0]));
		$songGenre=$req23->fetch();
	}



	