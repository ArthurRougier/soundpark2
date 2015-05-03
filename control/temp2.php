<?php
	
	echo($_COOKIE['current_user']);
	echo($_COOKIE['sessionType']);
	echo($_COOKIE['currentSession']);
	include_once($_SERVER['DOCUMENT_ROOT'].'/model/get_userEmail_from_userId.php');
	echo($userEmail);


