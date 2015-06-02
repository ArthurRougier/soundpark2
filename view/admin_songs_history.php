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
    Sortable.min
 </head>
 
	<body>
		<header>
			<h1>Soundpark.<span style="color: white;">fm</span></h1>
			<ul>
				<?php 
					include_once('../model/get_current_playlist_id.php'); // renvoi $currentPlaylistId
				?>
				<li><a id="playlist_tab" href="../view/admin_index.php?idPlaylist=<?php echo($currentPlaylistId); ?>">Playlists</a></li>
				<li><a id="songs_tab" style="color: white; border-bottom: 1px solid white;" href="../view/admin_songs_new.php">Songs</a></li>
				<li><a id="curator_tab" href="../view/admin_curator.php">Curators</a></li>
				<li><a id="curator_tab" href="../view/admin_genres.php">Genres</a></li>
			</ul>
		</header>

		<aside>
			<ul>
				<li><a href="../view/admin_songs_new.php">New</a></li>
				<li><a style="color: #531931; border-bottom: 1px solid #531931;" href="#">Used</a></li>
				<li><a href="../view/admin_songs_storage.php">Storage</a></li>
			<ul>
		</aside>

		<div id="container">
			<?php 
				if(isset($_GET['message']))
				{
					echo('<h1>'.$_GET['message'].' !</h1></br>');
				}
			?>

			<h2> Songs treated: </h2>
			
				
				<?php include_once('../control/display_treated_songs.php'); ?>
		


			</div>
		</div>

		<footer>
			
		</footer>		
</body>
<script type="text/javascript" src="../assets/player_bo.js"></script>
</html>