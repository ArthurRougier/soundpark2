<?php



include_once('../model/connect_sql.php');



$numberOfTracks = intval($_POST['numberOfTracks']);


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

//echo $_POST['idPlaylist'];
header('Location: ../view/admin_index.php?modifyPlaylist=TRUE&idPlaylist='.$_POST['idPlaylist']);



?>