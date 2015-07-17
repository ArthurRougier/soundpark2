<?php
include_once('../model/get_song_boxes.php');

$i = 1;
while($songBoxes = $req->fetch())
{
	
	?>
	<div id="sound_box<?php echo($i);?>" class="sound_box"
		><div class="cover_container" id="cover_container<?php echo($i);?>"
			><img src="<?php echo($songBoxes[0]);?>" class="sound_cover" id="sound_cover<?php echo($i);?>"></img	
			><div class="blurred_sound_cover_container" id="blurred_sound_cover_container<?php echo($i);?>"><img src="<?php echo($songBoxes[0]);?>" class="blurred_sound_cover" id="blurred_sound_cover<?php echo($i);?>"></img></div	
			><div class="cover_overlay" id="cover_overlay<?php echo($i);?>"><div class="track_position" id="track_position<?php echo($i);?>">0:00</div></div
			><div class="transparent_overlay" id="transparent_overlay<?php echo($i);?>"></div	
		></div
		><!--<img src="../assets/pictures/soundcloudLogoWhite.png" class="soundcloudLogo" id="soundcloudLogo<?php echo($i);?>"></img-->
		<div class="sound_informations", id="sound_informations<?php echo($i);?>"
			><h3 class="artist"><div class="artistText"><span>Artiste : <?php echo($songBoxes[1]);?></span></div></h3
			><h3 class="title"><div class="titleText"> <span style="background-color: black">Titre : <?php echo($songBoxes[2]);?></span></div></h3
			><h3 class="curator"><div class="curatorText"> <span style="background-color: black">Curator : <?php echo($songBoxes[4]);?></span></div></h3
		></div
		><div class="socialIcons"
			><a href="http://www.facebook.com/sharer.php?u=http://soundpark.fm/view/fromshare.php?trackId=<?php echo $songBoxes[5];?>" target="_blank"><div  class="socialIconFb" id="socialIconFb<?php echo($i);?>"></div></a
			><a href="http://twitter.com/share?url=http://soundpark.fm/view/fromshare.php?trackId=<?php echo $songBoxes[5];?>&text=j’ai%20découvert%20ce%20son%20sur%20Soundpark.fm,%20la%20newsletter%20musicale%20qui%20te%20régale%20tous%20les%20lundis.%20Inscrivez%20vous%20aussi!" target="_blank"><div  class="socialIconTwitter" id="socialIconTwitter<?php echo($i);?>"></div></a
			><a href="mailto:?subject=Ecoute ce que je viens de découvrir sur Soundpark.fm !&amp;body=je viens de découvrir ce morceau sur Soundpark.fm, la seule newsletter de découverte musicale qui arrive directement dans votre boite tous les lundis. Inscrivez-vous aussi pour vous régaler toutes les semaines : http://soundpark.fm/view/fromshare.php?trackId=<?php echo $songBoxes[5];?>"><div  class="socialIconEmail" id="socialIconEmail<?php echo($i);?>" target="_blank"></div></a
			><a href="<?php echo $songBoxes[6];?>" target="_blank"><div class="socialIconSoundcloud" id="socialIconSoundcloud<?php echo($i);?>"></div></a
		></div
		><div class="dropdown-menu" id="dropdown-menu<?php echo($i);?>"
			><div class="share-button" onclick="fill()"
				  ><div class="circle"></div
				  ><div class="circle"></div 
				  ><div class="circle"></div
				  ><div class="shareButtonText" id="shareButtonText<?php echo($i);?>">Share</div
			></div
			><div class="dropdown-menu-overlay" id="dropdown-menu-overlay<?php echo($i);?>"
	 		></div
	 	></div
	></div>
	<?php 
	$i++;
};

if($radioMode)
{
	$i = 1;
	while($songBoxes = $req2->fetch())
	{
		
		?>
		<div id="sound_box<?php echo($i);?>" class="sound_box"
			><div class="cover_container" id="cover_container<?php echo($i);?>"
				><img src="<?php echo($songBoxes[0]);?>" class="sound_cover" id="sound_cover<?php echo($i);?>"></img	
				><div class="blurred_sound_cover_container" id="blurred_sound_cover_container<?php echo($i);?>"><img src="<?php echo($songBoxes[0]);?>" class="blurred_sound_cover" id="blurred_sound_cover<?php echo($i);?>"></img></div	
				><div class="cover_overlay" id="cover_overlay<?php echo($i);?>"><div class="track_position" id="track_position<?php echo($i);?>">0:00</div></div
				><div class="transparent_overlay" id="transparent_overlay<?php echo($i);?>"></div	
			></div
			><!--<img src="../assets/pictures/soundcloudLogoWhite.png" class="soundcloudLogo" id="soundcloudLogo<?php echo($i);?>"></img-->
			<div class="sound_informations", id="sound_informations<?php echo($i);?>"
				><h3 class="artist"><div class="artistText"><span>Artiste : <?php echo($songBoxes[1]);?></span></div></h3
				><h3 class="title"><div class="titleText"> <span style="background-color: black">Titre : <?php echo($songBoxes[2]);?></span></div></h3
				><h3 class="curator"><div class="curatorText"> <span style="background-color: black">Curator : <?php echo($songBoxes[4]);?></span></div></h3
			></div
			><div class="socialIcons"
				><a href="http://www.facebook.com/sharer.php?u=http://soundpark.fm/view/fromshare.php?trackId=<?php echo $songBoxes[5];?>" target="_blank"><div  class="socialIconFb" id="socialIconFb<?php echo($i);?>"></div></a
				><a href="http://twitter.com/share?url=http://soundpark.fm/view/fromshare.php?trackId=<?php echo $songBoxes[5];?>&text=j’ai%20découvert%20ce%20son%20sur%20Soundpark.fm,%20la%20newsletter%20musicale%20qui%20te%20régale%20tous%20les%20lundis.%20Inscrivez%20vous%20aussi!" target="_blank"><div  class="socialIconTwitter" id="socialIconTwitter<?php echo($i);?>"></div></a
				><a href="mailto:?subject=Ecoute ce que je viens de découvrir sur Soundpark.fm !&amp;body=je viens de découvrir ce morceau sur Soundpark.fm, la seule newsletter de découverte musicale qui arrive directement dans votre boite tous les lundis. Inscrivez-vous aussi pour vous régaler toutes les semaines : http://soundpark.fm/view/fromshare.php?trackId=<?php echo $songBoxes[5];?>"><div  class="socialIconEmail" id="socialIconEmail<?php echo($i);?>" target="_blank"></div></a
				><a href="<?php echo $songBoxes[6];?>" target="_blank"><div class="socialIconSoundcloud" id="socialIconSoundcloud<?php echo($i);?>"></div></a
			></div
			><div class="dropdown-menu" id="dropdown-menu<?php echo($i);?>"
				><div class="share-button" onclick="fill()"
					  ><div class="circle"></div
					  ><div class="circle"></div 
					  ><div class="circle"></div
					  ><div class="shareButtonText" id="shareButtonText<?php echo($i);?>">Share</div
				></div
				><div class="dropdown-menu-overlay" id="dropdown-menu-overlay<?php echo($i);?>"
		 		></div
		 	></div
		></div>
		<?php 
		$i++;
	};	
}

?>
