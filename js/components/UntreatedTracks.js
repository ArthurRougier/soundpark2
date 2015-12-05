export default class UntreatedTracks extends React.Component {
	render() {
	    return (
	      <PlayerBo urlTrackListUrl={"../model/get_all_songs_json.php" } untreated={true} pollInterval={30000} />
	    )
	  }
}