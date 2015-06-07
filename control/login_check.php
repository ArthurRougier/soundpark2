<?php
	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/

	if(isset($_POST['user_email']) AND isset($_POST['password'])) // Si on a bien reçu les deux parametre, sinon renvoyer avec code d'erreur
	{
		$email = htmlspecialchars($_POST['user_email']);
		$hashPassword = sha1($_POST['password']);

	    if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) // Si l'email est valide sinon on ne se fait pas chier
	    {

	        include('../model/connect_sql.php');
	        $req = $bdd->prepare('SELECT EXISTS(SELECT * FROM user WHERE email = ?)');
	        $req->execute(array($email));
	        $exists = $req->fetch();
	        if($exists[0]) // si l'email existe, sinon renvoyer code d'erreur adapté
	        {
	        	include('../model/get_hashed_password.php');
	        	include('../model/get_user_id.php'); //take $email as entry, returns $userId
	        	if($hashedPasswordDb == $hashPassword)
	        	{
	        		//good. On met à jour le token et les cookies. 
		        	$length = 20;
					$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
		        	$req = $bdd->prepare('UPDATE user SET token=? WHERE ID = ?') or die(print_r($bdd->errorInfo()));
					$req->execute(array($randomString, $userId));

					setcookie('sessionType', 'classic', time() + 31*24*3600,  "/", null, false, true);
					setcookie('currentSession', $userId.'='.$randomString, time() + 31*24*3600,  "/", null, false, true);
					setcookie('current_user', $userId, time() + 31*24*3600, "/", null, false, false);

					if(isset($_POST['urlSource']))
					{
						header('Location: '.$_POST['urlSource']); 
					}
					else
					{
						header('Location: ../view/frommail.php?pwd='.$email); 
					}
	        	}
	        	else
	        	{
	        		if(isset($_POST['urlSource']))
					{
						header('Location: ../view/landing.php?wrongPassword=TRUE&source='.$_POST['urlSource']); 
					}
					else
					{
						header('Location: ../view/landing.php?wrongPassword=TRUE'); 
					}
	        	}
	        	//include_once('../view/landing.php?alreadyExists=TRUE');
	        }
	        else
	        {
        		if(isset($_POST['urlSource']))
				{
					header('Location: ../view/landing.php?unknownEmail=TRUE&source='.$_POST['urlSource']); 
				}
				else
				{
	        		header('Location: ../view/landing.php?unknownEmail=TRUE'); 
	        	}
	        }			
	    }
	    else
	    {
    		if(isset($_POST['urlSource']))
			{
				header('Location: ../view/landing.php?invalidEmail=TRUE&source='.$_POST['urlSource']); 
			}
			else
			{
        		header('Location: ../view/landing.php?invalidEmail=TRUE'); 
        	}
	        
	        //include_once('../view/landing.php?invalidEmail=TRUE');
	    }
	}
	else if(isset($_POST['user_email']))
    {
		if(isset($_POST['urlSource']))
		{
			header('Location: ../view/landing.php?missingPassword=TRUE&source='.$_POST['urlSource']); 
		}
		else
		{
    		header('Location: ../view/landing.php?missingPassword=TRUE'); 
    	}
       
        //include_once('../view/landing.php?invalidEmail=TRUE');
    }
    else
    {
    	 header('Location: ../view/landing.php?missingAll=TRUE'); 
    }