<?php
	//entry = userEmail, returns hashedToken
	include_once('connect_sql.php');
	$req = $bdd->prepare('SELECT hashed_token FROM facebook_account, user WHERE user.email = ? AND user.ID = facebook_account.ID_user');
	$req->execute(array($userEmail));
	$res = $req->fetch();
	$hashedToken = $res[0];