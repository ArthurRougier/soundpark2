<?php
	include_once("../model/connect_sql.php");

	$req = $bdd->prepare('SELECT * FROM tags');
	$req->execute();
	
