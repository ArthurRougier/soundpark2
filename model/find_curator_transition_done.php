<?php 
	if(isset($_GET['curatorId']))
	{
		$req = $bdd->prepare('SELECT ID_user FROM curator WHERE ID = ?') or die(print_r($bdd->errorInfo()));
		$req->execute(array($_GET['curatorId']));
	}
	else
	{
		header('Location: ../view/landing.php');
	}
	

