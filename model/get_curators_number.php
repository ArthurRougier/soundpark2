<?php
	include('connect_sql.php');
	$req = $bdd->query('SELECT count(*) FROM curator');
	if($res = $req->fetch())
	{
		$curatorsNumber = $res[0];
	}
	else
	{
		$curatorsNumber = 'baysey';
	}
