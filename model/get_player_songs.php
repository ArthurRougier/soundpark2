<?php
include_once('connect_sql.php');
include_once('get_beta_users.php'); 	// creates $betaUserArray

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$playlistId = $playlistId ?: $_GET['playlistId'];

if (isset($_GET['playlistId']) AND isset($_GET['standalonePlaylist']))
{
	$playlistId = $_GET['playlistId'];
	$req = $bdd->prepare('SELECT url, "1" AS like_number, songNew.ID
						  FROM songNew, playlist
						  WHERE songNew.ID_playlist=playlist.ID AND songNew.ID_playlist=? 
						  ORDER BY songNew.id');
	$req->execute(array($playlistId));
}
else if (isset($_COOKIE['current_user']) AND isset($playlistId))
{
	$req = $bdd->query(
		'SELECT * FROM
			(SELECT * FROM 
				((SELECT * FROM 
					(SELECT url, count(distinct `like`.ID) as like_number, songNew.ID 
					FROM songNew, `like` 
					WHERE  
						`like`.ID_song = songNew.ID 
						AND NOT EXISTS 
							(select * 
							from dislike 
							where 
								dislike.ID_song = songNew.ID 
								and dislike.ID_user = '.$_COOKIE['current_user'].') 
						AND songNew.ID not in (SELECT b.Id_Song FROM (SELECT * FROM (SELECT COUNT(distinct automatic_next.ID) as numberAN, Id_Song FROM automatic_next, user WHERE user.ID = automatic_next.mail AND user.ID = '.$_COOKIE['current_user'].' GROUP BY Id_Song) a WHERE a.numberAN > 3 ) b) 
					GROUP BY url 
					ORDER BY count(distinct like.ID) DESC LIMIT 4)a 
				ORDER BY rand())
			)DummyAlias1
			UNION
			SELECT * FROM 
			(
				(SELECT url, "0" as like_number, songNew.ID 
				FROM songNew, playlist 
				WHERE 
					songNew.ID_playlist=playlist.ID 
					AND songNew.ID_playlist='.$playlistId.' 
					AND NOT EXISTS (select * from dislike where dislike.ID_song = songNew.ID and dislike.ID_user = '.$_COOKIE['current_user'].')   
				ORDER BY songNew.id LIMIT 15)
			)DummyAlias2)twotablesmerged ORDER BY RAND()');
	$radioMode=1;
	$req2 = $bdd->query('SELECT * FROM 
		(SELECT url, count(distinct `like`.ID) as like_number, songNew.ID 
		FROM songNew, `like` 
		WHERE  
			`like`.ID_song = songNew.ID 
			AND NOT EXISTS (select * from dislike where dislike.ID_song = songNew.ID and dislike.ID_user = '.$_COOKIE['current_user'].')  
			AND songNew.ID not in 
				(SELECT b.Id_Song 
				FROM 
					(SELECT * FROM 
						(SELECT COUNT(distinct automatic_next.ID) as numberAN, Id_Song 
						FROM automatic_next, user 
						WHERE 
							user.ID = automatic_next.mail 
							AND user.ID = '.$_COOKIE['current_user'].' GROUP BY Id_Song) a WHERE a.numberAN > 3 ) b) 
		GROUP BY url 
		ORDER BY count(distinct like.ID) DESC LIMIT 40 offset 4)a where a.like_number > 5');
}
else if($playlistId == 59)
{
	$req = $bdd->query('SELECT * 
		FROM 
		(
			SELECT url, COUNT( DISTINCT  `like`.ID ) AS like_number, songNew.ID
			FROM songNew, `like` 
			WHERE  `like`.ID_song = songNew.ID
			GROUP BY url
			ORDER BY COUNT( DISTINCT  `like`.ID ) DESC 
			LIMIT 25
		)a'
	);
}
else if($playlistId)
{
	$req = $bdd->prepare(
		'SELECT url, songNew.ID
		FROM songNew, playlist 
		WHERE 
			songNew.ID_playlist=playlist.ID 
			AND songNew.ID_playlist=? 
		ORDER BY songNew.ID');
	$req->execute(array($playlistId));
}
else
{
	$req = $bdd->query(
		'SELECT url, songNew.ID 
		FROM songNew, playlist 
		WHERE 
			songNew.ID_playlist=playlist.ID 
			AND playlist.date_end >= NOW() 
			AND playlist.date_start <= NOW()  
		ORDER BY songNew.id');
}

$i = 1;

while($songBoxes = $req->fetch())
{
	$playlistUrls[($i-1)] = $songBoxes['url'];
	$i++;
}

if($radioMode)
{
	$j = 1;
	while($songBoxes2 = $req2->fetch())
	{
		$j++;
		$playlistUrls[($i-1)] = $songBoxes2['url'];
		$i++;
	}
}


if(isset($_GET['displayResults']))
{
	echo json_encode($playlistUrls);
}
