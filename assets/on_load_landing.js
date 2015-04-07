window.onload=function(){
	mixpanel.track("Page view", {fullUrl: window.location.href});
};

//signUpOverlay

  var CTA = document.getElementById('CTAP1');
  CTA.addEventListener('click', function() 
  { 
    displaySignUpOverlay();
  },false);

  var headerSignUp = document.getElementById('headerSignUp');
  headerSignUp.addEventListener('click', function() 
  { 
    displaySignUpOverlay();
  },false);

  var closeSignUpOverlay = document.getElementById('closeSignUpOverlay');
  closeSignUpOverlay.addEventListener('click', function() 
  { 
    undisplaySignUpOverlay();
  },false);
  

  function displaySignUpOverlay()
  {
    var signUpOverlay = document.getElementById('signUpOverlay');
    var mainHeader = document.getElementById('mainHeader');
    signUpOverlay.style.visibility = "visible";
    signUpOverlay.style.opacity = "0.95";
    mainHeader.style.visibility = "hidden";
  }

    function undisplaySignUpOverlay()
  {
    var signUpOverlay = document.getElementById('signUpOverlay');
    signUpOverlay.style.visibility = "hidden";
    signUpOverlay.style.opacity = "0";
    mainHeader.style.visibility = "visible";
  }

  //Fb signup


  var fbButton = document.getElementById('fbButton');
  fbButton.addEventListener('click', function() 
  { 
    facebookLogin();
  },false);


	//skrollr and smoothScroll

  smoothScroll.init({
    speed: 10x00, // Integer. How fast to complete the scroll in milliseconds
    easing: 'easeInOutCubic', // Easing pattern to use
    updateURL: true, // Boolean. Whether or not to update the URL with the anchor hash on scroll
    offset: 0, // Integer. How far to offset the scrolling anchor location in pixels
    callbackBefore: function ( toggle, anchor ) {}, // Function to run before scrolling
    callbackAfter: function ( toggle, anchor ) {} // Function to run after scrolling
});

	skrollr.init({
	     render: function(data){
	        //console.log(data.curTop);
	        //document.getElementById('offset').innerHTML = data.curTop;
	     },
	    smoothScrolling: true,
	   	forceHeight: false
  	});

  $(window).scroll(function()
  {
    var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0)
    if ($(window).scrollTop() >= (h-70)) {
       $('header').addClass('fix-header');
       var mainHeader = document.getElementById('mainHeader');
        mainHeader.style.opacity = "0.5";
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