<?php

include_once('../model/connect_sql.php');

$numberOfTracks = intval($_POST['numberOfTracks']);

//echo($numberOfTracks);



for($index = 0; $index < $numberOfTracks; $index++)
{


	$req30 = $bdd->prepare('UPDATE proposed_song SET genre=?, title=?, artist=?, ID_curator=?, occ1=?, occ2=? WHERE ID = ?');
	$req30->execute(array(
		$_POST['songGenre_'.$index],
		$_POST['song_title'.$index],
		$_POST['song_artist'.$index],
		$_POST['idCurator'.$index],
		$_POST['songOccasion1_'.$index],
		$_POST['songOccasion2_'.$index],
		$_POST['songId'.$index]
	));
}

//echo $_POST['idPlaylist'];

if(isset($_GET['source']) AND $_GET['source']=="admin_songs_new.php" )
	{
			header('Location: ../view/admin_songs_new.php?message=Updated');
	}
	else
	{
			header('Location: ../view/admin_index.php?message=Updated');
	}




