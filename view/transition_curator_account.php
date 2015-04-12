<?php 
  session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
  <head>
    <title>Soundpark</title>
    <link href="../assets/login.css" media="all" rel="stylesheet" />

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

 <body>

  <!--<div id="offset" data-0="width: 0%" data-end="width: 100%"></div>-->

  <div id="ui">
    <div id="signUpOverlay">
  <div id="headerSignUpOverlay">
    <h1>SOUNDPARK.FM</h1>
    <ul>
      <li><a href="http://soundpark.fm">Home</a></li>
    </ul>
  </div>
  <div id="signUpOverlayContainer">
    <div id="facebookLogin">
      <div id="message">
        <h2>Hey bro. We are now creating accounts so you can do much more with Soundpark!
      </div>
      </br>
      </br>
    </div>
    <div id="classicLogin">
      <h2 id="oldWayMessage">We need to link your curator account with your Soundpark mail</br>Please enter the email you use to listen to Soundpark: </h2>
      <form accept-charset="UTF-8" action=<?php echo "../control/transition_link_curator_to_user.php?curatorId=".$_GET['curatorId'];?> class="signUpForm" id="signUpForm" method="post">
        <input placeholder="Email" id="emailField" name="user_email" value="" type="email" /></br>
        <input id="registerSource" name="registerSource" value="newLanding" type="hidden" />
        <input name="commit" type="submit" value="Next" />
       </form>
    </div>
  </div>
  <span class="helper"></span>
</div>
  </div>
  
     
    </body>

    <!--<script type="text/javascript" src="../assets/player_landing.js"></script>-->
    <script type="text/javascript" src="../assets/retina.js"></script>
    <script type="text/javascript" src="../assets/facebook.js"></script>
    <script type="text/javascript" src="../assets/smooth-scroll.min.js"></script>    
    <script>



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