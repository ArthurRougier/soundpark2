var Player = function(trackListUrl, divSelector, playButtonSelector, arrowSelectors, fadeTime){
	this.nextTrack 				= null;
	this.divSelector 			= divSelector || null;
	this.arrowSelectors 		= arrowSelectors || [];
	this.prevArrow 				= document.querySelector(this.arrowSelectors[0]);
	this.nextArrow 				= document.querySelector(this.arrowSelectors[1]);
	this.playButtonSelector 	= playButtonSelector || null;
	this.playButton 			= document.querySelector(this.playButtonSelector);
	this.trackList 				= trackListUrl && this.getMasterJson(trackListUrl, this.createTrackBoxes);
	this.isPlaying 				= false;
	this.isPaused 				= false;
	this.isYoutubeInitialized 	= false;
	this.whenReady 				= null;
	this.playersToLoad 			= 0;
	this.progress 				= null;
	this.playTimeout 			= null;
	this.position 				= 1;
	this.fadeTime 				= fadeTime || 500;
	this.boxesCreated			= 0;
	this.domElements			= "";

	// Helpers
	this.currentTrack 			= null; 
	that 						= this;   

	that.prepareNavigationButtons();
}

Player.prototype = {

	// CSS classes for slider
    activeClass			: "rslides_here",
    visibleClass		: "rslides1_on",
    visible 			: {"float": "left", "position": "relative", "opacity": 1, "zIndex": 2},
    hidden 				: {"float": "none", "position": "absolute", "opacity": 0, "zIndex": 1},

	supportTransitions	: (function () {
          var docBody 	= document.body || document.documentElement;
          var styles 	= docBody.style;
          var prop 		= "transition";
          if (typeof styles[prop] === "string") {
            return true;
          }
          // Tests for vendor specific prop
          vendor = ["Moz", "Webkit", "Khtml", "O", "ms"];
          prop = prop.charAt(0).toUpperCase() + prop.substr(1);
          var i;
          for (i = 0; i < vendor.length; i++) {
            if (typeof styles[vendor[i] + prop] === "string") {
              return true;
            }
          }
          return false;
        })(),

	// dom construction methods
	createTrackBoxes: function (numberOfBoxes){
		numberOfBoxes 				= numberOfBoxes || 10;
		var numberOfBoxesWithOffset = numberOfBoxes + that.boxesCreated;
		var trackListCopy 			= that.trackList;
		var masterJsonCopy 			= that.masterJson || {};
		if(that.masterJson)
		{
			if(that.boxesCreated > 0)
			{
				mainUl = document.getElementById('sliderTest');
			}
			else // Case were it's the first time we create boxes. We need to create parents then.
			{
				var mainUl 			= document.createElement('ul');
				mainUl.setAttribute('id','sliderTest');
				mainUl.setAttribute('class','rslides');	
			}
			for(var indexSongBoxes = that.boxesCreated, lengthCopy = that.trackList.length ; (indexSongBoxes < lengthCopy && indexSongBoxes < numberOfBoxesWithOffset) ; indexSongBoxes++ )
			{
				//var trackBox = new TrackBox((indexSongBoxes +1), trackListCopy[indexSongBoxes].cover, trackListCopy[indexSongBoxes].player, trackListCopy[indexSongBoxes].title, trackListCopy[indexSongBoxes].curatorPseudo, trackListCopy[indexSongBoxes].curatorLink, trackListCopy[indexSongBoxes].curatorPic);						
				var trackBox = new TrackBox((indexSongBoxes +1), {
					trackCover: 	trackListCopy[indexSongBoxes].cover,
					trackPlayer: 	trackListCopy[indexSongBoxes].player,
					trackTitle: 	trackListCopy[indexSongBoxes].title,
					curatorPseudo: 	trackListCopy[indexSongBoxes].curatorPseudo,
					curatorLink: 	trackListCopy[indexSongBoxes].curatorLink,
					curatorPic: 	trackListCopy[indexSongBoxes].curatorPic
				});
				mainUl.appendChild(trackBox.listDomElement);
				that.trackList[indexSongBoxes].TrackBox = trackBox.listDomElement;
				that.boxesCreated++
			}

			that.domElements = mainUl;
			document.querySelector(that.divSelector).appendChild(that.domElements);
			var $slides = $('.slide');
			// Hide all slides, then show first one
			$slides
			  .hide()
			  .css(that.hidden)
			  .eq(that.position - 1)
			  .addClass(that.visibleClass)
			  .css(that.visible)
			  .show();

			if (that.supportTransitions) {
				$slides
				  .show()
				  .css({
				    "-webkit-transition": "opacity " + that.fadeTime + "ms ease-in-out",
				    "-moz-transition": "opacity " + that.fadeTime + "ms ease-in-out",
				    "-o-transition": "opacity " + that.fadeTime + "ms ease-in-out",
				    "transition": "opacity " + that.fadeTime + "ms ease-in-out"
				  });
			}
		}
		else
		{
			console.log('error: attempt to create songboxes without master json');
		}
		//$(that.divSelector).unblock();
	},

	createOrNotTrackBoxes: function(){
		if(that.boxesCreated < (that.position + 3)){
			that.createTrackBoxes(10);
			return "10 new trackBoxes in creation";
		} 
		else
		{
			return "no need to create trackBoxes";
		}
	},

	getMasterJson: function (trackList, callBack){

		this.masterJson 			= [];
		var ajaxRequestNumber 		= 0;
		var ajaxRequestCompleted 	= 0;
		var trackListProper 		= [];

		for(indexTrackList 	= 0, trackListLength = trackList.length ; indexTrackList < trackListLength ; indexTrackList++)
		{
			var urlCopy 					= trackList[indexTrackList];
			

			if(trackList[indexTrackList].toLowerCase().indexOf("youtube") > -1 )
			{
				trackListProper[indexTrackList] = new YoutubeTrack();
				var videoId 					= trackList[indexTrackList].match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
				trackIdCopy 					=  videoId[1] ||  null;

				(function(trackIdCopy, indexTrackList){
							var xhr 			= [];
							xhr[indexTrackList] = new XMLHttpRequest();
							var urlToSend 		= "https://www.googleapis.com/youtube/v3/videos?id="+ trackIdCopy +"&key=AIzaSyAzc_ihjBq03TOwwPqkt1ZgfT6ouEJ5plI&part=snippet";
							xhr[indexTrackList].open('GET', urlToSend); // On test si le son a déjà été liké par currentUser
							
						    xhr[indexTrackList].onreadystatechange = function() 
							{ // On gère ici une requête asynchrone

						        if(xhr[indexTrackList].readyState == 4 && xhr[indexTrackList].status == 200) 
						        { // Si le fichier est chargé sans erreur
						            var json 								= JSON.parse(xhr[indexTrackList].responseText);
					            	trackListProper[indexTrackList].url 	= trackList[indexTrackList];
				            		trackListProper[indexTrackList].trackId = json.items[0].id;
				            		trackListProper[indexTrackList].player 	= "youtube";
				            		trackListProper[indexTrackList].title 	= json.items[0].snippet.title;

						           	if(isFinished(indexTrackList))
						           	{
						           		that.trackList = trackListProper;
						           		callBack();
						           		console.log(trackListProper);
						           	} 
						        }
						    };
						    xhr[indexTrackList].send(null); // La requête est prête, on envoie tout !
					})(trackIdCopy, indexTrackList);
					ajaxRequestNumber++;

			}
			else if(trackList[indexTrackList].toLowerCase().indexOf("soundcloud") > -1 ){
				trackListProper[indexTrackList] = new SoundcloudTrack();
				(function(urlCopy, indexTrackList){
					//console.log(urlCopy);
					SC.get('/resolve', { url: urlCopy.toLowerCase() }, function(track)
					{
						trackListProper[indexTrackList].url = track.permalink_url;
						trackListProper[indexTrackList].trackId = track.id;
						trackListProper[indexTrackList].player = "soundcloud";
						trackListProper[indexTrackList].title = track.title;
						trackListProper[indexTrackList].cover
						track.artwork_url ? trackListProper[indexTrackList].cover 	= track.artwork_url.replace("large.jpg", "t500x500.jpg") : trackListProper[indexTrackList].cover = "../assets/pictures/default_cover.png";

						if(isFinished(indexTrackList))
						{
							that.trackList = trackListProper;
							callBack();
						} 
					});
				})(urlCopy, indexTrackList);
				ajaxRequestNumber++;
			}

			(function(urlCopy, indexTrackList){
				var xhrDb 				= [];
				xhrDb[indexTrackList] 	= new XMLHttpRequest();
				var urlToSend 			= "../model/get_curator_information_from_song_url.php?trackUrl="  + encodeURIComponent(urlCopy) + "&jsonDisplay=TRUE";
				xhrDb[indexTrackList].open('GET', urlToSend); // On test si le son a déjà été liké par currentUser
				
			    xhrDb[indexTrackList].onreadystatechange = function() 
				{ // On gère ici une requête asynchrone

			        if(xhrDb[indexTrackList].readyState == 4 && xhrDb[indexTrackList].status == 200) 
			        { // Si le fichier est chargé sans erreur
			            var json 										= JSON.parse(xhrDb[indexTrackList].responseText);
			            trackListProper[indexTrackList].id 				= json.id;
			            trackListProper[indexTrackList].curatorPseudo 	= json.pseudo;
			            trackListProper[indexTrackList].curatorLink 	= json.link;
			            trackListProper[indexTrackList].curatorPic 		= json.avatar_url;

			            if(isFinished(indexTrackList))
			            {
			            	that.trackList = trackListProper;
			            	callBack();
			            	console.log(trackListProper);
			            } 
			        }
			    };
			    xhrDb[indexTrackList].send(null); // La requête est prête, on envoie tout !
			    ajaxRequestNumber++;
			})(urlCopy, indexTrackList);
		}

		var isFinished = function(index){
			ajaxRequestCompleted++;
			console.log('Ajax Req Number: ' + ajaxRequestNumber);
			console.log('Ajax Req Completed: ' + ajaxRequestCompleted);
			if(ajaxRequestCompleted === ajaxRequestNumber){
				console.log('completed! Launching callback...');
				return true;
			}
		}
	},
	prepareNavigationButtons: function(){
		if(that.playButton)
		{
			that.playButton.addEventListener('click', function(){
				that.playPauseToggle(that.trackList[that.position - 1]);
			}, false);
			var playButton = true;
			
		}
		if(that.nextArrow){
			that.nextArrow.addEventListener('click', function(){
				that.next();
			}, false);
			var nextArrow = true;
		}
		if(that.prevArrow){
			that.prevArrow.addEventListener('click', function(){
				that.prev();
			}, false);
			var prevArrow = true;
		}

		return "Play Button: " + playButton + "Next Button: " + nextArrow + "Prev Button: " + prevArrow;
	},
	displayOrNotLeftArrow: function(){
		that.position > 1 ? that.displayLeftArrow() : that.undisplayLeftArrow();
	},
	displayLeftArrow: function(){
		this.prevArrow.style.opacity = 1;		
	},
	undisplayLeftArrow: function(){
		this.prevArrow.style.opacity = 0;		
	},
	cleanProgressionLayer: function(position){

		document.getElementById('blurred_sound_cover_container'+ position).style.width= "0";
		document.getElementById('cover_overlay'+ position).style.width= "0";

	},

	// helpers
    slideTo: function (position) {

		// If CSS3 transitions are supported
		if (this.supportTransitions) {
			var $slides = $('.slide');
			$slides
              .removeClass(that.visibleClass)
              .css(that.hidden)
              .eq((position - 1))
              .addClass(that.visibleClass)
              .css(that.visible);
          	that.position = position;
		}

		// If not, use jQuery fallback
       	else {
       	var $slides = $('.slide');
        $slides
          .stop()
          .fadeOut(that.fadeTime, function () {
            $(this)
              .removeClass(that.visibleClass)
              .css(that.hidden)
              .css("opacity", 1);
          })
          .eq(position - 1)
          .fadeIn(that.fadeTime, function () {
          	console.log( $(this));
            $(this)
              .addClass(that.visibleClass)
              .css(that.visible);
            that.position = position;
          });
      }
    },

    getNextTrack: function(targetPosition){

    	var targetTrack = targetPosition ? that.trackList((targetPosition - 1)) :  that.trackList[that.position];
    	//console.log('targetPos: '+ targetPosition + 'position player: '+ that.position);
    	return targetTrack;
    },

    getPrevTrack: function(targetPosition){

    	var targetTrack = targetPosition ? that.trackList((targetPosition - 1)) : that.trackList[that.position - 2];
    	return targetTrack;
    },

    getMatchingTrackInTrackList: function(track){
    	var copyTrackList = that.trackList;
    	for(var index = 0, trackListLength = copyTrackList.length ; index < trackListLength ; index++){
    		if (track.trackId === copyTrackList[index].trackId)
    		{
    			return that.trackList[index];
    		}
    	}
    },


    //player methods
    play: function(track, position, comingFromPrevious){

    	track.play(comingFromPrevious, that);
    },

    stopTrack: function(){
    	that.currentTrack.stopTrack();
    },

    playPauseToggle: function(track){
    	if(that.isPlaying){
    		if(!that.isPaused)
    		{
    			track.player == 'soundcloud' ? that.currentTrack.PlayerObject.togglePause() : (track.player == 'youtube' ? that.currentTrack.PlayerObject.pauseVideo() : console.log('unsupported player'));
    			that.playButton.value = "play";
    			that.isPaused = true;
    		}
    		else
    		{
    			if(that.getMatchingTrackInTrackList(track).isInitialized)
    			{
    				track.player == 'soundcloud' ? that.currentTrack.PlayerObject.togglePause() : (track.player == 'youtube' ? that.currentTrack.PlayerObject.playVideo() : console.log('unsupported player'));
    			}
    			else
    			{
    				that.play(track);
    			}
    			that.playButton.value = "pause";
    			that.isPaused = false;
    		}
    	}
    	else
    	{
    		that.play(track);
    		that.playButton.value = "pause";
    		that.isPlaying = true;
    	}
    },

    next: function(targetPosition){
    	
    	if(that.currentTrack)
    	{
	    	if(that.currentTrack.isInitialized)
	    	{
	    		that.stopTrack();
    			that.currentTrack.isInitialized = false;
	    	}	
    		that.cleanProgressionLayer(that.position);
    		if(!that.isPaused)
    		{
    			targetPosition ? that.play(that.getNextTrack(targetPosition)) : that.play(that.getNextTrack());
    		}
    		targetPosition ? that.position = targetPosition : that.position++;
    		that.slideTo(that.position);
    		that.displayOrNotLeftArrow();
    		that.createOrNotTrackBoxes();
    		return("moved to track n"+that.position)
    	}
    	else
    	{
    		return('No current Track');
    	}
    },

    prev: function(targetPosition){
    	if(that.currentTrack)
    	{
	    	if(that.currentTrack.isInitialized)
	    	{
	    		that.stopTrack();
    			that.currentTrack.isInitialized = false;
	    	}	
	    	that.cleanProgressionLayer(that.position);
	    	if(!that.isPaused)
	    	{
	    		targetPosition ? that.play(that.getPrevTrack(targetPosition), null, true) : that.play(that.getPrevTrack(), null, true);
	    	}
	    	targetPosition ? that.position = targetPosition : that.position--;
	    	that.slideTo(that.position);
	    	that.displayOrNotLeftArrow();
	    	return("moved to track n"+that.position)
	    }
	    else
	    {
	    	return('No current Track');
	    }
    }
}

// track class

var Track = function(TrackInformation, CuratorInformation, TrackBox, PlayerObject){
	if(TrackInformation)
	{
		this.url 					= TrackInformation.URL || ""; 
		this.trackId 				= TrackInformation.trackId || 0;
		this.player 				= TrackInformation.player || "";
		this.cover 					= TrackInformation.cover || "";
		this.title 					= TrackInformation.title || ""
		this.id 					= TrackInformation.id || 0;
	}
	if(CuratorInformation)
	{
		this.curatorPseudo 			= CuratorInformation.curatorPseudo || "";
		this.curatorLink 			= CuratorInformation.curatorLink || "";
		this.curatorPic 			= CuratorInformation.curatorPic || "";
	}
	this.TrackBox				= TrackBox || {};
	this.PlayerObject			= PlayerObject || {};
	this.isPrepared 			= false;	// Youtube only: if we prepared the song in advance or not
	this.isInitialized			= false;
	this.currentIntervalId 		= 0;		// Interval for youtube progression bar
	this.currentIntervalBisId 	= 0;		// Interval for youtube next song's preparation
}

// Track children: SoundcloudTrack


function SoundcloudTrack(TrackInformation, CuratorInformation, TrackBox, PlayerObject){
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
					 	console.log('loaded');
					 	var playerPosition 				= PlayerLinked.position;
					 	var trackDuration 				= thatTrack.PlayerObject.durationEstimate;
					 	var TranparentOverlayDiv 		= document.getElementById('transparent_overlay'+ playerPosition);
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
					 	}

					 	// Prepare next song if needed
					 	thatTrack.PlayerObject.onPosition((trackDuration-10000), function(eventPosition){
					 		console.log('it\'s time to load next track, next player:'+ PlayerLinked.trackList[(PlayerLinked.position)].player);
					 		if(that.trackList[(that.position)].player === "youtube")
					 		{
					 			console.log('test 1 success');
					 			PlayerLinked.prepareYoutubePlayer(PlayerLinked.trackList[(that.position)], false, (PlayerLinked.position + 1));
					 			console.log(PlayerLinked.trackList[(PlayerLinked.position)]+ ' has been prepared from soundcloud');
					 		}
					 	});

					 	// Position navigation with click 
					 	TranparentOverlayDiv.addEventListener('click', function (e) 
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
					 	}, false);
					 }			
    			}}, 

				function(track){
					
					//that.currentTrack = track;
					PlayerLinked.currentTrack = that.getMatchingTrackInTrackList(thatTrack);
					thatTrack.PlayerObject = track;
					thatTrack.isInitialized = true;

					PlayerLinked.isPlaying = true;
					thatTrack.PlayerObject.play();

					//console.log(that.currentTrack);
					/*if ($('#play').val() == "pause") 
					{	
						if(window.matchMedia("(min-width: 480px)").matches )
						{
							onPlay=true;
			  				currentTrack.play();	
						}
						else if (document.getElementById('play').value==='pause')
						{
							onPlay=true;
			  				currentTrack.play();
						}	
					}*/
				});
	    },
	    stopTrack: function(){
	    	this.PlayerObject.stop();
	    }
}

// Track children: YoutubeTrack

function YoutubeTrack(TrackInformation, CuratorInformation, TrackBox, PlayerObject){
	Track.call(this, TrackInformation, CuratorInformation, TrackBox, PlayerObject);
}


YoutubeTrack.prototype = Object.create(Track.prototype);
YoutubeTrack.prototype.constructor = Track;

YoutubeTrack.prototype = {
	    prepareYoutubePlayer: function(playWhenReady, PlayerLinked, position){
	    	var targettedTrack = this;
	    	if(!position)
	    	{
	    		position = PlayerLinked.trackList.indexOf(that.getMatchingTrackInTrackList(targettedTrack)) + 1;
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
					that.nextTrack = new YT.Player('sound_cover'+ position, {
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
				that.nextTrack = new YT.Player('sound_cover'+ position, {
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

				PlayerLinked.nextTrack = that.getMatchingTrackInTrackList(targettedTrack);
				PlayerLinked.nextTrack.PlayerObject = event.target;

				event.target.playVideo();
				event.target.pauseVideo();

				if(playWhenReady){
					PlayerLinked.currentTrack = that.nextTrack;
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
						if(playerCurrentTime > (playerTotalTime-10) && that.trackList[(that.position)].player === "youtube" && !that.trackList[(that.position)].isPrepared && !triggered)
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
							var coverWidth 		= document.getElementById('sound_cover'+ playerPosition).offsetWidth;
							durationBeforeJump 	= targettedTrack.PlayerObject.getCurrentTime();
							var mousePos 		= {'x': e.layerX, 'y': e.layerY};
							var aimedPositionS 	= (mousePos['x']*(playerTotalTime/coverWidth));
							targettedTrack.PlayerObject.seekTo(aimedPositionS);
							document.getElementById('blurred_sound_cover_container'+ playerPosition).style.width=(mousePos['x']+"px");
							document.getElementById('cover_overlay'+ playerPosition).style.width=(mousePos['x']+"px");
							/*mixpanel.track("Progression bar hit", {
								"fullUrl": window.location.href,
								"trackId": that.trackList[(position-1)].trackID,
								"durationBeforeJump": durationBeforeJump,
								"jumpedTo": that.currentTrack.position
							});*/
					}, false);
				} 
				else if(event.data == YT.PlayerState.ENDED){
					PlayerLinked.next();

					//record automatic next to add here
				}
			}
	    },

	    play: function(comingFromPrevious, PlayerLinked){
	    	if(this.isPrepared)
	    	{
	    		PlayerLinked.currentTrack = that.nextTrack;
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

// TrackBox class

var TrackBox = function(index, TrackInfo){
	if(!TrackInfo)
	{
		return "missing track information";
	}
	else
	{
		this.trackIndex		= index || 0;
		this.trackCover 	= TrackInfo.trackCover || "";
		this.trackPlayer 	= TrackInfo.trackPlayer || "";
		this.trackTitle 	= TrackInfo.trackTitle || "";
		this.curatorPseudo 	= TrackInfo.curatorPseudo || "";
		this.curatorLink 	= TrackInfo.curatorLink || "";
		this.curatorPic 	= TrackInfo.curatorPic || "";

		this.listDomElement	= document.createElement('li');
		this.listDomElement.setAttribute('id','slide'+(this.trackIndex));
		this.listDomElement.setAttribute('class','slide');
			var songBox = document.createElement('div');
			songBox.setAttribute('id','sound_box'+(this.trackIndex));
			songBox.setAttribute('class','sound_box');
				var coverContainer = document.createElement('div');
				coverContainer.setAttribute('id','cover_container'+(this.trackIndex));
				coverContainer.setAttribute('class','cover_container');
					var soundCover = document.createElement('img');
					soundCover.setAttribute('id','sound_cover'+(this.trackIndex));
					soundCover.setAttribute('class','sound_cover');	
					this.trackPlayer == 'soundcloud' ? soundCover.setAttribute('src',this.trackCover) : soundCover.setAttribute('src','');
					var blurredCoverContainer = document.createElement('div');
					blurredCoverContainer.setAttribute('id', 'blurred_sound_cover_container'+(this.trackIndex));		
					blurredCoverContainer.setAttribute('class','blurred_sound_cover_container');
					if(this.trackPlayer == 'soundcloud')	
					{
						var blurredSoundCover = document.createElement('img');
						blurredSoundCover.setAttribute('id','blurred_sound_cover'+(this.trackIndex));
						blurredSoundCover.setAttribute('class','blurred_sound_cover');	
						blurredSoundCover.setAttribute('src', this.trackCover);
						blurredCoverContainer.appendChild(blurredSoundCover);
					}	
					var coverOverlay = document.createElement('div');
					coverOverlay.setAttribute('id','cover_overlay'+(this.trackIndex));
					coverOverlay.setAttribute('class','cover_overlay');
						var trackPosition = document.createElement('div');
						trackPosition.setAttribute('id','track_position'+(this.trackIndex));
						trackPosition.setAttribute('class','track_position');
						trackPosition.innerHTML = '0:00';
						coverOverlay.appendChild(trackPosition);
					var transparentOverlay = document.createElement('div');
					transparentOverlay.setAttribute('id','transparent_overlay'+(this.trackIndex));
					transparentOverlay.setAttribute('class','transparent_overlay');

					coverContainer.appendChild(soundCover);
					coverContainer.appendChild(blurredCoverContainer);
					coverContainer.appendChild(coverOverlay);
					coverContainer.appendChild(transparentOverlay);

				var soundInformations = document.createElement('div');
				soundInformations.setAttribute('id','sound_informations'+(this.trackIndex));
				soundInformations.setAttribute('class','sound_informations');
					var curatorLink = document.createElement('a');
					curatorLink.setAttribute('href',this.curatorLink);
					curatorLink.setAttribute('target','_blank');
						var curatorTextTitle = document.createElement('h3');
						curatorTextTitle.setAttribute('class','curator');
							var curatorText  = document.createElement('div');
							curatorText.setAttribute('class','curatorText');
								var curatorSpan = document.createElement('span');
								curatorSpan.style.backgroundColor = "black";
								curatorSpan.innerHTML = "Curator: " + this.curatorPseudo;
								var curatorStuff = document.createElement('div');
								curatorStuff.setAttribute('class', 'curatorStuff');
									var curatorPicture = document.createElement('img');
									curatorPicture.setAttribute('class','curatorPicture');	
									curatorPicture.setAttribute('src', this.curatorPic);
									curatorStuff.appendChild(curatorPicture);
								curatorText.appendChild(curatorSpan);
								curatorText.appendChild(curatorStuff);
							curatorTextTitle.appendChild(curatorText);
						curatorLink.appendChild(curatorTextTitle);
					var songTitle = document.createElement('h3');
					songTitle.setAttribute('class','title');
						var titleText = document.createElement('div');
						titleText.setAttribute('class','titleText');
							var titleSpan = document.createElement('span');
							titleSpan.setAttribute('class','titleText');
							titleSpan.style.backgroundColor = "black";
							titleSpan.innerHTML = this.trackTitle;
							titleText.appendChild(titleSpan);
						songTitle.appendChild(titleText);
					soundInformations.appendChild(curatorLink);
					soundInformations.appendChild(songTitle);
				songBox.appendChild(coverContainer);
				songBox.appendChild(soundInformations);
			this.listDomElement.appendChild(songBox);
		return this;
	}
}




