// React and react router
import React from 'react';
import ReactDOM from 'react-dom';

import SongList from './SongList';

import SongFormBacklog from './SongFormBacklog';
import SongFormPlaylist from './SongFormPlaylist';

export default class SongBox extends React.Component {

	constructor(props) {
	    super(props);

	    this.state = {
	    	curatorsData: [],
	    	genreData: [],
	    	occasionData: [],
	    	playlistToPushSongsIn: 0
	    };

	    this.loadCuratorsFromServer 	= this.loadCuratorsFromServer.bind(this);
	    this.handleSongSubmit 			= this.handleSongSubmit.bind(this);
	    this.loadGenreFromServer 		= this.loadGenreFromServer.bind(this);
	    this.loadOccasionFromServer 	= this.loadOccasionFromServer.bind(this);
	    this.loadPlaylistToPushSongsIn 	= this.loadPlaylistToPushSongsIn.bind(this);
		this.moveSongToPlaylist 		= this.moveSongToPlaylist.bind(this);
	    
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

	loadPlaylistToPushSongsIn() {
		$.ajax({
		  url: "../model/get_next_playlist_id.php?display",
		  cache: false,

		  success: function(playlistToPushSongsIn) {
		  	if(playlistToPushSongsIn !=  this.state.playlistToPushSongsIn)
		  	{
		  		console.log("ajax to get playlist to push songs in good: " + playlistToPushSongsIn);
		  		this.setState({playlistToPushSongsIn: playlistToPushSongsIn});
		  	}
		  }.bind(this),

		  error: function(xhr, status, err) {
		    console.error("../model/get_next_playlist_id.php", status, err.toString());
		  }.bind(this)
		});
	}


	componentDidMount() {
		console.log("SongBox Did Mount");
	    this.loadCuratorsFromServer();
	    this.loadPlaylistToPushSongsIn();
	    //this.loadSongsFromServer();
	    this.loadGenreFromServer();
	    this.loadOccasionFromServer();
	   	// setInterval(this.loadSongsFromServer, this.props.pollInterval);
	    this.loadInterval  = setInterval(this.loadCuratorsFromServer, this.props.pollInterval);
	    this.loadInterval2 = setInterval(this.loadPlaylistToPushSongsIn, 10000);
	    //setInterval(this.loadGenreFromServer, this.props.pollInterval);
	    //setInterval(this.loadOccasion1FromServer, this.props.pollInterval);
	    //setInterval(this.loadOccasion2FromServer, this.props.pollInterval);
	}

	componentWillUnmount () {
		console.log("unmounting SongBox");
	    this.loadInterval && clearInterval(this.loadInterval);
	    this.loadInterval = false;
	    this.loadInterval2 && clearInterval(this.loadInterval2);
	    this.loadInterval2 = false;
	}

	handleSongSubmit(){

	}

	moveSongToPlaylist(songId){
		console.log("../model/move_track_to_playlist.php?songId=" + songId + "&playlistId="+ this.state.playlistToPushSongsIn);
		$.ajax({
			url: "../model/move_track_to_playlist.php?songId=" + songId + "&playlistId="+ this.state.playlistToPushSongsIn,
			cache: false,

			success: function(result) {
				console.log('Track successfully move in playlist');
			}.bind(this),

			error: function(xhr, status, err) {
			console.error(this.props.storeUrl, status, err.toString());
			}.bind(this)
		});
	}

  	render() {

    var songFormToDisplay = this.props.playlist? <SongFormPlaylist curatorsData={this.state.curatorsData} playlist={this.props.playlist}/> : (this.props.untreated? <SongFormBacklog curatorsData={this.state.curatorsData} playlist={this.props.playlist}/> : "");

  	return(
		<div className="SongBox">
			{songFormToDisplay}
			<SongList
				playlist={this.props.playlist}
				playMethod={this.props.playMethod}
				currentTrack={this.props.currentTrack}
				songsData={this.props.songsData}
				genreData={this.state.genreData}
				occasionData={this.state.occasionData}
				untreated={this.props.untreated}
				used={this.props.used}
				stored={this.props.stored}
				moveSongToPlaylist = {this.moveSongToPlaylist}
				updateGenreUrl="../model/update_song_genre.php"
				updateCuratorUrl="../model/update_song_curator.php"
				updateOccasion1Url="../model/update_song_occasion1.php"
				updateOccasion2Url="../model/update_song_occasion2.php" />
		</div>
  	);
  }
}