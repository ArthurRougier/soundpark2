<?php 
//echo
	session_start();
	include_once('../model/connect_sql.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >


<link rel="shortcut icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">
<link rel="icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">


<!-- meta fb -->
<meta property="og:site_name" content="Soundpark.fm"/>
<meta property="og:description" content="je viens de découvrir ce morceau sur Soundpark.fm, la seule newsletter de découverte musicale qui arrive directement dans votre boite tous les lundis. Inscrivez-vous pour vous régaler toutes les semaines !" />
<meta property="og:image" content="http://soundpark.fm/assets/pictures/thumbnail_fb.jpg" />

<!-- start Mixpanel --><script type="text/javascript">(function(f,b){if(!b.__SV){var a,e,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=f.createElement("script");a.type="text/javascript";a.async=!0;a.src="//cdn.mxpnl.com/libs/mixpanel-2.2.min.js";e=f.getElementsByTagName("script")[0];e.parentNode.insertBefore(a,e)}})(document,window.mixpanel||[]);
mixpanel.init("96e08627ec77b0c4f5e065ece45960fb");</script><!-- end Mixpanel -->





  <head>
    <title>Soundpark</title>
    <script src="http://connect.soundcloud.com/sdk.js"></script>
    <link href="/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <link href="../assets/fromshare.css" media="all" rel="stylesheet" />
    <script type="text/javascript" src="../assets/jquery.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
 </head>
 
	<body>
		<header>
			<h1>Soundpark.<span style="color: #660066">fm</span></h1>
			<h2>Toutes les semaines, le lundi matin, <span style="color: #660066">le meilleur de la musique</span> sélectionné par <span style="color: #660066">la crème de la crème</span> au chaud <span style="color: #660066">dans votre boite mail</span>.</h2>
		</header>
		
		<div class="container"> 
			
			<?php include_once('../control/display_share_song_box.php'); ?>

		
		</div>
		<div class="trackId" id="trackId"><?php if(isset($_GET['trackId'])){echo($_GET['trackId']);} ?></div>		
		<footer>
			<div id="subscription_area">
				<?php
					include_once('../control/display_email_text.php');
				?>
				<div id="saisie">
					<form accept-charset="UTF-8" action="../control/register_fromshare.php" class="new_user" id="new_user" method="post">
							<input autofocus="autofocus" id="user_email" name="user_email" placeholder="Email" type="text" autocorrect="off" autocapitalize="off"/>
							<input name="commit" type="submit" value="Go" />
							<input type="hidden" name="trackId" value="<?php echo($_GET['trackId']); ?>" /><br />
							<div class="clearfix"></div
					></form
				></div>
			</div>
		</footer>		
</body>

<script>


	var parts = window.location.search.substr(1).split("&");
	var $_GET = {};
	for (var i = 0; i < parts.length; i++) 
	{
	    var temp = parts[i].split("=");
	    $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
	}

	mixpanel.track("Page view", {
			"fullUrl": window.location.href,
			"trackId": $_GET['trackId']
			});

	document.getElementById('play').addEventListener('click', function () 
	{
		mixpanel.track("Play/Pause Clicked");
	}, false);

	document.getElementById('user_email').addEventListener('click', function () 
	{
		mixpanel.track("email input field clicked");
	}, false);

	mixpanel.track_forms("#new_user", "Created Account", {"emailAdress": document.getElementById('user_email').value});



</script>

<script src="../assets/player_fromshare.js"></script>

</html>
