<?php
	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/

	if(isset($_POST['user_email']) AND isset($_POST['password']))
	{
		if(strlen($_POST['password']) > 6)
		{
			$length = 20;
			$email = $_POST['user_email'];
			$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
			include('../model/connect_sql.php');
	        $req = $bdd->prepare('UPDATE user SET password = ?, token = ? WHERE email = ?') or die(print_r($bdd->errorInfo()));
	        $req->execute(array(sha1($_POST['password']), $randomString, $email));

	      	setcookie('sessionType', 'classic', time() + 31*24*3600,  "/", null, false, true);
			setcookie('currentSession', $email.'='.$randomString, time() + 31*24*3600,  "/", null, false, true);
			setcookie('current_user', $email, time() + 31*24*3600, "/", null, false, false);
			//echo($_COOKIE['currentSession']);
	       	header('Location: ../view/frommail.php'); 
		}
		else
		{
			header('Location: ../transition_password.php?shortPassword=TRUE&pwd='.$_POST['user_email']); 
		}
		

	}
	else if (isset($_POST['user_email']))
	{
		header('Location: ../transition_password.php?noPassword=TRUE&pwd='.$_POST['user_email']); 
	}
	else
	{
		header('Location: ../view/landing.php');
	}
	