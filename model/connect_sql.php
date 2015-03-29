<?php
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=soundpark2', 'root', 'mWLbiJWD73');
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}