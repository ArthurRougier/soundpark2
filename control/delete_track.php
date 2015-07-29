<?php
	include_once("../model/connect_sql.php");
	if(isset($_GET['idSong']))
	{
		if (isset($_GET['source']) AND $_GET['source']=="admin_songs_storage.php" )
		{
			$req = $bdd->prepare('DELETE FROM proposed_song WHERE ID = ?');
			$req->execute(array($_GET['idSong']));
			header('Location: ../view/admin_songs_storage.php?message=Updated');
		}
		else
		{
			$req = $bdd->prepare('DELETE FROM song WHERE id = ?');
			$req->execute(array($_GET['idSong']));
			header('Location: ../view/admin_index.php?message=Updated');
		}
	}
	else
	{
		echo('No songId');
	}