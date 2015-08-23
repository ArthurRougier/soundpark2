<?php

	include_once("../model/connect_sql.php");

	if(isset($_GET['idSong']))
	{
		$req = $bdd->prepare('UPDATE proposed_song SET treated = 1 WHERE ID=?');
		$req->execute(array($_GET['idSong']));
	}
	else
	{
		echo "error";
	}

if (isset($_GET['source']) AND $_GET['source']=="admin_songs_new.php")
{
	header("Location: ../view/admin_songs_new.php");
}
		