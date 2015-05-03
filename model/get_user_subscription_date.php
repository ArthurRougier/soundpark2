<?php
	include_once('connect_sql.php');
	$req = $bdd->prepare('SELECT subscription_date FROM user WHERE ID = ?');
	$req->execute(array($_COOKIE['current_user']));
	$result = $req->fetch();
	$subsciptionDate = $result[0];