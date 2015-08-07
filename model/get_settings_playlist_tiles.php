<?php
	
	if(isset($_COOKIE['current_user']))
	{
		$req = $bdd->query('SELECT ID, date_start, date_end,
				(SELECT artwork_url FROM song WHERE song.ID_playlist = a.ID LIMIT 1) as pic1,
				(SELECT artwork_url FROM song WHERE song.ID_playlist = a.ID LIMIT 1, 1) as pic2,
				(SELECT artwork_url FROM song WHERE song.ID_playlist = a.ID LIMIT 2, 1) as pic3,
				(SELECT artwork_url FROM song WHERE song.ID_playlist = a.ID LIMIT 3, 1) as pic4
			FROM playlist a WHERE date_end <= NOW() ORDER BY ID DESC'
		);
	}


	