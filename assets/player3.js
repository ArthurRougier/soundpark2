var Player = function(trackListUrl, divSelector, fadeTime, navButtons){
	this.currentTrack = null ; 
	this.divSelector = divSelector || null;
	this.trackList = trackListUrl && disembiguateTracks(trackListUrl);
	this.whenReady = null;
	this.playersToLoad = 0;
	this.progress = null;
	this.playTimeout = null;
	this.position = 1;
	this.fadeTime = fadeTime || 500;
	this.navButtons = navButtons || {};

	// Helpers
	that = this;    

	function disembiguateTracks(trackList) { // function to return tracks objects with player types, trackIds and Urls from a simple url list
		var trackListProper = [];
		var idTable = []
		for(indexTrackList = 0, trackListLength = trackList.length ; indexTrackList < trackListLength ; indexTrackList++)
		{
			if(trackList[indexTrackList].toLowerCase().indexOf("youtube") > -1 )
			{
				var videoId = trackList[indexTrackList].match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
				trackId =  videoId[1] ||  null;
				trackListProper[indexTrackList] = new Track(trackList[indexTrackList], trackId, 'youtube');

			}
			else if(trackList[indexTrackList].toLowerCase().indexOf("soundcloud") > -1 ){
				var urlCopy = trackList[indexTrackList];
				(function(urlCopy, indexTrackList){
					SC.get('/resolve', { url: urlCopy.toLowerCase() }, function(track)
					{
						trackListProper[indexTrackList] = new Track(track.permalink_url, track.id, 'soundcloud');
					});
				})(trackList[indexTrackList], indexTrackList);
			}
			else
			{
				trackListProper[indexTrackList] = new Track(trackList[indexTrackList], null, 'unknown');
			}
		}
		return trackListProper;
	}
}

Player.prototype = {

	// CSS classes for slider
    activeClass: "rslides_here",
    visibleClass: "rslides1_on",
    visible: {"float": "left", "position": "relative", "opacity": 1, "zIndex": 2},
    hidden: {"float": "none", "position": "absolute", "opacity": 0, "zIndex": 1},

	supportTransitions: (function () {
          var docBody = document.body || document.documentElement;
          var styles = docBody.style;
          var prop = "transition";
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




	createTenFirstTrackBoxes: function (){
		if(this.masterJson)
		{
			var masterJsonCopy = this.masterJson;
			var mainUl = document.createElement('ul');
			mainUl.setAttribute('id','sliderTest');
			mainUl.setAttribute('class','rslides');	

			for(var indexSongBoxes = 0, lengthCopy = this.trackList.length ; (indexSongBoxes < lengthCopy && indexSongBoxes < 10) ; indexSongBoxes++ )
			{
				var listElement = document.createElement('li');
				listElement.setAttribute('id','slide'+(indexSongBoxes + 1));
				listElement.setAttribute('class','slide');
					var songBox = document.createElement('div');
					songBox.setAttribute('id','sound_box'+(indexSongBoxes + 1));
					songBox.setAttribute('class','sound_box');
						var coverContainer = document.createElement('div');
						coverContainer.setAttribute('id','cover_container'+(indexSongBoxes + 1));
						coverContainer.setAttribute('class','cover_container');
							var soundCover = document.createElement('img');
							soundCover.setAttribute('id','sound_cover'+(indexSongBoxes + 1));
							soundCover.setAttribute('class','sound_cover');	
							masterJsonCopy[indexSongBoxes].player == 'soundcloud' ? soundCover.setAttribute('src',masterJsonCopy[indexSongBoxes].cover) : soundCover.setAttribute('src','');
							var blurredCoverContainer = document.createElement('div');
							blurredCoverContainer.setAttribute('id', 'blurred_sound_cover_container'+(indexSongBoxes + 1));		
							blurredCoverContainer.setAttribute('class','blurred_sound_cover_container');	
								var blurredSoundCover = document.createElement('div');
								blurredSoundCover.setAttribute('id','blurred_sound_cover'+(indexSongBoxes + 1));
								blurredSoundCover.setAttribute('class','blurred_sound_cover');	
								blurredSoundCover.setAttribute('src','http://i1.sndcdn.com/artworks-000058618321-b2dnoh-crop.jpg?e76cf77');
								blurredCoverContainer.appendChild(blurredSoundCover);
							var coverOverlay = document.createElement('div');
							coverOverlay.setAttribute('id','cover_overlay'+(indexSongBoxes + 1));
							coverOverlay.setAttribute('class','cover_overlay');
								var trackPosition = document.createElement('div');
								trackPosition.setAttribute('id','track_position'+(indexSongBoxes + 1));
								trackPosition.setAttribute('class','track_position');
								trackPosition.innerHTML = '0:00';
								coverOverlay.appendChild(trackPosition);
							var transparentOverlay = document.createElement('div');
							transparentOverlay.setAttribute('id','transparent_overlay'+(indexSongBoxes + 1));
							transparentOverlay.setAttribute('class','transparent_overlay');

							coverContainer.appendChild(soundCover);
							coverContainer.appendChild(blurredCoverContainer);
							coverContainer.appendChild(coverOverlay);
							coverContainer.appendChild(transparentOverlay);

						var soundInformations = document.createElement('div');
						soundInformations.setAttribute('id','sound_informations'+(indexSongBoxes + 1));
						soundInformations.setAttribute('class','sound_informations');
							var curatorLink = document.createElement('a');
							curatorLink.setAttribute('href',masterJsonCopy[indexSongBoxes].curatorLink);
							curatorLink.setAttribute('target','_blank');
								var curatorTextTitle = document.createElement('h3');
								curatorTextTitle.setAttribute('class','curator');
									var curatorText  = document.createElement('h3');
									curatorText.setAttribute('class','curator');
										var curatorSpan = document.createElement('span');
										curatorSpan.style.backgroundColor = "black";
										curatorSpan.innerHTML = "Curator: " + masterJsonCopy[indexSongBoxes].curatorPseudo;
										var curatorStuff = document.createElement('div');
										curatorStuff.setAttribute('class', 'curatorStuff');
											var curatorPicture = document.createElement('img');
											curatorPicture.setAttribute('class','curatorPicture');	
											curatorPicture.setAttribute('src', masterJsonCopy[indexSongBoxes].curatorPic);
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
									titleSpan.innerHTML = masterJsonCopy[indexSongBoxes].title;
									titleText.appendChild(titleSpan);
								songTitle.appendChild(titleText);
							soundInformations.appendChild(curatorLink);
							soundInformations.appendChild(songTitle);
						songBox.appendChild(coverContainer);
						songBox.appendChild(soundInformations);
					listElement.appendChild(songBox);
				mainUl.appendChild(listElement);
			}
			document.querySelector(this.divSelector).appendChild(mainUl);

			var $slides = $('.slide');
			// Hide all slides, then show first one
			$slides
			  .hide()
			  .css(that.hidden)
			  .eq(0)
			  .addClass(that.visibleClass)
			  .css(that.visible)
			  .show();

			if (this.supportTransitions) {
				$slides
				  .show()
				  .css({
				    // -ms prefix isn't needed as IE10 uses prefix free version
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
		
	},

	getMasterJson: function (){

		this.masterJson = [];
		that = this;
		for(var indexTrackList = 0, lengthCopy = that.trackList.length ; indexTrackList < lengthCopy ; indexTrackList++ )
		{
			var urlCopy = that.trackList[indexTrackList].url;
			var player = that.trackList[indexTrackList].player;
			var trackIdCopy = that.trackList[indexTrackList].trackId;

			if(player == "soundcloud")
			{
				(function(urlCopy, indexTrackList){
					//console.log(urlCopy);
					SC.get('/resolve', { url: urlCopy.toLowerCase() }, function(track)
					{
						that.masterJson[indexTrackList] = that.masterJson[indexTrackList] || {};
						track.artwork_url ? that.masterJson[indexTrackList].cover = track.artwork_url.replace("large.jpg", "t500x500.jpg") : that.masterJson[indexTrackList].cover = "../assets/pictures/default_cover.png";
						that.masterJson[indexTrackList].title = track.title;
						that.masterJson[indexTrackList].trackId = track.id;
						that.masterJson[indexTrackList].player = "soundcloud";
					});
				})(urlCopy, indexTrackList);
			}
			else if(player == "youtube")
			{
					(function(trackIdCopy, indexTrackList){
								xhr = new XMLHttpRequest();
								var urlToSend = "https://www.googleapis.com/youtube/v3/videos?id="+ trackIdCopy +"&key=AIzaSyAzc_ihjBq03TOwwPqkt1ZgfT6ouEJ5plI&part=snippet";
								xhr.open('GET', urlToSend); // On test si le son a déjà été liké par currentUser
								
							    xhr.onreadystatechange = function() 
								{ // On gère ici une requête asynchrone

							        if(xhr.readyState == 4 && xhr.status == 200) 
							        { // Si le fichier est chargé sans erreur
							            var json = JSON.parse(xhr.responseText);
							            that.masterJson[indexTrackList] = that.masterJson[indexTrackList] || {};
							            that.masterJson[indexTrackList].title = json.items[0].snippet.title;
							            that.masterJson[indexTrackList].trackId = json.items[0].id;
							            that.masterJson[indexTrackList].player = "youtube";
							        }
							    };


							    xhr.send(null); // La requête est prête, on envoie tout !
						})(trackIdCopy, indexTrackList);
			}
			(function(urlCopy, indexTrackList){
					var xhrDb = [];
					xhrDb[indexTrackList] = new XMLHttpRequest();
					var urlToSend = "../model/get_curator_information_from_song_url.php?trackUrl="  + encodeURIComponent(urlCopy) + "&jsonDisplay=TRUE";
					xhrDb[indexTrackList].open('GET', urlToSend); // On test si le son a déjà été liké par currentUser
					
				    xhrDb[indexTrackList].onreadystatechange = function() 
					{ // On gère ici une requête asynchrone

				        if(xhrDb[indexTrackList].readyState == 4 && xhrDb[indexTrackList].status == 200) 
				        { // Si le fichier est chargé sans erreur
				            var json = JSON.parse(xhrDb[indexTrackList].responseText);
				            that.masterJson[indexTrackList] = that.masterJson[indexTrackList] || {};
				            that.masterJson[indexTrackList].id = json.id;
				            that.masterJson[indexTrackList].curatorPseudo = json.pseudo;
				            that.masterJson[indexTrackList].curatorLink = json.link;
				            that.masterJson[indexTrackList].curatorPic = json.avatar_url;
				        }
				    };


				    xhrDb[indexTrackList].send(null); // La requête est prête, on envoie tout !
			})(urlCopy, indexTrackList);

		}
	},

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

    play: function(track){
    	track.player == 'soundcloud' ? that.playSoundcloud(track) : (track.player == 'youtube' ? that.playYoutube(track) : console.log('unsupported player'));
    },

    playSoundcloud: function(track)
    {
    	SC.stream("/tracks/"+track.trackId,
    		{
    			onfinish: function()
    			{ 
    				console.log('trackFinished');
    				/*nextTrack();
    				record_automatic_next();
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
    				console.log('loaded');
    				var playerPosition = that.position;
    				var TranparentOverlayDiv = document.getElementById('transparent_overlay'+ playerPosition);
    				var trackPositionTextContainer = document.getElementById('track_position'+ playerPosition);

    				for(var index = 1, trackDurationInSeconds = that.currentTrack.durationEstimate/1000  ; index < trackDurationInSeconds ; index++)
    				{
    					that.currentTrack.onPosition(index*1000, function(eventPosition)
    					{
    						//console.log(this.id+' reached '+eventPosition);

    						//On change le formatage du compteur temps ici pour afficher mn:sec 

    						var minutes = (eventPosition / 60000) | (0);
    						var seconds = eventPosition/1000 - minutes * 60;
    						seconds < 10 ? seconds = '0'+ seconds : (!minutes ? trackPositionTextContainer.innerHTML = seconds : trackPositionTextContainer.innerHTML = minutes + ':' + seconds); 

    						// On fait avancer l'overlay
    						var coverWidth = document.getElementById('sound_cover'+ playerPosition).offsetWidth;
    						var step = (eventPosition/1000*coverWidth/(that.currentTrack.durationEstimate/1000));
    						document.getElementById('blurred_sound_cover_container'+ playerPosition).style.width=(step+"px");
    						document.getElementById('cover_overlay'+ playerPosition).style.width=((step)+"px");
    						//END On fait avancer l'overlay
    					});
    				}

    				// Position navigation with click 
    				
    				TranparentOverlayDiv.addEventListener('click', function (e) 
    				{
    						//clearDropdownMenu();
    						var coverWidth = document.getElementById('sound_cover'+ playerPosition).offsetWidth;
    						durationBeforeJump = that.currentTrack.position;
    						var mousePos = {'x': e.layerX, 'y': e.layerY};
    						//console.log(mousePos['x']);
    						var aimedPositionMs = (mousePos['x']*(that.currentTrack.durationEstimate/coverWidth));
    						that.currentTrack.setPosition(aimedPositionMs);
    						document.getElementById('blurred_sound_cover_container'+ playerPosition).style.width=(mousePos['x']+"px");
    						document.getElementById('cover_overlay'+ playerPosition).style.width=(mousePos['x']+"px");
    						mixpanel.track("Progression bar hit", {
    							"fullUrl": window.location.href,
    							"trackId": that.trackList[(position-1)].trackID,
    							"durationBeforeJump": durationBeforeJump,
    							"jumpedTo": that.currentTrack.position
    						});
    		
    				}, false);

    					// END position navigation with click 				
    			}
    		}, 
    			function(track)
    			{
    				that.currentTrack = track;
    				that.currentTrack.play();
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

    playYoutube: function(track){

		// 2. This code loads the IFrame Player API code asynchronously.
		var tag = document.createElement('script');

		tag.src = "https://www.youtube.com/iframe_api";
		var firstScriptTag = document.getElementsByTagName('script')[0];
		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

		// 3. This function creates an <iframe> (and YouTube youtubeTrackPlayer)
		//    after the API code downloads.
		var youtubeTrackPlayer;
		window.onYouTubeIframeAPIReady = function() {
		var divHeight = $('sound_cover'+that.position).height();
		youtubeTrackPlayer = new YT.Player('sound_cover'+that.position, {
		  height: divHeight,
		  width: divHeight,
		  videoId: track.trackId,
		  youtubeTrackPlayerVars: {
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

		// 4. The API will call this function when the video youtubeTrackPlayer is ready.
		function onPlayerReady(event) {
			youtubeTrackPlayer.playVideo();
			console.log('playY');
		}

		// 5. The API calls this function when the youtubeTrackPlayer's state changes.
		//    The function indicates that when playing a video (state=1),
		//    the youtubeTrackPlayer should play for six seconds and then stop.
		var done = false;
		function onPlayerStateChange(event) {
		    if (event.data == YT.PlayerState.PLAYING) {

				var playerPosition = that.position;
				var playerTotalTime = youtubeTrackPlayer.getDuration();
				var TranparentOverlayDiv = document.getElementById('transparent_overlay'+ playerPosition);
				var trackPositionTextContainer = document.getElementById('track_position'+ playerPosition);

				mytimer = setInterval(function() {

					var playerCurrentTime = youtubeTrackPlayer.getCurrentTime();
					var playerTimeDifference = (playerCurrentTime / playerTotalTime) * 100;

					//On change le formatage du compteur temps ici pour afficher mn:sec 

					var minutes = (playerCurrentTime / 60) | (0);
					var seconds = Math.round(playerCurrentTime - minutes * 60);
					seconds < 10 ? seconds = '0'+ seconds : seconds = seconds;
					!minutes ? trackPositionTextContainer.innerHTML = seconds : trackPositionTextContainer.innerHTML = minutes + ':' + seconds;
					//console.log(minutes + ' - ' + seconds);

					// On fait avancer l'overlay
					var coverWidth = document.getElementById('sound_cover'+ playerPosition).offsetWidth;
					var step = (playerCurrentTime*coverWidth/(playerTotalTime));
					document.getElementById('blurred_sound_cover_container'+ playerPosition).style.width=(step+"px");
					document.getElementById('cover_overlay'+ playerPosition).style.width=((step)+"px");

				}, 1000);   

				// Position navigation with click 	
				TranparentOverlayDiv.addEventListener('click', function (e) 
				{
						//clearDropdownMenu();
						var coverWidth = document.getElementById('sound_cover'+ playerPosition).offsetWidth;
						durationBeforeJump = youtubeTrackPlayer.getCurrentTime();
						var mousePos = {'x': e.layerX, 'y': e.layerY};
						var aimedPositionS = (mousePos['x']*(playerTotalTime/coverWidth));
						youtubeTrackPlayer.seekTo(aimedPositionS);
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
			else {

			}
		}

    }

    
}


var Track = function(URL, trackId, player){
	this.url = URL || ""; 
	this.trackId = trackId || 0;
	this.player = player || "";
}




