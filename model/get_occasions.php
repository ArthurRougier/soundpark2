<?php

	include_once ('../model/connect_sql.php');
	$req25 = $bdd->query('SELECT ID_occasion, name FROM occasions');
	$l = 0;
	$idoccasion = array();
	$OccasionName = array();
	while($list2 = $req25->fetch())
	{
		$idoccasion[$l] = $list2[0];
		$OccasionName[$l] = $list2[1];
		$l++;
	}