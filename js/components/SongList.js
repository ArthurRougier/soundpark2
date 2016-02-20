// React 
import React from 'react';
import ReactDOM from 'react-dom';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';

import Song from './Song';

export default class SongList extends React.Component {
  render() {

  	var genreData 				= this.props.genreData;
  	var occasionData 			= this.props.occasionData;
  	var playMethod				= this.props.playMethod;
  	var updateGenreUrl			= this.props.updateGenreUrl;
  	var updateCuratorUrl		= this.props.updateCuratorUrl;
  	var updateOccasion1Url		= this.props.updateOccasion1Url;
  	var updateOccasion2Url		= this.props.updateOccasion2Url;
  	var used 					= this.props.used;
  	var untreated 				= this.props.untreated;
  	var stored 					= this.props.stored;
  	var playlist 				= this.props.playlist;
  	var siblingsNumberUsed		= 0;
  	var siblingsNumberUntreated	= 0;
  	var siblingsNumberStored	= 0;
  	var siblingsNumberPlaylist	= 0;
  	var position 				= 1;

  	// We count here the number of siblings for each type of song so later we can correclty place the menu according their position
  	this.props.songsData.forEach(function(song) {if(!parseInt(song.treated)){siblingsNumberUntreated++}});
  	this.props.songsData.forEach(function(song) {if(parseInt(song.treated) && parseInt(song.playlistId)){siblingsNumberUsed++}});
  	this.props.songsData.forEach(function(song) {if(parseInt(song.treated) && !parseInt(song.playlistId)){siblingsNumberStored++}});
  	this.props.songsData.forEach(function(song) {if(parseInt(song.treated) && song.playlistId === playlist){siblingsNumberPlaylist++}});

  	var songRows = [];
    this.props.songsData.forEach(function(song) {
        
    	if(untreated)
    	{
    		if(parseInt(song.treated))
    		{
    			return;
    		}
    		else
    		{
    	        songRows.push(
    	        	<Song 
	    				updateGenreUrl={updateGenreUrl}
	    				currentTrack={this.props.currentTrack} 
	    				updateCuratorUrl={updateCuratorUrl}
	    				updateOccasion1Url={updateOccasion1Url}
	    				updateOccasion2Url={updateOccasion2Url}
	    				playMethod={playMethod} 
	    				track={song} 
	    				genreData={genreData} 
	    				occasionData={occasionData}
	    				untreated={this.props.untreated}
						used={this.props.used}
						stored={this.props.stored}
	    				moveSongToPlaylist = {this.props.moveSongToPlaylist}
	    				siblingsNumber={siblingsNumberUntreated}
	    				position={position}
	    				key={song.id}  />
    	        	);
    	        position++;
    		}
    	}

        else if (playlist) 
        {
        	//console.log('untreated well entered, playlist state:'+ playlist);
            if(song.playlistId !== playlist){
                    	return;
            } 
            else
            {
    	        songRows.push(
    	        	<Song 
	    				updateGenreUrl={updateGenreUrl}
	    				currentTrack={this.props.currentTrack} 
	    				updateCuratorUrl={updateCuratorUrl}
	    				updateOccasion1Url={updateOccasion1Url}
	    				updateOccasion2Url={updateOccasion2Url}
	    				playMethod={playMethod} 
	    				track={song} 
	    				genreData={genreData} 
	    				occasionData={occasionData}
	    				untreated={this.props.untreated}
						used={this.props.used}
						stored={this.props.stored}
	    				moveSongToPlaylist = {this.props.moveSongToPlaylist}
	    				siblingsNumber={siblingsNumberPlaylist}
	    				position={position}
	    				key={song.id}  />
    	        	);
    	        position++;
            }
        }

        else if(used)
        {
        	if(!parseInt(song.treated))
    		{
    			return;
    		}
    		else if (!parseInt(song.playlistId))
    		{
    			return;
    		}
    		else
    		{
		        songRows.push(
		        	<Song 
	    				updateGenreUrl={updateGenreUrl}
	    				currentTrack={this.props.currentTrack} 
	    				updateCuratorUrl={updateCuratorUrl}
	    				updateOccasion1Url={updateOccasion1Url}
	    				updateOccasion2Url={updateOccasion2Url}
	    				playMethod={playMethod} 
	    				track={song} 
	    				genreData={genreData} 
	    				occasionData={occasionData}
	    				untreated={this.props.untreated}
						used={this.props.used}
						stored={this.props.stored}
	    				moveSongToPlaylist = {this.props.moveSongToPlaylist}
	    				siblingsNumber={siblingsNumberUsed} 
	    				position={position}
	    				key={song.id}  />
		        	);	
		        position++;
    		}
        } 

        else if(stored)
    	{ 
	    	if(!parseInt(song.treated))
			{
				return;
			}
			else if (parseInt(song.playlistId)) {
				return;
			}
			else
			{
				songRows.push(
		        	<Song 
	    				updateGenreUrl={updateGenreUrl}
	    				currentTrack={this.props.currentTrack} 
	    				updateCuratorUrl={updateCuratorUrl}
	    				updateOccasion1Url={updateOccasion1Url}
	    				updateOccasion2Url={updateOccasion2Url}
	    				playMethod={playMethod} 
	    				track={song} 
	    				genreData={genreData} 
	    				occasionData={occasionData} 
	    				untreated={this.props.untreated}
						used={this.props.used}
						stored={this.props.stored}
						moveSongToPlaylist = {this.props.moveSongToPlaylist}
						siblingsNumber={siblingsNumberStored}
						position={position}
	    				key={song.id}  />
		        	);
				position++;
			}
		}

    }.bind(this));

	var headline = playlist? <h2>Playlist #{playlist} songs: </h2> : (untreated? <h2>New tunes: </h2> : (used? <h2>Already used tunes: </h2> : <h2>Stored: </h2>));

	return(
		<div>
			{headline}
			<ol className="songList">
				<ReactCSSTransitionGroup transitionName="example" transitionEnterTimeout={500} transitionLeaveTimeout={300}>
					{songRows}
				</ReactCSSTransitionGroup>
			</ol>
			<div id="heightSecureBlock"></div>
		</div>
	);
  }
}