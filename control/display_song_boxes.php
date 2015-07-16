<?php
// include_once('../model/get_song_boxes.php');

// $i = 1;
// while($songBoxes = $req->fetch())
// {
	
	?>
	<!-- <div id="sound_box1" class="sound_box"
		><div class="cover_container" id="cover_container1"
			><img src="<?php echo($songBoxes[0]);?>" class="sound_cover" id="sound_cover1"></img	
			><div class="blurred_sound_cover_container" id="blurred_sound_cover_container1"><img src="<?php echo($songBoxes[0]);?>" class="blurred_sound_cover" id="blurred_sound_cover1"></img></div	
			><div class="cover_overlay" id="cover_overlay1"><div class="track_position" id="track_position1">0:00</div></div
			><div class="transparent_overlay" id="transparent_overlay1"></div	
		></div>
		<div class="sound_informations", id="sound_informations1"
			><h3 class="artist"><div class="artistText"><span>Artiste : <?php echo($songBoxes[1]);?></span></div></h3
			><h3 class="title"><div class="titleText"> <span style="background-color: black">Titre : <?php echo($songBoxes[2]);?></span></div></h3
			><h3 class="curator"><div class="curatorText"> <span style="background-color: black">Curator : <?php echo($songBoxes[4]);?></span></div></h3
		></div
		><div class="socialIcons"
			><a href="http://www.facebook.com/sharer.php?u=http://soundpark.fm/view/fromshare.php?trackId=<?php echo $songBoxes[5];?>" target="_blank"><div  class="socialIconFb" id="socialIconFb1"></div></a
			><a href="http://twitter.com/share?url=http://soundpark.fm/view/fromshare.php?trackId=<?php echo $songBoxes[5];?>&text=j’ai%20découvert%20ce%20son%20sur%20Soundpark.fm,%20la%20newsletter%20musicale%20qui%20te%20régale%20tous%20les%20lundis.%20Inscrivez%20vous%20aussi!" target="_blank"><div  class="socialIconTwitter" id="socialIconTwitter1"></div></a
			><a href="mailto:?subject=Ecoute ce que je viens de découvrir sur Soundpark.fm !&amp;body=je viens de découvrir ce morceau sur Soundpark.fm, la seule newsletter de découverte musicale qui arrive directement dans votre boite tous les lundis. Inscrivez-vous aussi pour vous régaler toutes les semaines : http://soundpark.fm/view/fromshare.php?trackId=<?php echo $songBoxes[5];?>"><div  class="socialIconEmail" id="socialIconEmail1" target="_blank"></div></a
			><a href="<?php echo $songBoxes[6];?>" target="_blank"><div class="socialIconSoundcloud" id="socialIconSoundcloud1"></div></a
		></div
		><div class="dropdown-menu" id="dropdown-menu1"
			><div class="share-button" onclick="fill()"
				  ><div class="circle"></div
				  ><div class="circle"></div 
				  ><div class="circle"></div
				  ><div class="shareButtonText" id="shareButtonText1">Share</div
			></div
			><div class="dropdown-menu-overlay" id="dropdown-menu-overlay1"
	 		></div
	 	></div
	></div> -->
	<?php 
// 	$i++;
// };

?>

<div id="sound_box1" class="sound_box"
		><div class="cover_container" id="cover_container1"
			><div class="sound_cover" id="sound_cover1"></div	
			><div class="blurred_sound_cover_container" id="blurred_sound_cover_container1"><div class="blurred_sound_cover" id="blurred_sound_cover1"></div></div	
			><div class="cover_overlay" id="cover_overlay1"><div class="track_position" id="track_position1">0:00</div></div
			><div class="transparent_overlay" id="transparent_overlay1"></div	
		></div>
		<div class="sound_informations", id="sound_informations1"
			><h3 class="artist"><div class="artistText"><span>Artiste : <?php echo($songBoxes[1]);?></span></div></h3
			><h3 class="title"><div class="titleText"> <span style="background-color: black">Titre : <?php echo($songBoxes[2]);?></span></div></h3
			><h3 class="curator"><div class="curatorText"> <span style="background-color: black">Curator : <?php echo($songBoxes[4]);?></span></div></h3
		></div
		><div class="socialIcons"
			><a href="http://www.facebook.com/sharer.php?u=http://soundpark.fm/view/fromshare.php?trackId=<?php echo $songBoxes[5];?>" target="_blank"><div  class="socialIconFb" id="socialIconFb1"></div></a
			><a href="http://twitter.com/share?url=http://soundpark.fm/view/fromshare.php?trackId=<?php echo $songBoxes[5];?>&text=j’ai%20découvert%20ce%20son%20sur%20Soundpark.fm,%20la%20newsletter%20musicale%20qui%20te%20régale%20tous%20les%20lundis.%20Inscrivez%20vous%20aussi!" target="_blank"><div  class="socialIconTwitter" id="socialIconTwitter1"></div></a
			><a href="mailto:?subject=Ecoute ce que je viens de découvrir sur Soundpark.fm !&amp;body=je viens de découvrir ce morceau sur Soundpark.fm, la seule newsletter de découverte musicale qui arrive directement dans votre boite tous les lundis. Inscrivez-vous aussi pour vous régaler toutes les semaines : http://soundpark.fm/view/fromshare.php?trackId=<?php echo $songBoxes[5];?>"><div  class="socialIconEmail" id="socialIconEmail1" target="_blank"></div></a
			><a href="<?php echo $songBoxes[6];?>" target="_blank"><div class="socialIconSoundcloud" id="socialIconSoundcloud1"></div></a
		></div
		><div class="dropdown-menu" id="dropdown-menu1"
			><div class="share-button" onclick="fill()"
				  ><div class="circle"></div
				  ><div class="circle"></div 
				  ><div class="circle"></div
				  ><div class="shareButtonText" id="shareButtonText1">Share</div
			></div
			><div class="dropdown-menu-overlay" id="dropdown-menu-overlay1"
	 		></div
	 	></div
	></div>


   <script>
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('sound_cover1', {
          height: '300',
          width: '300',
          videoId: 'JrlfFTS9kGU',
          playerVars: {
            'controls': 0,
            'disablekb': 1,
            'modestbranding': 1,
            'showinfo': 0,
            'rel': 0
          },
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
		player.playVideo();
      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      var done = false;
      function onPlayerStateChange(event) {
        
      }
    </script>
