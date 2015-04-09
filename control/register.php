<?php
	session_start();
	if(isset($_POST['registerSource']))
	{
		if($_POST['registerSource'] == 'oldLanding')
		{
			if(isset($_POST['user_email']))
			{
				$_POST['user_email'] = htmlspecialchars($_POST['user_email']);

			    if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['user_email']))
			    {

			        include('../model/connect_sql.php');
			        $req = $bdd->prepare('SELECT EXISTS(SELECT * FROM user WHERE email = ?)');
			        $req->execute(array($_POST['user_email']));
			        $exists = $req->fetch();
			        if($exists[0])
			        {
			        	header('Location: ../view/landing.php?alreadyExists=TRUE'); 
			        	//include_once('../view/landing.php?alreadyExists=TRUE');
			        }
			        else
			        {
			        	$req = $bdd->prepare('INSERT INTO user(email, subscription_date) VALUES(?, NOW())');
						$req->execute(array($_POST['user_email']));
						include_once('mailchimpUserNewSubscribe.php');
						header('Location: ../view/registered.php?userEmail='.$_POST['user_email']); 
			        }			
			    }
			    else
			    {
			        header('Location: ../view/landing.php?invalidEmail=TRUE'); 
			        //include_once('../view/landing.php?invalidEmail=TRUE');
			    }
			}
		}
		else if($_POST['registerSource'] == 'newLanding')
		{
			if(isset($_POST['user_email']) AND isset($_POST['password']))
			{
				$email = htmlspecialchars($_POST['user_email']);
				$hashPassword = sha1($_POST['password']);

			    if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email))
			    {

			        include('../model/connect_sql.php');
			        $req = $bdd->prepare('SELECT EXISTS(SELECT * FROM user WHERE email = ?)');
			        $req->execute(array($email));
			        $exists = $req->fetch();
			        if($exists[0])
			        {
			        	header('Location: ../view/landing.php?alreadyExists=TRUE'); 
			        	//include_once('../view/landing.php?alreadyExists=TRUE');
			        }
			        else
			        {
			        	$length = 20;
						$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
			        	$req = $bdd->prepare('INSERT INTO user(email, password, token, type, subscription_date) VALUES(?, ?, ?, ?, NOW())');
						$req->execute(array($email, $hashPassword, $randomString, $_POST['userType']));
						if($_POST['userType'] == 2)
						{
							// On vient récupérer son tout nouvel userId
							$req = $bdd->prepare('SELECT ID  FROM user WHERE email = ?') or die(print_r($bdd->errorInfo()));
							$req->execute(array($email));
							$Id = $req->fetch();
							$userId = $Id[0];
							$req = $bdd->prepare('INSERT INTO curator(ID_user) VALUES(?)');
							$req->execute(array($userId));
						}
						setcookie('sessionType', 'classic', time() + 31*24*3600,  "/", null, false, true);
						setcookie('currentSession', $email.'='.$randomString, time() + 31*24*3600,  "/", null, false, true);
						setcookie('current_user', email, time() + 7*24*3600, "/", null, false, false);
						include_once('mailchimpUserNewSubscribe.php');
						header('Location: ../view/registered.php?userEmail='.$email); 
			        }			
			    }
			    else
			    {
			        header('Location: ../view/landing.php?invalidEmail=TRUE'); 
			        //include_once('../view/landing.php?invalidEmail=TRUE');
			    }
			}
			else if(isset($_POST['user_email']))
		    {
		        header('Location: ../view/landing.php?missingPassword=TRUE'); 
		        //include_once('../view/landing.php?invalidEmail=TRUE');
		    }
		    else
		    {
		    	 header('Location: ../view/landing.php?missingAll=TRUE'); 
		    }
		}
		else
		{
			if(isset($_POST['user_email']))
			{
				$_POST['user_email'] = htmlspecialchars($_POST['user_email']);

			    if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['user_email']))
			    {

			        include('../model/connect_sql.php');
			        $req = $bdd->prepare('SELECT EXISTS(SELECT * FROM user WHERE email = ?)');
			        $req->execute(array($_POST['user_email']));
			        $exists = $req->fetch();
			        if($exists[0])
			        {
			        	header('Location: ../view/landing.php?alreadyExists=TRUE'); 
			        	//include_once('../view/landing.php?alreadyExists=TRUE');
			        }
			        else
			        {
			        	$req = $bdd->prepare('INSERT INTO user(email, subscription_date) VALUES(?, NOW())');
						$req->execute(array($_POST['user_email']));
						include_once('mailchimpUserNewSubscribe.php');
						header('Location: ../view/registered.php?userEmail='.$_POST['user_email']); 
			        }			
			    }
			    else
			    {
			        header('Location: ../view/landing.php?invalidEmail=TRUE'); 
			        //include_once('../view/landing.php?invalidEmail=TRUE');
			    }
			}
		}
	}
	
	

function generateRandomString($length = 30) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
	