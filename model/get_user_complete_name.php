<?php
	
	include_once('connect_sql.php');
	if(isset($_COOKIE['current_user']))
	{
		$req = $bdd->prepare('SELECT pseudo FROM curator WHERE ID_user = ?');
		$req->execute(array($_COOKIE['current_user']));
		if($names = $req->fetch())
		{
			$completeName = $names[0];
			if(isset($_GET['displayResult']))
			{
				echo $completeName;
			}
		}

		else
		{
			$req = $bdd->prepare('SELECT first_name, last_name FROM facebook_account WHERE ID_user = ?');
			$req->execute(array($_COOKIE['current_user']));
			if($names = $req->fetch())
			{
				$completeName = $names[0] . ' ' . $names[1];
				if(isset($_GET['displayResult']))
				{
					echo $completeName;
				}
			}
			else
			{
				$req = $bdd->prepare('SELECT email FROM user WHERE ID = ?');
				$req->execute(array($_COOKIE['current_user']));
				if($names = $req->fetch())
				{
					$completeName = $names[0];
					if(isset($_GET['displayResult']))
					{
						echo $completeName;
					}
				}
			}
		}		
	}
	else
	{
	}


	

	