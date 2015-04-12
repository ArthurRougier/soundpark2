<?php

include_once('../model/connect_sql.php');

$numberOfTracks = intval($_POST['numberOfTracks']);

//echo($numberOfTracks);

if(isset($_POST['page']))
	{
		if ($_POST['page']=="../view/curator_index.php")
		{
			for($index = 0; $index < $numberOfTracks; $index++)
			{
		
			$req = $bdd->prepare('UPDATE proposed_song SET genre=?, title=?, artist=? WHERE proposed_song.ID = ?');
			$req->execute(array(
				$_POST['song_genre'.$index],
				$_POST['song_title'.$index],
				$_POST['song_artist'.$index],
				$_POST['songId'.$index]
			));
			}
			header('Location: ../view/curator_index.php?message=Updated');
		}
		else
		{

			for($index = 0; $index < $numberOfTracks; $index++)
			{
				
				$req = $bdd->prepare('UPDATE proposed_song SET genre=?, title=?, artist=?, ID_curator=? WHERE proposed_song.ID = ?');
				$req->execute(array(
					$_POST['song_genre'.$index],
					$_POST['song_title'.$index],
					$_POST['song_artist'.$index],
					$_POST['idCurator'.$index],
					$_POST['songId'.$index]
				));
			}
		}
	}
	else
	{
		if(isset($_POST['page']))
		{
			header('Location: ../view/curators_songs_history.php?message=Updated');
		}
		else
		{
			header('Location: ../view/curators_songs_new.php?message=Updated');
		}
	}

//echo $_POST['idPlaylist'];






