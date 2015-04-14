<?php 
	session_start();
	require('../control/decide_lang.php');
	include_once('../model/connect_sql.php');
	setcookie('playlist_url', $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'], time() + 7*24*3600, null, null, false, true);
	setcookie('current_user', $_GET['pwd'], time() + 7*24*3600, null, null, false, false);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
  <head>
    <title><?php echo TXT_LANDING_HEADTITLE; ?></title>
    <meta name="description" content="<?php echo TXT_LANDING_HEADDESCRIPTION; ?>">
    <link href="../assets/landing2.css" media="all" rel="stylesheet" />

	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <link rel="stylesheet" media="screen and (max-width: 1285px)" href="../assets/landing2smallRes.css" />
    <link rel="stylesheet" media="screen and (max-width: 768px)" href="../assets/landing2smallRes.css" />
    <link rel="stylesheet" media="screen and (max-height: 700px)" href="../assets/landing2smallRes.css" />
    <link rel="stylesheet" media="screen and (min-width: 1700px)" href="../assets/landing2HighRes.css" />
    <link rel="stylesheet" media="all and (max-width: 700px)" href="../assets/landing2Mobile.css" />

    <meta property="og:site_name" content="Soundpark.fm"/>
    <meta property="og:description" content="Toutes les semaines, le lundi matin, le meilleur de la musique sélectionné par la crème de la crème, au chaud dans ta boîte mail" />
    <meta property="og:image" content="http://soundpark.fm/assets/pictures/thumbnail_fb.jpg" />



	<link rel="shortcut icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">
	<link rel="icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">

    <script src="http://connect.soundcloud.com/sdk.js"></script>
    <script type="text/javascript" src="../assets/jquery.js"></script>
    <script type="text/javascript" src="../assets/cookies.js"></script>
    <script type="text/javascript" src="../assets/AJAX/update_player_position.js"></script>
    <script type="text/javascript" src="../assets/AJAX/add_like_dislike.js"></script>
    <script type="text/javascript" src="../assets/AJAX/display_user_past_likes.js"></script>

    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>

    <!-- start Mixpanel --><script type="text/javascript">(function(f,b){if(!b.__SV){var a,e,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=f.createElement("script");a.type="text/javascript";a.async=!0;a.src="//cdn.mxpnl.com/libs/mixpanel-2.2.min.js";e=f.getElementsByTagName("script")[0];e.parentNode.insertBefore(a,e)}})(document,window.mixpanel||[]);
mixpanel.init("96e08627ec77b0c4f5e065ece45960fb");</script><!-- end Mixpanel -->


 </head>
 
	<body>
		<header>
			<div id="title">
				<h1>Soundpark.<span style="color: #660066">fm</span></h1>
			</div>
			<h2 id="player_position"><?php include("../control/display_player_position.php"); ?></h2>
			<h2><?php echo TXT_LANDING_TAGLINE; ?></h2>
			<!--<h3> <?php //echo($_COOKIE['playlist_url']); ?> </h3>-->
			<!--<h3> <?php //echo($_COOKIE['current_user']); ?> </h3>-->
		</header>
		<div id="tagLineContainer"><h2>Cette semaine, les sons qui ont buzzé :</h2></div>
		<div class="container" id="galerie"> 
			
			<div id="left_arrow">
				<input type="button" id="left_arrow_icon" class="previous" onclick="previousTrack()"/>
			</div>
			<div id="right_arrow">
				<input type="button" id="right_arrow_icon" class="next" onclick="nextTrack()"/>
			</div>
			<div class="slider"
			<?php include_once('../control/display_landing_song_boxes.php'); ?>
			<?php 
				$req = $bdd->query('SELECT trackId, count(distinct like.ID) FROM song, playlist, soundpark2.like WHERE song.ID_playlist=playlist.ID AND like.ID_song = song.ID AND playlist.date_end >= NOW() AND playlist.date_start <= NOW() GROUP BY trackId order by count(distinct soundpark2.like.ID) DESC LIMIT 3');
				$i = 0;
				while($trackIds = $req->fetch())
				{
					?> ><div class="trackIds"><?php echo($trackIds[0]); ?></div <?php
				};
			?>	
			></div			
		></div		
		><footer>
			<div id="subscription_area">
				<h2><?php include_once('../control/display_email_text.php'); ?></h2>
				<div id="saisie"
					><form accept-charset="UTF-8" action="../control/register.php" class="new_user" id="new_user" method="post">
							<input autofocus="autofocus" id="user_email" name="user_email" placeholder="Email" type="text" autocorrect="off" autocapitalize="off"/>
							<input id="registerSource" name="registerSource" value="oldLanding" type="hidden" />
							<input name="commit" type="submit" value="Go" />
							<div class="clearfix"></div
					></form
				></div
			></div
		></footer>		
</body>
    <script type="text/javascript" src="../assets/player_landing.js"></script>
    <script type="text/javascript" src="../assets/glide_up_share_link.js"></script>
    <script type="text/javascript" src="../assets/on_load_landing.js"></script>
   
    <!-- MIXPANEL TRACKING CODE -->
    <script>


	for (var i = 0 ; i < document.getElementsByClassName('play').length; i++){document.getElementsByClassName('play')[i].addEventListener('click', function() 
	    { 
	    	mixpanel.track("Play/Pause Clicked on landing", {fullUrl: window.location.href}); 

		}, false);}

	document.getElementById('user_email').addEventListener('click', function () 
	{
		mixpanel.track("email input field clicked", {fullUrl: window.location.href});
	}, false);

	mixpanel.track_forms("#new_user", "Created Account", {"emailAdress": document.getElementById('user_email').value});


	document.getElementById('right_arrow_icon').addEventListener('click', function () {
		mixpanel.track("Next Clicked", {fullUrl: window.location.href});
	}, false);

	document.getElementById('left_arrow_icon').addEventListener('click', function () {
		mixpanel.track("Previous Clicked", {fullUrl: window.location.href});
	}, false);



	</script>

</html>