
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
  <head>
    <title>Soundpark</title>
    <link href="/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <script type="text/javascript" src="../assets/jquery-1.3.2.min.js"></script>
    <script src="http://connect.soundcloud.com/sdk.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
 </head>
 
	<body>
		<header>
		</header>
		<div id="songInfo">
		</div>
		<div id="addLink">
		</div>
		<script type="text/javascript"> 
			SC.initialize({

			    client_id: "17f3a8c69cb36c955df82f908611e27e"
			});

			var songUrl = "<?php echo($_POST['song_url'])?>";
			var playlist = "<?php echo($_POST['playlist'])?>";
			var idCurator = "<?php echo($_POST['idCurator'])?>";
			var streamable, trackId, trackArtWork, trackArtist, trackTitle, trackGenre;


			SC.get('/resolve', { url: songUrl }, function(track)
						{
							streamable = track.streamable;
							trackId = track.id;
							duration = track.duration;
							permalinkUrl = track.permalink_url
							var str = track.artwork_url;
							if(str)
							{
								trackArtWork = str.replace("large.jpg", "t500x500.jpg");
							}
							else
							{
								trackArtWork = "../assets/pictures/default_cover.png";
							}

							str = track.title;
							var res = str.split("-");
							trackArtist = res[0];
							trackTitle =  res[1];
							if(track.genre)
							{
								trackGenre = track.genre;	
							}
							else
							{
								trackGenre = "";
							}
							
							if(streamable && trackGenre)
							{
								var songInfo = document.getElementById('songInfo');
								songInfo.innerHTML = "<p id=\"artist\"> Artist = " + trackArtist +"</p><p id=\"title\"> Title = " + trackTitle +"</p><p id=\"genre\"> Genre = " + trackGenre +"</p><img src=\""+trackArtWork+"\"id=\"artWork\">" ;
								var addLink = document.getElementById('addLink');
								addLink.innerHTML = "<a href=\"add_track.php?title="+trackTitle+"&artist="+trackArtist+"&genre="+trackGenre+"&trackId="+trackId+"&trackArtWork="+trackArtWork+"&playlist="+playlist+"&idCurator="+idCurator+"&duration="+duration+"&permalinkUrl="+permalinkUrl+"\"> Add Track Bitch </a>";
							}
							else if(streamable)
							{
								var songInfo = document.getElementById('songInfo');
								songInfo.innerHTML = "<p id=\"artist\"> Artist = " + trackArtist +"</p><p id=\"title\"> Title = " + trackTitle +"</p><p id=\"trackId\"> Trackid = " + trackId +"</p><p id=\"genre\"> Genre = Undefined</p><img src=\""+trackArtWork+"\"id=\"artWork\">" ;
								var addLink = document.getElementById('addLink');
								addLink.innerHTML = "<a href=\"add_track.php?title="+trackTitle+"&trackId="+trackId+"&trackArtWork="+trackArtWork+"&playlist="+playlist+"&idCurator="+idCurator+"&duration="+duration+"&artist="+trackArtist+"&permalinkUrl="+permalinkUrl+"\"> Add Track Bitch </a>";
							}
							else
							{
								var songInfo = document.getElementById('songInfo');
								songInfo.innerHTML = "Pas streamable";
							}
						});
		</script>

		

		<footer>
			
		</footer>		
</body>
</html>


