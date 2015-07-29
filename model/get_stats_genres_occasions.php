<?php
	include_once('../model/connect_sql.php');


	$req11 = $bdd->prepare('SELECT count(*) FROM song WHERE genre=?');
	$req11->execute(array($genreslist[0]));
	$nbSongsOfThisGenre=$req11->fetch();

	$req12 = $bdd->prepare('SELECT count(*) FROM song WHERE (occ1=? OR occ2=?)');
	$req12->execute(array($occasionslist[0],$occasionslist[0]));
	$nbSongsForThisOccasion=$req12->fetch();


	$req13 = $bdd->prepare('SELECT count(*) FROM song, soundpark2.like WHERE genre=? AND song.ID=soundpark2.like.ID');
	$req13->execute(array($genreslist[0]));
	$nbLikesForThisGenre=$req13->fetch();


	$req14 = $bdd->prepare('SELECT count(*) FROM song, soundpark2.like WHERE (occ1=? OR occ2=?) AND song.ID=soundpark2.like.ID');
	$req14->execute(array($occasionslist[0],$occasionslist[0]));
	$nbLikesForThisOccasion=$req14->fetch();