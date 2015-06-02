<?php
	include_once('../model/connect_sql.php');
	$req = $bdd->prepare('SELECT * FROM song, proposed_song WHERE song.trackId = ? or proposed_song.trackId=?');
	$req->execute(array($_GET['trackId'],$_GET['trackId']));
	$exists = $req->fetch();
	//$exists = $data[0];