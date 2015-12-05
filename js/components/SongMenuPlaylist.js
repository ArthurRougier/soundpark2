// React and react router
import React from 'react';
import ReactDOM from 'react-dom';

import IconMenu from '../../node_modules/material-ui/lib/menus/icon-menu';
import MenuItem from '../../node_modules/material-ui/lib/menus/menu-item';
import IconButton from '../../node_modules/material-ui/lib/icon-button';

let injectTapEventPlugin = require("react-tap-event-plugin");
injectTapEventPlugin();

export default class SongMenuPlaylist extends React.Component {

	constructor(props) {
	    super(props);
	    this.handleMenuChange = this.handleMenuChange.bind(this);
	  }
  	
  	handleMenuChange(event, item) {
  		switch(item.props.index) {
  		    case 1:
				var win = window.open(this.props.track.url, '_blank');
				win.focus();
  		        break;
  		    case 2:
  		    	//console.log('url ajax call:' + this.props.storeUrl + "?songId=" + this.props.track.id);
  		    	$.ajax({
					url: this.props.storeUrl + "?songId=" + this.props.track.id,
					cache: false,
					success: function(result) {
						console.log('Track successfully stored');
					}.bind(this),
					error: function(xhr, status, err) {
					console.error(this.props.storeUrl, status, err.toString());
					}.bind(this)
    			});
  		        break;
  		    case 3:
  		    	//console.log('url ajax call:' + this.props.moveNextPlaylistUrl + "?songId=" + this.props.track.id);
  		    	$.ajax({
					url: this.props.moveNextPlaylistUrl + "?songId=" + this.props.track.id,
					cache: false,
					success: function(result) {
						console.log('Track successfully moved');
					}.bind(this),
					error: function(xhr, status, err) {
					console.error(this.props.moveNextPlaylistUrl, status, err.toString());
					}.bind(this)
    			});
  		        break;
  		    case 4:
  		    	//console.log('url ajax call:' + this.props.movePreviousPlaylistUrl + "?songId=" + this.props.track.id);
  		    	$.ajax({
					url: this.props.movePreviousPlaylistUrl + "?songId=" + this.props.track.id,
					cache: false,
					success: function(result) {
						console.log('Track successfully moved');
					}.bind(this),
					error: function(xhr, status, err) {
					console.error(this.props.movePreviousPlaylistUrl, status, err.toString());
					}.bind(this)
    			});
  		        break;       
  		    default:
  		    	console.log('what??');
  		}
	}

  render() {
    var popOverOpeningDirection = (this.props.position > (this.props.siblingsNumber - 3) && this.props.position > 3) ? "top-right" : "bottom-right";
    //console.log("popOverOpeningDirection: " +popOverOpeningDirection);
    return (
        <IconMenu openDirection={popOverOpeningDirection}
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