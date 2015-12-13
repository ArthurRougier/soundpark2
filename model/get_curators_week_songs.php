<?php
	session_start();
	include_once("connect_sql.php");

	if(isset($_SESSION['id_curator']) OR isset($_GET['curatorId']))
	{
		$curatorId = $_SESSION['id_curator'] ?: $_GET['curatorId'];
		$req= $bdd->prepare('SELECT url, date_add, ID FROM songNew WHERE songNew.ID_curator=? AND songNew.treated = FALSE ORDER BY date_add DESC');
		$req->execute(array($curatorId));
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
	
	

	
