<?php

include_once('../model/connect_sql.php');

include_once('../model/get_newsong_status.php');



if (isset($_GET['trackId']) AND !$exists)
{
	if(isset($_GET['title']) AND isset($_GET['artist']) AND isset($_GET['trackArtWork']) AND isset($_GET['genre']) AND isset($_GET['trackId']) AND isset($_GET['curatorId']) AND isset($_GET['permalinkUrl']) AND isset($_GET['type']) )
	{
		$req = $bdd->prepare('INSERT INTO proposed_song(ID_curator, date_add, type, treated, artwork_url, genre, title, artist, trackId, duration, permalink_URL) VALUES(:ID_curator, NOW(), :type, :treated, :artwork_url, :genre, :title, :artist, :trackId, :duration, :permalink_URL)');
		$req->execute(array(
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
		else if ($_GET['source'] == "admin")
		{
			header('Location: ../view/admin_songs_new.php?message=successAdd');
		}
		else
		{
			header('Location: ../view/create_playlist.php?yala=yala'); //A UPDATER
		}	
	}
	else if(isset($_GET['title']) AND isset($_GET['artist']) AND isset($_GET['trackArtWork']) AND isset($_GET['trackId']) AND isset($_GET['curatorId']) AND isset($_GET['permalinkUrl']) AND isset($_GET['type']) )
	{
		$req = $bdd->prepare('INSERT INTO proposed_song(ID_curator, date_add, type, treated, artwork_url, title, artist, trackId, duration, permalink_URL) VALUES(:ID_curator, NOW(), :type, :treated, :artwork_url, :title, :artist, :trackId, :duration, :permalink_URL)');
		$req->execute(array(
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
		else if ($_GET['source'] == "admin")
		{
			header('Location: ../view/admin_songs_new.php?message=successAdd');
		}
		else
		{
			header('Location: ../view/create_playlist.php?yala=yala'); //A UPDATER
		}
	}
	else if(isset($_GET['artist']) AND isset($_GET['trackArtWork']) AND isset($_GET['trackId']) AND isset($_GET['curatorId']) AND isset($_GET['permalinkUrl']) AND isset($_GET['type']) )
	{
		$req = $bdd->prepare('INSERT INTO proposed_song(ID_curator, date_add, type, treated, artwork_url, title, artist, trackId, duration, permalink_URL) VALUES(:ID_curator, NOW(), :type, :treated, :artwork_url, :title, :artist, :trackId, :duration, :permalink_URL)');
		$req->execute(array(
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
		else if ($_GET['source'] == "admin")
		{
			header('Location: ../view/admin_songs_new.php?message=successAdd');
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
	if ($_GET['source'] == "dropPage") 
	{
		header('Location: ../view/curator_index.php?message=this song has already been posted!');
	}
	else if ($_GET['source'] == "admin")
	{
		header('Location: ../view/admin_songs_new.php?message=this song has already been posted!');
	}
}


?>