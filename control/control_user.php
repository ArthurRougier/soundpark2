<?php
	if(isset($_COOKIE['idType']))
	{
		/*if($_COOKIE['idType'] == 'facebook')
		{
			include_once('../model/get_user_hashed_token.php'); // returne $hashedToken
			if($hashedToken != $_COOKIE['hashedToken'])
			{
				header('Location: ../view/landing.php');
			}
		}
		else if($_COOKIE['idType'] == 'classic')
		{
			include_once('../model/get_user_hashed_password.php'); // returne $hashedPassword
			if($hashedPassword != $_COOKIE['hashedPassword'])
			{
				header('Location: ../view/landing.php');
			}
		}*/
	}
	else
	{
		include_once('../model/find_user_email.php');
		if($res = $req->fetch()) 
		{
	     	
		}
		else
		{
			header('Location: ../view/landing.php');
		}

	}




	