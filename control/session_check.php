<?php
	
	require($_SERVER['DOCUMENT_ROOT'].'/vendor/facebook/php-sdk-v4/autoload.php');
	require ($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

	
		use Facebook\FacebookSession;
		use Facebook\FacebookRequest;
		use Facebook\GraphUser;
		use Facebook\FacebookRequestException;
		use Facebook\FacebookJavaScriptLoginHelper;


	function sessionTestFacebook() // require initiate_facebook_php_sdk.php
	{


		FacebookSession::setDefaultApplication('623682164399249', 'b1591419a11ad7e71d1ead609ceff8fe');

		//check for existing session and validate it
		$helper = new FacebookJavaScriptLoginHelper();
		

		$appid = '623682164399249'; // your AppID
		$secret = 'b1591419a11ad7e71d1ead609ceff8fe'; // your secret
		 
			 
		if ( isset( $_SESSION ) && isset( $_SESSION['fb_token'] ) ) 
		{
			// create new session from saved access_token
			$session = new FacebookSession( $_SESSION['fb_token'] );

			// validate the access_token to make sure it's still valid
			try 
			{
				if ( !$session->validate() ) 
				{
			  		$session = null;
			  		return FALSE;
				}
			} catch ( Exception $e ) 
			{
				// catch any exceptions
				$session = null;
				return FALSE;
			}

		} 
		else 
		{
			// no session exists

			try 
			{
				$session = $helper->getSession();
			} catch( FacebookRequestException $ex ) {
				return FALSE;
				// When Facebook returns an error
			} catch( Exception $ex ) {
				//return FALSE;// When validation fails or other local issues
				return $ex->message;
			}

		}

			// see if we have a session
		if ( isset( $session ) ) 
		{

			// save the session
			$_SESSION['fb_token'] = $session->getToken();
			// create a session using saved token or the new one we generated at login
			$session = new FacebookSession( $session->getToken() );

			// graph api request for user data
			$request = new FacebookRequest( $session, 'GET', '/me' );
			$response = $request->execute();
			// get response
			$graphObject = $response->getGraphObject()->asArray();

			// print profile data
			return '<pre>' . print_r( $graphObject, 1 ) . '</pre>';

			// print logout url using session and redirect_uri (logout.php page should destroy the session)
			//echo '<a href="' . $helper->getLogoutUrl( $session, 'http://yourwebsite.com/app/logout.php' ) . '">Logout</a>';

		} 
		else 
		{
			// show login url
			return FALSE;
			//echo '<a href="' . $helper->getLoginUrl( array( 'email', 'user_friends' ) ) . '">Login</a>';
		}
	}


	function sessionTestClassic()
	{
		if(isset($_COOKIE['sessionType']))
		{
			if($_COOKIE['sessionType'] == 'facebook')
			{
				if(isset($_COOKIE['currentSession']))
				{
					$currentSession = explode("=", $_COOKIE['currentSession']);
					$ID_user = $currentSession[0];
					$key = $currentSession[1];
					//return $key;

					include($_SERVER['DOCUMENT_ROOT'].'/model/get_hashed_token.php');
					if(isset($hashedToken))
					{
						if($key == $hashedToken)
						{
							return $hashedToken;
						}
						else
						{
							return false;
						}
					}
					else
					{
						return false;
					}
					//return true;
					
				}
				else
				{
					return false;
				}
				
			}
			else if($_COOKIE['sessionType'] == 'classic')
			{
				if(isset($_COOKIE['currentSession']))
				{
					$currentSession = explode("=", $_COOKIE['currentSession']);
					$ID_user = $currentSession[0];
					$key = $currentSession[1];
					
					include($_SERVER['DOCUMENT_ROOT'].'/model/get_classic_token.php'); //takes $ID_user, return $classicToken;
					
					if(isset($classicToken))
					{
						if($key == $classicToken)
						{
							return $classicToken;
						}
						else
						{
							return false;
						}
					}
					else
					{
						return false;
					}
					return true;
				}
				else
				{
					return false;
				}
				
			}
			//return true;
		}
		else
		{
			return false;
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
	