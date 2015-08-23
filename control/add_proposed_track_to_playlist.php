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
	$req = $bdd->prepare('SELECT ID_curator, date_add, type, duration, artwork_url, genre, title, artist, trackId, permalink_url FROM proposed_song WHERE proposed_song.ID = ?');
	$req->execute(array($_GET['idSong']));
	$result=$req->fetch();



	if (isset($result[5]))
	{
		$insert = $bdd->prepare('INSERT INTO song(ID_playlist, ID_curator, artwork_url, genre, title, artist, trackId, duration, permalink_URL, playlistOrder) VALUES(:ID_playlist, :ID_curator, :artwork_url, :genre, :title, :artist, :trackId, :duration, :permalink_URL, :playlistOrder)');
		$insert->execute(array(
			'ID_playlist' => $nextPlaylistId,
			'ID_curator' => $result[0],
			'artwork_url' => $result[4],
			'genre' => $result[5],
			'title' => $result[6],
			'artist' => $result[7],
			'trackId' => $result[8],
			'duration' => $result[3],
			'permalink_URL' => $result[9],
			'playlistOrder' => $playlistOrderToSet
			));
	}
	else
	{
		$insert = $bdd->prepare('INSERT INTO song(ID_playlist, ID_curator, artwork_url, title, artist, trackId, duration, permalink_URL, playlistOrder) VALUES(:ID_playlist, :ID_curator, :artwork_url, :title, :artist, :trackId, :duration, :permalink_URL, :playlistOrder)');
		$insert->execute(array(
			'ID_playlist' => $nextPlaylistId,
			'ID_curator' => $result[0],
			'artwork_url' => $result[4],
			'title' => $result[6],
			'artist' => $result[7],
			'trackId' => $result[8],
			'duration' => $result[3],
			'permalink_URL' => $result[9],
			'playlistOrder' => $playlistOrderToSet
			));
	}
		
	


	//On supprime l'entrée de la table proposed_song
	$req = $bdd->prepare('DELETE from proposed_song WHERE proposed_song.ID=?');
	$req->execute(array($_GET['idSong']));


		
	if(isset($_GET['page']))
	{
			header('Location: ../view/curators_songs_history.php?message=Added');
	}
	else
	{
			header('Location: ../view/curators_songs_new.php?message=Addeed');
	}

