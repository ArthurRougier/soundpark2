<?php

	include_once("../model/connect_sql.php");

	if(isset($_GET['idSong']))
	{
		
		$req = $bdd->prepare('SELECT * FROM song WHERE ID=?');
		$req->execute(array($_GET['idSong']));	
		$track=$req->fetch();


		$req = $bdd->prepare('INSERT INTO proposed_song (ID_curator, date_add, treated, duration, artwork_url, genre, occ1, occ2, title, artist, trackId, permalink_url) VALUES(:ID_curator, NOW(), 1, :duration, :artwork_url, :genre, :occ1, :occ2, :title, :artist, :trackId, :permalink_url)');
		$req->execute(array(
				'ID_curator' => $track[1],
				'duration' => $track[3],
				'artwork_url' => $track[4],
				'genre' => $track[5],
				'occ1' => $track[6],
				'occ2' => $track[7],
				'title' => $track[8],
				'artist' => $track[9],
				'trackId' => $track[10],
				'permalink_url' => $track[11]
				));


		$req = $bdd->prepare('DELETE FROM song WHERE ID=?');
		$req->execute(array($_GET['idSong']));
	}
	else
	{
		echo "error";
	}

if (isset($_GET['source']) AND $_GET['source']=="admin_index.php")
{
	header("Location: ../view/admin_index.php");
}
		