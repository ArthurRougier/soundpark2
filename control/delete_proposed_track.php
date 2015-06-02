<?php
	include_once("../model/connect_sql.php");
	if(isset($_GET['idSong']))
	{
		$req = $bdd->prepare('DELETE FROM proposed_song WHERE ID = ?');
		$req->execute(array($_GET['idSong']));
		header('Location: ../view/admin_songs_new.php');
	}
	else
	{
		echo('No songId');
	}
	