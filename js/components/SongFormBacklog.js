// React
import React from 'react';
import ReactDOM from 'react-dom';

import TextField from '../../node_modules/material-ui/lib/text-field';

let injectTapEventPlugin = require("react-tap-event-plugin");
injectTapEventPlugin();

export default class SongFormBacklog extends React.Component {
	
	constructor(props) {
	    super(props);
	    this.state = {
	    	url: "",
	    	curatorId: 1,
	    	playlistToPushSongsIn: 0
	    };
	    this.handleSubmit 				= this.handleSubmit.bind(this);
	    this.handleUrlChange 			= this.handleUrlChange.bind(this);
	    this.handleCuratorChange 		= this.handleCuratorChange.bind(this);
	}


	handleUrlChange(e) {
	  this.setState({url: e.target.value});
	}

	handleCuratorChange(e) {
	  this.setState({curatorId: e.target.value});
	}

	handleSubmit(e) {
	    e.preventDefault();
	    var url 		= this.state.url.trim();
	    var curatorId 	= this.state.curatorId;
	    var that 		= this;
	    //console.log(url + "by curator: " + curatorId);
	    if (!url || !curatorId) {
	    	console.log('coucou');
	      return;
	    }
	    //this.props.onCommentSubmit({url: url, curator: curator});
	    urlValidityTester(url,function(result){
	    	//console.log("launching ajax call to: ../model/store_new_track.php?url="+url+"&curatorId="+curatorId+"&treated=1&playlistId="+playlistId);
	    	if(result)
	    	{
	    		that.setState({url: ''});
	    		var urlEncoded= encodeURIComponent(url);
		    	$.ajax({
					url: "../model/store_new_track.php?url="+urlEncoded+"&curatorId="+curatorId,
					cache: false,
					success: function(resultAjax) {
						console.log('Track successfully stored in playlist '+playlistId);
					}.bind(this),
					error: function(xhr, status, err) {
					console.error("../model/store_new_track.php?url=", status, err.toString());
					}.bind(this)
				});
	    	}
	    });
	    return;
	}

	render() {

		var curatorNodes = this.props.curatorsData.map(function(curator, index){
			return(
	    		<option value={curator.curatorId}>{curator.pseudo}</option>
			);
		});

		return (
		    <form className="postNewSong" onSubmit={this.handleSubmit}>
		    	<h2>Add a new tune to the backlog:</h2>
		        <TextField
	        		className="urlNewSong"
	        		type="url"
	        		floatingLabelText="Song URL"
	        	  	defaultValue={this.props.curator}
	        	  	ref="url"
	        	  	value={this.state.url}
	        	  	style={{ width: '350px', marginRight: '20px'}}
	        	  	onChange={this.handleUrlChange} />
		        <select type="text" placeholder="" ref="curatorId" value={this.state.curatorId} onChange={this.handleCuratorChange}>
		        	{curatorNodes}
		        </select>
		        <input type="submit" value="Post" />
			</form>
		);
	}
}