<?php

	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/

	session_start();
	include_once('../model/connect_sql.php');
	
	$req = $bdd->prepare('SELECT songNew.id, curator.pseudo, curator.avatar_url, curator.link FROM curator, songNew WHERE songNew.id_curator = curator.ID AND songNew.url like ? ');
	$req->execute(array('%'.explode(".com/",rawurldecode($_GET['trackUrl']))[1].'%'));

	$data = $req->fetch();

	if(isset($_GET['jsonDisplay']))
	{
		echo(json_encode($data));
	}