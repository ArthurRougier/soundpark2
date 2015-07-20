<?php
include_once('connect_sql.php');


if (isset($_COOKIE['current_user']) AND (isset($_GET['radioMode']) OR $_COOKIE['current_user'] == 68 OR $_COOKIE['current_user'] == 30 OR $_COOKIE['current_user'] == 180 OR $_COOKIE['current_user'] == 372 ))
{
	$req = $bdd->query('
		SELECT * FROM
			(SELECT * FROM 
				((SELECT * FROM 

					(SELECT artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url, count(distinct soundpark2.like.ID) as like_number, playlistOrder, song.ID FROM song, curator, soundpark2.like WHERE  soundpark2.like.ID_song = song.ID AND song.ID_curator = curator.ID AND NOT EXISTS (select * from dislike where dislike.ID_song = song.ID and dislike.ID_user = '.$_COOKIE['current_user'].') AND song.ID in (SELECT b.Id_Song FROM (SELECT * FROM (SELECT COUNT(distinct automatic_next.ID) as numberAN, Id_Song FROM automatic_next, user WHERE user.ID = automatic_next.mail AND user.ID = '.$_COOKIE['current_user'].' GROUP BY Id_Song) a WHERE a.numberAN < 2 ) b) GROUP BY artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url ORDER BY count(distinct like.ID) DESC LIMIT 4)a ORDER BY rand())

			)DummyAlias1

			UNION

			SELECT * FROM 
			(

				(SELECT artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url, "0" as like_number, playlistOrder, song.ID FROM song, playlist, curator WHERE song.ID_playlist=playlist.ID AND song.ID_curator = curator.ID AND playlist.date_end >= NOW() AND playlist.date_start <= NOW() AND NOT EXISTS (select * from dislike where dislike.ID_song = song.ID and dislike.ID_user = '.$_COOKIE['current_user'].')   ORDER BY song.playlistOrder, song.id LIMIT 15)

			)DummyAlias2)twotablesmerged ORDER BY RAND()');

	$radioMode=1;

	$req2 = $bdd->query('SELECT * FROM (SELECT artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url, count(distinct soundpark2.like.ID) as like_number, playlistOrder, song.ID FROM song, curator, soundpark2.like WHERE  soundpark2.like.ID_song = song.ID AND song.ID_curator = curator.ID AND NOT EXISTS (select * from dislike where dislike.ID_song = song.ID and dislike.ID_user = '.$_COOKIE['current_user'].')  AND song.ID in (SELECT b.Id_Song FROM (SELECT * FROM (SELECT COUNT(distinct automatic_next.ID) as numberAN, Id_Song FROM automatic_next, user WHERE user.ID = automatic_next.mail AND user.ID = '.$_COOKIE['current_user'].' GROUP BY Id_Song) a WHERE a.numberAN < 3 ) b) GROUP BY artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url ORDER BY count(distinct like.ID) DESC LIMIT 40 offset 4)a where a.like_number > 9');

}

else if($playlistId)
{
	$req = $bdd->prepare('SELECT artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url FROM song, playlist, curator WHERE song.ID_playlist=playlist.ID AND song.ID_curator = curator.ID AND song.ID_playlist=? ORDER BY song.playlistOrder, song.id');
	$req->execute(array($playlistId));
}

else
{
	$req = $bdd->query('SELECT artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url FROM song, playlist, curator WHERE song.ID_playlist=playlist.ID AND playlist.date_end >= NOW() AND playlist.date_start <= NOW() AND song.ID_curator = curator.ID ORDER BY song.playlistOrder, song.id');
}

