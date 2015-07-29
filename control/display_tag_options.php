<?php

	//Tag Genre
	echo "<label for='songGenre_".$index."'> <!--Genre:--> </label><select name='songGenre_".$index."' class='songGenre' id='songGenre_".$index."'>";
	unset($songGenre);
	include('../model/get_song_genre.php');
	$j=0;
	if ($songGenre[0]==NULL)
		{
			echo "<option value=''>Genre?</option>";
		}
	while($j<$k) //k is defined in get_genres and corresponds to the number of genres we have
	{
		if ($songGenre[0] == $genreName[$j])
		{
			echo "<option value='".$idgenre[$j]."' selected>".$genreName[$j]."</option>";
		}
		else
		{
			echo "<option value='".$idgenre[$j]."'>".$genreName[$j]."</option>";
		}
		$j++;
	}
	echo "</select>";


	//Tag Occasion 1
	echo "<label for='songOccasion1_".$index."'>  <!--Occ.1--> : </label><select name='songOccasion1_".$index."' class='songOccasion' id='songOccasion1_".$index."'>";
	unset($songOccasion);
	include('../model/get_song_occasion.php');
	$j=0;
	if ($songOccasion[0]==NULL)
		{
			echo "<option value=''>Occasion 1?</option>";
		}
	while($j<$l) //l is defined in get_genres and corresponds to the number of curators we have
	{
		if ($songOccasion[0] == $OccasionName[$j])
		{
			echo "<option value='".$idoccasion[$j]."' selected>".$OccasionName[$j]."</option>";
		}
		else
		{
			echo "<option value='".$idoccasion[$j]."'>".$OccasionName[$j]."</option>";
		}
		$j++;
	}
	echo "</select>";


		//Tag Occasion 2
	echo "<label for='songOccasion2_".$index."'>  <!--Occ.2--> : </label><select name='songOccasion2_".$index."' class='songOccasion' id='songOccasion2_".$index."'>";
	unset($songOccasion);
	include('../model/get_song_occasion.php');
	$j=0;
	if ($songOccasion2[0]==NULL)
		{
			echo "<option value=''>Occasion 2?</option>";
		}
	while($j<$l) //l is defined in get_genres and corresponds to the number of curators we have
	{
		if ($songOccasion2[0] == $OccasionName[$j])
		{
			echo "<option value='".$idoccasion[$j]."' selected>".$OccasionName[$j]."</option>";
		}
		else
		{
			echo "<option value='".$idoccasion[$j]."'>".$OccasionName[$j]."</option>";
		}
		$j++;
	}
	echo "</select>";
	