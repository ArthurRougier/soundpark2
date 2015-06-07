<?php
	if(isset($_POST['email']) && isset($_COOKIE['current_user']))
	{
	    if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email']))
	    {

	        include('../model/connect_sql.php');
	        $req=$bdd->prepare('UPDATE user SET email=? WHERE ID = ?');
	        $req->execute(array($_POST['email'],$_COOKIE['current_user']));
	        header('Location: ../view/settings.php?message=good'); 
	    }
	    else
	    {
	        header('Location: ../view/settings.php?message=InvlidEmail'); 
	        //include_once('../view/landing.php?invalidEmail=TRUE');
	    }

	}
