<?php
include_once('../model/get_landing_song_boxes.php');

$i = 1;
while($songBoxes = $req->fetch())
{

	?>
	><div id="sound_box<?php echo($i);?>" class="sound_box"
		><div style="background-image: url('<?php echo($songBoxes[0]);?>')" class="sound_cover" id="sound_cover<?php echo($i);?>"></div
		><div class="ribbon">#<?php echo($i);?> - <?php echo(round($songBoxes[5]*7,26)); ?> likes </div
		><div class="cover_wrapper" id="cover_wrapper<?php echo($i);?>"><div class="playPauseButton play" id="play<?php echo($i);?>"></div></div
		><div class="sound_informations", id="sound_informations<?php echo($i);?>"
			><h3> Artiste : <?php echo($songBoxes[1]);?> </br></h3
			><h3> Titre : <?php echo($songBoxes[2]);?> </br></h3
			><h3> Curator : <?php echo($songBoxes[4]);?> </br></h3
		></div
	></div
	<?php 
	$i++;
};

?>