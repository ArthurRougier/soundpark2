<?php
	//entry = userEmail, returns classicToken
	include('connect_sql.php');
	$req = $bdd->prepare('SELECT token FROM user WHERE user.email = ?');
	$req->execute(array($userEmail));
	if($res = $req->fetch())
	{
		$classicToken = $res[0];
	}
	else
	{
		$classicToken = 'baysey';
	}
	