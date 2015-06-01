<?php
	// setcookie('current_user', '', time() + 31*24*3600,  "/", null, false, true);
	// setcookie('sessionType', '', time() + 31*24*3600,  "/", null, false, true);
	// setcookie('currentSession', '', time() + 31*24*3600,  "/", null, false, true);
	// echo($_COOKIE['sessionType']);

	if (isset($_SERVER['HTTP_COOKIE']))
	{
	    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
	    foreach($cookies as $cookie)
	    {
	        $mainCookies = explode('=', $cookie);
	        $name = trim($mainCookies[0]);
	        setcookie($name, '', time()-1000);
	        setcookie($name, '', time()-1000, '/');
	    }
	}
	session_destroy();

	header('Location: ../view/landing.php?logout=1'); 