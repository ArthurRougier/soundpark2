<?php

	include_once ('connect_sql.php');

	$req1 = $bdd->query(
		'SELECT ID
		FROM playlist 
		WHERE 
			playlist.date_end >= NOW() 
			AND playlist.date_start <= NOW()  ');

	$result = $req1->fetch();
	$minimumPlaylist = $result[0] - 1;
	$maximumPlaylist = $result[0] + 1;

	$i = 0;

	$req2 = $bdd->prepare(
		'SELECT songNew.`ID`, `ID_curator`, `ID_playlist`, `url`, `ID_occasion1`, `ID_occasion2`, `playlistOrder`, `date_add`, `treated`, `ID_Genre`, `pseudo`, `avatar_url`, `link` 
		FROM songNew, curator
		WHERE 
			songNew.ID_curator = curator.ID
			AND songNew.ID_playlist <= ?
			AND songNew.ID_playlist >= ?');

	$req2->execute(array(
		$maximumPlaylist,
		$minimumPlaylist
		));

	$i = 0;
	$songsArray = array();
	while($song = $req2->fetch())
	{
		$songsArray[$i] = array("id" => $song['ID'], "curatorId" => $song['ID_curator'], "playlistId" => $song['ID_playlist'], "url" => $song['url'], "occasion1" => $song['ID_occasion1'], "occasion2" => $song['ID_occasion2'], "playlistOrder" => $song['playlistOrder'], "songDateAdd" => $song['date_add'], "treated" => $song['treated'], "genre" => $song['ID_Genre'], "curatorPseudo" => $song['pseudo'], "curatorPic" => $song['avatar_url'], "curatorLink" => $song['link']);
		$i++;
	}
	echo(json_encode($songsArray));