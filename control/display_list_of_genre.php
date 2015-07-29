<?php
	
	$req = $bdd->prepare('SELECT * FROM genres');
	$req->execute();
	
	/*
	echo '<ul>';
	while($genreslist = $req->fetch())
	{
			include('../model/get_stats_genres_occasions.php');
			echo('<li> <span> Name: '.$genreslist[1].'</span>');
			echo('<span>    - # of Songs: '.$nbSongsOfThisGenre[0].'</span>');
			echo('<span>    - # of Likes: '.$nbLikesForThisGenre[0].'</span></li>');

	}		
	echo '</ul>';
*/

	echo '<table border=1';
		//echo '<caption>List Of Genre</caption>';
		echo '<tr>';
		echo '<th> Name </th>';
		echo '<th> # of Songs </th>';
		echo '<th> # of Likes </th>';
		echo '</tr>';

	while($genreslist = $req->fetch())
	{
			include('../model/get_stats_genres_occasions.php');
			echo '<tr>';
			echo('<th width="200px">'.$genreslist[1].'</th>');
			echo('<td>'.$nbSongsOfThisGenre[0].'</td>');
			echo('<td>'.$nbLikesForThisGenre[0].'</td>');
			echo '</tr>';
	}		
	echo '</table>';