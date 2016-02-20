<?php
	if(isset($_COOKIE['current_user']))
	{
		include_once('connect_sql.php');
		$req=$bdd->prepare('SELECT type FROM user WHERE ID=?');
		$req->execute(array($_COOKIE['current_user']));
		$resultat=$req->fetch();
		if(isset($_GET['displayResult']))
		{
			echo $resultat[0];
		}
	}