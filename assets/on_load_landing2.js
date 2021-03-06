  mixpanel.track("Page view", {fullUrl: window.location.href});
  var curatorCTA = false;

  var bgTempPaths = ['../assets/pictures/bg_home_1.jpg','../assets/pictures/bg_home_1_2.jpg','../assets/pictures/bg_home_1_3.jpeg','../assets/pictures/bg_home_1_4.jpeg'];

  var random = Math.floor((Math.random() * 2) + 1);
  if(random === 1)
  {
    document.getElementById('page1').style.backgroundImage = 'url('+bgTempPaths[1]+')';
    var pictureHome = 'ladyDesert';
  }
  else
  {
    document.getElementById('page1').style.backgroundImage = 'url('+bgTempPaths[3]+')';
    var pictureHome = 'DeskWithSpeakers';
  }

//signUpOverlay

  var CTA = document.getElementById('CTAP1');
  CTA.addEventListener('click', function() 
  { 
  	var message = document.getElementById('message');
  	var signUpForm = document.getElementsByTagName('signUpForm');
  	var userTypeField = document.getElementById('userType');
    var fbButtonText = document.getElementById('fbButtonText');
    fbButtonText.innerHTML = 'Sign up with Facebook';
  	userTypeField.value = '1';
  	signUpForm.action = '../control/register.php';
  	message.innerHTML = '<h2>Only the ones using Facebook to sign up will receive a birthday gift. Life is unfair.</h2><img id="explainArrow" src="../assets/pictures/explain_arrow.png" data-no-retina></br>';
    displaySignUpOverlay();



    //tracking

    mixpanel.track("Main CTA page 1 clicked", {
      fullUrl: window.location.href,
      "BackgroungPicture": pictureHome
      });


  },false);

  var headerSignUp = document.getElementById('headerSignUp');
  headerSignUp.addEventListener('click', function() 
  { 
  	var message = document.getElementById('message');
  	var signUpForm = document.getElementsByTagName('signUpForm');
  	var userTypeField = document.getElementById('userType');
    var fbButtonText = document.getElementById('fbButtonText');
    fbButtonText.innerHTML = 'Sign up with Facebook';
  	userTypeField.value = '1';
  	signUpForm.action = '../control/register.php';
  	message.innerHTML = '<h2>Only the ones using Facebook to sign up will receive a birthday gift. Life is unfair.</h2><img id="explainArrow" src="../assets/pictures/explain_arrow.png" data-no-retina></br>';
    displaySignUpOverlay();

    //tracking

    var scrollPosition = $(document).scrollTop();
    mixpanel.track("Header sign up clicked", {
      "fullUrl": window.location.href,
      "BackgroungPicture": pictureHome,
      "scrollPosition": scrollPosition
      });


  },false);

  var headerLogIn = document.getElementById('headerLogIn');
  headerLogIn.addEventListener('click', function() 
  { 
  	var message = document.getElementById('message');
  	var oldWayMessage = document.getElementById('oldWayMessage');
  	var signUpForm = document.getElementById('signUpForm');
  	var userTypeField = document.getElementById('userType');
    var fbButtonText = document.getElementById('fbButtonText');
    fbButtonText.innerHTML = 'Log in with Facebook';
  	userTypeField.value = '1';
  	signUpForm.action = '../control/login_check.php';
  	message.innerHTML = '<h2>Facebook prefered :)</h2><img id="explainArrow" src="../assets/pictures/explain_arrow.png" data-no-retina></br>';
    oldWayMessage.innerHTML = 'Ok, you can also log in the old way:';
    displaySignUpOverlay();

    //tracking

    var scrollPosition = $(document).scrollTop();
    mixpanel.track("Header log in clicked", {
      "fullUrl": window.location.href,
      "BackgroungPicture": pictureHome,
      "scrollPosition": scrollPosition
      });

  },false);

  var headerCuratorSignUp = document.getElementById('headerCuratorSignUp');
  headerCuratorSignUp.addEventListener('click', function() 
  { 
  	var message = document.getElementById('message');
  	var userTypeField = document.getElementById('userType');
    var fbButtonText = document.getElementById('fbButtonText');
    var signUpForm = document.getElementById('signUpForm');
    curatorCTA = true;
    fbButtonText.innerHTML = 'Sign up with Facebook';
  	userTypeField.value = '2';
  	message.innerHTML = '<h2>Welcome, music lord! Only the ones using Facebook to sign up will receive a birthday gift. Life is unfair.</h2><img id="explainArrow" src="../assets/pictures/explain_arrow.png" data-no-retina></br>';
    signUpForm.action = '../control/register.php';
    displaySignUpOverlay();

    //tracking

    var scrollPosition = $(document).scrollTop();
    mixpanel.track("Header curator sign up clicked", {
      "fullUrl": window.location.href,
      "BackgroungPicture": pictureHome,
      "scrollPosition": scrollPosition
      });

  },false);

  var CTAP3 = document.getElementById('CTAP3');
  CTAP3.addEventListener('click', function() 
  { 
    var message = document.getElementById('message');
    var userTypeField = document.getElementById('userType');
    var signUpForm = document.getElementById('signUpForm');
    var fbButtonText = document.getElementById('fbButtonText');
    curatorCTA = true;
    userTypeField.value = '1';
    signUpForm.action = '../control/register.php';
    fbButtonText.innerHTML = 'Sign up with Facebook';
    message.innerHTML = '<h2>Welcome, music lord! Only the ones using Facebook to sign up will receive a birthday gift. Life is unfair.</h2><img id="explainArrow" src="../assets/pictures/explain_arrow.png" data-no-retina></br>';
    displaySignUpOverlay();

    //tracking

    mixpanel.track("CTA P3 clicked", {
      "fullUrl": window.location.href,
      "BackgroungPicture": pictureHome
      });

  },false);


  var youCuratorLink = document.getElementById('youCuratorLink');
  youCuratorLink.addEventListener('click', function() 
  { 

    //tracking

    mixpanel.track("you curator link clicked", {
      "fullUrl": window.location.href,
      "BackgroungPicture": pictureHome
      });

  },false);


  

  // var CTAP2 = document.getElementById('CTAP2');
  // CTAP2.addEventListener('click', function() 
  // { 
  // 	var message = document.getElementById('message');
  // 	var userTypeField = document.getElementById('userType');
  //   var fbButtonText = document.getElementById('fbButtonText');
  //   var signUpForm = document.getElementById('signUpForm');
  // 	fbButtonText.innerHTML = 'Sign up with Facebook';
  //   userTypeField.value = '1';
  //   signUpForm.action = '../control/register.php';
  //   message.innerHTML = '<h2>Only the ones using Facebook to sign up will receive a birthday gift. Life is unfair.</h2><img id="explainArrow" src="../assets/pictures/explain_arrow.png" data-no-retina></br>';
  //   displaySignUpOverlay();
  // },false);


  var closeSignUpOverlay = document.getElementById('closeSignUpOverlay');
  closeSignUpOverlay.addEventListener('click', function() 
  { 
    undisplaySignUpOverlay();
  },false);
  

  function displaySignUpOverlay()
  {
    var signUpOverlay = document.getElementById('signUpOverlay');
    var mainHeader = document.getElementById('mainHeader');
    mainHeader.style.visibility = "hidden";
    signUpOverlay.style.visibility = "visible";
    signUpOverlay.style.opacity = "0.92";
  }

    function undisplaySignUpOverlay()
  {
    var signUpOverlay = document.getElementById('signUpOverlay');
    signUpOverlay.style.visibility = "hidden";
    signUpOverlay.style.opacity = "0";
    mainHeader.style.visibility = "visible";
    curatorCTA = false;
  }

  // messages display on signup overlay

  	//if error

 	var message = document.getElementById('message');
 	if(getParameterByName('invalidEmail') == 'TRUE')
	{
		displaySignUpOverlay();
		message.innerHTML = '<h2> Email invalid... Try again...</h2></br>';
	}

	else if(getParameterByName('alreadyExists') == 'TRUE')
	{
		displaySignUpOverlay();
		message.innerHTML = '<h2> Unfortunately you cannot subscribe twice...</h2></br>';
	}

	else if(getParameterByName('missingPassword') == 'TRUE')
	{
		displaySignUpOverlay();
		message.innerHTML = '<h2>If you aren\'t logging in with facebook, please chose a password bro.</h2></br>';
	}

	else if(getParameterByName('missingAll') == 'TRUE')
	{
		displaySignUpOverlay();
		message.innerHTML = '<h2> If you aren\'t logging in with facebook, please fill your email address and password fields.</h2></br>';
	}

	else if(getParameterByName('unknownEmail') == 'TRUE')
	{
		displaySignUpOverlay();
		message.innerHTML = '<h2> Unknown email... Please try again.</h2></br>';
	}

	else if(getParameterByName('wrongPassword') == 'TRUE')
	{
		displaySignUpOverlay();
		message.innerHTML = '<h2> wrongPassword... Please try again.</h2></br>';
	}

  // else if(getParameterByName('logout') == '1')
  // {
    
  // }



	


  //Fb signup


  var fbButton = document.getElementById('fbButton');
  fbButton.addEventListener('click', function() 
  { 
    facebookLogin();

    //tracking

    mixpanel.track("Fb button clicked", {
      fullUrl: window.location.href,
      "BackgroungPicture": pictureHome
      });

  },false);

  //tracking classic sign ups

  mixpanel.track_forms("#signUpForm", "Classic form used on landing");


	//skrollr and smoothScroll

  smoothScroll.init({
    speed: 1000, // Integer. How fast to complete the scroll in milliseconds
    easing: 'easeInOutCubic', // Easing pattern to use
    updateURL: true, // Boolean. Whether or not to update the URL with the anchor hash on scroll
    offset: 0, // Integer. How far to offset the scrolling anchor location in pixels
    callbackBefore: function ( toggle, anchor ) {}, // Function to run before scrolling
    callbackAfter: function ( toggle, anchor ) {} // Function to run after scrolling
});

$(document).ready(function(){
      if ($(window).width() > 1000) {
          skrollr.init({
             render: function(data){
                //console.log(data.curTop);
                //document.getElementById('offset').innerHTML = data.curTop;
             },
            smoothScrolling: true,
            forceHeight: false
          });
      }
    });
	

var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0)
var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0)

if(w<500)
{
  skrollr.init().destroy();
}

  

  $(window).scroll(function()
  {
    var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0)
    if ($(window).scrollTop() >= (h-120)) {
      $('header').addClass('fix-header');
      var mainHeader = document.getElementById('mainHeader');
      //mainHeader.style.opacity = "0.5";
    }
    else {
      $('header').removeClass('fix-header');
      var mainHeader = document.getElementById('mainHeader');
      mainHeader.style.opacity = "1";
    }
  });


  //fonction pour récupérer les $_GET en javascript
  function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
  }



  // TEMP Changement de bg

var bgTempPaths = ['../assets/pictures/bg_home_1.jpg','../assets/pictures/bg_home_1_2.jpg','../assets/pictures/bg_home_1_3.jpeg','../assets/pictures/bg_home_1_4.jpeg'];
var bgPosition = 0;

  document.addEventListener('keydown', function(e) 
{
  if(e.keyCode == 73)
  {
    if(bgPosition !== 3)
    {
      bgPosition++;
      //console.log(bgTempPaths[bgPosition]);
      document.getElementById('page1').style.backgroundImage = 'url('+bgTempPaths[bgPosition]+')';
    }
    else
    {
      bgPosition = 0;
      //console.log('fefefefdzdzdze');
      document.getElementById('page1').style.backgroundImage = 'url('+bgTempPaths[bgPosition]+')';

    }
  }
}, false);



