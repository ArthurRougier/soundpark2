<?php
include_once('connect_sql.php');
$req = $bdd->prepare('SELECT artwork_url, artist, title, song.genre, pseudo, count(distinct like.ID) as like_number FROM song, curator, `like` WHERE like.ID_song = song.ID AND song.trackId = ? AND song.ID_curator = curator.ID GROUP BY artwork_url, artist, title, song.genre, pseudo');
$req->execute(array($_GET['trackId']));
$songBox = $req->fetch();