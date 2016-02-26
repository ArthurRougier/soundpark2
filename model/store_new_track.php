<?php

	if(isset($_GET['url']) AND isset($_GET['curatorId']))
	{
		$curatorId 		= $_GET['curatorId'];
		$url 			= urldecode($_GET['url']);
		$treated 		= $_GET['treated'] ?: 0;
		$playlistId 	= $_GET['playlistId'] ?: 0;

		include_once('../model/connect_sql.php');

		//if no playlist id, we store in next playlist
		if(!$playlistId)
		{


			// We check the current playlist ID
			$req2 = $bdd->query('SELECT ID FROM playlist WHERE playlist.date_end >= NOW() AND playlist.date_start <= NOW()');
			$playlistIdTab = $req2->fetch();
			$currentPlaylistId = $playlistIdTab[0];


			// now we are gonne try to find the next playlist ID with less than 15 tracks already added
			$indexPlaylistId = $currentPlaylistId + 1;
			$findRightPlaylist = false;
			
			
			while(!$findRightPlaylist)
			{
				$req3 = $bdd->prepare(
					'SELECT count(*), songNew.ID_playlist 
					FROM songNew 
					WHERE songNew.ID_playlist = ?  
					GROUP BY songNew.ID_playlist');

				$req3->execute(array($indexPlaylistId));

				if($result = $req3->fetch())
				{
					if($result[0] < 15)
					{
						$playlistId = $result[1];
						print_r($result[1]);
						$findRightPlaylist = true;
						$treated = 1;

					}
					else
					{
						print_r($result[1]);
						$indexPlaylistId = $indexPlaylistId + 1;
					}
				}
				else
				{
					$playlistId = $indexPlaylistId;
					$findRightPlaylist = true;
					$treated = 1;
				}
			}	
		}

		$req = $bdd->prepare(
			'INSERT INTO `songNew` (`ID_curator`, `ID_playlist`, `url`, `treated`, `date_add`) 
			VALUES (?, ?, ?, ?, NOW())'
			) or die(print_r($bdd->errorInfo()));

		$req->execute(array(
			$curatorId,
			$playlistId,
			$url,
			$treated
		));

		echo('Tracked stored in playlist '. $playlistId);
	}