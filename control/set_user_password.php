<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	if(isset($_POST['setPassword']) && isset($_COOKIE['current_user']))
	{
		include_once('../model/connect_sql.php');
		$hashPassword = sha1($_POST['setPassword']);
		$req=$bdd->prepare('UPDATE user SET password=? WHERE ID = ?');
		$req->execute(array($hashPassword,$_COOKIE['current_user']));
		header('Location: ../view/settings.php');

	}
	
	else
	{
		echo 'iuhr';
	}