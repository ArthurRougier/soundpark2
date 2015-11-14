//let injectTapEventPlugin = require("react-tap-event-plugin");


// main.js
import React from 'react';
import ReactDOM from 'react-dom';

let injectTapEventPlugin = require("react-tap-event-plugin");
injectTapEventPlugin();

import IconMenu from '../node_modules/material-ui/lib/menus/icon-menu';
import MenuItem from '../node_modules/material-ui/lib/menus/menu-item';
import IconButton from '../node_modules/material-ui/lib/icon-button';
import SelectField from '../node_modules/material-ui/lib/select-field';
import TextField from '../node_modules/material-ui/lib/text-field';


import Track from './player_modules/Track'
import YoutubeTrack from './player_modules/YoutubeTrack'
import SoundcloudTrack from './player_modules/SoundcloudTrack'

SC.initialize({
        client_id: '17f3a8c69cb36c955df82f908611e27e'
      });


class PlayerBo extends React.Component {
	constructor (props) {
		super(props);
		this.state = {
			currentTrack			: {},
			nextTrack 				: null,
			trackListEntry 			: [],
			trackList				: [],
			isPlaying 				: false,
			isPaused 				: false,
			isYoutubeInitialized 	: false,
			whenReady 				: null,
			playersToLoad 			: 0,
			progress 				: null,
			playTimeout 			: null,
			position 				: 1
		};

		var that = this;
		this.loadRawSongsFromServer 		= this.loadRawSongsFromServer.bind(this);
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

	    this.loadRawSongsFromServer();
	    setInterval(this.loadRawSongsFromServer, this.props.pollInterval);
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

	getMasterJson(callBack){
		var that 					= this;
		var trackList 				= this.state.trackListEntry;
		var ajaxRequestNumber 		= 0;
		var ajaxRequestCompleted 	= 0;
		var trackListProper 		= [];

		for(var indexTrackList 	= 0, trackListLength = trackList.length ; indexTrackList < trackListLength ; indexTrackList++)
		{
			var urlCopy 					= trackList[indexTrackList].url;
			console.log(indexTrackList + " url: " + urlCopy);
			
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
					            	trackListProper[indexTrackList].url 			= trackList[indexTrackList];
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

						           	if(isFinished(indexTrackList))
						           	{
						           		that.setState({trackList: trackListProper});
						           		console.log(that.state.trackList);
						           		callBack();
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

						if(isFinished(indexTrackList))
						{
							//that.trackList = trackListProper;
							//callBack();
							that.setState({trackList: trackListProper});
							console.log(that.state.trackList);
						} 
					});
				})(urlCopy, indexTrackList);
				ajaxRequestNumber++;
			}

			/*(function(urlCopy, indexTrackList){
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
			*/
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
    	//console.log('targetPos: '+ targetPosition + 'position player: '+ that.position);
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
    	track.play(comingFromPrevious, that);
    }

    stopTrack() {
    	var that = this;
    	that.state.currentTrack.stopTrack();
    }

    playPauseToggle(track) {
    	var that = this;
    	if(that.isPlaying){
    		if(!that.isPaused)
    		{
    			track.player == 'soundcloud' ? that.state.currentTrack.PlayerObject.togglePause() : (track.player == 'youtube' ? that.state.currentTrack.PlayerObject.pauseVideo() : console.log('unsupported player'));
    			that.isPaused = true;
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
    			that.setState({isPaused, false});
    		}
    	}
    	else
    	{
    		that.play(track);
    		that.setState({isPlaying: true});
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
					songsData={this.state.trackList}
					playMethod={this.play}
					urlCurators="../model/get_curators_json.php" 
					urlGenre="../model/get_genres_json.php" 
					urlOccasion="../model/get_occasions_json.php" 
					pollInterval={10000} />
			</div>
		);
  	}


}


class SongBox extends React.Component {

	constructor(props) {
	    super(props);

	    this.state = {
	    	curatorsData: [],
	    	genreData: [],
	    	occasionData: []
	    };

	    this.loadCuratorsFromServer = this.loadCuratorsFromServer.bind(this);
	    this.handleSongSubmit = this.handleSongSubmit.bind(this);
	    this.loadGenreFromServer = this.loadGenreFromServer.bind(this);
	    this.loadOccasionFromServer = this.loadOccasionFromServer.bind(this);
	  }

	loadCuratorsFromServer() {
	    $.ajax({
	      url: this.props.urlCurators,
	      dataType: 'json',
	      cache: false,
	      success: function(curatorsData) {
	        this.setState({curatorsData: curatorsData});
	      }.bind(this),
	      error: function(xhr, status, err) {
	        console.error(this.props.urlCurators, status, err.toString());
	      }.bind(this)
	    });
	}

	loadGenreFromServer() {
	    $.ajax({
	      url: this.props.urlGenre,
	      dataType: 'json',
	      cache: false,
	      success: function(genreData) {
	        this.setState({genreData: genreData});
	      }.bind(this),
	      error: function(xhr, status, err) {
	        console.error(this.props.urlGenre, status, err.toString());
	      }.bind(this)
	    });
	}

	loadOccasionFromServer() {
	    $.ajax({
	      url: this.props.urlOccasion,
	      dataType: 'json',
	      cache: false,
	      success: function(occasionData) {
	        this.setState({occasionData: occasionData});
	      }.bind(this),
	      error: function(xhr, status, err) {
	        console.error(this.props.urlOccasion, status, err.toString());
	      }.bind(this)
	    });
	}

	componentDidMount() {
	    this.loadCuratorsFromServer();
	    //this.loadSongsFromServer();
	    this.loadGenreFromServer();
	    this.loadOccasionFromServer();
	   // setInterval(this.loadSongsFromServer, this.props.pollInterval);
	    setInterval(this.loadCuratorsFromServer, this.props.pollInterval);
	    //setInterval(this.loadGenreFromServer, this.props.pollInterval);
	    //setInterval(this.loadOccasion1FromServer, this.props.pollInterval);
	    //setInterval(this.loadOccasion2FromServer, this.props.pollInterval);
	}

	handleSongSubmit(){

	}

  	render() {
  	return(
		<div className="SongBox">
			<SongList
				playMethod={this.props.playMethod}
				songsData={this.props.songsData}
				genreData={this.state.genreData}
				occasionData={this.state.occasionData}
				updateGenreUrl="../model/update_song_genre.php"
				updateCuratorUrl="../model/update_song_curator.php"
				updateOccasion1Url="../model/update_song_occasion1.php"
				updateOccasion2Url="../model/update_song_occasion2.php" />
			<SongForm curatorsData={this.state.curatorsData} />
		</div>
  	);
  }
}


class SongList extends React.Component {
  render() {

  	var genreData 			= this.props.genreData;
  	var occasionData 		= this.props.occasionData;
  	var playMethod			= this.props.playMethod;
  	var updateGenreUrl		= this.props.updateGenreUrl;
  	var updateCuratorUrl	= this.props.updateCuratorUrl;
  	var updateOccasion1Url	= this.props.updateOccasion1Url;
  	var updateOccasion2Url	= this.props.updateOccasion2Url;

	var songNodes = this.props.songsData.map(function(song, index){
		return(
    		<Song 
    			updateGenreUrl={updateGenreUrl} 
    			updateCuratorUrl={updateCuratorUrl}
    			updateOccasion1Url={updateOccasion1Url}
    			updateOccasion2Url={updateOccasion2Url}
    			playMethod={playMethod} 
    			track={song} 
    			genreData={genreData} 
    			occasionData={occasionData} 
    			key={song.id}  />
		);
	});
	return(
		<ol className="songList">
			{songNodes}
		</ol>
	);
  }
}

class Song extends React.Component {
	constructor(props) {
	    super(props);

	    this.state = {
	    	titleValue: this.props.trackTitle,
	    	curatorValue: 0,
	    	genreValue: this.props.track.genre,
	    	occasion1Value: this.props.track.occasion1,
	    	occasion2Value: this.props.track.occasion2
	    };

	    this.handleGenreSelectValue = this.handleGenreSelectValue.bind(this);
	    this.handleOccasion1SelectValue = this.handleOccasion1SelectValue.bind(this);
	    this.handleOccasion2SelectValue = this.handleOccasion2SelectValue.bind(this);
	    this.handleTitleSelectValue = this.handleTitleSelectValue.bind(this);

	  }



	handleGenreSelectValue(event) {
		console.log(this.props.updateGenreUrl + "?songId=" + this.props.track.id + "&songGenreId=" + event.target.value);
		
		$.ajax({
		  url: this.props.updateGenreUrl + "?songId=" + this.props.track.id + "&songGenreId=" + event.target.value,
		  cache: false,
		  success: function(result) {
		  	console.log('genre successfully changed');
		  	this.setState({ genreValue: event.target.value });
		  }.bind(this),
		  error: function(xhr, status, err) {
		    console.error(this.props.updateGenreUrl, status, err.toString());
		  }.bind(this)
		});
	}

	handleOccasion1SelectValue(event) {
		console.log(this.props.updateOccasion1Url + "?songId=" + this.props.track.id + "&songOccasion1Id=" + event.target.value);
		
		$.ajax({
		  url: this.props.updateOccasion1Url + "?songId=" + this.props.track.id + "&songOccasion1Id=" + event.target.value,
		  cache: false,
		  success: function(result) {
		  	console.log('Occasion1 successfully changed');
		  	this.setState({ occasion1Value: event.target.value });
		  }.bind(this),
		  error: function(xhr, status, err) {
		    console.error(this.props.updateOccasion1Url, status, err.toString());
		  }.bind(this)
		});
	}

	handleOccasion2SelectValue(event) {
		console.log(this.props.updateOccasion2Url + "?songId=" + this.props.track.id + "&songOccasion2Id=" + event.target.value);
				
		$.ajax({
		  url: this.props.updateOccasion2Url + "?songId=" + this.props.track.id + "&songOccasion2Id=" + event.target.value,
		  cache: false,
		  success: function(result) {
		  	console.log('Occasion2 successfully changed');
		  	this.setState({ occasion2Value: event.target.value });
		  }.bind(this),
		  error: function(xhr, status, err) {
		    console.error(this.props.updateOccasion2Url, status, err.toString());
		  }.bind(this)
		});
	}

	handleTitleSelectValue(event) {
		this.setState({ titleValue: event.target.value });
		console.log("change db title to" + event.target.value);
	}

	handlePlayClick(e) {
		//this.props.playMethod(this.props.track);
		SC.stream('/tracks/'+this.props.track.trackId, function(track){
		  track.play();
		  console.log(track);
		});
		//console.log(this.props);
	}

	render() {

		// write function to find pre-selected one

		return(
			<li className= "song" id="li0">
				<IconButton 
					iconClassName="material-icons songIcons" 
					iconStyle={{color: 'grey'}}
					onClick={this.handlePlayClick.bind(this)}
					>play_arrow</IconButton>
	        	<div className="boFieldParent">
		        	<TextField
		        		className="song_title boField"
		        		floatingLabelText="Song Title"
		        	  	hintText="Disabled Hint Text"
		        	  	disabled={true}
		        	  	onBlur={this.handleTitleSelectValue}
		        	  	defaultValue={this.props.track.title}
		        	  	style={{ width: '170px', marginLeft: '20px', fontSize: '12px' }} />
			        <TextField
		        		className="curatorPseudo boField"
		        		floatingLabelText="Curator"
		        	 	disabled={true}
		        	  	defaultValue={this.props.track.curatorPseudo}
		        	  	style={{ width: '120px', fontSize: '12px' }} />
		        	<SelectField
		        	  className={"boField"}
		        	  floatingLabelText="Genre"
		        	  value={this.state.genreValue}
		        	  onChange={this.handleGenreSelectValue}
		        	  menuItems={this.props.genreData}
		        	  style={{ width: "140px", fontSize: "12px", marginRight: '30px' }} />
		        	<SelectField
		        	  className="boField"
		        	  floatingLabelText="Occasion1"
		        	  value={this.state.occasion1Value}
		        	  onChange={this.handleOccasion1SelectValue}
		        	  menuItems={this.props.occasionData}
		        	  style={{ width: "140px", fontSize: "12px", marginRight: '30px' }} />
		        	<SelectField
		        	  className="boField"
		        	  floatingLabelText="Occasion2"
		        	  value={this.state.occasion2Value}
		        	  onChange={this.handleOccasion2SelectValue}
		        	  menuItems={this.props.occasionData}
		        	  style={{ width: "140px", fontSize: "12px", marginRight: '30px' }} />
		        </div>		
	        	<SongMenu key={this.props.key} />
	        </li>
		);
	}
}

class SongMenu extends React.Component {


	constructor(props) {
	    super(props);
	    this.handleMenuChange = this.handleMenuChange.bind(this);

	  }
  	
  	handleMenuChange(event, item) {

		console.log(item.props);
	}

  render() {
    return (
        <IconMenu openDirection="bottom-right" 
        	iconButtonElement={
        	<IconButton iconClassName="material-icons songIcons" tooltipPosition="bottom-center"
        	 tooltip="actions">more_vert</IconButton>
        	}
        	onItemTouchTap={this.handleMenuChange}
    	>
          <MenuItem primaryText="Link" index={1} />
          <MenuItem primaryText="Store" index={2} />
          <MenuItem primaryText="Move to next playlist" index={3}/>
          <MenuItem primaryText="Move to previous playlist" index={4}/>
        </IconMenu>

    );
  }
}

class SongForm extends React.Component {
	
	constructor(props) {
	    super(props);
	    this.state = {};
	    this.handleSubmit = this.handleSubmit.bind(this);
	  }

	handleSubmit(e) {
	    e.preventDefault();
	    var url = this.refs.author.value.trim();
	    var curator = this.refs.text.value.trim();
	    if (!url || !curator) {
	      return;
	    }
	    this.props.onCommentSubmit({url: url, curator: curator});
	    this.refs.author.value = '';
	    this.refs.text.value = '';
	    return;
	}

	render() {

		var curatorNodes = this.props.curatorsData.map(function(curator, index){
			return(
	    		<option value={curator.curatorId}>{curator.pseudo}</option>
			);
		});

		return (
		    <form className="commentForm" onSubmit={this.handleSubmit}>
		        <TextField
	        		className="urlNewSong"
	        		type="url"
	        		floatingLabelText="Song URL"
	        	  	defaultValue={this.props.curator}
	        	  	ref="url" />
		        <select type="text" placeholder="" ref="curator">
		        	{curatorNodes}
		        </select>
		        <input type="submit" value="Post" />
			</form>
		);
	}
}


ReactDOM.render(
	<PlayerBo urlTrackListUrl={"../model/get_all_songs_json.php" } pollInterval={2000} />,
  	document.getElementById('react')
);


