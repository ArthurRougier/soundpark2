<?php
	if($_COOKIE['sessionType'] = 'facebook')
	{
		if(isset($_COOKIE['currentSession']))
		{
			$currentSession = explode("=", $_COOKIE['currentSession']);
			$userEmail = $currentSession[0];
			$key = $currentSession[1];
			include_once('../model/get/get_hashed_token.php'); // take $userEmail in entry
			if($key == $hashedToken)
			{

			}
			else
			{
				include_once('../control/classic_session_check.php');
			}
		}
		
	}
	else if($_COOKIE['sessionType'] = 'classic')
	{
		if(isset($_COOKIE['currentSession']))
		{
			$currentSession = explode("=", $_COOKIE['currentSession']);
			$userEmail = $currentSession[0];
			$key = $currentSession[1];
			include_once('../model/get/get_hashed_token.php'); // take $userEmail in entry
			if($key == $hashedToken)
			{

			}
			else
			{
				include_once('../control/classic_session_check.php');
			}
		}
		
	}
	