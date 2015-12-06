var Track       	= require('./Track.js');
var YoutubeTrack  	= require('./YoutubeTrack.js');
var SoundcloudTrack = require('./SoundcloudTrack.js');
var TrackBox    	= require('./TrackBox.js');

var Player = function(trackListUrl, divSelector, playButtonSelector, arrowSelectors, autoplay, fadeTime){
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
	this.autoplay				= autoplay || false;

	// Helpers
	this.currentTrack 			= null; 
	var that 					= this;
	console.log(that);  

	that.prepareNavigationButtons();
}

Player.prototype = {

	// CSS classes for slider

	that				: this,
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
	createTrackBoxes: function (numberOfBoxes, playerObject){

		var that					= playerObject || this || that;
		console.log(that);
		numberOfBoxes 				= numberOfBoxes || 10;
		var numberOfBoxesWithOffset = numberOfBoxes + that.boxesCreated;
		var trackListCopy 			= that.trackList;
		var masterJsonCopy 			= that.masterJson || {};
		console.log('createTrackBoxes' + that);
		if(that.masterJson)
		{
			document.getElementById("mainPlayerLoader").style.display = "none";
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

			document.getElementById("outerLoader").style.opacity = "0";
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

			if(that.boxesCreated < 15 && that.autoplay){that.play(that.trackList[0]);}
		}
		else
		{
			console.log('error: attempt to create songboxes without master json');
		}
		//$(that.divSelector).unblock();
	},

	createOrNotTrackBoxes: function(){
		var that = this;
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

		var that 					= this;

		this.masterJson 			= [];
		var ajaxRequestNumber 		= 0;
		var ajaxRequestCompleted 	= 0;
		var trackListProper 		= [];
		console.log('masterJson' + that);

		for(var indexTrackList 	= 0, trackListLength = trackList.length ; indexTrackList < trackListLength ; indexTrackList++)
		{
			var urlCopy 					= trackList[indexTrackList];
			//console.log(urlCopy);
			

			if(trackList[indexTrackList].toLowerCase().indexOf("youtube") > -1 )
			{
				trackListProper[indexTrackList] = new YoutubeTrack();
				var videoId 					= urlCopy.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
				var trackIdCopy 				=  videoId[1] ||  null;

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
						           		callBack(10, that);
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
						if(track)
						{
							trackListProper[indexTrackList].url = track.permalink_url;
							trackListProper[indexTrackList].trackId = track.id;
							trackListProper[indexTrackList].player = "soundcloud";
							trackListProper[indexTrackList].title = track.title;
							trackListProper[indexTrackList].cover
							track.artwork_url ? trackListProper[indexTrackList].cover 	= track.artwork_url.replace("large.jpg", "t500x500.jpg") : trackListProper[indexTrackList].cover = "../assets/pictures/default_cover.png";
						}
						if(isFinished(indexTrackList))
						{
							that.trackList = trackListProper;
							callBack(10, that);
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
			            if(json)
			            {
			            	console.log(json.id);
			            	trackListProper[indexTrackList].id 				= json.id || 0;
			            	trackListProper[indexTrackList].curatorPseudo 	= json.pseudo || "";
			            	trackListProper[indexTrackList].curatorLink 	= json.link || "";
			            	trackListProper[indexTrackList].curatorPic 		= json.avatar_url || "";
			            }
			           
			            //new ajax request to get like state
			            (function(urlCopy, indexTrackList){
			            	var xhrLikeTest 				= [];
			            	xhrLikeTest[indexTrackList] 	= new XMLHttpRequest();
			            	var urlToSend 					= "../model/get_like_state.php?songId="  + json.id;
			            	xhrLikeTest[indexTrackList].open('GET', urlToSend); // On test si le son a déjà été liké par currentUser
			                xhrLikeTest[indexTrackList].onreadystatechange = function() 
			            	{ // On gère ici une requête asynchrone

			                    if(xhrLikeTest[indexTrackList].readyState == 4 && xhrLikeTest[indexTrackList].status == 200) 
			                    { // Si le fichier est chargé sans erreur
			                        trackListProper[indexTrackList].isLiked	 = xhrLikeTest[indexTrackList].responseText === "FALSE" ? false : true;
			                        if(isFinished(indexTrackList))
			                        {
			                        	that.trackList = trackListProper;
			                        	callBack(10, that);
			                        	console.log(trackListProper);
			                        } 
			                    }
			                };
			                xhrLikeTest[indexTrackList].send(null); // La requête est prête, on envoie tout !
			                ajaxRequestNumber++;
			            })(urlCopy, indexTrackList);

			            if(isFinished(indexTrackList))
			            {
			            	that.trackList = trackListProper;
			            	callBack(10, that);
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
		var that = this;
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
			that.nextArrow.style.visibility = "visible";
			var nextArrow = true;
		}
		if(that.prevArrow){
			that.prevArrow.addEventListener('click', function(){
				that.prev();
			}, false);
			that.prevArrow.style.visibility = "visible";
			var prevArrow = true;
		}

		document.addEventListener('keydown', function(e) 
		{
		    if(e.keyCode == 32) //spacebar
		    {
		    	/*mixpanel.track("Shortcut Play/Pause", 
				{
					"fullUrl": window.location.href
				});*/
		    	if(document.activeElement.nodeName != "INPUT")
			   	{
			   		that.playPauseToggle(that.currentTrack);
			   	}
			   	else
			   	{
			   		$('input').blur();
			   		that.playPauseToggle(that.currentTrack);
			   	}
		    }
		}, false);

		return "Play Button: " + playButton + "Next Button: " + nextArrow + "Prev Button: " + prevArrow;
	},
	displayOrNotLeftArrow: function(){
		var that = this;
		that.position > 1 ? that.displayLeftArrow() : that.undisplayLeftArrow();
	},
	displayLeftArrow: function(){
		this.prevArrow.style.opacity = 1;		
	},
	undisplayLeftArrow: function(){
		this.prevArrow.style.opacity = 0;		
	},
	cleanProgressionLayer: function(position){
		var that = this;
		document.getElementById('blurred_sound_cover_container'+ position).style.width= "0";
		document.getElementById('cover_overlay'+ position).style.width= "0";

	},

	// helpers
    slideTo: function (position) {

    	var that = this;
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

    	var that = this;
    	var targetTrack = targetPosition ? that.trackList((targetPosition - 1)) :  that.trackList[that.position];
    	//console.log('targetPos: '+ targetPosition + 'position player: '+ that.position);
    	return targetTrack;
    },

    getPrevTrack: function(targetPosition){

    	var that = this;
    	var targetTrack = targetPosition ? that.trackList((targetPosition - 1)) : that.trackList[that.position - 2];
    	return targetTrack;
    },

    getMatchingTrackInTrackList: function(track){

    	var that = this;
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

    	var that = this;
    	track.play(comingFromPrevious, that);

    	//check if liked, to change like button color in case it is
    	var isLiked = that.getMatchingTrackInTrackList(track).isLiked ? true : false;
    	isLiked ? that.pressLikeButton() : that.unpressLikeButton();
    	that.playButton.value = "pause";
    },

    stopTrack: function(){

    	var that = this;
    	that.currentTrack.stopTrack();
    },

    playPauseToggle: function(track){

    	var that = this;
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

    	var that = this;
    	
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

    	var that = this;
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
    },

    pressLikeButton: function(){
		var likeStamp = document.getElementById("plus_one");
        likeStamp.style.background="url(http://soundpark.fm/assets/pictures/heart_like_pressed.png)";
        likeStamp.style.backgroundSize="contain";
        likeStamp.style.backgroundRepeat="no-repeat";
    },

    unpressLikeButton: function(){
    	var likeStamp = document.getElementById("plus_one");
        likeStamp.style.background="url(http://soundpark.fm/assets/pictures/heart_like.png)";
        likeStamp.style.backgroundSize="contain";
        likeStamp.style.backgroundRepeat="no-repeat";
    },

    recordAutomaticNext: function(songId)
	{
		console.log('auto next launched, songId: '+ songId);
		
	    $.ajax({
	      url: "../control/record_automatic_next.php?songId="+songId,
	      cache: false,
	      
	      success: function(trackListEntry) {
	        console.log('autoNext registered');
	      }.bind(this),

	      error: function(xhr, status, err) {
	        console.error("../control/record_automatic_next.php?songId=", status, err.toString());
	      }.bind(this)
	    });

	    mixpanel.track("Automatic Next", 
	    {
	    	"fullUrl": window.location.href,
	    	"TrackId": track.trackId,
	    	"userId": userId,
	    	"playlistPosition": playerPositionLogs,
	    	"curator": that.masterJson.curatorPseudo
	    });
	}
}

module.exports = Player;