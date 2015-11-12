<?php

	include_once ('connect_sql.php');
	$req2 = $bdd->query('SELECT ID, pseudo FROM curator');
	$i = 0;
	$curatorsArray = array();
	while($curator = $req2->fetch())
	{
		$curatorsArray[$i] = array("curatorId" => $curator[0], "pseudo" => $curator[1]);
		$i++;
	}
	echo(json_encode($curatorsArray));