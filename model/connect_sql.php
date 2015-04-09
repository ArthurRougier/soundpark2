<?php
	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/

	if (null !== getenv('ENVIRONMENT'))
	{
		if (getenv('ENVIRONMENT') == 'staging')
		{
			try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=soundpark2-staging', 'root', 'mWLbiJWD73');
			}
			catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());
			}
		}
		else if (getenv('ENVIRONMENT') == 'production')
		{
			try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=soundpark2', 'root', 'mWLbiJWD73');
			}
			catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());
			}
		}
		else
		{
			try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=soundpark2', 'root', 'root');
			}
			catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());
			}
		}
	}
	else
	{
		echo('kjhfez');
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=soundpark2', 'root', 'root');
		}
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}
	}
	