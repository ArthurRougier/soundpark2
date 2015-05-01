<?php
session_start();

include_once("../model/get_curators_week_songs.php");				
	if($trackList = $req->fetch())
	{
		
	echo '<form <form accept-charset="UTF-8" action="../control/modify_curators_songs2.php" id="update_untreated_songs_curator" method="post">';

		echo '<ol id="sortable">';
		$index = 0;
		do
		{				
				//Infos relatives à la chanson
				echo('<li id="li'.$index.'"><div id="playPauseIcon'.$index.'" class="playPauseIcon play"></div><span style="color:white;">Title : </span><input autofocus="autofocus" class="song_title" id="song_title'.$index.'" name="song_title'.$index.'" value="'.$trackList[6].'" type="text" /> <span style="color:white;">  Artist : </span><input autofocus="autofocus" id="song_artist'.$index.'" name="song_artist'.$index.'" value="'.$trackList[7].'" type="text" /> <span style="color:white;"> <!-- Genre : </span><input autofocus="autofocus" class="song_genre" id="song_genre'.$index.'" name="song_genre'.$index.'" value="'.$trackList[5].'" type="text" />-->');
				//2 liens en fin de ligne
				echo('   <a style="color:white;" href="../control/remove_week_track_curator.php?idSong='.$trackList[0].'&curatorId='.$_GET['curatorId'].'">Remove</a> ');
				echo ('-');
				echo('  <a style="color:white;" target=\"_blank\" href="'.$trackList[9].'">Link</a></br><input autofocus="autofocus" class="songId" id="songId'.$index.'" name="songId'.$index.'" value="'.$trackList[0].'" type="hidden"/><input autofocus="autofocus" class="trackId" id="trackId'.$index.'" name="trackId'.$index.'" value="'.$trackList[8].'" type="hidden"/></li>');
				$index++;
		} while($trackList = $req->fetch());	
		echo '</ol>';
		
		echo('</br>');
		echo('<input id="sourcepage" name="page" value="../view/curator_index.php" type="hidden"/>');
		echo('<input autofocus="autofocus" class="numberOfTracks" id="numberOfTracks" name="numberOfTracks" value="'.$index.'" type="hidden"/>');
		echo('<input name="commit" type="submit" value="Update" /></br></br>');
	echo '</form>';
		
		//echo('<a id="checkDoneLink" href="../control/get_curators_songs_treated.php">DONE</a> </br></br>');

	}
	else
	{
		echo('<ul><li><h3>No songs yet inna da selecta, brotha <3</h3></li></ul>');
	}
	
	