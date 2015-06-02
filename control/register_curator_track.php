<script src="http://connect.soundcloud.com/sdk.js"></script>
<div id="songInfo">
</div>
<div id="addLink">
</div>


<?php
if (isset($_POST['curator_track'])) 
{
	if(strpos($_POST['curator_track'],'soundcloud')!== false)
	{
		?>
		<script type="text/javascript"> 
			SC.initialize({
			    client_id: "17f3a8c69cb36c955df82f908611e27e"
			});

			var songUrl = "<?php echo($_POST['curator_track'])?>";
			var curatorId = "<?php echo($_POST['ID_curator'])?>";
			var source = "<?php echo($_POST['source'])?>";
			var streamable, trackId, trackArtWork, trackArtist, trackTitle, trackGenre, type;


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
				type = "soundcloud";
				if(streamable && trackGenre)
				{
					//var songInfo = document.getElementById('songInfo');
					//songInfo.innerHTML = "<p id=\"artist\">1 Artist = " + trackArtist +"</p><p id=\"title\"> Title = " + trackTitle +"</p><p id=\"genre\"> Genre = " + trackGenre +"</p><img src=\""+trackArtWork+"\"id=\"artWork\">" ;
					//var addLink = document.getElementById('addLink');
					var link = "add_proposed_track.php?title="+trackTitle+"&artist="+trackArtist+"&genre="+trackGenre+"&trackId="+trackId+"&trackArtWork="+trackArtWork+"&duration="+duration+"&permalinkUrl="+permalinkUrl+"&curatorId="+curatorId+"&type="+type;
					if(source == 'dropPage')
					{
						link = link + "&source=dropPage";
					}
					else if (source == 'admin')
					{
						link = link + "&source=admin";
					}
					window.location.href = link;
					//addLink.innerHTML = "<a href=\"add_proposed_track.php?title="+trackTitle+"&artist="+trackArtist+"&genre="+trackGenre+"&trackId="+trackId+"&trackArtWork="+trackArtWork+"&duration="+duration+"&permalinkUrl="+permalinkUrl+"&curatorId="+curatorId+"&type="+type+"\"> Add Track Bitch </a>";
				}
				else if(streamable)
				{
					//var songInfo = document.getElementById('songInfo');
					//songInfo.innerHTML = "<p id=\"artist\">2 Artist = " + trackArtist +"</p><p id=\"title\"> Title = " + trackTitle +"</p><p id=\"trackId\"> Trackid = " + trackId +"</p><p id=\"genre\"> Genre = Undefined</p><img src=\""+trackArtWork+"\"id=\"artWork\">" ;
					//var addLink = document.getElementById('addLink');
					var link = "add_proposed_track.php?title="+trackTitle+"&trackId="+trackId+"&trackArtWork="+trackArtWork+"&duration="+duration+"&artist="+trackArtist+"&permalinkUrl="+permalinkUrl+"&curatorId="+curatorId+"&type="+type;
					if(source == 'dropPage')
					{
						link = link + "&source=dropPage";
					}
					else if (source =='admin')
					{
						link = link + "&source=admin";
					}
					window.location.href = link;
					//addLink.innerHTML = "<a href=\"add_track.php?title="+trackTitle+"&trackId="+trackId+"&trackArtWork="+trackArtWork+"&duration="+duration+"&artist="+trackArtist+"&permalinkUrl="+permalinkUrl+"&curatorId="+curatorId+"&type="+type+"\"> Add Track Bitch </a>";
				}
				else if (!streamable) 
				{
					if(source == 'dropPage')
					{
						window.location.href = "../view/curatorDropPage.php?message=notStreamable";
					}
					else if (source =='admin')
					{
						window.location.href = "../view/admin_songs_new.php?message=notStreamable";
					}
					else
					{
						addLink.innerHTML = "pas streamable"; // A changer
					}
					
				}
				else
				{
					if(source == 'dropPage')
					{
						window.location.href = "../view/curatorDropPage.php?message=notWorking";
					}
					else if (source =='admin')
					{
						window.location.href = "../view/admin_songs_new.php?message=notWorking";
					}
					else
					{
						addLink.innerHTML = "Vraiment navré, le lien suivant ne marche pas :(. Ce serait cool de nous mailer sur @contact@soundpark.fm!"; // A changer
					}
				}
			});
		</script>
	<?php
	}
	else if(strpos($_POST['curator_track'],'youtube')!== false)
	{
		$curatorId = $_POST['ID_curator'];
		include_once('mailYoutubeLink.php');
	}
	else
	{
		$curatorId = $_POST['ID_curator'];
		echo('<script>window.location.href = "../view/curatorDropPage.php?message=badLink&curatorId='.$curatorId.'";</script>');
	}
}


else
{
	//redirect and explain
}

?>

