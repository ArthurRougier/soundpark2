<?php
include_once('connect_sql.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$req = $bdd->query('SELECT trackId 
					  FROM song
					  WHERE song.permalink_url = ""');



$trackIds = array();
$i = 0;

while($result = $req->fetch())
{
	$trackIds[$i] = $result[0];
	$i++;
}

?>
<script src="http://connect.soundcloud.com/sdk.js"></script>
<script type="text/javascript" src="../assets/jquery.js"></script>
<script>

SC.initialize({

    client_id: "17f3a8c69cb36c955df82f908611e27e"
});

var trackIds = <?php echo(json_encode($trackIds)); ?>;

for(var indexTrackList 	= 0, trackListLength = trackIds.length ; indexTrackList < trackListLength ; indexTrackList++)
{
	trackIdCopy = trackIds[indexTrackList];

	(function(indexTrackList, trackIdCopy){
		//console.log('trackIdCopy: '+ trackIdCopy);
		SC.get('/tracks/'+trackIdCopy,  function(track)
		{
			console.log(track.permalink_url);
			console.log(encodeURIComponent(track.permalink_url));
			if(track.permalink_url)
			{
				$.ajax({
				  url: "../model/update_song_permalinkUrl.php?trackId="+trackIdCopy+"&url="+encodeURIComponent(track.permalink_url),
				  cache: false,
				  success: function(trackListEntry) {
				    console.log('youhou');
				  }.bind(this),

				  error: function(xhr, status, err) {
				    console.error(this.props.urlTrackListUrl, status, err.toString());
				  }.bind(this)
				});
			}
		});
	})(indexTrackList, trackIdCopy);

}



console.log(trackIds);

</script>
