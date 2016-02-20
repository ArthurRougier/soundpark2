// React 
import React from 'react';
import ReactDOM from 'react-dom';


//Import player modules
import Track from '../player_modules/Track';
import YoutubeTrack from '../player_modules/YoutubeTrack';
import SoundcloudTrack from '../player_modules/SoundcloudTrack';

import SongBox from './SongBox';
import TrackSlider from './TrackSlider';

export default class PlayerBo extends React.Component {
	constructor (props) {
		super(props);
		this.state = {
			currentTrack			: {},
			nextTrack 				: null,
			trackListEntry 			: [],
			trackList				: [],
			isPlaying 				: false,
			isPaused 				: false,
			isYoutubeInitialized 	: document.getElementById('youtubeScript') ? true : false,
			whenReady 				: null,
			playersToLoad 			: 0,
			progress 				: null,
			playTimeout 			: null,
			position 				: 1,
			playlistToDisplay 		: 0
		};

		var that = this;
		this.displayUntreated 				= this.props.untreated || false;
		this.displayUsed 					= this.props.used || false;
		this.stored 						= this.props.stored || false;

		this.loadRawSongsFromServer 		= this.loadRawSongsFromServer.bind(this);
		this.loadPlaylistToDisplay 			= this.loadPlaylistToDisplay.bind(this);
		this.getMasterJson 					= this.getMasterJson.bind(this);
		this.getNextTrack 					= this.getNextTrack.bind(this);
		this.getPrevTrack 					= this.getPrevTrack.bind(this);
		this.getMatchingTrackInTrackList	= this.getMatchingTrackInTrackList.bind(this);
		this.play 							= this.play.bind(this);
		this.stopTrack	 					= this.stopTrack.bind(this);
		this.playPauseToggle 				= this.playPauseToggle.bind(this);
		this.next 							= this.next.bind(this);
		this.prev 							= this.prev.bind(this);
	}

	componentDidMount() {

		console.log("PlayerBo Mounted");
	    this.loadRawSongsFromServer();
	    this.loadPlaylistToDisplay();
	    this.loadInterval = setInterval(this.loadRawSongsFromServer, this.props.pollInterval);
	}

	componentWillUnmount () {
		console.log("unmounting PlayerBo");
		if(this.state.isPlaying)
		{
			this.stopTrack();
		}
	    this.loadInterval && clearInterval(this.loadInterval);
	    this.loadInterval = false;
	}

	loadRawSongsFromServer() {
	    $.ajax({
	      url: this.props.urlTrackListUrl,
	      dataType: 'json',
	      cache: false,
	      success: function(trackListEntry) {
	      	if(JSON.stringify(trackListEntry) !=  JSON.stringify(this.state.trackListEntry))
	      	{
	      		this.setState({trackListEntry: trackListEntry});
	      		this.getMasterJson();
	      	}
	      }.bind(this),
	      error: function(xhr, status, err) {
	        console.error(this.props.urlTrackListUrl, status, err.toString());
	      }.bind(this)
	    });
	}

	loadPlaylistToDisplay() {
		if(this.props.playlistGetterUrl)
		{
			$.ajax({
				url: this.props.playlistGetterUrl,
				cache: false,

				success: function(playlistToDisplay) {
					if(playlistToDisplay !=  this.state.playlistToDisplay)
					{
						//console.log(playlistToDisplay);
						this.setState({playlistToDisplay: playlistToDisplay});
					}
				}.bind(this),

				error: function(xhr, status, err) {
					console.error(this.props.playlistGetterUrl, status, err.toString());
				}.bind(this)
			});
		}
	}

	getMasterJson(callBack){
		var that 					= this;
		var trackList 				= this.state.trackListEntry;
		var ajaxRequestNumber 		= 0;
		var ajaxRequestCompleted 	= 0;
		var trackListProper 		= [];

		for(var indexTrackList 	= 0, trackListLength = trackList.length ; indexTrackList < trackListLength ; indexTrackList++)
		{
			var urlCopy 					= trackList[indexTrackList].url;
			//console.log(indexTrackList + " url: " + urlCopy);
			
			if(urlCopy.toLowerCase().indexOf("youtube") > -1 )
			{
				trackListProper[indexTrackList] = new YoutubeTrack();
				var videoId 					= urlCopy.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
				var trackIdCopy 				= videoId[1] ||  null;

				(function(trackIdCopy, indexTrackList){
							var xhr 			= [];
							xhr[indexTrackList] = new XMLHttpRequest();
							var urlToSend 		= "https://www.googleapis.com/youtube/v3/videos?id="+ trackIdCopy +"&key=AIzaSyAzc_ihjBq03TOwwPqkt1ZgfT6ouEJ5plI&part=snippet";
							xhr[indexTrackList].open('GET', urlToSend); // On test si le son a déjà été liké par currentUser
							
						    xhr[indexTrackList].onreadystatechange = function() 
							{ // On gère ici une requête asynchrone

						        if(xhr[indexTrackList].readyState == 4 && xhr[indexTrackList].status == 200) 
						        { // Si le fichier est chargé sans erreur
						            var json 										= JSON.parse(xhr[indexTrackList].responseText);
					            	trackListProper[indexTrackList].url 			= trackList[indexTrackList].url;
				            		trackListProper[indexTrackList].trackId 		= json.items[0].id;
				            		trackListProper[indexTrackList].player 			= "youtube";
				            		trackListProper[indexTrackList].title 			= json.items[0].snippet.title;
				            		trackListProper[indexTrackList].id 				= trackList[indexTrackList].id;
				            		trackListProper[indexTrackList].curatorPseudo 	= trackList[indexTrackList].curatorPseudo;
				            		trackListProper[indexTrackList].curatorLink 	= trackList[indexTrackList].curatorLink;
				            		trackListProper[indexTrackList].curatorPic		= trackList[indexTrackList].curatorPic;
				            		trackListProper[indexTrackList].occasion1		= trackList[indexTrackList].occasion1;
				            		trackListProper[indexTrackList].occasion2		= trackList[indexTrackList].occasion2;
				            		trackListProper[indexTrackList].genre 			= trackList[indexTrackList].genre;
				            		trackListProper[indexTrackList].treated			= trackList[indexTrackList].treated;
				            		trackListProper[indexTrackList].playlistId		= trackList[indexTrackList].playlistId;

						           	if(isFinished(indexTrackList))
						           	{
						           		that.setState({trackList: trackListProper});
						           		console.log("Tracklist after all calls:" + that.state.trackList);
						           		//callBack();
						           	} 
						        }
						    };
						    xhr[indexTrackList].send(null); // La requête est prête, on envoie tout !
					})(trackIdCopy, indexTrackList);
					ajaxRequestNumber++;

			}
			else if(urlCopy.toLowerCase().indexOf("soundcloud") > -1 ){
				trackListProper[indexTrackList] = new SoundcloudTrack();
				(function(urlCopy, indexTrackList){
					//console.log(urlCopy);
					SC.get('/resolve', { url: urlCopy.toLowerCase() }, function(track)
					{
						if(track)
						{
							trackListProper[indexTrackList].url 			= track.permalink_url;
							trackListProper[indexTrackList].trackId 		= track.id;
							trackListProper[indexTrackList].player 			= "soundcloud";
							trackListProper[indexTrackList].title 			= track.title;
							track.artwork_url ? trackListProper[indexTrackList].cover 	= track.artwork_url.replace("large.jpg", "t500x500.jpg") : trackListProper[indexTrackList].cover = "../assets/pictures/default_cover.png";
							trackListProper[indexTrackList].id 				= trackList[indexTrackList].id;
							trackListProper[indexTrackList].curatorPseudo 	= trackList[indexTrackList].curatorPseudo;
							trackListProper[indexTrackList].curatorLink 	= trackList[indexTrackList].curatorLink;
							trackListProper[indexTrackList].curatorPic		= trackList[indexTrackList].curatorPic;
							trackListProper[indexTrackList].occasion1		= trackList[indexTrackList].occasion1;
							trackListProper[indexTrackList].occasion2		= trackList[indexTrackList].occasion2;
							trackListProper[indexTrackList].genre 			= trackList[indexTrackList].genre;
							trackListProper[indexTrackList].treated			= trackList[indexTrackList].treated;
							trackListProper[indexTrackList].playlistId		= trackList[indexTrackList].playlistId;
						}

						if(isFinished(indexTrackList))
						{
							//that.trackList = trackListProper;
							that.setState({trackList: trackListProper});
							console.log("Tracklist after all calls:" + that.state.trackList);
							//callBack();
						} 
					});
				})(urlCopy, indexTrackList);
				ajaxRequestNumber++;
			}
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
	}

    getNextTrack(targetPosition) {
    	var that = this;
    	var targetTrack = targetPosition ? that.state.trackList[(targetPosition - 1)] :  that.state.trackList[that.position];
    	return targetTrack;
    }

    getPrevTrack(targetPosition) {
    	var that = this;
    	var targetTrack = targetPosition ? that.state.trackList[(targetPosition - 1)] : that.state.trackList[that.position - 2];
    	return targetTrack;
    }

    getMatchingTrackInTrackList(track){
    	var that = this;
    	var copyTrackList = that.state.trackList;
    	for(var index = 0, trackListLength = copyTrackList.length ; index < trackListLength ; index++){
    		if (track.trackId === copyTrackList[index].trackId)
    		{
    			return that.state.trackList[index];
    		}
    	}
    }

    //player methods
    play(track, position, comingFromPrevious) {
    	var that = this;
    	console.log("trying to play: " + track);
    	track.play(comingFromPrevious, that);
    }

    stopTrack() {
    	var that = this;
    	console.log('stop track entered');
    	console.log(that.state.currentTrack);
    	that.state.currentTrack.stopTrack();
    }

    playPauseToggle(track) {
    	var that = this;
    	if(that.state.currentTrack == track && that.state.isPlaying)
    	{
    		if(!that.state.isPaused)
    		{
    			track.player == 'soundcloud' ? that.state.currentTrack.PlayerObject.togglePause() : (track.player == 'youtube' ? that.state.currentTrack.PlayerObject.pauseVideo() : console.log('unsupported player'));
    			that.setState({isPaused: true});
    			return 2;
    		}
    		else
    		{
    			if(that.getMatchingTrackInTrackList(track).isInitialized)
    			{
    				track.player == 'soundcloud' ? that.state.currentTrack.PlayerObject.togglePause() : (track.player == 'youtube' ? that.state.currentTrack.PlayerObject.playVideo() : console.log('unsupported player'));
    			}
    			else
    			{
    				that.play(track);
    			}
    			that.setState({isPaused: false});
    			return 3;
    		}
    	}
    	else if(!that.state.isPlaying)
    	{
    		that.play(track);
    		that.setState({isPlaying: true});
    		return 1;
    	}
    	else
    	{
    		console.log('new track asked to be played');
    		that.stopTrack();
    		that.play(track);
    		that.setState({isPlaying: true});
    		return 1;
    	}
    }

    next(targetPosition){
    	var that = this;
    	if(that.state.currentTrack)
    	{
	    	if(that.state.currentTrack.isInitialized)
	    	{
	    		that.stopTrack();
    			that.state.currentTrack.isInitialized = false;
	    	}	
    		//that.cleanProgressionLayer(that.position);
    		if(!that.state.isPaused)
    		{
    			targetPosition ? that.play(that.getNextTrack(targetPosition)) : that.play(that.getNextTrack());
    		}
    		targetPosition ? that.setState({position: targetPosition}) : that.setState({position: position++});
    		return("moved to track n"+that.position)
    	}
    	else
    	{
    		return('No current Track');
    	}
    }

    prev(targetPosition) {
    	var that = this;
    	if(that.state.currentTrack)
    	{
	    	if(that.state.currentTrack.isInitialized)
	    	{
	    		that.stopTrack();
    			that.state.currentTrack.isInitialized = false;
	    	}	
	    	//that.cleanProgressionLayer(that.position);
	    	if(!that.state.isPaused)
	    	{
	    		targetPosition ? that.play(that.getPrevTrack(targetPosition), null, true) : that.play(that.getPrevTrack(), null, true);
	    	}
	    	targetPosition ? that.setState({position: targetPosition}) : that.setState({position: position--});
	    	return("moved to track n"+that.position)
	    }
	    else
	    {
	    	return('No current Track');
	    }
    }

  	render() {
		return(
			<div className="Player">
				<SongBox 
					playlist={this.state.playlistToDisplay}
					songsData={this.state.trackList}
					playMethod={this.playPauseToggle}
					urlCurators="../model/get_curators_json.php" 
					urlGenre="../model/get_genres_json.php" 
					urlOccasion="../model/get_occasions_json.php"
					untreated={this.displayUntreated}
					used={this.displayUsed}
					stored={this.stored}
					currentTrack={this.state.currentTrack}
					pollInterval={1000} />
				<TrackSlider currentTrack={this.state.currentTrack}/>
			</div>
		);
  	}
}