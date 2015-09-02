<?php



include_once('../model/connect_sql.php');



$numberOfTracks = intval($_POST['numberOfTracks']);


if(isset($_GET['source']) AND $_GET['source']=="admin_index.php")
{
	for($index = 0; $index < $numberOfTracks; $index++)
	{
		
		$req = $bdd->prepare('UPDATE song SET genre=?, title=?, artist=?, ID_curator=?, playlistOrder=?, occ1=?, occ2=? WHERE song.ID = ?');
		$req->execute(array(
			$_POST['songGenre_'.$index],
			$_POST['song_title'.$index],
			$_POST['song_artist'.$index],
			$_POST['idCurator'.$index],
			$_POST['songOrder'.($index+1)],
			$_POST['songOccasion1_'.$index],
			$_POST['songOccasion2_'.$index],
			$_POST['songId'.$index]
		));
	}
}
elseif (isset($_GET['source']) AND $_GET['source']=="admin_songs_history.php")
{
	for($index = 0; $index < $numberOfTracks; $index++)
	{
		
		$req = $bdd->prepare('UPDATE song SET genre=?, title=?, artist=?, ID_curator=?, occ1=?, occ2=? WHERE song.ID = ?');
		$req->execute(array(
			$_POST['songGenre_'.$index],
			$_POST['song_title'.$index],
			$_POST['song_artist'.$index],
			$_POST['idCurator'.$index],
			$_POST['songOccasion1_'.$index],
			$_POST['songOccasion2_'.$index],
			$_POST['songId'.$index]
		));
	}
}


//echo $_POST['idPlaylist'];


if(isset($_GET['source']) AND $_GET['source']=="admin_index.php" )
	{
			header('Location: ../view/admin_index.php?message=Updated');
	}
	elseif (isset($_GET['source']) AND $_GET['source']=="admin_songs_history.php" )
	{
			header('Location: ../view/admin_songs_history.php?message=Updated');
	}
	else
	{
		header('Location: ../view/admin_index.php?message=Updated');
	}

?>