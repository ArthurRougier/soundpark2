<?php 
	// error_reporting(E_ALL);
	// ini_set('display_errors', 1);
	session_start();
	include_once ('../model/connect_sql.php');
	include($_SERVER['DOCUMENT_ROOT'].'/control/session_check.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/control/control_user.php');

	$req=$bdd->prepare('SELECT curator.ID FROM curator, user WHERE curator.ID_user=user.id AND user.id=?');
	$req->execute(array($_COOKIE['current_user']));
	$resultat=$req->fetch();

	$_SESSION['id_curator']=$resultat[0];

?>

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
				<li><a id="my_account_tab" href="../view/settings.php">My account</a></li>
				<li><a id="my_songs_tab" style="color: white; border-bottom: 1px solid white;" href="../view/likes.php">My Songs</a></li>
				<!--<li><a id="account_tab" href="curator_my_account.php">My Account</a></li>-->
				<li><a id="playlist_tab" href="../view/frommail.php">Playlist</a></li>
			</ul>
		</header>
		
		<aside>
			<ul>
				<li style="box-shadow: 0 0 0 1px rgb(232, 232, 232) inset; background-color: rgba(83, 25, 49, 0.05);"><a style="color: #531931; border-left: 8px solid #531931; " href="playlists.php">Playlists</a></li>
				<li><a style="color: #531931;" href="likes.php">My likes</a></li>
				<?php

					include_once ('../control/connect_sql.php');
					$req=$bdd->prepare('SELECT type FROM user WHERE id=?');
					$req->execute(array($_COOKIE['current_user']));
					$resultat=$req->fetch();

					if ($resultat[0]==2)
					{
						echo '<li><a style="color: #531931;" href="curator_index.php">This Week</a></li>';
						echo '<li><a style="color: #531931" href="curator_historic_songs.php">History</a></li>';
					}
				?>					
			<ul>
		</aside>

		<div id="container">
			<div id="tilesContainer">
				<!-- Define all of the tiles: -->
				 <?php include_once('../control/display_settings_playlist_tiles.php'); ?>
			</div>
		</div>

		<footer>
			
		</footer>
		<script src="../assets/BO_styles_handler.js"></script>
</body>
</html>