export default class UsedTracks extends React.Component {
	render() {
	    return (
	      <PlayerBo urlTrackListUrl={"../model/get_all_songs_json.php" } used={true} pollInterval={30000} />
	    )
	  }
}