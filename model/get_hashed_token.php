<?php
	//entry = $ID_user, returns hashedToken
	include('connect_sql.php');
	$req = $bdd->prepare('SELECT hashed_token FROM facebook_account WHERE ID_user = ?');
	$req->execute(array($ID_user));
	
	if($res = $req->fetch())
	{
		$hashedToken = $res[0];
	}
	else
	{
		$hashedToken = 'noHashedToken';
	}
	