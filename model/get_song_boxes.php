<?php
include_once('connect_sql.php');
include_once('get_beta_users.php'); 	// creates $betaUserArray


if (isset($_GET['playlistId']) AND isset($_GET['standalonePlaylist']))
{
	$playlistId = $_GET['playlistId'];
	$req = $bdd->prepare('SELECT artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url, "1" AS like_number, playlistOrder, song.ID, avatar_url, link 
						  FROM song, playlist, curator 
						  WHERE song.ID_playlist=playlist.ID AND song.ID_curator = curator.ID AND song.ID_playlist=? 
						  ORDER BY song.playlistOrder, song.id');
	$req->execute(array($playlistId));
}

else if($playlistId == 59 OR $playlistId == 77 OR $playlistId == 78)
{
	$req = $bdd->query('SELECT * 
		FROM 
		(
			SELECT artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url, COUNT( DISTINCT  `like`.ID ) AS like_number, playlistOrder, song.ID, avatar_url, link
			FROM song, curator,  `like` 
			WHERE  `like`.ID_song = song.ID
			AND song.ID_curator = curator.ID
			GROUP BY artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url
			ORDER BY COUNT( DISTINCT  `like`.ID ) DESC 
			LIMIT 25
		)a'
	);
}

else if (isset($_COOKIE['current_user']) AND isset($playlistId))
{
	$req = $bdd->query('
		SELECT * FROM
			(SELECT * FROM 
				((SELECT * FROM 

					(SELECT artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url, count(distinct `like`.ID) as like_number, playlistOrder, song.ID, avatar_url, link FROM song, curator, `like` WHERE  `like`.ID_song = song.ID AND song.ID_curator = curator.ID AND NOT EXISTS (select * from dislike where dislike.ID_song = song.ID and dislike.ID_user = '.$_COOKIE['current_user'].') AND song.ID not in (SELECT b.Id_Song FROM (SELECT * FROM (SELECT COUNT(distinct automatic_next.ID) as numberAN, Id_Song FROM automatic_next, user WHERE user.ID = automatic_next.mail AND user.ID = '.$_COOKIE['current_user'].' GROUP BY Id_Song) a WHERE a.numberAN > 3 ) b) GROUP BY artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url ORDER BY count(distinct like.ID) DESC LIMIT 4)a ORDER BY rand())

			)DummyAlias1

			UNION

			SELECT * FROM 
			(

				(SELECT artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url, "0" as like_number, playlistOrder, song.ID, avatar_url, link FROM song, playlist, curator WHERE song.ID_playlist=playlist.ID AND song.ID_curator = curator.ID AND song.ID_playlist='.$playlistId.' AND NOT EXISTS (select * from dislike where dislike.ID_song = song.ID and dislike.ID_user = '.$_COOKIE['current_user'].')   ORDER BY song.playlistOrder, song.id LIMIT 15)

			)DummyAlias2)twotablesmerged ORDER BY RAND()');

	$radioMode=1;
	$req2 = $bdd->query('SELECT * FROM (SELECT artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url, count(distinct `like`.ID) as like_number, playlistOrder, song.ID, avatar_url, link FROM song, curator, `like` WHERE  `like`.ID_song = song.ID AND song.ID_curator = curator.ID AND NOT EXISTS (select * from dislike where dislike.ID_song = song.ID and dislike.ID_user = '.$_COOKIE['current_user'].')  AND song.ID not in (SELECT b.Id_Song FROM (SELECT * FROM (SELECT COUNT(distinct automatic_next.ID) as numberAN, Id_Song FROM automatic_next, user WHERE user.ID = automatic_next.mail AND user.ID = '.$_COOKIE['current_user'].' GROUP BY Id_Song) a WHERE a.numberAN > 3 ) b) GROUP BY artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url ORDER BY count(distinct like.ID) DESC LIMIT 40 offset 4)a where a.like_number > 5');
}

else if($playlistId)
{
	$req = $bdd->prepare('SELECT artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url, avatar_url, link FROM song, playlist, curator WHERE song.ID_playlist=playlist.ID AND song.ID_curator = curator.ID AND song.ID_playlist=? ORDER BY song.playlistOrder, song.id');
	$req->execute(array($playlistId));
}


else
{
	$req = $bdd->query('SELECT artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url, avatar_url, link FROM song, playlist, curator WHERE song.ID_playlist=playlist.ID AND playlist.date_end >= NOW() AND playlist.date_start <= NOW() AND song.ID_curator = curator.ID ORDER BY song.playlistOrder, song.id');
}

