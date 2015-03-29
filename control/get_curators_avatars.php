<?php

// vieux fichier ou j'ai pas respecté le MVC!


include_once('../model/connect_sql.php');
$req = $bdd->query('SELECT distinct curator.pseudo, curator.avatar_url, curator.link FROM song, playlist, curator WHERE song.ID_curator=curator.ID AND song.ID_playlist=playlist.ID AND playlist.date_end >= NOW() AND playlist.date_start <= NOW()');
$i = 1;
while($songBoxes = $req->fetch())
{
	?>
		><a href="<?php echo($songBoxes[2]);?>"><img src="<?php echo($songBoxes[1]);?>" class="curator_avatar" id="curator_avatar<?php echo($songBoxes[0]);?>"></img></a
	<?php 
	$i++;
};

?>