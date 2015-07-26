<?php
	// creates $betaUserArray
	include_once('connect_sql.php');
	$req = $bdd->query('SELECT id FROM user WHERE beta = 1');
	$betaUserArray = array();
	while($result = $req->fetch())
	{
		array_push($betaUserArray, $result[0]);
	}