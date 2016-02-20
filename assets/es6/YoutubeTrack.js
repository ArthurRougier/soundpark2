var Track       = require('./Track.js');

var YoutubeTrack = function(TrackInformation, CuratorInformation, TrackBox, PlayerObject){
	Track.call(this, TrackInformation, CuratorInformation, TrackBox, PlayerObject);
}


YoutubeTrack.prototype = Object.create(Track.prototype);
YoutubeTrack.prototype.constructor = Track;

YoutubeTrack.prototype = {
	    prepareYoutubePlayer: function(playWhenReady, PlayerLinked, position){
	    	var targettedTrack = this;
	    	if(!position)
	    	{
	    		position = PlayerLinked.trackList.indexOf(PlayerLinked.getMatchingTrackInTrackList(targettedTrack)) + 1;
	    		console.log('position to play: '+position);
	    	}
	    	console.log('PrepareYoutube Entered. position: '+ position + 'track: ' + targettedTrack.trackId);
			if(!PlayerLinked.isYoutubeInitialized)
			{
				// 2. This code loads the IFrame Player API code asynchronously.
				var tag = document.createElement('script');
				tag.src = "https://www.youtube.com/iframe_api";
				var firstScriptTag = document.getElementsByTagName('script')[0];
				firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

				// 3. This function creates an <iframe> (and YouTube youtubeTrackPlayer)
				//    after the API code downloads.
				window.onYouTubeIframeAPIReady = function() {
					var divHeight = $('sound_cover'+ position).height();
					PlayerLinked.nextTrack = new YT.Player('sound_cover'+ position, {
					  height: divHeight,
					  width: divHeight,
					  videoId: targettedTrack.trackId,
					  youtubeTrackPlayerVars: {
					    'controls': 0,
					    'disablekb': 1,
					    'modestbranding': 1,
					    'showinfo': 0,
					    'rel': 0,
					    'iv_load_policy': 3
					  },
					  events: {
					    'onReady': onPlayerReady,
					    'onStateChange': onPlayerStateChange
					  }
					});
					PlayerLinked.isYoutubeInitialized = true;
				}
			}

			else
			{
				var divHeight = $('sound_cover'+ position).height();
				PlayerLinked.nextTrack = new YT.Player('sound_cover'+ position, {
				  height: divHeight,
				  width: divHeight,
				  videoId: targettedTrack.trackId,
				  youtubeTrackPlayerVars: {
				    'controls': 0,
				    'disablekb': 1,
				    'modestbranding': 1,
				    'showinfo': 0,
				    'rel': 0,
				    'iv_load_policy': 3
				  },
				  events: {
				    'onReady': onPlayerReady,
				    'onStateChange': onPlayerStateChange
				  }
				});
			}

			// 4. The API will call this function when the video youtubeTrackPlayer is ready.
			function onPlayerReady(event) {
				var copyTrackList = PlayerLinked.trackList;

				PlayerLinked.nextTrack = PlayerLinked.getMatchingTrackInTrackList(targettedTrack);
				PlayerLinked.nextTrack.PlayerObject = event.target;

				event.target.playVideo();
				event.target.pauseVideo();

				if(playWhenReady){
					PlayerLinked.currentTrack = PlayerLinked.nextTrack;
					event.target.playVideo();
					PlayerLinked.isPlaying = true;		
				}

				PlayerLinked.nextTrack.isPrepared = true;
				console.log(PlayerLinked.nextTrack.trackId + ' is now prepared for playing. Autoplay: '+ playWhenReady);
			}

			// 5. The API calls this function when the youtubeTrackPlayer's state changes.
			var done = false;
			function onPlayerStateChange(event) {
			    if (event.data == YT.PlayerState.PLAYING) {

					var playerPosition 				= PlayerLinked.position;
					var playerTotalTime 			= targettedTrack.PlayerObject.getDuration();
					var TranparentOverlayDiv 		= document.getElementById('transparent_overlay'+ playerPosition);
					var trackPositionTextContainer 	= document.getElementById('track_position'+ playerPosition);
					var interval 					= targettedTrack.currentIntervalId;
					var intervalBis 				= targettedTrack.currentIntervalBisId;
					//var intervalBis 				= that.getMatchingTrackInTrackList(targettedTrack).currentIntervalBisId;

					if(interval)
					{
						clearInterval(interval); 	
					}

					//making move progression bar
					targettedTrack.currentIntervalId = setInterval(function() {

						var playerCurrentTime	 = targettedTrack.PlayerObject.getCurrentTime();
						var playerTimeDifference = (playerCurrentTime / playerTotalTime) * 100;

						//On change le formatage du compteur temps ici pour afficher mn:sec 
						var minutes = (playerCurrentTime / 60) | (0);
						var seconds = Math.round(playerCurrentTime - minutes * 60);
						seconds < 10 ? seconds = '0'+ seconds : seconds = seconds;
						!minutes ? trackPositionTextContainer.innerHTML = seconds : trackPositionTextContainer.innerHTML = minutes + ':' + seconds;

						// On fait avancer l'overlay
						var coverWidth = document.getElementById('sound_cover'+ playerPosition).offsetWidth;
						var step = (playerCurrentTime*coverWidth/(playerTotalTime));
						document.getElementById('blurred_sound_cover_container'+ playerPosition).style.width=(step+"px");
						document.getElementById('cover_overlay'+ playerPosition).style.width=((step)+"px");

					}, 1000);  
					
					if(intervalBis)
					{
						clearInterval(intervalBis); 	
					}

					targettedTrack.currentIntervalBisId = setInterval(function() {
						
						// prepare next song if we arrive at the end 
						var playerCurrentTime	 = targettedTrack.PlayerObject.getCurrentTime();
						var playerTimeDifference = (playerCurrentTime / playerTotalTime) * 100;
						var triggered = false;
						if(playerCurrentTime > (playerTotalTime-10) && PlayerLinked.trackList[(PlayerLinked.position)].player === "youtube" && !PlayerLinked.trackList[(PlayerLinked.position)].isPrepared && !triggered)
						{
							PlayerLinked.prepareYoutubePlayer(PlayerLinked.trackList[(PlayerLinked.position)], false);
							triggered = true;
							console.log(PlayerLinked.trackList[(PlayerLinked.position)] + ' has been prepared from youtube');
						}
					}, 3000); 

					// Position navigation with click 	
					TranparentOverlayDiv.addEventListener('click', function (e) 
					{
							//clearDropdownMenu();
							var coverWidth 			= document.getElementById('sound_cover'+ playerPosition).offsetWidth;
							var durationBeforeJump 	= targettedTrack.PlayerObject.getCurrentTime();
							var mousePos 			= {'x': e.layerX, 'y': e.layerY};
							var aimedPositionS 		= (mousePos['x']*(playerTotalTime/coverWidth));
							targettedTrack.PlayerObject.seekTo(aimedPositionS);
							document.getElementById('blurred_sound_cover_container'+ playerPosition).style.width=(mousePos['x']+"px");
							document.getElementById('cover_overlay'+ playerPosition).style.width=(mousePos['x']+"px");
							/*mixpanel.track("Progression bar hit", {
								"fullUrl": window.location.href,
								"trackId": that.trackList[(position-1)].trackID,
								"durationBeforeJump": durationBeforeJump,
								"jumpedTo": thatTrack.currentTrack.position
							});*/
					}, false);
				} 
				else if(event.data == YT.PlayerState.ENDED){
					PlayerLinked.next();
					PlayerLinked.recordAutomaticNext(targettedTrack.id);
					//record automatic next to add here
				}
			}
	    },

	    play: function(comingFromPrevious, PlayerLinked){
	    	if(this.isPrepared)
	    	{
	    		PlayerLinked.currentTrack = PlayerLinked.nextTrack;
	    		this.PlayerObject.playVideo();
	    		this.isInitialized = true;
	    		this.isPlaying = true;
	    	}
	    	else
	    	{
	    		this.isInitialized = true;
	    		this.prepareYoutubePlayer(true, PlayerLinked);
	    	}
	    },

	    stopTrack: function(){
    	clearInterval(this.currentIntervalId);
    	clearInterval(this.currentIntervalBisId);
    	console.log('interval: ' + this.currentIntervalId + 'intervalBis: ' + this.currentIntervalBisId);
    	this.PlayerObject.stopVideo();
    	this.PlayerObject.destroy();
    	this.isPrepared = false;
    	}

}

module.exports = YoutubeTrack;
