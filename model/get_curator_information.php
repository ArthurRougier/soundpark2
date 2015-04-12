<?php
	session_start();
	include_once('connect_sql.php');
	
	$req = $bdd->prepare('SELECT user.email, curator.pseudo, user.password, curator.avatar_url, curator.link FROM curator, user WHERE user.id = curator.ID_user AND curator.ID=?');
	$req->execute(array($_SESSION['id_curator']));
	
	$data = $req->fetch();
	
	$curatormail = $data[0];
	$curatorpseudo = $data[1];
	$curatorpassword = $data[2];
	$curatoravatar = $data[3];
	$curatorlink = $data[4];