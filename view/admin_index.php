<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
  <head>
    <title>Soundpark</title>
    <link href="/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <script type="text/javascript" src="../assets/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="../Sortable/Sortable.min.js"></script>
    <script src="http://connect.soundcloud.com/sdk.js"></script>
    <link href="../assets/BO.css" media="all" rel="stylesheet" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
 </head>
 
	<body>
		<header>
			<h1>Soundpark.<span style="color: white;">fm</span></h1>
			<ul>
				<?php 
					include_once('../model/get_current_playlist_id.php'); // renvoi $currentPlaylistId
				?>
				<li><a id="playlist_tab" style="color: white; border-bottom: 1px solid white;" href="../view/admin_index.php?idPlaylist=<?php echo($currentPlaylistId); ?>">Playlists</a></li>
				<li><a id="songs_tab" href="../view/admin_songs_new.php">Songs</a></li>
				<li><a id="curator_tab" href="../view/admin_curator.php">Curators</a></li>
				<li><a id="curator_tab" href="../view/admin_genres.php">Genres</a></li>
			</ul>
		</header>

		<aside>
			<ul>
				<li><a
				<?php if(($_GET['idPlaylist'] == $currentPlaylistId) OR !isset($_GET['idPlaylist']))
				{
					echo(' style="color: #531931; border-bottom: 1px solid #531931;" ');
				}?>
				href="admin_index.php?idPlaylist=<?php echo($currentPlaylistId);?>">Current</a></li>
				<li><a
				<?php if($_GET['idPlaylist'] == ($currentPlaylistId+1))
				{
					echo(' style="color: #531931; border-bottom: 1px solid #531931;" ');
				}?>
				href="admin_index.php?idPlaylist=<?php echo($currentPlaylistId+1); ?>">n+1</a></li>
				<li><a
				
			<ul>
		</aside>

		<div id="container">
			<?php 
			$playlistId = $currentPlaylistId;
			if(isset($_GET['addTrack']) AND isset($_GET['idPlaylist']))
			{
				$playlistId = $_GET['idPlaylist'];
				?> <h1> Son bien ajouté ! </h1></br>

			<?php

			}
			else if(isset($_GET['modifyPlaylist']) AND isset($_GET['idPlaylist']))
			{
				$playlistId = $_GET['idPlaylist'];
				?> <h1> Playlist updated :) ! </h1></br>

			<?php

			}
			else if(isset($_GET['idPlaylist']))
			{
				$playlistId = $_GET['idPlaylist'];
			}
			else if(!isset($_GET['idPlaylist']))
			{
				header("Location: ../view/admin_index.php?idPlaylist=".$currentPlaylistId);
			}
			?>

			<h2> Add a new song to the playlist : </h2>
			<form accept-charset="UTF-8" action="../control/get_track_info.php" class="new_song" id="new_song" method="post">
				 <span>URL : </span><input autofocus="autofocus" id="song_url" name="song_url" type="url" />
				 <input autofocus="autofocus" class="playlist" id="playlist" name="playlist" value="<?php echo($_GET['idPlaylist']);?>" type="hidden"/>
			       <?php 
			      	include_once('../model/get_curators.php');
			       	echo'<label for="idCurator">Quel influenceur ?</label>';
			       	echo'<select name="idCurator" id="idCurator">';
					$j = 0;

					while($j<$i)
					{
						?>
						<option value="<?php echo $idCurator[$j]; ?>"><?php echo $pseudoCurator[$j]; ?></option>
						<?php
						$j++;
					}
					?>
			       </select>
					
				<input name="commit" type="submit" value="Go" />
			</form>

			<div id="songInfo">
			</div>

			<div id="track_list">

				<h2> Playlist de la semaine courante : </h2>
				
				<?php include_once('../control/display_complete_track_list_form.php'); ?>
				<script type="text/javascript">
					var el = document.getElementById('sortable');
					var sortable = Sortable.create(el, 
					{
						handle: '.icon-move',
						animation: 150,
						group: "localStorage-example",
						scroll: true, // or HTMLElement
			

					     setData: function (dataTransfer, dragEl) {
					        dataTransfer.setData('Text', dragEl.textContent);
					    },

					    onStart: function (/**Event*/evt) {
					        evt.oldIndex;  // element index within parent
					    },

					    // dragging ended
					    onEnd: function (/**Event*/evt) {
					        evt.oldIndex;  // element's old index within parent
					        evt.newIndex;  // element's new index within parent
					        for(var index = 0; index < document.getElementsByClassName('songOrder').length; index++)
					        {
					        	var elem = document.getElementById("songOrder"+sortable.toArray()[index]);
								elem.value = (index+1);
					        }
					        
					    },

					    // Element is dropped into the list from another list
					    onAdd: function (/**Event*/evt) {
					        var itemEl = evt.item;  // dragged HTMLElement
					        evt.from;  // previous list
					        // + indexes from onEnd
					    },

					    // Changed sorting within list
					    onUpdate: function (/**Event*/evt) {
					        var itemEl = evt.item;  // dragged HTMLElement
					        // + indexes from onEnd
					    },

					    // Called by any change to the list (add / update / remove)
					    onSort: function (/**Event*/evt) {
					        // same properties as onUpdate
					    },

					    // Element is removed from the list into another list
					    onRemove: function (/**Event*/evt) {
					        // same properties as onUpdate
					    },

					    // Attempt to drag a filtered element
					    onFilter: function (/**Event*/evt) {
					        var itemEl = evt.item;  // HTMLElement receiving the `mousedown|tapstart` event.
					    }
					});
				</script>
				

			</div>
		</div>

		<footer>
			
		</footer>		
</body>
<script type="text/javascript" src="../assets/player_bo.js"></script>
<script type="text/javascript">

	var menus = document.getElementsByClassName('optionsMenuBo');
	var optionLinks = document.getElementsByClassName('optionLink');
	
	for (var indexMenus = 0 ; indexMenus < optionLinks.length ; indexMenus++)
	{
		optionLinks[indexMenus].addEventListener('click', function() 
	    { 
	    	if(Number(this.id.slice(-2))==this.id.slice(-2))
	    	{
				var indexMenusNew = this.id.slice(-2); 
	    	}
	    	else
	    	{
	    		var indexMenusNew = this.id.slice(-1); 
	    	}
	    	for (var indexMenusAll = 0 ; indexMenusAll < optionLinks.length ; indexMenusAll++)
				{
					menus[indexMenusAll].style.display="none";
				}
	    	//console.log(indexMenusNew);
	    	menus[indexMenusNew].style.display="inline-block";
		}, false);
	}
	$('body').click(function(e) 
	{
		if ($(e.target).closest('.optionLink').length === 0) 
		{
		   for (var indexMenusAll = 0 ; indexMenusAll < optionLinks.length ; indexMenusAll++)
				{
					menus[indexMenusAll].style.display="none";
				}
		}
	});
	
</script>
</html>