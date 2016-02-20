<?php	
	include_once("../model/connect_sql.php");
	if(isset($_GET['trackId']))
	{
		$req = $bdd->prepare('DELETE FROM songNew WHERE id = ?');
		$req->execute(array($_GET['trackId']));
		if(isset($_GET['displayResults']))
		{
			echo "success";
		}
	}
	