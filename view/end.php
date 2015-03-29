<?php 
	session_start(); 
	require('../control/decide_lang.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
  <head>
    <title>Soundpark</title>
    <link href="/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <link href="../assets/end.css" media="all" rel="stylesheet" />
    <script src="../assets/audio_player.js"></script>

	<link rel="shortcut icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">
	<link rel="icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">
    
    <script type="text/javascript" src="../assets/jquery-1.3.2.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
 

    <!-- start Mixpanel --><script type="text/javascript">(function(f,b){if(!b.__SV){var a,e,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=f.createElement("script");a.type="text/javascript";a.async=!0;a.src="//cdn.mxpnl.com/libs/mixpanel-2.2.min.js";e=f.getElementsByTagName("script")[0];e.parentNode.insertBefore(a,e)}})(document,window.mixpanel||[]);
mixpanel.init("96e08627ec77b0c4f5e065ece45960fb");</script><!-- end Mixpanel -->


 </head>
 
	<body>
		
		<header>
			<h1><a id="bannerBackLink" href="http://<?php echo($_COOKIE['playlist_url']); ?>?pwd=<?php echo($_COOKIE['current_user']); ?>">Soundpark.<span style="color: #660066">fm</span></a></h1>
		</header>
		<div class="container"> 
				<h2><?php echo TXT_END_HEADLINE; ?></h2>
				<a href="http://www.facebook.com/sharer.php?u=http://soundpark.fm/view/landing.php" id="facebookShare" target="_blank"><input type="button" id="facebookShare"/></a>
				<a href="http://twitter.com/share?url=http://soundpark.fm&text=Toutes%20les%20semaines,%20le%20meilleur%20de%20la%20musique%20sélectionné%20par%20la%20crème%20de%20la%20crème,%20au%20chaud%20dans%20ta%20boîte%20mail" class="twitter-share-button" id="twitterShare" target="_blank"><input type="button" id="twitterShare"/></a>
				<a href="curators.php" id="curatorPageLink"><h3><?php echo TXT_END_CURATORSLINK; ?></h3></a>
		</div>
		<footer>
			<div id="buttons_area">
				<a href="http://<?php echo($_COOKIE['playlist_url']); ?>?pwd=<?php echo($_COOKIE['current_user']); ?>" id="replay"></a>
			</div>
		</footer>	

		
		   <script type="text/javascript">

				//Mixpanel Logs

		   		mixpanel.track_links("#bannerBackLink", "Clicked on the banner backlink", {fullUrl: window.location.href});
		   		mixpanel.track_links("#facebookShare", "Clicked on the Facebook share Link", {fullUrl: window.location.href});
		   		mixpanel.track_links("#twitterShare", "Clicked on the Twitter share Link", {fullUrl: window.location.href});
		   		document.getElementById('replay').addEventListener('click', function () {
					mixpanel.track("Replay Clicked");
					}, false);
		   		mixpanel.track_links("#curatorPageLink", "Clicked on the 'Et merci qui ?' Link", {fullUrl: window.location.href});
		   		mixpanel.track("Page view", {fullUrl: window.location.href});


		   		// twitter pop up
		   		  
		   		 
		   </script>	
</body>
</html>