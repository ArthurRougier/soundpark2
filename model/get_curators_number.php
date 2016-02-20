<?php

	if(isset($root))
	{
		include_once($root.'model/connect_sql.php');
	}
	else
	{	
		include_once('../model/connect_sql.php');
	}	

	
	$req = $bdd->query('SELECT count(*) FROM curator');
	if($res = $req->fetch())
	{
		$curatorsNumber = $res[0];
	}
	else
	{
		$curatorsNumber = 'baysey';
	}
