export default class StoredTracks extends React.Component {
	render() {
	    return (
	      <PlayerBo urlTrackListUrl={"../model/get_all_songs_json.php" } stored={true} pollInterval={30000} />
	    )
	  }
}