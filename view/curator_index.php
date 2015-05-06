<?php 
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
    <script type="text/javascript" src="../assets/player_bo.js"></script>
    <link href="../assets/BO_theo.css" media="all" rel="stylesheet" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    Sortable.min
 </head>
 
	<body>
		<header>
			<h1>Soundpark.<span style="color: white;">fm</span></h1>
			<ul>
				<li><a id="my_songs_tab" style="color: white; border-bottom: 1px solid white;" href="curator_index.php">My Songs</a></li>
				<!--<li><a id="account_tab" href="curator_my_account.php">My Account</a></li>-->
				<li><a id="playlist_tab" href="../view/frommail.php">Playlist</a></li>
			</ul>
		</header>

		<aside>
			<ul>
				<li><a style="color: #531931; border-bottom: 1px solid #531931;" href="curator_index.php">This Week</a></li>
				<li><a style="color: #531931;" href="curator_historic_songs.php">History</a></li>
			<ul>
		</aside>

		<div id="container">
			<?php 
				//Code permettant de faire un retour sur le post
				if(isset($_GET['message']))
				{
					echo('<h1>'.$_GET['message'].' !</h1></br>');
				}
			?>
			<div id="DropSpace">
				<h2> Share a new song: </h2>
					<form accept-charset="UTF-8" action="../control/register_curator_track.php" class="new_user" id="new_user" method="post">
						<input autofocus="autofocus" placeholder="URL of your tune. Soundcloud prefered! But youtube compatible." id="curator_track" name="curator_track"  type="url" autocorrect="off" autocapitalize="off"/>
						<input name="commit" type="submit" value="Go" />
						<input type="hidden" value="<?php echo($_SESSION['id_curator']) ?>" name="ID_curator">
						<input type="hidden" value="dropPage" name="source">
					</form>
			</div>

			<div id="SongsPosted_Index">
				<h2> Songs for the week: </h2>
				<?php
					include("../control/display_untreated_songs_curator.php");
				?>
			</div>	
		</div>

		<footer>
			
		</footer>		
</body>
</html>