<?php
	include_once("connect_sql.php");
	$req = $bdd->query('SELECT ID FROM playlist WHERE playlist.date_end >= NOW() AND playlist.date_start <= NOW()');
	$playlistIdTab = $req->fetch();
	$currentPlaylistId = $playlistIdTab[0];
	
	if(isset($_GET['display'])){
		echo($currentPlaylistId);
	}
	
