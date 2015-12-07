var Track       = require('./Track.js');

var YoutubeTrack = function(TrackInformation, CuratorInformation, TrackBox, PlayerObject){
	Track.call(this, TrackInformation, CuratorInformation, TrackBox, PlayerObject);
}


YoutubeTrack.prototype = Object.create(Track.prototype);
YoutubeTrack.prototype.constructor = Track;

YoutubeTrack.prototype = {
    prepareYoutubePlayer: function(playWhenReady, PlayerLinked, position){
    	var targettedTrack = this;
    	console.log("youtube track call, parameters are: PlayerLinked:");
    	console.log(PlayerLinked);
    	if(!position)
    	{
    		position = PlayerLinked.state.trackList.indexOf(PlayerLinked.getMatchingTrackInTrackList(targettedTrack)) + 1;
    		console.log('position to play: '+position);
    	}
    	console.log('PrepareYoutube Entered. position: '+ position + 'track: ' + targettedTrack.trackId);
		if(!PlayerLinked.state.isYoutubeInitialized)
		{
			console.log('jhefvzb');
			// 1. Clean previous state
			var previousTag = document.getElementById('youtubeScript');
			console.log(previousTag);
			if(previousTag)
			{
				previousTag.parentNode.removeChild(previousTag);
				console.log('ala');
			}

			// 2. This code loads the IFrame Player API code asynchronously.
			var tag = document.createElement('script');
			tag.setAttribute("id","youtubeScript");
			tag.src = "https://www.youtube.com/iframe_api";
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

			// 3. This function creates an <iframe> (and YouTube youtubeTrackPlayer)
			//    after the API code downloads.
			window.onYouTubeIframeAPIReady = function() {
				console.log("youtube to be prepared");
				var divHeight = $('sound_cover'+ position).height();
				PlayerLinked.setState({nextTrack: new YT.Player('youtubeContainer', {
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
				})});
				PlayerLinked.setState({isYoutubeInitialized: true});
			}
		}

		else
		{
			console.log("youtube already prepared");
			var divHeight = $('sound_cover'+ position).height();
			PlayerLinked.setState({nextTrack: new YT.Player('youtubeContainer', {
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
			})});
		}

		// 4. The API will call this function when the video youtubeTrackPlayer is ready.
		function onPlayerReady(event) {

			console.log('parti');
			var copyTrackList = PlayerLinked.state.trackList;

			PlayerLinked.getMatchingTrackInTrackList(targettedTrack).PlayerObject = event.target;
			PlayerLinked.setState({nextTrack: PlayerLinked.getMatchingTrackInTrackList(targettedTrack)});

			event.target.playVideo();
			event.target.pauseVideo();

			if(playWhenReady){
				PlayerLinked.setState({currentTrack: PlayerLinked.state.nextTrack});
				event.target.playVideo();
				PlayerLinked.setState({isPlaying: true});		
			}

			PlayerLinked.setState({nextTrack: {isPrepared: true}});
			console.log(PlayerLinked.state.nextTrack.trackId + ' is now prepared for playing. Autoplay: '+ playWhenReady);
		}

		// 5. The API calls this function when the youtubeTrackPlayer's state changes.
		var done = false;
		function onPlayerStateChange(event) {
		    if (event.data == YT.PlayerState.PLAYING) {

				var playerPosition 				= PlayerLinked.state.position;
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

			} 
			else if(event.data == YT.PlayerState.ENDED){
				PlayerLinked.next();
			}
		}
    },

    play: function(comingFromPrevious, PlayerLinked){
    	if(this.isPrepared)
    	{
    		//PlayerLinked.currentTrack = that.nextTrack;
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
	    console.log('stop youtube track');
    	console.log('interval: ' + this.currentIntervalId + 'intervalBis: ' + this.currentIntervalBisId);
    	this.PlayerObject.stopVideo();
    	this.PlayerObject.destroy();
    	this.isPrepared = false;
	},

	getPosition: function(){
	   return this.PlayerObject.getCurrentTime();
	},

	getDuration: function(){
		return this.PlayerObject.getDuration();
	},

	setDuration: function(aimedPosition){
		return this.PlayerObject.seekTo(aimedPosition);
	}

}

module.exports = YoutubeTrack;
