<?php 
	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/
	session_start();
	header('Access-Control-Allow-Origin: *');
	include_once('../model/connect_sql.php');
	//include_once('../control/control_user.php');
	include($_SERVER['DOCUMENT_ROOT'].'/control/session_check.php');
	if(sessionTestFacebook())
	{
		//echo(sessionTestFacebook());
	}
	else
	{
		if(sessionTestClassic())
		{
			//echo(sessionTestClassic());
		}
		else
		{
			header('Location: ../login.php'); 
		}
	}
	setcookie('playlist_url', $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'], time() + 7*24*3600, null, null, false, true);
	setcookie('current_user', $_GET['pwd'], time() + 7*24*3600, null, null, false, false);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
  <head>
    <title>Soundpark</title>
    <link href="../assets/frommail8.css" media="all" rel="stylesheet" />

	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <!--<link rel="stylesheet" media="screen and (max-width: 1285px)" href="../assets/frommail8SmallRes.css" />
    <link rel="stylesheet" media="screen and (min-width: 1700px)" href="../assets/frommail8HighRes.css" />
    <link rel="stylesheet" media="screen and (max-width: 768px)" href="../assets/frommail8SmallRes.css" />
    <link rel="stylesheet" media="screen and (max-height: 700px)" href="../assets/frommail8SmallRes.css" />-->
    <link rel="stylesheet" media="all and (max-width: 550px)" href="../assets/frommail8Mobile.css" />

    <link rel="shortcut icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">
	<link rel="icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">


    <script src="http://connect.soundcloud.com/sdk.js"></script>
    <script type="text/javascript" src="../assets/jquery.js"></script>
    <script type="text/javascript" src="../assets/cookies.js"></script>
    <script type="text/javascript" src="../assets/date.js"></script>
    <script type="text/javascript" src="../assets/AJAX/update_player_position.js"></script>
    <script type="text/javascript" src="../assets/AJAX/add_like_dislike.js"></script>
    <script type="text/javascript" src="../assets/AJAX/display_user_past_likes.js"></script>
    <!--<script type="text/javascript" src="../zeroclipboard-2.1.6/dist/ZeroClipboard.min.js"></script>-->
    

	<!--Intercom integration-->
	
		<?php
			include_once('../model/get_user_subscription_date.php');
		?>
	    <script>
	    	var unixtime = Date.parse("<?php echo($subsciptionDate); ?>").getTime()/1000
		 	var parts = window.location.search.substr(1).split("&");
			var $_GET = {};
			for (var i = 0; i < parts.length; i++) 
			{
			    var temp = parts[i].split("=");
			    $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
			}
			//console.log($_GET['pwd']);

		 	 window.intercomSettings = {
			    // TODO: The current logged in user's full name
			    name: $_GET['pwd'],
			    // TODO: The current logged in user's email address.
			    email: $_GET['pwd'],
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
			include_once('../model/get_user_id.php');
			include_once('../model/get_user_subscription_date.php');
		?>

		<script type="text/javascript">
			userId = "<?php echo($userId); ?>";
			var subsciptionDate = "<?php echo($subsciptionDate); ?>";
			var userEmail = "<?php echo($_GET['pwd']); ?>";
			//console.log(subsciptionDate);
			//console.log(userEmail);
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
	<?php
		include_once('view/frommail.php');
	?>
</body>
    <script type="text/javascript" src="../assets/player2.js"></script>
    <!--<script type="text/javascript" src="../assets/glide_up_share_link.js"></script>-->
    <script type="text/javascript" src="../assets/on_load.js"></script>
    <script type="text/javascript" src="../assets/mixpanel_logs.js"></script>
    <script type="text/javascript">
    
    </script>
</html>