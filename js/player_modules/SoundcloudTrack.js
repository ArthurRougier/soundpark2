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
	    	console.log(thatTrack);
	    	SC.stream("/tracks/"+thatTrack.trackId,{
    			onfinish: function()
    			{ 
    				console.log('trackFinished');
    				PlayerLinked.next();
    				/*record_automatic_next();
    				mixpanel.track("Automatic Next", 
    				{
    					"fullUrl": window.location.href,
    					"TrackId": track.trackId,
    					"userId": userId,
    					"playlistPosition": playerPositionLogs,
    					"curator": that.masterJson.curatorPseudo
    				});*/
    			}, 
    			onload: function()
    			{
					if (this.readyState == 2) {
					   comingFromPrevious ? PlayerLinked.prev() :  PlayerLinked.next();
					 }
					 else{
					 	console.log(this.readyState);
					 	var playerPosition 				= PlayerLinked.state.position;
					 	var trackDuration 				= thatTrack.PlayerObject.durationEstimate;
					 	/*var TranparentOverlayDiv 		= document.getElementById('transparent_overlay'+ playerPosition);
					 	var trackPositionTextContainer 	= document.getElementById('track_position'+ playerPosition);


					 	// progression bar moving
					 	for(var index = 1, trackDurationInSeconds = trackDuration/1000  ; index < trackDurationInSeconds ; index++)
					 	{
					 		thatTrack.PlayerObject.onPosition(index*1000, function(eventPosition)
					 		{
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
					 		});
					 	}*/

					 	// Prepare next song if needed

					 	/*thatTrack.PlayerObject.onPosition((trackDuration-10000), function(eventPosition){
					 		console.log('it\'s time to load next track, next player:'+ PlayerLinked.trackList[(PlayerLinked.position)].player);
					 		if(PlayerLinked.state.trackList[(PlayerLinked.state.position)].player === "youtube")
					 		{
					 			console.log('test 1 success');
					 			PlayerLinked.prepareYoutubePlayer(PlayerLinked.state.trackList[(that.position)], false, (PlayerLinked.state.position + 1));
					 			console.log(PlayerLinked.trackList[(PlayerLinked.state.position)]+ ' has been prepared from soundcloud');
					 		}
					 	});*/

					 	// Position navigation with click 
					 	/*TranparentOverlayDiv.addEventListener('click', function (e) 
					 	{
					 			//clearDropdownMenu();
					 			var coverWidth 		= document.getElementById('sound_cover'+ playerPosition).offsetWidth;
					 			durationBeforeJump 	= thatTrack.PlayerObject.position;
					 			var mousePos 		= {'x': e.layerX, 'y': e.layerY};
					 			//console.log(mousePos['x']);
					 			var aimedPositionMs = (mousePos['x']*(thatTrack.PlayerObject.durationEstimate/coverWidth));
					 			thatTrack.PlayerObject.setPosition(aimedPositionMs);
					 			document.getElementById('blurred_sound_cover_container'+ playerPosition).style.width=(mousePos['x']+"px");
					 			document.getElementById('cover_overlay'+ playerPosition).style.width=(mousePos['x']+"px");
					 			mixpanel.track("Progression bar hit", {
					 				"fullUrl": window.location.href,
					 				"trackId": thatTrack.trackID,
					 				"durationBeforeJump": durationBeforeJump,
					 				"jumpedTo": that.position
					 			}); 	
					 	}, false);*/
					 }			
    			}}, 

				function(track){
					
					PlayerLinked.setState({
						currentTrack: PlayerLinked.getMatchingTrackInTrackList(thatTrack)
					});

					thatTrack.PlayerObject = track;
					thatTrack.isInitialized = true;

					PlayerLinked.setState({isPlaying: true});
					thatTrack.PlayerObject.play();
					//console.log(PlayerLinked.state);
				});
	    },

	    stopTrack: function(){
	    	this.PlayerObject.stop();
	    },

	    getPosition: function(){
		   return this.PlayerObject.position;
    	},

    	getDuration: function(){
			return this.PlayerObject.durationEstimate;
    	},

    	setDuration: function(aimedPosition){
			return this.PlayerObject.setPosition(aimedPosition);
    	}
}

module.exports = SoundcloudTrack;
