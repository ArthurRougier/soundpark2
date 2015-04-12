<?php
	include_once("../model/connect_sql.php");
	
	if(isset($_GET['idSong']))
	{
		$req2 = $bdd->prepare('DELETE FROM proposed_song WHERE ID=?');
		$req2->execute(array($_GET['idSong']));
	}	


	
	if(isset($_GET['page']))
	{
			header('Location: ../view/curator_index.php?message=SongDeleted&curatorId='.$_GET['curatorId']);
	}
	else
	{
			header('Location: ../view/curator_index.php?message=SongDeleted&curatorId='.$_GET['curatorId']);
	}
?>
