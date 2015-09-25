<?php
	session_start();
	include_once('connect_sql.php');
	
	$req = $bdd->prepare('SELECT user.email, curator.pseudo, user.password, curator.avatar_url, curator.link, curator.id FROM curator, user WHERE user.id = curator.ID_user AND user.ID=?');
	$req->execute(array($_COOKIE['current_user']));
	
	$data = $req->fetch();
	
	$curatormail = $data[0];
	$curatorpseudo = $data[1];
	$curatorpassword = $data[2];
	$curatoravatar = $data[3];
	$curatorlink = $data[4];
	$curatorId = $data[5];