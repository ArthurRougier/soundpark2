<?php 
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
  <head>
    <title>Soundpark</title>
    <link href="assets/login.css" media="all" rel="stylesheet" />

	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <!--<link rel="stylesheet" media="screen and (max-width: 1285px)" href="../assets/landing2smallRes.css" />
    <link rel="stylesheet" media="screen and (max-width: 768px)" href="../assets/landing2smallRes.css" />
    <link rel="stylesheet" media="screen and (max-height: 700px)" href="../assets/landing2smallRes.css" />
    <link rel="stylesheet" media="screen and (min-width: 1700px)" href="../assets/landing2HighRes.css" />
    <link rel="stylesheet" media="all and (max-width: 700px)" href="../assets/landing2Mobile.css" />-->

    <meta property="og:site_name" content="Soundpark.fm"/>
    <meta property="og:description" content="Toutes les semaines, le lundi matin, le meilleur de la musique sélectionné par la crème de la crème, au chaud dans ta boîte mail" />
    <meta property="og:image" content="http://soundpark.fm/assets/pictures/thumbnail_fb.jpg" />



	<link rel="shortcut icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">
	<link rel="icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">

    <!--<script src="http://connect.soundcloud.com/sdk.js"></script>-->
    <script type="text/javascript" src="../assets/jquery.js"></script>
    <script type="text/javascript" src="../assets/cookies.js"></script>
    <script type="text/javascript" src="../assets/AJAX/update_player_position.js"></script>
    <script type="text/javascript" src="../assets/AJAX/add_like_dislike.js"></script>
    <script type="text/javascript" src="../assets/AJAX/display_user_past_likes.js"></script>
    <script type="text/javascript" src="../skrollr/dist/skrollr.min.js"></script>

    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>

    <!-- start Mixpanel --><script type="text/javascript">(function(f,b){if(!b.__SV){var a,e,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=f.createElement("script");a.type="text/javascript";a.async=!0;a.src="//cdn.mxpnl.com/libs/mixpanel-2.2.min.js";e=f.getElementsByTagName("script")[0];e.parentNode.insertBefore(a,e)}})(document,window.mixpanel||[]);
mixpanel.init("96e08627ec77b0c4f5e065ece45960fb");</script><!-- end Mixpanel -->


 <body>

    <!-- Fb sdk -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '623682164399249',
          cookie     : true, 
          xfbml      : true,
          version    : 'v2.3'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    </script>

 	<!--<div id="offset" data-0="width: 0%" data-end="width: 100%"></div>-->

	<div id="ui">
    <?php
      include('view/transition_password.php');
    ?>
	</div>
	
     
    </body>

    <script type="text/javascript" src="../assets/retina.js"></script>
    <script type="text/javascript" src="../assets/facebook.js"></script>
    <script type="text/javascript" src="../assets/smooth-scroll.min.js"></script>
   
    
    <script>

  //MIXPANEL TRACKING CODE


    /*
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
	}, false);*/


  if(getParameterByName('noPassword') == 'TRUE')
  {
    oldWayMessage = document.getElementById('oldWayMessage');
    oldWayMessage.innerHTML = 'Wrong password... Please try again';
  }

  else if(getParameterByName('shortPassword') == 'TRUE')
  {
    oldWayMessage = document.getElementById('oldWayMessage');
    oldWayMessage.innerHTML = 'Password too short buddy... Please try again';
  } 
  

   //fonction pour récupérer les $_GET en javascript
  function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
  }

  var fbButton = document.getElementById('fbButton');
  fbButton.addEventListener('click', function() 
  { 
    facebookLogin();
  },false);
  


	</script>

</html>