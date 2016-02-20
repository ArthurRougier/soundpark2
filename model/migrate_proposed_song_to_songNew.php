<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

	include_once('../model/connect_sql.php');

	$req2 = $bdd->query('SELECT ID_curator, date_add, treated, permalink_url FROM proposed_song');
	$i = 0;
	while($result = $req2->fetch())
	{
		//$song[$i] = array("ID_curator"=>$result['ID_curator'], "ID_playlist"=>$result['ID_playlist'], "ID_occasion1"=>$result['occ1'], "ID_occasion2"=>$result['occ2'], "url"=>$result['permalink_url']);

		if(!$result['treated'])
		{
			$req = $bdd->prepare(
				'INSERT INTO `songNew` (`ID_curator`, `url`, `date_add`, `treated`) 
				VALUES ( ?, ?, ?, ?)'
				) or die(print_r($bdd->errorInfo()));

			$req->execute(array(
				$result['ID_curator'],
				$result['permalink_url'],
				$result['date_add'],
				$result['treated']
			));
			print_r(i);
		}

		$i++;

		
	}