<?php
	if(isset($_COOKIE['current_user']))
	{
		include_once('connect_sql.php');
		$req=$bdd->prepare('SELECT email FROM user WHERE user.ID = ? ');
		$req->execute(array($_COOKIE['current_user']));
		if($rep = $req->fetch())
		{
			$userEmail = $rep[0];
		}
	}

	