<?php session_start();?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
  <head>
    <title>Soundpark</title>
    <link href="/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <script type="text/javascript" src="../assets/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="../Sortable/Sortable.min.js"></script>
    <script src="http://connect.soundcloud.com/sdk.js"></script>
    <link href="../assets/BO_theo.css" media="all" rel="stylesheet" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    Sortable.min
 </head>
 
	<body>
		<header>
			<h1>Soundpark.<span style="color: white;">fm</span></h1>
			<ul>
				<li><a id="my_songs_tab" href="curator_index.php">My Songs</a></li>
				<li><a id="account_tab" style="color: white; border-bottom: 1px solid white;" href="curator_my_account.php">My Account</a></li>
			</ul>
		</header>

		<aside>
			<ul>
				<li><a style="color: #531931;" href="curator_my_account.php">Information</a></li>
				<li><a style="color: #531931; border-bottom: 1px solid #531931;" href="curator_personal_stat.php">My Stats</a></li>
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
			
				<h2> Curating the best songs in Soundpark.fm </h2>
				
				<?php include_once('../control/display_like_dislike_stats.php');?>	
				
				
				<h2> The best curators in Soundpark.fm </h2>

				Liste

		</div>

		<footer>
			
		</footer>		
</body>
<script type="text/javascript" src="../assets/player_bo.js"></script>
</html>