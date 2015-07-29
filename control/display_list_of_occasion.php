<?php
	
	$req = $bdd->prepare('SELECT * FROM occasions');
	$req->execute();

/*	echo '<ul>';
	while($occasionslist = $req->fetch())
	{
			include('../model/get_stats_genres_occasions.php');
			echo('<li> <span> Name: '.$occasionslist[1].'</span>');
			echo('<span>    - # of Songs: '.$nbSongsForThisOccasion[0].'</span>');
			echo('<span>    - # of Likes: '.$nbLikesForThisOccasion[0].'</span></li>');
	}		
	echo '</ul>';
	*/


		echo '<table border=1';
		echo '<tr>';
		echo '<th> Name </th>';
		echo '<th> # of Songs </th>';
		echo '<th> # of Likes </th>';
		echo '</tr>';

	while($occasionslist = $req->fetch())
	{
			include('../model/get_stats_genres_occasions.php');
			echo '<tr>';
			echo('<th width="200px">'.$occasionslist[1].'</th>');
			echo('<td>'.$nbSongsForThisOccasion[0].'</td>');
			echo('<td>'.$nbLikesForThisOccasion[0].'</td>');
			echo '</tr>';
	}		
	echo '</table>';