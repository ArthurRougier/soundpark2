<?php
include_once('connect_sql.php');

if (isset($_GET['radioMode']) AND isset($_COOKIE['current_user']))
{
	//$req = $bdd->query('SELECT trackId, count(distinct `like`.ID) as like_number FROM song, curator, `like` WHERE  `like`.ID_song = song.ID AND song.ID_curator = curator.ID AND song.ID not in (SELECT b.Id_Song FROM (SELECT * FROM (SELECT COUNT(distinct automatic_next.ID) as numberAN, Id_Song FROM automatic_next, user WHERE user.ID = automatic_next.mail AND user.ID = '.$_COOKIE['current_user'].' GROUP BY Id_Song) a WHERE a.numberAN < 4 ) b) GROUP BY artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url ORDER BY count(distinct like.ID) DESC LIMIT 30');
	//$req = $bdd->execute(array($_COOKIE['current_user']));
	$req = $bdd->query('
		SELECT * FROM
			(SELECT * FROM 
				((SELECT * FROM 

					(SELECT trackId, count(distinct `like`.ID) as like_number FROM song, curator, `like` WHERE  `like`.ID_song = song.ID AND song.ID_curator = curator.ID AND song.ID in (SELECT b.Id_Song FROM (SELECT * FROM (SELECT COUNT(distinct automatic_next.ID) as numberAN, Id_Song FROM automatic_next, user WHERE user.ID = automatic_next.mail AND user.ID = '.$_COOKIE['current_user'].' GROUP BY Id_Song) a WHERE a.numberAN < 5 ) b) GROUP BY artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url ORDER BY count(distinct like.ID) DESC LIMIT 4)a ORDER BY rand())

			)DummyAlias1

			UNION

			SELECT * FROM 
			(

				(SELECT trackId, "0" as like_number FROM song, playlist, curator WHERE song.ID_playlist=playlist.ID AND song.ID_curator = curator.ID AND playlist.date_end >= NOW() AND playlist.date_start <= NOW()  ORDER BY song.playlistOrder, song.id LIMIT 15)

			)DummyAlias2)twotablesmerged ORDER BY RAND()');

	$radioModeTrackIds=1;

	$req2 = $bdd->query('SELECT * FROM (SELECT trackId, count(distinct `like`.ID) as like_number FROM song, curator, `like` WHERE  `like`.ID_song = song.ID AND song.ID_curator = curator.ID AND song.ID in (SELECT b.Id_Song FROM (SELECT * FROM (SELECT COUNT(distinct automatic_next.ID) as numberAN, Id_Song FROM automatic_next, user WHERE user.ID = automatic_next.mail AND user.ID = '.$_COOKIE['current_user'].' GROUP BY Id_Song) a WHERE a.numberAN < 3 ) b) GROUP BY artwork_url, artist, title, song.genre, pseudo, trackId, permalink_url ORDER BY count(distinct like.ID) DESC LIMIT 40 offset 4)a where a.like_number > 9');
}

else if($playlistId)
{
	$req = $bdd->prepare('SELECT trackId FROM song, playlist WHERE song.ID_playlist=playlist.ID AND song.ID_playlist=? ORDER BY song.playlistOrder, song.id');
	$req->execute(array($playlistId));
}
else
{
	$req = $bdd->query('SELECT trackId FROM song, playlist WHERE song.ID_playlist=playlist.ID AND playlist.date_end >= NOW() AND playlist.date_start <= NOW() ORDER BY song.playlistOrder, song.id');
}
	