export default class CurrentPlaylist extends React.Component {
	render() {
	    return (
	      <PlayerBo urlTrackListUrl={"../model/get_all_songs_json.php" } playlistGetterUrl="../model/get_current_playlist_id.php?display=TRUE" pollInterval={30000} />
	    )
	  }
}