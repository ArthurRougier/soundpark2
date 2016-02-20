<?php
	session_start();
	include_once("connect_sql.php");

	if(isset($_SESSION['id_curator']) OR isset($_GET['curatorId']))
	{
		$req2 = $bdd->query('SELECT ID FROM playlist WHERE playlist.date_end >= NOW() AND playlist.date_start <= NOW()');
		$playlistIdTab = $req2->fetch();
		$currentPlaylistId = $playlistIdTab[0];

		$curatorId = $_SESSION['id_curator'] ?: $_GET['curatorId'];
		$req= $bdd->prepare('SELECT url, date_add, songNew.ID FROM songNew, playlist WHERE songNew.ID_curator=? AND playlist.date_end >= songNew.date_add AND playlist.date_start <= songNew.date_add AND playlist.id = ? ORDER BY date_add DESC');
		$req->execute(array(
			$curatorId,
			$currentPlaylistId
		));
	}

	if(isset($_GET['displayResults']))
	{
		$i = 0;
		$songsArray = array();
		while($song = $req->fetch())
		{
			$songsArray[$i] = array("ID" => $song['ID'], "url" => $song['url'], "dateAdd" => $song['date_add']);
			$i++;
		}
		echo(json_encode($songsArray));
	}
	
	

	
