<?php
	//entry = userEmail, returns hashedToken
	include_once('connect_sql.php');
	$req = $bdd->prepare('SELECT token FROM user WHERE user.email = ?');
	$req->execute(array($userEmail));
	if($res = $req->fetch())
	{
		$hashedToken = $res[0];
	}
	