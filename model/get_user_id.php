<?php
	if(isset($_COOKIE['current_user']))
	{
		$userId = $_COOKIE['current_user'];
	}
	else if(isset($_GET['pwd']))
	{
		include_once('connect_sql.php');
		$req=$bdd->prepare('SELECT ID FROM user WHERE user.email = ? ');
		$req->execute(array($_GET['pwd']));
		if($rep = $req->fetch())
		{
			$userId = $rep[0];
		}
	}
	else if(isset($email))
	{
		include_once('connect_sql.php');
		$req=$bdd->prepare('SELECT ID FROM user WHERE user.email = ? ');
		$req->execute(array($email));
		if($rep = $req->fetch())
		{
			$userId = $rep[0];
		}
	}

	if(isset($_GET['displayResults']))
	{
		echo $userId;
	}
	