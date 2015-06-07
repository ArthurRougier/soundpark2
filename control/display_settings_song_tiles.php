<?php
	include_once('../model/get_settings_song_tiles.php');

	$i = 1;
	while($songBoxes = $req->fetch())
	{
		
		?>
		<div id="box<?php echo($i);?>" class="box"
			><div class="boxInner" id="boxInner<?php echo($i);?>"
				><img src="<?php echo($songBoxes[0]);?>" class="sound_cover" id="sound_cover<?php echo($i);?>"></img	
				><div class="cover_overlay" id="cover_overlay<?php echo($i);?>"
					><a href="<?php echo($songBoxes[5]); ?>" target="_blank"><img class="soundcloudSettingsLink" src="../assets/pictures/sc_white_240x120.png" /><div class="helper"></div></a
				></div
			></div
		></div>
		<?php 
		$i++;
	};

