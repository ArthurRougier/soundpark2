<?php
	if(isset($_POST['new_user_email']) && isset($_POST['user_email']) && isset($_COOKIE['current_user']))
	{
	    if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['new_user_email']))
	    {

	        include('../model/connect_sql.php');
	        $req=$bdd->prepare('UPDATE user SET email=? WHERE ID = ?');
	        $req->execute(array($_POST['new_user_email'],$_COOKIE['current_user']));
	        include_once('../control/mailchimpUserUpdate.php');
	        header('Location: ../view/settings.php?message=good'); 
	    }
	    else
	    {
	        header('Location: ../view/settings.php?message=InvlidEmail'); 
	        //include_once('../view/landing.php?invalidEmail=TRUE');
	    }

	}
