<?php
	
	include_once("../model/get_curators_list.php");
	


echo '<table border=1';
		//echo '<caption>List Of Genre</caption>';
		echo '<tr>';
		echo '<th> Name </th>';
		echo '<th> Link </th>';
		echo '<th> Email </th>';
		echo '<th> # of Songs </th>';
		echo '<th> # of Likes </th>';
		echo '<th> Last Song Added </th>';
		echo '</tr>';

	
	while($curatorsList = $req->fetch())
	{
			//include('../model/get_stats_genres_occasions.php');
			echo '<tr>';
			echo('<th width="150px">'.$curatorsList[1].'</th>');
			echo('<td>'.$curatorsList[4].'</td>');
			echo('<td>'.$curatorsList[7].'</td>');
			echo('<td>'.$curatorsList[6].'</td>');
			echo('<td>'.$curatorsList[5].'</td>');
			$req2 = $bdd->prepare('SELECT date_add FROM proposed_song WHERE ID_curator=? ORDER BY date_add ASC LIMIT 1');
			$req2->execute(array($curatorsList[0]));
			if ($Last = $req2->fetch())
			{
				echo('<td>'.$Last[0].'</td>');
			}
			else
			{
				echo('<td>N/A</td>');
			}
			echo '</tr>';
	}		
	echo '</table>';
