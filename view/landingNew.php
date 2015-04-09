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
    <title>Soundpark</title>
    <link href="../assets/landingNew.css" media="all" rel="stylesheet" />

   	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
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
    <script type="text/javascript" src="../skrollr/dist/skrollr.min.js"></script>

      
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>-->

    <!-- start Mixpanel --><script type="text/javascript">(function(f,b){if(!b.__SV){var a,e,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
    for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=f.createElement("script");a.type="text/javascript";a.async=!0;a.src="//cdn.mxpnl.com/libs/mixpanel-2.2.min.js";e=f.getElementsByTagName("script")[0];e.parentNode.insertBefore(a,e)}})(document,window.mixpanel||[]);
    mixpanel.init("96e08627ec77b0c4f5e065ece45960fb");</script><!-- end Mixpanel -->
  </head>

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
 	<header id="mainHeader">
 		<h1>SOUNDPARK.FM</h1>
 		<ul>
 			<li><a id="headerCuratorSignUp" href="#">Become a curator</a></li>
 			<li><a id="headerLogIn" href="#">Log in</a></li>
 			<li><a id="headerSignUp" data-scroll href="#page1">Sign up</a></li>
		</ul>
	</header>
	<div id="page1" data-center-bottom="opacity: 1;" data--530-top="opacity: 0">
      <div id="signUpOverlay">
        <div id="headerSignUpOverlay">
          <h1>SOUNDPARK.FM</h1>
          <ul>
            <li><a id="closeSignUpOverlay" href="#">close</a></li>
          </ul>
        </div>
        <div id="signUpOverlayContainer">
          <div id="facebookLogin">
            <div id="message">
              <h2>Only the ones using Facebook to sign up will receive a birthday gift. Life is unfair.</h2>
              <img id="explainArrow" src="../assets/pictures/explain_arrow.png" data-no-retina></br>
            </div>
            <div id="fbButton">
              <span class="helper"></span>
              <img id="fbIcon" src="../assets/pictures/facebook_f.svg" data-no-retina>
              <h2 id="fbButtonText">Sign up with facebook</h2>
            </div>
            </br>
            </br>
          </div>
          <div id="classicLogin">
            <h2 id="oldWayMessage">Or sign up the old way: </h2>
            <form accept-charset="UTF-8" action="../control/register.php" class="signUpForm" id="signUpForm" method="post">
              <input placeholder="Email" id="emailField" name="user_email" type="email" /></br>
              <input placeholder="Password" id="emailField" name="password" type="password" /></br>
              <input id="registerSource" name="registerSource" value="newLanding" type="hidden" />
              <input id="userType" name="userType" value="1" type="hidden" />
              <input name="commit" type="submit" value="Go" />
             </form>
          </div>
        </div>
        <span class="helper"></span>
      </div>
      <div id="backroundOverlay"></div>
    	<div id="container1">
    		<h1>We delight you with <span class="strong"> great new music</br></span> in the <span class="strong">simpliest way.</span></h1>
    		<a class="CTA" id="CTAP1" href="#">Give it a try!</a>
        </br>
        <a id="chevronLink" data-scroll href="#page2"><svg id="svg_down_chevron" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="36.3 26.1 30.3 16.4" enable-background="new 36.3 26.1 30.3 16.4" xml:space="preserve">
          <path id="down_chevron" fill="#FFFFFF" d="M50.8,41.5c0.1,0.1,0.3,0.2,0.5,0.2c0.2,0,0.4-0.1,0.5-0.2l13.1-13.1c0.3-0.3,0.3-0.7,0-1c-0.3-0.3-0.7-0.3-1,0L51.3,39.9L38.7,27.4c-0.3-0.3-0.7-0.3-1,0c-0.3,0.3-0.3,0.7,0,1L50.8,41.5z"/>
        </svg></a>
		</div>
	</div>
  	<div id="page2">
    	<div id="container2">
     		<span class="helper"></span>
        <div class="img-container first">
          <img src="../assets/pictures/macbook.png" data-bottom="opacity:0" data--40-bottom="opacity: 1"/>
        </div>
     		<aside class="second" data--140-bottom="opacity: 0" data--180-bottom="opacity: 1">
     			<h1>A <span class="strong">one-click</span> music </br>experience.</h1>
     			<p>No complicated platform with shitloads of tracks and filtering options. </br></br>Just a slick player with one stream.</p> 
     			<a class="CTA" id="CTAP2" data-scroll href="#page1">Give it a try!</a>
        </aside>
		</div
  ></div>
  <div id="page3">
    <div id="backroundOverlay"></div>
    <div id="container3" data-250-end="opacity: 0; background-attachment: scroll;" data-150-end="opacity: 1; background-attachment: fixed;">
      <h1><span class="strong">Hand-curated</span> with love.</h1>
      <p>Every monday morning, we release our new stream of music composed of tracks found by music lovers.</br> We believe in human taste, not in algorithms.</p>
      <a class="CTA" data-scroll id="CTAP3" href="#page1">Become a curator</a>
      </br>
    </div>
  </div>
  <footer>
    <span class="helper"></span>
    <ul>
      <li><a href="">Contact us</a></li>
      <li><a href="">Jobs</a></li>
    </ul>
    <div id="mixpanel">
      <span class="helper"></span>
      <a href="https://mixpanel.com/f/partner"><img src="//cdn.mxpnl.com/site_media/images/partner/badge_blue.png" alt="Mobile Analytics" data-no-retina/></a>
    </div>

     
  </footer
  ></body>

    <!--<script type="text/javascript" src="../assets/player_landing.js"></script>-->
    <script type="text/javascript" src="../assets/retina.js"></script>
    <script type="text/javascript" src="../assets/facebook.js"></script>
    <script type="text/javascript" src="../assets/smooth-scroll.min.js"></script>
    <script type="text/javascript" src="../assets/on_load_landing2.js"></script>
   
    
    <script>

  //MIXPANEL TRACKING CODE ----> TO REDO


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
<<<<<<< HEAD
	}, false);

  */
	</script>
</html>