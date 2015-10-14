<?php

	include_once("connect_sql.php");
	include_once("../model/get_current_playlist_id.php"); // renvoi $playlistId
	$nextPlaylistId = $currentPlaylistId + 1;


/* PART DE CODE SUPPRIMEE PAR THEO : UNE FOIS QU'UNE TUNE PASSE EN PLAYLIST, ELLE EST SUPPRIMEE DE proposed_song
	// on met à jour proposed song
	$req = $bdd->prepare('UPDATE proposed_song SET treated=1, ID_playlist=? WHERE proposed_song.ID = ?');
	$req->execute(array(
		$nextPlaylistId,
		$_GET['idSong']
		));
*/

	//on prend le dernier song Order pour calculer le suivant
	$req2 = $bdd->query('SELECT playlistOrder FROM song ORDER BY ID DESC LIMIT 1');
	
	if($lastPlaylistOrderNumber = $req2->fetch())
	{
		$playlistOrderToSet = $lastPlaylistOrderNumber[0] + 1;
	}
	else
	{
		$lastPlaylistOrderNumber[0] = 0;
	}
	

	
	//on vient maintenant chercher la ligne a insérer dans song
	$req = $bdd->prepare('SELECT * FROM song WHERE ID = ?');
	$req->execute(array($_GET['idSong']));
	$result=$req->fetch();



	if (isset($result))
	{
		$insert = $bdd->prepare('INSERT INTO song(ID_curator, ID_playlist, duration, artwork_url, genre, occ1, occ2, title, artist, trackId, permalink_url, playlistOrder) VALUES(:ID_curator, :ID_playlist, :duration, :artwork_url, :genre, :occ1, :occ2, :title, :artist, :trackId, :permalink_url, :playlistOrder)');
		$insert->execute(array(	
			'ID_curator' => $result[1],
			'ID_playlist' => $nextPlaylistId,
			'duration' => $result[3],
			'artwork_url' => $result[4],
			'genre' => $result[5],
			'occ1' => $result[6],
			'occ2' => $result[7],
			'title' => $result[8],
			'artist' => $result[9],
			'trackId' => $result[10],
			'permalink_url' => $result[11],
			'playlistOrder' => $playlistOrderToSet
			));

	}
		
	

		
	if(isset($_GET['source']) & $_GET['source']=="admin_songs_history.php")
	{
			header('Location: ../view/admin_songs_history.php?message=Added');
	}
	else
	{
			header('Location: ../view/admin_index.php?message=Addeed');
	}

