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
        <h2>Hey bro. We are now creating accounts so you can do much more with Soundpark! </br>Just one step and you're done. If you have a facebook account:</h2>
        <img id="explainArrow" src="../assets/pictures/explain_arrow.png" data-no-retina></br>
      </div>
      <div id="fbButton">
        <span class="helper"></span>
        <img id="fbIcon" src="../assets/pictures/facebook_f.svg" data-no-retina>
        <h2>Log in with facebook</h2>
      </div>
      </br>
      </br>
    </div>
    <div id="classicLogin">
      <h2 id="oldWayMessage">If you have no facebook account, please set (and remember) a password: </h2>
      <form accept-charset="UTF-8" action="../control/transition_password_set.php" class="signUpForm" id="signUpForm" method="post">
        <input placeholder="Email" id="emailField" name="user_email" value="<?php echo($_GET['pwd']) ?>" type="hidden" /></br>
        <input placeholder="Password" id="emailField" name="password" type="password" /></br>
        <input id="registerSource" name="registerSource" value="newLanding" type="hidden" />
        <input name="commit" type="submit" value="Go" />
       </form>
    </div>
  </div>
  <span class="helper"></span>
</div>
      