<?php 
  // error_reporting(E_ALL);
  // ini_set('display_errors', 1);
	session_start();
  if (null !== getenv('ENVIRONMENT'))
  {
    if (getenv('ENVIRONMENT') == 'staging')
    {
      $root2 = "http://staging.soundpark.fm/";
    }
    else if (getenv('ENVIRONMENT') == 'production')
    {
      $root2 = "http://soundpark.fm/";
    }
    else
    {
      $root2 = "http://localhost:8888/";
    }
  }

  $root = $_SERVER["DOCUMENT_ROOT"];


	require($_SERVER['DOCUMENT_ROOT'].'/control/decide_lang.php');
  include($root.'/control/session_check.php');
  include_once($root.'/control/redirect_user_to_playlist.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
  <head>
    <title><?php echo TXT_LANDING_HEADTITLE; ?></title>
    <meta name="description" content="<?php echo TXT_LANDING_HEADDESCRIPTION; ?>">
    <link href="<?php echo $root2; ?>assets/landingNew.css" media="all" rel="stylesheet" />

   	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <meta property="og:site_name" content="Soundpark.fm"/>
    <meta property="og:url" content="http://soundpark.fm/view/landing.php" />
    <meta property="fb:app_id" content="623682164399249" />
    <meta property="og:title" content="<?php echo TXT_LANDING_HEADTITLE; ?>" />
    <meta property="og:description" content="<?php echo TXT_LANDING_HEADDESCRIPTION; ?>" />
    <meta property="og:image" content="http://soundpark.fm/assets/pictures/uploaded_avatars/Sandrine.jpg" />



    	<link rel="shortcut icon" href="<?php echo $root2; ?>/assets/pictures/favicon.ico" type="image/x-icon">
    	<link rel="icon" href="<?php echo $root2; ?>/assets/pictures/favicon.ico" type="image/x-icon">

    <script src="http://connect.soundcloud.com/sdk.js"></script>
    <script type="text/javascript" src="<?php echo $root2; ?>assets/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $root2; ?>assets/cookies.js"></script>
    <script type="text/javascript" src="<?php echo $root2; ?>assets/AJAX/update_player_position.js"></script>
    <script type="text/javascript" src="<?php echo $root2; ?>assets/AJAX/add_like_dislike.js"></script>
    <script type="text/javascript" src="<?php echo $root2; ?>assets/AJAX/display_user_past_likes.js"></script>
    <script type="text/javascript" src="<?php echo $root2; ?>skrollr/dist/skrollr.min.js"></script>

      
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>

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
 			<li><a id="headerCuratorSignUp" href="#"><?php echo TXT_LANDING_HEADERCURATOR;?></a></li>
 			<li><a id="headerLogIn" href="#"><?php echo TXT_LANDING_HEADERLOGIN;?></a></li>
 			<li><a id="headerSignUp" data-scroll href="#page1"><?php echo TXT_LANDING_HEADERSIGNUP;?></a></li>
		</ul>
	</header>
	<div id="page1" data-center-bottom="opacity: 1;" data--620-top="opacity: 0">
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
              <img id="explainArrow" src="<?php echo $root2; ?>assets/pictures/explain_arrow.png" data-no-retina></br>
            </div>
            <div id="fbButton">
              <span class="helper"></span>
              <img id="fbIcon" src="<?php echo $root2; ?>assets/pictures/facebook_f.svg" data-no-retina>
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
    		<h1><?php echo TXT_LANDING_PAGEONEHEADLINE;?></h1>
    		<a class="CTA" id="CTAP1" href="#"><?php echo TXT_LANDING_PAGEONECTA;?></a>
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
          <img src="<?php echo $root2; ?>assets/pictures/macbook.png" data-at2x="<?php echo $root2; ?>assets/pictures/macbook@2x.png" data-bottom="opacity:0" data--40-bottom="opacity: 1"/>
        </div>
     		<aside class="second" data--140-bottom="opacity: 0" data--180-bottom="opacity: 1">
     			<h1><?php echo TXT_LANDING_PAGETWOHEADLINE;?></h1>
     			<p><?php echo TXT_LANDING_PAGETWOPARONE;?></br><span class="jumpline"><?php echo TXT_LANDING_PAGETWOPARTWO;?></span></p> 
     			<!--<a class="CTA" id="CTAP2" data-scroll href="#page1">Give it a try!</a>-->
        </aside>
		</div
  ></div>
  <div id="page3">
    <div id="backroundOverlay"></div>
    <div id="container3" data-1950-end="opacity: 0; background-attachment: scroll;" data-1850-end="opacity: 1; background-attachment: fixed;">
      <h1><?php echo TXT_LANDING_PAGETHREEHEADLINE;?></h1>
      <p><?php echo TXT_LANDING_PAGETHREEPAR;?></p>
      <a class="CTA" id="CTAP3" data-scroll href="#page1"><?php echo TXT_LANDING_PAGETHREECTA;?></a>
      </br>
    </div>
  </div>
  <!--<div id="page4"
    ><div id="headerPage4"><span class="helper"></span><h1><?php echo TXT_LANDING_PAGESONGSHEADLINE;?></h1> </div
    <?php include_once('../control/display_landing_song_boxes.php'); ?>
      <?php 
        $req = $bdd->query('SELECT trackId, count(distinct like.ID) FROM song, playlist, `like` WHERE song.ID_playlist=playlist.ID AND like.ID_song = song.ID AND playlist.date_end >= NOW() AND playlist.date_start <= NOW() GROUP BY trackId order by count(distinct `like`.ID) DESC LIMIT 3');
        $i = 0;
        while($trackIds = $req->fetch())
        {
          ?> ><div class="trackIds"><?php echo($trackIds[0]); ?></div <?php
        };

      ?>  
  ></div>-->
  <div id="page5">
    <span class="helper"></span>
    <div id="container5">
      <div id="curatorsNumber">
        <?php
         include_once($root.'/model/get_curators_number.php');
         echo $curatorsNumber;
        ?>
      </div>
      <h1><?php echo TXT_LANDING_PAGECURATORSHEADLINE;?></h1>
      <?php
        include_once($root.'/control/display_curators_photo.php');
      ?>
      <div id="number22"><span class="helper"></span><p>...</p></div>
      <a id="youCuratorLink" href="#page3" data-scroll><div id="you"><span class="helper"></span>You?</div></a>
    </div>
  </div>

  <footer>
    <span class="helper"></span>
    <ul>
      <li><a href="mailto:contact@soundpark.fm"><?php echo TXT_LANDING_FOOTERCONTACT;?></a></li>
      <li><a href="mailto:jobs@soundpark.fm"><?php echo TXT_LANDING_FOOTERJOBS;?></a></li>
    </ul>
    <div id="mixpanel">
      <span class="helper"></span>
      <a href="https://mixpanel.com/f/partner"><img src="//cdn.mxpnl.com/site_media/images/partner/badge_blue.png" alt="Mobile Analytics" data-no-retina/></a>
    </div>
    <div id="soundcloudLogo">
      <span class="helper"></span>
      <a href="http://www.soundcloud.com"><img src="<?php echo $root2; ?>assets/pictures/powered_by_soundcloud.png" data-no-retina/></a>
    </div>

     
  </footer>
  <script type="text/javascript" src="<?php echo $root2; ?>assets/retina.js"></script>
  <script type="text/javascript" src="<?php echo $root2; ?>assets/facebook.js"></script>
  <script type="text/javascript" src="<?php echo $root2; ?>assets/smooth-scroll.min.js"></script>
  <script type="text/javascript" src="<?php echo $root2; ?>assets/on_load_landing2.js"></script>

</body>
   
    
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
	}, false);

  */
	</script>
</html>