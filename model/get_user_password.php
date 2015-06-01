<?php
	
	if(isset($_COOKIE['current_user']))
	{
		include_once('../model/connect_sql.php');
		$req=$bdd->prepare('SELECT password FROM user WHERE user.ID = ? ');
		$req->execute(array($_COOKIE['current_user']));
		if($rep = $req->fetch())
		{
			$userHashedPassword = $rep[0];
			// echo $userHashedPassword;
		}
		else
		{
			$userHashedPassword = false;
		}
	}
