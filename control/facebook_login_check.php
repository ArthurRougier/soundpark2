<?php

	require('../vendor/facebook/php-sdk-v4/autoload.php');
	require '../vendor/autoload.php';

	/*define('FACEBOOK_SDK_V4_SRC_DIR', '../vendor/facebook/php-sdk-v4/autoload.php');
	require __DIR__ . '../vendor/facebook/php-sdk-v4/autoload.php';*/


	//echo('jkbfku');
	
	use Facebook\FacebookSession;
	use Facebook\FacebookRequest;
	use Facebook\GraphUser;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookJavaScriptLoginHelper;

	FacebookSession::setDefaultApplication('623682164399249', 'b1591419a11ad7e71d1ead609ceff8fe');
	session_start();
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	if(sessionTestFacebook())
	{
		
		echo(sessionTestFacebook()); 
	}

	else
	{
		echo 'lost';
	}

	function sessionTestFacebook()
	{


		//check for existing session and validate it
		if (isset($_SESSION['facebookToken'])) 
		{
			$session = new FacebookSession($_SESSION['facebookToken']);
			try
			{
			    $session->Validate('623682164399249', 'b1591419a11ad7e71d1ead609ceff8fe');
			} catch(FacebookAuthorizationException $ex)
			{
			    // Session is not valid any more, get a new one.
			   unset($session);
			   return TRUE;
			}

		   	try 
		 	{

		    $user_profile = (new FacebookRequest(
			      $session, 'GET', '/me'
			    ))->execute()->getGraphObject(GraphUser::className());

			    return "Name: " . $user_profile->getName();

			 } catch(FacebookRequestException $e) {

			    return "Exception occured, code: " . $e->getCode();
			    return " with message: " . $e->getMessage();

			}   
	  	}
		

		else if (!isset($session)) 
		{
		  try 
		  {
		    $helper = new FacebookJavaScriptLoginHelper();
		    $session = $helper->getSession();
		   } catch(FacebookRequestException $e) 
		  {
		    unset($session);
		    RETURN $e->getMessage();
		  }
		}

		else if (isset($session)) 
		{
		 	return TRUE;
		}
		else
		{
			return TRUE;
		}

	}

	function sessionTestClassic()
	{
		if($_COOKIE['sessionType'] == 'facebook')
		{
			if(isset($_COOKIE['currentSession']))
			{
				$currentSession = explode("=", $_COOKIE['currentSession']);
				$userEmail = $currentSession[0];
				$key = $currentSession[1];
				include_once('../model/get/get_hashed_token.php'); // take $userEmail in entry
				if(isset($hashedToken))
				{
					if($key == $hashedToken)
					{
						return TRUE;
					}
					else
					{
						return FALSE;
					}
				}
				
			}
			
		}
		else if($_COOKIE['sessionType'] == 'classic')
		{
			if(isset($_COOKIE['currentSession']))
			{
				$currentSession = explode("=", $_COOKIE['currentSession']);
				$userEmail = $currentSession[0];
				$key = $currentSession[1];
				include_once('../model/get/get_classic_token.php'); // take $userEmail in entry
				if(isset($hashedToken))
				{
					if($key == $hashedToken)
					{
						return TRUE;
					}
					else
					{
						return FALSE;
					}
				}
			}
			
		}
	}


		//do some api stuff
		/*if (isset($session)) 
		{
		 	try 
		 	{

			    $user_profile = (new FacebookRequest(
			      $session, 'GET', '/me'
			    ))->execute()->getGraphObject(GraphUser::className());

			    echo "Name: " . $user_profile->getName();

			 } catch(FacebookRequestException $e) {

			    echo "Exception occured, code: " . $e->getCode();
			    echo " with message: " . $e->getMessage();

			}   

		}*/
	