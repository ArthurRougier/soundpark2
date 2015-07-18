<?php 
	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/
	session_start();
	header('Access-Control-Allow-Origin: *');
	include_once('../model/connect_sql.php');
	include($_SERVER['DOCUMENT_ROOT'].'/control/session_check.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/control/control_user.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/model/get_userEmail_from_userId.php');
	setcookie('playlist_url', $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'], time() + 7*24*3600, null, null, false, true);
	//echo($_COOKIE['sessionType']);	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
  <head>
    <title>Soundpark</title>
    <link href="../assets/frommail8.css" media="all" rel="stylesheet" />
    <link href="../assets/css_dropdown_menu.css" media="all" rel="stylesheet" />
    
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

    <link rel="shortcut icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">
	<link rel="icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">


    <script src="http://connect.soundcloud.com/sdk.js"></script>
    <script type="text/javascript" src="../assets/jquery.js"></script>
    <script type="text/javascript" src="../assets/cookies.js"></script>
    <script type="text/javascript" src="../assets/date.js"></script>
    <script type="text/javascript" src="../assets/AJAX/update_player_position.js"></script>
    <script type="text/javascript" src="../assets/AJAX/add_like_dislike.js"></script>
    <script type="text/javascript" src="../assets/AJAX/record_automatic_next.js"></script>
    <script type="text/javascript" src="../assets/AJAX/display_user_past_likes.js"></script>
    <!--<script type="text/javascript" src="../zeroclipboard-2.1.6/dist/ZeroClipboard.min.js"></script>-->
    

	<!--Intercom integration-->
	
		<?php
			include_once('../model/get_user_subscription_date.php');
		?>
	    <script type="text/javascript">
	    	var unixtime = Date.parse("<?php echo($subsciptionDate); ?>").getTime()/1000;
		 	var email = "<?php echo($userEmail); ?>";
			//console.log('Intercom : '+email);

		 	 window.intercomSettings = {
			    // TODO: The current logged in user's full name
			    name: email,
			    email: email,
			    // TODO: The current logged in user's sign-up date as a Unix timestamp.
			    created_at: unixtime,
			    app_id: "qbgtpz2g"
			};
		</script>
		<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/qbgtpz2g';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
	   
	<!-- end Intersom -->

	<!--Google fonts integration-->
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>

    <!-- start Mixpanel -->
	    <script type="text/javascript">(function(f,b){if(!b.__SV){var a,e,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
			for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=f.createElement("script");a.type="text/javascript";a.async=!0;a.src="//cdn.mxpnl.com/libs/mixpanel-2.2.min.js";e=f.getElementsByTagName("script")[0];e.parentNode.insertBefore(a,e)}})(document,window.mixpanel||[]);
			mixpanel.init("96e08627ec77b0c4f5e065ece45960fb");
		</script>
		
		<?php
			include_once('../model/get_user_subscription_date.php');
		?>

		<script type="text/javascript">
			var userId = "<?php echo($_COOKIE['current_user']); ?>";
			var subsciptionDate = "<?php echo($subsciptionDate); ?>";
			var userEmail = "<?php echo($userEmail); ?>";
			//console.log(subsciptionDate);
	
			//console.log('Mixpa ID : '+userId);
			//console.log('Mixpa : '+userEmail);
			mixpanel.identify(userId);
			mixpanel.people.set(
			{
			    "$email": userEmail,    // only special properties need the 
			    "$created": subsciptionDate,
			    "$last_login": Date.now()        // properties can be dates...
			});
		</script>

	<!-- end Mixpanel -->


 </head>
 
	<body>
		<header>
			<!--<?php include_once('../control/display_curator_access_logo.php');?>-->
			<?php include_once('../control/display_account_dropdown_menu.php');?>

			<h1>SOUNDPARK.FM</h1>
			<h2 id="player_position"><?php include("../control/display_player_position.php"); ?></h2>
				
		</header>
		
		<div class="container" id="galerie"> 
			
			<div id="left_arrow" >
				<input type="button" id="left_arrow_icon" class="rslides_nav rslides1_nav prev" onclick="previousTrack()"/>
				<div id="previousHandler" class="rslides_nav rslides1_nav next"></div>
			</div>
			
			<div class="slider">
			<?php 
				include_once('../model/get_current_playlist_id.php'); // renvoi $currentPlaylistId
				if(isset($_GET['playlistId']))
				{
					$playlistId = $_GET['playlistId'];
				}
				else
				{
					$playlistId = $currentPlaylistId;
				}
				include_once('../control/display_song_boxes.php'); 
			?>
			</div>
			<div id="right_arrow">
				<input type="button" id="right_arrow_icon" class="rslides_nav rslides1_nav next" onclick="nextTrack()"/>
				<div id="nextHandler" class="rslides_nav rslides1_nav next"></div>
			</div>
			
			
		</div>
		
		<footer>
			<div id="buttons_area">
				<div id="dislike">
					<input type="button" id="minus_one" value="-1" onclick="addDislike()" align="center"/>
					<span class="likeText">Forget it</span>
				</div>
				<input type="button" class="play" id="play" value="pause"/>
				<div id="like">
					<input type="button" id="plus_one" value="+1" onclick="addLike()" align="center"/>
					<span class="likeText">Like it</span>
				</div>
				<form id="share_link">
					<span class="share_url_title"> Share that tune --> </span>
					<?php 
						//on va ici chercher le premier trackId pour initialiser le lien share
						$req = $bdd->query('SELECT trackId FROM song, playlist WHERE song.ID_playlist=playlist.ID AND playlist.date_end >= NOW() AND playlist.date_start <= NOW()');
						$trackIds = $req->fetch();
					?>
					<div id="share_url"> http://soundpark.fm/view/fromshare.php?trackId=<?php echo $trackIds[0]; ?></div>
					<span class="share_url_title"> <-- Share that tune </span>
				</form>
			</div>
		</footer>		
</body>
    <script type="text/javascript" src="../assets/player2.js"></script>
    <script type="text/javascript" src="../assets/popUps.js"></script>
    <script type="text/javascript" src="../assets/on_load.js"></script>
    <script type="text/javascript" src="../assets/mixpanel_logs.js"></script>
    <script src="../assets/responsiveslides.min.js"></script>
    <script type="text/javascript"></script>

    <script>
      $(function() {
        $(".rslides").responsiveSlides({
          auto: false,             // Boolean: Animate automatically, true or false
          speed: 1000,            // Integer: Speed of the transition, in milliseconds
          nav: true,             // Boolean: Show navigation, true or false
          random: false,          // Boolean: Randomize the order of the slides, true or false
          pause: false,           // Boolean: Pause on hover, true or false
          namespace: "rslides",   // String: Change the default namespace used
          before: function(){},   // Function: Before callback
          after: function(){}     // Function: After callback
        });
      });


    </script>

    <script>

    $(document).mouseup(function (e)
	{
	    var container = $(".dropdown");

	    if (!container.is(e.target) // if the target of the click isn't the container...
	        && container.has(e.target).length === 0) // ... nor a descendant of the container
	    {
	        document.getElementById("dropdownCheckbox").checked = false;
	    }
	});

    </script>
</html>