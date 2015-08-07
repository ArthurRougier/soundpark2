<?php
	include_once("../model/get_complete_track_list.php");				
	if($trackList = $req->fetch())
	{
		echo('<form accept-charset="UTF-8" action="../control/modify_songs.php" class="modifyPlaylist" id="modifyPlaylist" method="post">');
		echo '<ol id="sortable">';
		$index = 0;
		
		include_once('../model/get_curators.php');
		include_once('../model/get_genres.php');
		include_once('../model/get_occasions.php');

		do
		{
				//echo('<li>'.$trackList[5].' - '.$trackList[6].' - '.$trackList[4].'<a href="../control/delete_track.php?idSong='.$trackList[0].'"> Supprimer </a></li>');
				echo('<li id="li'.$index.'" data-id="'.($index+1).'"><div id="playPauseIcon'.$index.'" class="playPauseIcon play"></div><img src="../assets/pictures/handle_icon.svg" class="icon-move"><span id="trackOrder">'.$trackList[8].'. </span><span>Title : </span><input autofocus="autofocus" class="song_title" id="song_title'.$index.'" name="song_title'.$index.'" value="'.$trackList[5].'" type="text" /> <span>  Artist : </span><input autofocus="autofocus" class="song_artist" id="song_artist'.$index.'" name="song_artist'.$index.'" value="'.$trackList[6].'" type="text" />');
				
				$j = 0;
				$htmlSelectForm ="<!--<label for='idCurator".$index."'>  Curator : </label>--><select class='song_curator' name='idCurator".$index."' id='idCurator".$index."'>";
				while($j<$i) //i is defined in get_curator and corresponds to the number of curators we have
				{
					if ($trackList[1] == $pseudoCurator[$j])
					{
						$htmlSelectForm = $htmlSelectForm . "<option value='".$idCurator[$j]."' selected>".$pseudoCurator[$j]."</option>";
					}
					else
					{
						$htmlSelectForm = $htmlSelectForm . "<option value='".$idCurator[$j]."'>".$pseudoCurator[$j]."</option>";
					}	
					$j++;
				}
				$htmlSelectForm = $htmlSelectForm . "</select>";
				echo $htmlSelectForm;
					
				//Tags Genre et Occasions
				include('../control/display_tag_options.php');
				

				echo('    <a id="optionLink'.$index.'" class="optionLink" href="#">options</a><div id="optionsMenuBo'.$index.'" class="optionsMenuBo"><a target="_blank" href="'.$trackList[9].'">Link</a></br><a href="../control/store_track_from_playlist.php?idSong='.$trackList[0].'&source=admin_index.php">Store</a></br><a href="../control/move_track_to_next_playlist.php?idSong='.$trackList[0].'&idPlaylist='.$_GET['idPlaylist'].'">Move to next playlist</a></br><a href="../control/move_track_to_previous_playlist.php?idSong='.$trackList[0].'&idPlaylist='.$_GET['idPlaylist'].'">Move to previous playlist</a></div><input autofocus="autofocus" class="songId" id="songId'.$index.'" name="songId'.$index.'" value="'.$trackList[0].'" type="hidden"/><input autofocus="autofocus" class="songOrder" id="songOrder'.($index+1).'" name="songOrder'.($index+1).'" value="'.$trackList[8].'" type="hidden"/><input autofocus="autofocus" class="trackId" id="trackId'.$index.'" name="trackId'.$index.'" value="'.$trackList[7].'" type="hidden"/></br></li>');
				$index++;
		} while($trackList = $req->fetch());	
		echo '</ol>';
		echo('<input autofocus="autofocus" class="numberOfTracks" id="numberOfTracks" name="numberOfTracks" value="'.$index.'" type="hidden"/>');
		echo('<input autofocus="autofocus" class="idPlaylist" id="idPlaylist" name="idPlaylist" value="'.$_GET['idPlaylist'].'" type="hidden"/>');
		echo('<input name="commit" type="submit" value=" Update! " /></br></br>');
		echo('<a href="../view/frommail.php?pwd=thomas.bouttefort@gmail.com&playlistId='.$playlistId.'"> Ecoute cette playlist </a>');

	}
	else
	{
		echo('<ul><li><h3>No songs yet inna da selecta, brotha <3</h3></li></ul>');
	}
	