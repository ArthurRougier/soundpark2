<?php
include_once('../model/get_share_song_box.php');
?>
<div id="sound_box<?php echo($i);?>" class="sound_box">
	<img src="<?php echo($songBox[0]);?>" class="sound_cover"></img>
	<div class="sound_informations">
		<h3> Artiste : <?php echo($songBox[1]);?> </br></h3>
		<h3> Titre : <?php echo($songBox[2]);?> </br></h3>
		<h3> Currator : Jauhny </br></h3>
	</div>
</div>
