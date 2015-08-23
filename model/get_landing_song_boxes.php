<?php
include_once('connect_sql.php');
$req = $bdd->query('SELECT artwork_url, artist, title, song.genre, pseudo, count(distinct like.ID) as like_number  FROM song, playlist, curator, `like` WHERE like.ID_song = song.ID AND song.ID_playlist=playlist.ID AND playlist.date_end >= NOW() AND playlist.date_start <= NOW() AND song.ID_curator = curator.ID GROUP BY artwork_url, artist, title, song.genre, pseudo ORDER BY count(distinct `like`.ID) DESC LIMIT 3');
