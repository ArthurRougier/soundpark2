// React and react router
import React from 'react';
import ReactDOM from 'react-dom';

import IconMenu from '../../node_modules/material-ui/lib/menus/icon-menu';
import MenuItem from '../../node_modules/material-ui/lib/menus/menu-item';
import IconButton from '../../node_modules/material-ui/lib/icon-button';

let injectTapEventPlugin = require("react-tap-event-plugin");
injectTapEventPlugin();

export default class SongMenuNewSongs extends React.Component {

	constructor(props) {
	    super(props);
	    this.handleMenuChange = this.handleMenuChange.bind(this);
	  }
  	
  	handleMenuChange(event, item) {
  		switch(item.props.index) {
  		    case 1:
				//plug in method to do so :)
				this.props.moveSongToPlaylist(this.props.track.id);
  		        break;

  		    case 2:
  		    	//console.log('url ajax call:' + this.props.storeUrl + "?songId=" + this.props.track.id);
  		    	var win = window.open(this.props.track.url, '_blank');
				win.focus();
  		        break;

  		    case 3:
  		    	//to do
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
          <MenuItem primaryText="Add" index={1} />
          <MenuItem primaryText="Link" index={2} />
          <MenuItem primaryText="Store" index={3}/>
        </IconMenu>

    );
  }
}