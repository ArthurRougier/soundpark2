<?php
include_once("../model/get_untreated_songs.php");				
	if($trackList = $req->fetch())
	{
		echo('<form accept-charset="UTF-8" action="../control/modify_curators_songs.php?source=admin_songs_new.php" class="modifyPlaylist" id="modifyPlaylist" method="post">');
		echo '<ol id="sortable">';
		$index = 0;
		include_once('../model/get_curators.php');
		include_once('../model/get_genres.php');
		include_once('../model/get_occasions.php');
		do
		{
				
				echo('<li id="li'.$index.'"><div id="playPauseIcon'.$index.'" class="playPauseIcon play"></div><span>Title : </span><input autofocus="autofocus" class="song_title" id="song_title'.$index.'" name="song_title'.$index.'" value="'.$trackList[5].'" type="text" /> <span>  Artist : </span><input autofocus="autofocus" id="song_artist'.$index.'" name="song_artist'.$index.'" value="'.$trackList[6].'" type="text" />');
				$j = 0;
				$htmlSelectForm ="<!--<label for='idCurator".$index."'>  Curator : </label>--><select name='idCurator".$index."' id='idCurator".$index."'>";
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
				
				include('../control/display_tag_options.php');

				//Options Menu
				echo('<a id="optionLink'.$index.'" class="optionLink" href="#">options</a><div id="optionsMenuBo'.$index.'" class="optionsMenuBo"><a href="../control/add_proposed_track_to_playlist.php?idSong='.$trackList[0].'">Add</a></br><a target="_blank" href="'.$trackList[8].'">Link</a></br><a href="../control/store_track.php?idSong='.$trackList[0].'&source=admin_songs_new.php">Store</a></li>');
				echo '<input autofocus="autofocus" class="songId" id="songId'.$index.'" name="songId'.$index.'" value="'.$trackList[0].'" type="hidden"/>';

				//echo('   <a href="../control/add_proposed_track_to_playlist.php?idSong='.$trackList[0].'">Add</a>  -   <a target="_blank" href="'.$trackList[8].'">Link</a></br><input autofocus="autofocus" class="songId" id="songId'.$index.'" name="songId'.$index.'" value="'.$trackList[0].'" type="hidden"/><input autofocus="autofocus" class="trackId" id="trackId'.$index.'" name="trackId'.$index.'" value="'.$trackList[7].'" type="hidden"/></li>');
				$index++;
		} while($trackList = $req->fetch());	
		echo '</ol>';
		echo('<input autofocus="autofocus" class="numberOfTracks" id="numberOfTracks" name="numberOfTracks" value="'.$index.'" type="hidden"/>');
		echo('<input name="commit" type="submit" value=" Update! " /></br></br>');
		
	}
	else
	{
		echo('<ul><li><h3>No songs yet inna da selecta, brotha <3</h3></li></ul>');
	}
	
	