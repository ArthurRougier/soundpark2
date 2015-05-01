<?php

// Changer cette méthode
include_once("../model/get_curators_historic_songs.php");				
	
	if($trackList = $req->fetch())
	{

		echo '<ol id="sortable">';
		$index = 0;
		do
		{				
				echo('<li id="li'.$index.'"><div id="playPauseIcon'.$index.'" class="playPauseIcon play"></div><span style="color:white">Title : </span><input readonly autofocus="autofocus" class="song_title" id="song_title'.$index.'" name="song_title'.$index.'" value="'.$trackList['title'].'" type="text" /> <span style="color:white">  Artist : </span><input readonly autofocus="autofocus" id="song_artist'.$index.'" name="song_artist'.$index.'" value="'.$trackList['artist'].'" type="text" /> <span style="color:white"> <!-- Genre : </span><input readonly autofocus="autofocus" class="song_genre" id="song_genre'.$index.'" name="song_genre'.$index.'" value="'.$trackList['genre'].'" type="text" />-->');
				
				
				//Obtenir ici les stats d'une song

				$req2=$bdd->prepare('SELECT COUNT(*) FROM soundpark2.like WHERE ID_song=?');
				$req2->execute(array($trackList['ID']));
				$nblikes=$req2->fetch();
				$nblikes[0]=$nblikes[0]*4+3;
				
				$req2=$bdd->prepare('SELECT ID_playlist FROM song WHERE ID=?');
				$req2->execute(array($trackList['ID']));
				$Playlist=$req2->fetch();

				//$req2=$bdd->prepare('SELECT COUNT(*) FROM soundpark2.dislike WHERE ID_song=?');
				//$req2->execute(array($trackList['ID']));
				//$nbDislikes=$req2->fetch();

				
				//Playlist
				echo(' <a style="color:white"> Playlist:</a> <span class="KeyFigure">'.$Playlist['0'].'</span> - ');
				echo(' <a style="color:white"> Likes:</a> <span class="KeyFigure">'.$nblikes['0'].'</span> - ');
				//cho('Dislikes: '.$nbDislikes['0']);
				
				echo('  <a target=\"_blank\" style="color:white" href="'.$trackList['permalink_url'].'">Link</a></br><input autofocus="autofocus" class="songId" id="songId'.$index.'" name="songId'.$index.'" value="'.$trackList['ID'].'" type="hidden"/><input autofocus="autofocus" class="trackId" id="trackId'.$index.'" name="trackId'.$index.'" value="'.$trackList['trackId'].'" type="hidden"/></li>');
				$index++;
		} while($trackList = $req->fetch());	
		echo '</ol>';
	
	}
	else
	{
		echo('<ul><li><h3>No songs yet inna da selecta, brotha <3</h3></li></ul>');
	}
	
	