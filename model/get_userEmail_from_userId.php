<?php
	if(isset($userId))
	{
		include_once('connect_sql.php');
		$req=$bdd->prepare('SELECT email FROM user WHERE user.ID = ? ');
		$req->execute(array($userId));
		if($rep = $req->fetch())
		{
			$userEmail = $rep[0];
		}
	}
	else if(isset($_COOKIE['current_user'])) // on gère aussi le cas ou il est dans les cookies
	{
		include_once('connect_sql.php');
		$req=$bdd->prepare('SELECT email FROM user WHERE user.ID = ? ');
		$req->execute(array($_COOKIE['current_user']));
		if($rep = $req->fetch())
		{
			$userEmail = $rep[0];
		}
	}

	