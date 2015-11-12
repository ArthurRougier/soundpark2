<?php

	include_once ('connect_sql.php');
	$req2 = $bdd->query('SELECT ID_genre, name FROM genres');
	$i = 0;
	$genresArray = array();
	while($genre = $req2->fetch())
	{
		$genresArray[$i] = array("payload" => $genre[0], "text" => $genre[1]);
		$i++;
	}
	echo(json_encode($genresArray));