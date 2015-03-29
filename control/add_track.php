<?php

include_once('../model/connect_sql.php');

//on prend le dernier song Order pour calculer le suivant
	$req2 = $bdd->query('SELECT playlistOrder FROM song ORDER BY ID DESC LIMIT 1');
	
	if($lastPlaylistOrderNumber = $req2->fetch())
	{
		$playlistOrderToSet = $lastPlaylistOrderNumber[0] + 1;
	}
	else
	{
		$playlistOrderToSet = 1;
	}


if(isset($playlistOrderToSet) AND isset($_GET['title']) AND isset($_GET['artist']) AND isset($_GET['trackArtWork']) AND isset($_GET['genre']) AND isset($_GET['trackId']) AND isset($_GET['idCurator']) AND isset($_GET['permalinkUrl']))
{
	$req = $bdd->prepare('INSERT INTO song(ID_playlist, ID_curator, artwork_url, genre, title, artist, trackId, duration, permalink_URL, playlistOrder) VALUES(:ID_playlist, :ID_curator, :artwork_url, :genre, :title, :artist, :trackId, :duration, :permalink_URL, :playlistOrder)');
	$req->execute(array(
		'ID_playlist' => $_GET['playlist'],
		'ID_curator' => $_GET['idCurator'],
		'artwork_url' => $_GET['trackArtWork'],
		'genre' => $_GET['genre'],
		'title' => $_GET['title'],
		'artist' => $_GET['artist'],
		'trackId' => $_GET['trackId'],
		'duration' => $_GET['duration'],
		'permalink_URL' => $_GET['permalinkUrl'],
		'playlistOrder' => $playlistOrderToSet
		));
	header('Location: ../view/create_playlist.php?addTrack=TRUE&idPlaylist='.$_GET['playlist']);
}

else if(isset($_GET['title']) AND isset($_GET['artist']) AND isset($_GET['trackArtWork']) AND isset($_GET['genre']) AND isset($_GET['trackId']) AND isset($_GET['idCurator']) AND isset($_GET['permalinkUrl']))
{
	$req = $bdd->prepare('INSERT INTO song(ID_playlist, ID_curator, artwork_url, genre, title, artist, trackId, duration, permalink_URL) VALUES(:ID_playlist, :ID_curator, :artwork_url, :genre, :title, :artist, :trackId, :duration, :permalink_URL)');
	$req->execute(array(
		'ID_playlist' => $_GET['playlist'],
		'ID_curator' => $_GET['idCurator'],
		'artwork_url' => $_GET['trackArtWork'],
		'genre' => $_GET['genre'],
		'title' => $_GET['title'],
		'artist' => $_GET['artist'],
		'trackId' => $_GET['trackId'],
		'duration' => $_GET['duration'],
		'permalink_URL' => $_GET['permalinkUrl']
		));
	header('Location: ../view/create_playlist.php?addTrack=TRUE&idPlaylist='.$_GET['playlist']);
}
else if(isset($playlistOrderToSet) AND isset($_GET['title']) AND isset($_GET['artist']) AND isset($_GET['trackArtWork']) AND isset($_GET['trackId']) AND isset($_GET['idCurator']) AND isset($_GET['permalinkUrl']) )
{
	$req = $bdd->prepare('INSERT INTO song(ID_playlist, ID_curator, artwork_url, title, artist, trackId, duration, permalink_URL, playlistOrder)  VALUES(:ID_playlist, :ID_curator, :artwork_url, :title, :artist, :trackId, :duration, :permalink_URL, :playlistOrder)');
	$req->execute(array(
		'ID_playlist' => $_GET['playlist'],
		'ID_curator' => $_GET['idCurator'],
		'artwork_url' => $_GET['trackArtWork'],
		'title' => $_GET['title'],
		'artist' => $_GET['artist'],
		'trackId' => $_GET['trackId'],
		'duration' => $_GET['duration'],
		'permalink_URL' => $_GET['permalinkUrl'],
		'playlistOrder' => $playlistOrderToSet
		));
	header('Location: ../view/create_playlist.php?addTrack=TRUE&idPlaylist='.$_GET['playlist']);
}
else if(isset($playlistOrderToSet) AND isset($_GET['artist']) AND isset($_GET['trackArtWork']) AND isset($_GET['trackId']) AND isset($_GET['idCurator']) AND isset($_GET['permalinkUrl']) )
{
	$req = $bdd->prepare('INSERT INTO song(ID_playlist, ID_curator, artwork_url, title, artist, trackId, duration, permalink_URL, playlistOrder)  VALUES(:ID_playlist, :ID_curator, :artwork_url, :title, :artist, :trackId, :duration, :permalink_URL, :playlistOrder)');
	$req->execute(array(
		'ID_playlist' => $_GET['playlist'],
		'ID_curator' => $_GET['idCurator'],
		'artwork_url' => $_GET['trackArtWork'],
		'title' => "no title",
		'artist' => $_GET['artist'],
		'trackId' => $_GET['trackId'],
		'duration' => $_GET['duration'],
		'permalink_URL' => $_GET['permalinkUrl'],
		'playlistOrder' => $playlistOrderToSet
		));
	header('Location: ../view/create_playlist.php?addTrack=TRUE&idPlaylist='.$_GET['playlist']);
}
else
{
	echo('error, #121');
}



?>