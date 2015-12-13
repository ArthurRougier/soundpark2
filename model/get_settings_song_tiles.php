<?php
	
	if(isset($_COOKIE['current_user']))
	{
		include_once("connect_sql.php");
		$req = $bdd->prepare(
			'SELECT songNew.ID, songNew.url, curator.pseudo, curator.avatar_url 
			FROM songNew, curator, `like` 
			WHERE 
				songNew.ID_curator = curator.ID 
				AND songNew.ID = `like`.ID_song 
				AND `like`.ID_user = ? 
			ORDER BY songNew.ID DESC');

		$req->execute(array($_COOKIE['current_user']));
		if(isset($_GET['displayResults']))
		{
			$i = 0;
			$songsArray = array();
			while($song = $req->fetch())
			{
				$songsArray[$i] = array("ID" => $song['ID'], "url" => $song['url'], "pseudo" => $song['pseudo'], "avatarUrl" => $song['avatar_url']);
				$i++;
			}
			echo(json_encode($songsArray));
		}
	}




	