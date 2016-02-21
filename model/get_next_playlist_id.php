<?php
	include_once("connect_sql.php");

	$req = $bdd->query('SELECT ID FROM playlist WHERE playlist.date_end >= NOW() AND playlist.date_start <= NOW()');
	$playlistIdTab = $req->fetch();
	$currentPlaylistId = $playlistIdTab[0];

	if(isset($_GET['offset']))
	{
		if($_GET['offset'] == 1)
		{
			$nextPlaylist = $currentPlaylistId + 2;
		}
		else if($_GET['offset'] == 2)
		{
			$nextPlaylist = $currentPlaylistId + 3;
		}
		else
		{
			$nextPlaylist = $currentPlaylistId + 1;
		}
	}

	else
	{
		$nextPlaylist = $currentPlaylistId + 1;
	}


	
	if(isset($_GET['display'])){
		echo($nextPlaylist);
	}
	
