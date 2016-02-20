<?php
	include_once('connect_sql.php');
	if(!isset($curatorsNumber))
	{
		include_once('../model/get_curators_number.php');
	}
	$intervalPossible = $curatorsNumber - 20;
	$interval = rand(1, $intervalPossible);

	$req = $bdd->query('SELECT avatar_url, pseudo FROM curator WHERE pseudo not like "Les%" AND pseudo not like "Ed%" AND avatar_url not like "%fbcdn%" AND avatar_url not like "%none%" AND avatar_url not like "" LIMIT 1 , 20');

