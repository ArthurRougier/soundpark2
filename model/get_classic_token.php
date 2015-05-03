<?php
	//entry = ID_user, returns classicToken
	include('connect_sql.php');
	$req = $bdd->prepare('SELECT token FROM user WHERE user.ID = ?');
	$req->execute(array($ID_user));
	if($res = $req->fetch())
	{
		$classicToken = $res[0];
	}
	else
	{
		$classicToken = 'baysey';
	}
	