<?php 
	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/
	if (null !== getenv('ENVIRONMENT'))
		{
			if (getenv('ENVIRONMENT') == 'staging')
			{
				$root = "http://staging.soundpark.fm/";
			}
			else if (getenv('ENVIRONMENT') == 'production')
			{
				$root = "http://soundpark.fm/";
			}
			else
			{
				$root = "http://localhost:8888/";
			}
		}

	session_start();
	header('Access-Control-Allow-Origin: *');
	include_once($_SERVER['DOCUMENT_ROOT'].'/model/connect_sql.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/model/get_environment_variables.php');

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
    <link href="<?php echo $root;?>assets/frommail8.css" media="all" rel="stylesheet" />
    <link href="<?php echo $root;?>assets/css_dropdown_menu.css" media="all" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700,100' rel='stylesheet' type='text/css'>
    
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

    <link rel="shortcut icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">
	<link rel="icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">


   	<script src="http://connect.soundcloud.com/sdk.js"></script>
    <!--<script src="https://connect.soundcloud.com/sdk/sdk-3.0.0.js"></script>-->
    <script type="text/javascript" src="<?php echo $root;?>assets/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $root;?>assets/cookies.js"></script>
    <script type="text/javascript" src="<?php echo $root;?>assets/date.js"></script>
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
			    app_id: intercomApiKey
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
			mixpanel.init(mixpanelApiKey);
		</script>
		
		<?php
			include_once($root.'model/get_user_subscription_date.php');
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
			<h1>SOUNDPARK.FM</h1>
		</header>

		<div id="extraOptions"></div>
		
		<div class="container" id="galerie"> 
			
			<div id="left_arrow">
				<input type="button" id="left_arrow_icon" class="rslides_nav rslides1_nav prev"/>
				<div id="previousHandler" class="rslides_nav rslides1_nav prev"></div>
			</div>
			
			<div class="slider">
			<?php 
				
				include_once($root.'model/get_current_playlist_id.php'); // renvoi $currentPlaylistId
				if(isset($_GET['playlistId']))
				{
					$playlistId = $_GET['playlistId'];
				}
				else
				{
					$playlistId = $currentPlaylistId;
				}
			?>
			    <div id="outerLoader" class='outerLoader'>
			    	<div class='containerLoader'>
				    	<svg id='part' x="0px" y="0px" viewBox="0 0 256 256" style="enable-background:new 0 0 200 200;" xml:space="preserve">
							<path class="svgpath" id="playload" d="M189.5,140.5c-6.6,29.1-32.6,50.9-63.7,50.9c-36.1,0-65.3-29.3-65.3-65.3
							c0,0,17,0,23.5,0c10.4,0,6.6-45.9,11-46c5.2-0.1,3.6,94.8,7.4,94.8c4.1,0,4.1-92.9,8.2-92.9c4.1,0,4.1,83,8.1,83
							c4.1,0,4.1-73.6,8.1-73.6c4.1,0,4.1,63.9,8.1,63.9c4.1,0,4.1-53.9,8.1-53.9c4.1,0,4.1,44.1,8.2,44.1c4.1,0,3.1-34.5,7.2-34.5
							c4.1,0,3.1,24.6,7.2,24.6c4.1,0,2.5-14.5,5.2-14.5c2.2,0,0.8,5.1,4.2,4.9c0.4,0,13.1,0,13.1,0c0-34.4-27.9-62.3-62.3-62.3
							c-27.4,0-50.7,17.7-59,42.3"/>
					     </svg>

					      <svg id='part' x="0px" y="0px" viewBox="0 0 256 256" style="enable-background:new 0 0 200 200;" xml:space="preserve">
						        <path class="svgbg" d="M61,126c0,0,16.4,0,23,0c10.4,0,6.6-45.9,11-46c5.2-0.1,3.6,94.8,7.4,94.8c4.1,0,4.1-92.9,8.2-92.9
								c4.1,0,4.1,83,8.1,83c4.1,0,4.1-73.6,8.1-73.6c4.1,0,4.1,63.9,8.1,63.9c4.1,0,4.1-53.9,8.1-53.9c4.1,0,4.1,44.1,8.2,44.1
								c4.1,0,3.1-34.5,7.2-34.5c4.1,0,3.1,24.6,7.2,24.6c4.1,0,2.5-14.5,5.2-14.5c2.2,0,0.8,5.1,4.2,4.9c0.4,0,22.5,0,23,0"/>
					      </svg>
			    	</div>
			 	</div>
			 	<h2 id="mainPlayerLoader">Loading...</h2>

			</div>
			<div id="right_arrow">
				<input type="button" id="right_arrow_icon" class="rslides_nav rslides1_nav next"/>
				<div id="nextHandler" class="rslides_nav rslides1_nav next"></div>
			</div>
			
			
		</div>
		
		<footer>
			<div id="buttons_area">
				<div id="dislike">
					<input type="button" id="minus_one" value="-1" align="center"/>
					<span class="likeText">Forget it</span>
				</div>
				<input type="button" class="play" id="play" value="play"/>
				<div id="like">
					<input type="button" id="plus_one" value="+1" align="center"/>
					<span class="likeText">Like it</span>
				</div>
			</div>
		</footer>		
</body>
<?php
	if (null !== getenv('ENVIRONMENT'))
	{
		if (getenv('ENVIRONMENT') == 'staging' OR getenv('ENVIRONMENT') == 'production')
		{
			echo('<script src="'.$root.'build/b.bundle.js"></script>');
		}
		else
		{
			echo('<script src="http://localhost:8080/b.bundle.js"></script>');
		}
	}
?>
    <script type="text/javascript" src="<?php echo $root;?>assets/popUps.js"></script>
    <script type="text/javascript" src="<?php echo $root;?>assets/on_load.js"></script>
    <!--<script type="text/javascript" src="../assets/mixpanel_logs.js"></script>-->

    <script>

	// var curatorPics = document.querySelectorAll('.curatorPicture');
	// for(var indexCuratorPicture = 0 ; indexCuratorPicture <= curatorPics.length ; indexCuratorPicture++)
	// {
	// 	curatorPics[indexCuratorPicture].addEventListener('mouseover', function(e){
	// 		e.target.nextSibling.style.visibility = "visible";
	// 		e.target.nextSibling.style.opacity = "1";
	// 		//console.log(e.target.nextSibling);
	// 	}, false);
	// 	curatorPics[indexCuratorPicture].addEventListener('mouseout', function(e){
	// 		e.target.nextSibling.style.visibility = "hidden";
	// 		e.target.nextSibling.style.opacity = "0";
	// 		//console.log(e.target.nextSibling);
	// 	}, false);
	// }

    </script>
</html>