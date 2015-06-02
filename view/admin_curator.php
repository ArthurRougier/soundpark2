<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
  <head>
    <title>Soundpark</title>
    <link href="/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <script type="text/javascript" src="../assets/jquery-1.3.2.min.js"></script>
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
					include_once('../model/get_current_playlist_id.php'); 
				?>
				<li><a id="playlist_tab" href="../view/admin_index.php?idPlaylist=<?php echo($currentPlaylistId); ?>">Playlists</a></li>
				<li><a id="songs_tab" href="../view/admin_songs_new.php">Songs</a></li>
				<li><a id="curator_tab" style="color: white; border-bottom: 1px solid white;" href="../view/admin_curator.php">Curators</a></li>
				<li><a id="curator_tab" href="../view/admin_genres.php">Genres</a></li>

			</ul>
		</header>


		<div id="container">

			<?php 

			if(isset($_GET['addCurator']))
			{
				?> <h1> Curator well added ! </h1></br>

			<?php

			}
			?>

			<div id="curators_registering">

				<h2> Add a curator : </h2>
				
			<form accept-charset="UTF-8" action="../control/add_curator.php" class="new_curator" id="new_curator" method="post" enctype="multipart/form-data">
				 <span>Name : </span><input autofocus="autofocus" id="pseudo" name="pseudo" type="text" />
			      <label for="genre">Style de prédilection ?</label>
			       <select name="genre" id="genre">
			           <option value="1">Electro</option>
			           <option value="2">Samba</option>
			           <option value="3">Musette</option>
			       </select>
			       <span>Face : </span><input id="avatar" name="avatar" type="file" />
			       <span>Website : </span><input  id="link" name="link" type="url" />
				<input name="commit" type="submit" value="Go" />
			</form>

			</div>
			<div id="curators_displaying">

				<h2> Current curators : </h2>
				<?php include_once('../control/display_curators_list.php'); ?>
				
			</form>

			</div>
		</div>

		<footer>
			
		</footer>		
</body>
</html>