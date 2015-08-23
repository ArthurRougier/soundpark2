<?php

	include_once ('../model/connect_sql.php');
	$req21 = $bdd->query('SELECT ID_genre, name FROM genres');
	$k = 0;
	$idgenre = array();
	$genreName = array();
	while($list = $req21->fetch())
	{
		$idgenre[$k] = $list[0];
		$genreName[$k] = $list[1];
		$k++;
	}