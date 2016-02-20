<?php

	include_once ('connect_sql.php');
	$req2 = $bdd->query('SELECT ID_occasion, name FROM occasions');
	$i = 0;
	$occasionsArray = array();
	while($occasion = $req2->fetch())
	{
		$occasionsArray[$i] = array("payload" => $occasion[0], "text" => $occasion[1]);
		$i++;
	}
	echo(json_encode($occasionsArray));