<?php
	include_once('connect_sql.php');
	if(isset($_COOKIE['current_user']))
	{
		$req = $bdd->prepare('SELECT picture_url FROM facebook_account WHERE ID_user = ?');
		$req->execute(array($_COOKIE['current_user']));
		if($result = $req->fetch())
		{
			$pictureUrl = $result[0];
			if(isset($_GET['displayResult']))
			{
				echo $pictureUrl;
			}
		}
	}