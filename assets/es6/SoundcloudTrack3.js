var Track       = require('./Track.js');

var SoundcloudTrack = function(TrackInformation, CuratorInformation, TrackBox, PlayerObject){
	Track.call(this, TrackInformation, CuratorInformation, TrackBox, PlayerObject);
}

SoundcloudTrack.prototype = Object.create(Track.prototype);
SoundcloudTrack.prototype.constructor = Track;

SoundcloudTrack.prototype = {


	play: function(comingFromPrevious, PlayerLinked)
	    {
	    	var thatTrack = this;
	    	console.log("track requested to play: ");
	    	console.log(thatTrack);

	    	var streamCall = "/tracks/"+thatTrack.trackId;
	    	console.log(streamCall);

			SC.stream(streamCall).then(function (track) {

				track.play();
				console.log(track);
				//track.play();
				track.seek(10000);
				console.log(track.getVolume());
				console.log(track.currentTime());
				track.setVolume(0.5);
				console.log(track.getVolume());
				track.seek(15000);
				console.log(track.currentTime());
				track.play();
				track.pause();
				track.play();
				track.on("audio_error", function(){
					console.log('lala');
					
				});
				console.log(track);

			}).catch(function (error) {
				console.log('There was an error ' + error.message);
				console.log(error);
				comingFromPrevious ? PlayerLinked.prev() :  PlayerLinked.next();
			});
				/*PlayerLinked.currentTrack = PlayerLinked.getMatchingTrackInTrackList(thatTrack);
				thatTrack.PlayerObject = track;
				thatTrack.isInitialized = true;

				PlayerLinked.isPlaying = true;
				thatTrack.PlayerObject.play();
				console.log(track);
				console.log(thatTrack.PlayerObject);*/
				/*
				//When track finishes: 
				track.on("finish", function(){
					console.log('trackFinished');
					PlayerLinked.next();
					PlayerLinked.recordAutomaticNext(thatTrack.id);
				});

				//Progression bar handling:
		 		track.on("time", function(){
					console.log('position: ' + track);
				 	var playerPosition 				= PlayerLinked.position;
				 	var trackDuration 				= thatTrack.PlayerObject.options.duration;
				 	var TranparentOverlayDiv 		= document.getElementById('transparent_overlay'+ playerPosition);
				 	var trackPositionTextContainer 	= document.getElementById('track_position'+ playerPosition);


				 	// progression bar moving
				 	for(var index = 1, trackDurationInSeconds = trackDuration/1000  ; index < trackDurationInSeconds ; index++)
				 	{
				 		track.on("time", function(){
				 			
				 			var eventPosition = thatTrack.PlayerObject.currentTime();
				 			//On change le formatage du compteur temps ici pour afficher mn:sec 
				 			var minutes 	= (eventPosition / 60000) | (0);
				 			var seconds 	= eventPosition/1000 - minutes * 60;
				 			seconds < 10 	? seconds = '0'+ seconds : seconds = seconds;
								!minutes 		? trackPositionTextContainer.innerHTML = seconds : trackPositionTextContainer.innerHTML = minutes + ':' + seconds;

				 			// On fait avancer l'overlay
				 			var coverWidth = document.getElementById('sound_cover'+ playerPosition).offsetWidth;
				 			var step = (eventPosition/1000*coverWidth/(thatTrack.PlayerObject.durationEstimate/1000));
				 			document.getElementById('blurred_sound_cover_container'+ playerPosition).style.width=(step+"px");
				 			document.getElementById('cover_overlay'+ playerPosition).style.width=((step)+"px");

				 			if(eventPosition > trackDuration-10000)
				 			{
				 				console.log('it\'s time to load next track, next player:'+ PlayerLinked.trackList[(PlayerLinked.position)].player);
				 				if(that.trackList[(that.position)].player === "youtube")
				 				{
				 					console.log('test 1 success');
				 					PlayerLinked.prepareYoutubePlayer(PlayerLinked.trackList[(that.position)], false, (PlayerLinked.position + 1));
				 					console.log(PlayerLinked.trackList[(PlayerLinked.position)]+ ' has been prepared from soundcloud');
				 				}
				 			}
				 		});
				 	}

				 	// Position navigation with click 
				 	TranparentOverlayDiv.addEventListener('click', function (e) 
				 	{
				 			//clearDropdownMenu();
				 			var coverWidth 			= document.getElementById('sound_cover'+ playerPosition).offsetWidth;
				 			var durationBeforeJump 	= thatTrack.PlayerObject.currentTime();
				 			var trackDuration 		= thatTrack.PlayerObject.options.duration;
				 			var mousePos 			= {'x': e.layerX, 'y': e.layerY};
				 			//console.log(mousePos['x']);
				 			var aimedPositionMs = (mousePos['x']*(trackDuration/coverWidth));
				 			thatTrack.PlayerObject.seek(aimedPositionMs);
				 			document.getElementById('blurred_sound_cover_container'+ playerPosition).style.width=(mousePos['x']+"px");
				 			document.getElementById('cover_overlay'+ playerPosition).style.width=(mousePos['x']+"px");
				 			/*mixpanel.track("Progression bar hit", {
				 				"fullUrl": window.location.href,
				 				"trackId": thatTrack.trackID,
				 				"durationBeforeJump": durationBeforeJump,
				 				"jumpedTo": thatTrack.position
				 			});
				 	}, false);
				});
			*/
	    },
	    stopTrack: function(){
	    	//this.PlayerObject.pause();
	    }
}

module.exports = SoundcloudTrack;
