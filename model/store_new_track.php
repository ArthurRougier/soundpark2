<?php

	if(isset($_GET['url']) AND isset($_GET['curatorId']))
	{
		$curatorId 		= $_GET['curatorId'];
		$url 			= urldecode($_GET['url']);
		$treated 		= $_GET['treated'] ?: 0;
		$playlistId 	= $_GET['playlistId'] ?: 0;
		include_once('../model/connect_sql.php');

		$req = $bdd->prepare(
			'INSERT INTO `songNew` (`ID_curator`, `ID_playlist`, `url`, `treated`, `date_add`) 
			VALUES (?, ?, ?, ?, NOW())'
			) or die(print_r($bdd->errorInfo()));

		$req->execute(array(
			$curatorId,
			$playlistId,
			$url,
			$treated
		));

		echo('success');
	}