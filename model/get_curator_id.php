<?php
	if(isset($_COOKIE['current_user']))
	{
		include_once('connect_sql.php');
		$req=$bdd->prepare('SELECT curator.ID FROM curator, user WHERE user.ID = curator.ID_user AND user.ID = ? ');
		$req->execute(array($_COOKIE['current_user']));
		if($rep = $req->fetch())
		{
			$curatorId = $rep[0];
		}
	}

	if(isset($_GET['displayResults']))
	{
		echo $curatorId;
	}
	