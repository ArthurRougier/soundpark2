<?php

include_once('../model/connect_sql.php');


if (isset($_GET['trackId']))
{
	$req = $bdd->prepare('SELECT ID, trackID FROM song WHERE trackID=?');
	$req->execute(array($_GET['trackId']));
	$dejaPublie=$req->fetch();
}


if (!$dejaPublie)
{
	if(isset($_GET['title']) AND isset($_GET['artist']) AND isset($_GET['trackArtWork']) AND isset($_GET['genre']) AND isset($_GET['trackId']) AND isset($_GET['curatorId']) AND isset($_GET['permalinkUrl']) AND isset($_GET['type']) )
	{
		$req = $bdd->prepare('INSERT INTO proposed_song(ID_playlist, ID_curator, date_add, type, treated, artwork_url, genre, title, artist, trackId, duration, permalink_URL) VALUES(:ID_playlist, :ID_curator, NOW(), :type, :treated, :artwork_url, :genre, :title, :artist, :trackId, :duration, :permalink_URL)');
		$req->execute(array(
			'ID_playlist' => $_GET['playlist'],
			'ID_curator' => $_GET['curatorId'],
			'type' => $_GET['type'],
			'treated' => FALSE,
			'artwork_url' => $_GET['trackArtWork'],
			'genre' => $_GET['genre'],
			'title' => $_GET['title'],
			'artist' => $_GET['artist'],
			'trackId' => $_GET['trackId'],
			'duration' => $_GET['duration'],
			'permalink_URL' => $_GET['permalinkUrl']
			));
		if ($_GET['source'] == "dropPage") 
		{
			header('Location: ../view/curator_index.php?message=successAdd');
		}
		else
		{
			header('Location: ../view/create_playlist.php?yala=yala'); //A UPDATER
		}	
	}
	else if(isset($_GET['title']) AND isset($_GET['artist']) AND isset($_GET['trackArtWork']) AND isset($_GET['trackId']) AND isset($_GET['curatorId']) AND isset($_GET['permalinkUrl']) AND isset($_GET['type']) )
	{
		$req = $bdd->prepare('INSERT INTO proposed_song(ID_playlist, ID_curator, date_add, type, treated, artwork_url, title, artist, trackId, duration, permalink_URL) VALUES(:ID_playlist, :ID_curator, NOW(), :type, :treated, :artwork_url, :title, :artist, :trackId, :duration, :permalink_URL)');
		$req->execute(array(
			'ID_playlist' => $_GET['playlist'],
			'ID_curator' => $_GET['curatorId'],
			'type' => $_GET['type'],
			'treated' => FALSE,
			'artwork_url' => $_GET['trackArtWork'],
			'title' => $_GET['title'],
			'artist' => $_GET['artist'],
			'trackId' => $_GET['trackId'],
			'duration' => $_GET['duration'],
			'permalink_URL' => $_GET['permalinkUrl']
			));
		
		if ($_GET['source'] == "dropPage") 
		{
			header('Location: ../view/curator_index.php?message=successAdd');
		}
		else
		{
			header('Location: ../view/create_playlist.php?yala=yala'); //A UPDATER
		}
	}
	else if(isset($_GET['artist']) AND isset($_GET['trackArtWork']) AND isset($_GET['trackId']) AND isset($_GET['curatorId']) AND isset($_GET['permalinkUrl']) AND isset($_GET['type']) )
	{
		$req = $bdd->prepare('INSERT INTO proposed_song(ID_playlist, ID_curator, date_add, type, treated, artwork_url, title, artist, trackId, duration, permalink_URL) VALUES(:ID_playlist, :ID_curator, NOW(), :type, :treated, :artwork_url, :title, :artist, :trackId, :duration, :permalink_URL)');
		$req->execute(array(
			'ID_playlist' => $_GET['playlist'],
			'ID_curator' => $_GET['curatorId'],
			'type' => $_GET['type'],
			'treated' => FALSE,
			'artwork_url' => $_GET['trackArtWork'],
			'title' => "no title",
			'artist' => $_GET['artist'],
			'trackId' => $_GET['trackId'],
			'duration' => $_GET['duration'],
			'permalink_URL' => $_GET['permalinkUrl']
			));
		
		if ($_GET['source'] == "dropPage") 
		{
			header('Location: ../view/curator_index.php?message=successAdd');
		}
		else
		{
			header('Location: ../view/create_playlist.php?yala=yala'); //A UPDATER
		}
	}
	else
	{
		echo('error #122');
	}
}
else
{
	header("Location: ../view/curator_index.php?message=Sorry dude, we've already played this track. That's just a sign that you have great taste");
}


?>