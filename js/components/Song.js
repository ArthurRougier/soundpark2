// React and react router
import React from 'react';
import ReactDOM from 'react-dom';

import SongMenuPlaylist from './SongMenuPlaylist';
import SongMenuNewSongs from './SongMenuNewSongs';

import IconButton from '../../node_modules/material-ui/lib/icon-button';
import SelectField from '../../node_modules/material-ui/lib/select-field';
import TextField from '../../node_modules/material-ui/lib/text-field';
import CircularProgress from '../../node_modules/material-ui/lib/circular-progress';

let injectTapEventPlugin = require("react-tap-event-plugin");
injectTapEventPlugin();

export default class Song extends React.Component {
	constructor(props) {
	    super(props);

	    this.state = {
	    	titleValue: this.props.trackTitle,
	    	curatorValue: 0,
	    	genreValue: this.props.track.genre,
	    	occasion1Value: this.props.track.occasion1,
	    	occasion2Value: this.props.track.occasion2,
	    	playLaunched: false,
	    	isPlaying: false,
	    	isPaused: false
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
		switch(this.props.playMethod(this.props.track)){
			case 1:
				//console.log('1');
				this.setState({playLaunched: true});
				break;
			case 2:
				//console.log('2');
				this.setState({isPaused: true});
				break;
			case 3:
				//console.log('3');
				this.setState({isPlaying: true, isPaused: false});
				break;
		}
		//console.log(this.props);
	}

	componentWillReceiveProps(nextProps) {
	    if(JSON.stringify(nextProps.currentTrack) != JSON.stringify(this.props.track) && Object.keys(this.props.currentTrack).length != 0 && this.state.isPlaying){
	    	console.log("This track: ");
	    	console.log(this.props.track);
	    	console.log("Next track: ");
	    	console.log(nextProps.currentTrack);
	    	console.log(JSON.stringify(nextProps.currentTrack) != JSON.stringify(this.props.track));
	      	this.setState({isPlaying: false, playLaunched: false});
	    }
	    else if(this.state.playLaunched &&  JSON.stringify(nextProps.currentTrack) == JSON.stringify(this.props.track))
	    {
	    	this.setState({isPlaying: true});
	    }
  	}

	render() {

		var iconText = "play_arrow";
		var iconStyle = {color: 'grey'};
		var songIcon = <IconButton 
							iconClassName="material-icons songIcons" 
							iconStyle={iconStyle}
							onClick={this.handlePlayClick.bind(this)}
							>{iconText}</IconButton>;

		if(this.state.isPlaying == 1 && !this.state.isPaused)
		{
			iconText = "pause_circle_filled";
			iconStyle = {color: '#32B7A2'};
			var songIcon = <IconButton 
								iconClassName="material-icons songIcons" 
								iconStyle={iconStyle}
								onClick={this.handlePlayClick.bind(this)}
								>{iconText}</IconButton>;
		}
		else if(this.state.playLaunched && !this.state.isPlaying)
		{
			var songIcon = <CircularProgress mode="indeterminate" size={0.3} style={{marginLeft: '-6px', paddingRight: '6px'}} />

		}
		else
		{
			iconText = "play_arrow";
			iconStyle = {color: 'grey'};
			var songIcon = <IconButton 
								iconClassName="material-icons songIcons" 
								iconStyle={iconStyle}
								onClick={this.handlePlayClick.bind(this)}
								>{iconText}</IconButton>;
		}
		
		if(this.props.untreated)
		{
			var songMenuToDisplay = 
				<SongMenuNewSongs
	        		key={this.props.key} 
	        		track={this.props.track}
	        		untreated={this.props.untreated}
					used={this.props.used}
					stored={this.props.stored}
					siblingsNumber={this.props.siblingsNumber}
					position={this.props.position}
					moveSongToPlaylist = {this.props.moveSongToPlaylist}
	        		storeUrl="../model/store_track_from_playlist.php"
	        		moveNextPlaylistUrl="../model/move_track_to_next_playlist.php"
	        		movePreviousPlaylistUrl="../model/move_track_to_previous_playlist.php" />;
		}
		else if(this.props.used)
		{
			
		}
		else if(this.props.stored)
		{

		}
		else
		{
			var songMenuToDisplay = 
				<SongMenuPlaylist 
	        		key={this.props.key} 
	        		track={this.props.track}
	        		untreated={this.props.untreated}
					used={this.props.used}
					stored={this.props.stored}
					siblingsNumber={this.props.siblingsNumber}
					position={this.props.position}
	        		storeUrl="../model/store_track_from_playlist.php"
	        		moveNextPlaylistUrl="../model/move_track_to_next_playlist.php"
	        		movePreviousPlaylistUrl="../model/move_track_to_previous_playlist.php" />;
		}

		return(
			<li className= "song" id="li0">
				{songIcon}
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
		        {songMenuToDisplay}
	        </li>
		);
	}
}