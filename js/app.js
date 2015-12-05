// React and react router
import React from 'react';
import ReactDOM from 'react-dom';
import { Router, Route, IndexRoute, Link, IndexLink } from 'react-router'


import PlayerBo from './components/PlayerBo';

SC.initialize({
        client_id: '17f3a8c69cb36c955df82f908611e27e'
      });


var domain =  window.location.protocol + "//" + window.location.host;

class App extends React.Component {

	render() {
	    return (
	    <div id="app">
			<header>
				<h1>Soundpark.fm <span id="BOTitle">Bakauphisse</span></h1>
				<ul>
				  <li><Link activeClassName="activeBoMain" to="PlaylistManager">Playlists</Link></li>
				  <li><Link activeClassName="activeBoMain" to="SongsBacklogManager">Songs</Link></li>
				  <li><a href={domain+"/view/admin_curator.php"}>Curators</a></li>
				  <li><a href={domain+"/view/admin_genre.php"}>Songs</a></li>
				</ul>
			</header>
			{this.props.children}
     	 </div>
	    )
	  }
}

class PlaylistManager extends React.Component {
	render() {
	    return (
    	<div id="body">
			<aside>
				<ul>
				  <li><IndexLink activeClassName="activeBoSecondary" to="/PlaylistManager">Current</IndexLink></li>
				  <li><Link activeClassName="activeBoSecondary" to="/n+1">Next one</Link></li>
				</ul>
			</aside>
			<div id="container">
				{this.props.children}
			</div>
		</div>
	    )
	  }
}

class SongsBacklogManager extends React.Component {
	render() {
	    return (
	    	<div id="body">
				<aside>
					<ul>
					  <li><IndexLink activeClassName="activeBoSecondary" to="/SongsBacklogManager">New</IndexLink></li>
			          <li><Link activeClassName="activeBoSecondary" to="/used">Used</Link></li>
			          <li><Link activeClassName="activeBoSecondary" to="/storage">Storage</Link></li>
					</ul>
				</aside>
				<div id="container">
					{this.props.children}
				</div>
			</div>
	    )
	  }
}

class CurrentPlaylist extends React.Component {
	render() {
	    return (
	      <PlayerBo urlTrackListUrl={"../model/get_all_songs_json_playlists.php" } playlistGetterUrl="../model/get_current_playlist_id.php?display=TRUE" pollInterval={30000} />
	    )
	  }
}

class NextPlaylist extends React.Component {
	render() {
	    return (
	      <PlayerBo urlTrackListUrl={"../model/get_all_songs_json_playlists.php" } playlistGetterUrl="../model/get_next_playlist_id.php?display=TRUE" pollInterval={30000} />
	    )
	  }
}

class UntreatedTracks extends React.Component {
	render() {
	    return (
	      <PlayerBo urlTrackListUrl={"../model/../model/get_all_songs_json_untreated.php" } untreated={true} pollInterval={1000} />
	    )
	  }
}

class UsedTracks extends React.Component {
	render() {
	    return (
	      <PlayerBo urlTrackListUrl={"../model/get_all_songs_json_used.php" } used={true} pollInterval={1000} />
	    )
	  }
}

class StoredTracks extends React.Component {
	render() {
	    return (
	      <PlayerBo urlTrackListUrl={"../model/get_all_songs_json_stored.php" } stored={true} pollInterval={1000} />
	    )
	  }
}


ReactDOM.render(
	<Router>
	    <Route path="/" component={App}>
	     	<Route path="PlaylistManager" component={PlaylistManager}>
	     		<IndexRoute component={CurrentPlaylist}/>
	     		<Route path="/n+1" component={NextPlaylist}/>
      		</Route>
      		<Route path="SongsBacklogManager" component={SongsBacklogManager}>
      			<IndexRoute component={UntreatedTracks}/>
      			<Route path="/used" component={UsedTracks}/>
      			<Route path="/storage" component={StoredTracks}/>
      		</Route>
	    </Route>
  	</Router>,
  	document.getElementById('react')
);




