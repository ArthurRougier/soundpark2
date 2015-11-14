<?php
include_once('../model/get_song_boxes.php');

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$i = 1;
$playlist = array();

while($songBoxes = $req->fetch())
{
	$playlist[($i-1)] = array("artworkURL"=>$songBoxes[0],"artist"=> $songBoxes[1],"title"=> $songBoxes[2],"genre"=> $songBoxes[3],"pseudo"=> $songBoxes[4],"trackId"=> $songBoxes[5],"permalinkURL"=> $songBoxes[6],"likeNumber"=> $songBoxes[7], "playlistOrder"=> $songBoxes[8], "ID"=> $songBoxes[9], "avatarUrl"=> $songBoxes[10], "curatorLink"=> $songBoxes[11]);
	$i++;
}

if($radioMode)
{
	$j = 1;
	while($songBoxes = $req2->fetch())
	{
		$j++;
		$playlist[($i-1)] = array("artworkURL"=>$songBoxes[0],"artist"=> $songBoxes[1],"title"=> $songBoxes[2],"genre"=> $songBoxes[3],"pseudo"=> $songBoxes[4],"trackId"=> $songBoxes[5],"permalinkURL"=> $songBoxes[6],"likeNumber"=> $songBoxes[7], "playlistOrder"=> $songBoxes[8], "ID"=> $songBoxes[9], "avatarUrl"=> $songBoxes[10], "curatorLink"=> $songBoxes[11]);
		$i++;
	}
}

$playlist = array_unique($playlist, SORT_REGULAR);


?>
<ul class="rslides" id="sliderTest">
<?php

for($i = 0; $i <= count($playlist); $i++)
{
	
	?>
	<li>	
		<div id="sound_box<?php echo($i+1);?>" class="sound_box"
			><div class="cover_container" id="cover_container<?php echo($i+1);?>"
				><img src="<?php echo($playlist[$i]['artworkURL']);?>" class="sound_cover" id="sound_cover<?php echo($i+1);?>"></img	
				><div class="blurred_sound_cover_container" id="blurred_sound_cover_container<?php echo($i+1);?>"><img src="<?php echo($playlist[$i]['artworkURL']);?>" class="blurred_sound_cover" id="blurred_sound_cover<?php echo($i+1);?>"></img></div	
				><div class="cover_overlay" id="cover_overlay<?php echo($i+1);?>"><div class="track_position" id="track_position<?php echo($i+1);?>">0:00</div></div
				><div class="transparent_overlay" id="transparent_overlay<?php echo($i+1);?>"></div	
			></div
			><!--<img src="../assets/pictures/soundcloudLogoWhite.png" class="soundcloudLogo" id="soundcloudLogo<?php echo($i+1);?>"></img-->
			<div class="sound_informations", id="sound_informations<?php echo($i+1);?>"
				><a href="<?php echo($playlist[$i]['curatorLink']); ?>" target="_blank"><h3 class="curator"><div class="curatorText"> <span style="background-color: black">Curator : <?php echo($playlist[$i]['pseudo']);?></span><div class="curatorStuff"><img class="curatorPicture" src="<?php echo($playlist[$i]['avatarUrl']); ?>" /></div</div></h3></a
				><h3 class="title"><div class="titleText"> <span style="background-color: black"><?php echo($playlist[$i]['artist']." - ".$playlist[$i]['title']);?></span></div></h3
			></div
			><div class="socialIcons"
				><a href="http://www.facebook.com/sharer.php?u=http://soundpark.fm/view/fromshare.php?trackId=<?php echo $playlist[$i]['trackId'];?>" target="_blank"><div  class="socialIconFb" id="socialIconFb<?php echo($i+1);?>"></div></a
				><a href="http://twitter.com/share?url=http://soundpark.fm/view/fromshare.php?trackId=<?php echo $playlist[$i]['trackId'];?>&text=j’ai%20découvert%20ce%20son%20sur%20Soundpark.fm,%20la%20newsletter%20musicale%20qui%20te%20régale%20tous%20les%20lundis.%20Inscrivez%20vous%20aussi!" target="_blank"><div  class="socialIconTwitter" id="socialIconTwitter<?php echo($i+1);?>"></div></a
				><a href="mailto:?subject=Ecoute ce que je viens de découvrir sur Soundpark.fm !&amp;body=je viens de découvrir ce morceau sur Soundpark.fm, la seule newsletter de découverte musicale qui arrive directement dans votre boite tous les lundis. Inscrivez-vous aussi pour vous régaler toutes les semaines : http://soundpark.fm/view/fromshare.php?trackId=<?php echo $playlist[$i]['trackId'];?>"><div  class="socialIconEmail" id="socialIconEmail<?php echo($i+1);?>" target="_blank"></div></a
				><a href="<?php echo $$playlist[$i]['permalinkURL'];?>" target="_blank"><div class="socialIconSoundcloud" id="socialIconSoundcloud<?php echo($i+1);?>"></div></a
			></div
			><div class="dropdown-menu" id="dropdown-menu<?php echo($i+1);?>"
				><div class="share-button" onclick="fill()"
					  ><div class="circle"></div
					  ><div class="circle"></div 
					  ><div class="circle"></div
					  ><div class="shareButtonText" id="shareButtonText<?php echo($i+1);?>">Share</div
				></div
				><div class="dropdown-menu-overlay" id="dropdown-menu-overlay<?php echo($i+1);?>"
		 		></div
		 	></div
		></div>
	</li>
	<?php 
}

?>
</ul>

 <script type="text/javascript">
			var songTableComplete = <?php echo(json_encode($playlist)); ?>;
			songTableComplete = Object.keys(songTableComplete).map(function(k) { return songTableComplete[k] });
			console.log(songTableComplete);
			var songTable = [];
			var playlistReady = false;
			for(var i = 0 ; i<songTableComplete.length ; i++)
			{
				songTable[i] = songTableComplete[i].trackId;
				if (i == (songTableComplete.length - 1))
				{
					playlistReady = true; 
				}
			}
			console.log(songTable);
</script>
