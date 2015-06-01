<?php
	
	if(isset($_POST['currentPassword']) && isset($userHashedPassword) && isset($_POST['newPassword']))
	{
		include_once('../model/connect_sql.php');
		if(sha1($_POST['currentPassword']) == $userHashedPassword)
		{
			include_once('../model/connect_sql.php');
			$hashPassword = sha1($_POST['newPassword']);
			$req=$bdd->prepare('UPDATE user SET password=? WHERE ID = ?');
			$req->execute(array($hashPassword,$_COOKIE['current_user']));
			$message = 'password well changed!';
		}
		else
		{
			$message = 'Wrong current password.';
		}
	}
		