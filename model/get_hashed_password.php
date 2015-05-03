<?php
	//require $email
	if(isset($email))
	{
		include('connect_sql.php');
		$req = $bdd->prepare('SELECT password FROM soundpark2.user WHERE user.email = ?');
		$req->execute(array($email));
		
		if($res = $req->fetch())
		{
			$hashedPasswordDb = $res[0];
		}
		else
		{
			$hashedPasswordDb = 'noHashedPassword';
		}
	}
	else if(isset($userId))
	{
		include('connect_sql.php');
		$req = $bdd->prepare('SELECT password FROM soundpark2.user WHERE user.ID = ?');
		$req->execute(array($userId));
		
		if($res = $req->fetch())
		{
			$hashedPasswordDb = $res[0];
		}
		else
		{
			$hashedPasswordDb = 'noHashedPassword';
		}
	}
	else
	{
		$hashedPasswordDb = 'noEmail';
	}
	
	