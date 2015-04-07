<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	if(isset($_GET['accessToken']) AND isset($_GET['tokenEpiration']) AND isset($_GET['facebookUserId']) AND isset($_GET['email']) AND isset($_GET['gender']) AND isset($_GET['lastName']) AND isset($_GET['firstName']))
	{
		include_once('../model/connect_sql.php');
		//on vient tester si l'user à déjà un compte ou si c'est sa première
		$req = $bdd->prepare('SELECT email, ID  FROM user WHERE email = ?') or die(print_r($bdd->errorInfo()));
		$req->execute(array($_GET['email']));
		if($res = $req->fetch()) 
		{
			//ok, le gars à un compte soundpark. As-t-il aussi déjà un compte facebook attaché ?

			$userID = $res[1];
			$req = $bdd->prepare('SELECT facebook_id  FROM facebook_account WHERE ID_user = ?') or die(print_r($bdd->errorInfo()));
			$req->execute(array($userID));
			if($resBis = $req->fetch())
			{
				//OUI. Donc on met juste à jour ses infos
				$req = $bdd->prepare('UPDATE facebook_account SET hashed_token=?, token_expires=?, token_date=NOW(), first_name=?, last_name=?, gender=? WHERE facebook_id = ?') or die(print_r($bdd->errorInfo()));
				$req->execute(array(
					sha1($_GET['accessToken']),
					$_GET['tokenEpiration'],
					$_GET['firstName'],
					$_GET['lastName'],
					$_GET['gender'],
					$resBis[0]
				));
				setcookie('sessionType', 'facebook', time() + 31*24*3600, "/", null, false, true);
				setcookie('currentSession', $_GET['email'].'='.sha1($_GET['accessToken']), time() + 31*24*3600, "/", null, false, true);
				echo('successUpdateFb='. sha1($_GET['accessToken']) . 'And session type = '. $_COOKIE['sessionType'] . 'And current session = '. $_COOKIE['currentSession']);
				
			}
			else
			{
				//Non, on lui en crée un
				$req = $bdd->prepare('INSERT INTO facebook_account(ID_user, hashed_token, token_expires, token_date, first_name, last_name, gender) VALUES (?, ?, ?, NOW(), ?, ?, ?)') or die(print_r($bdd->errorInfo()));
				$req->execute(array(
					$userID,
					sha1($_GET['accessToken']),
					$_GET['tokenEpiration'],
					$_GET['firstName'],
					$_GET['lastName'],
					$_GET['gender']
				));
				setcookie('sessionType', 'facebook', time() + 31*24*3600, "/", null, false, true);
				setcookie('currentSession', $_GET['email'].'='.sha1($_GET['accessToken']), time() + 31*24*3600, "/", null, false, true);
				echo('successAddFb='. sha1($_GET['accessToken']) . 'And session type = '. $_COOKIE['sessionType'] . 'And current session = '. $_COOKIE['currentSession']);
			}
	     	
		}
		else
		{
			
			//oh merde, le gars n'as pas encore de compte SP. Il faut lui en créer un.

			//on lui crée un compte SP
			$req = $bdd->prepare('INSERT INTO user(email, type, subscription_date) VALUES (?, "1", NOW())') or die(print_r($bdd->errorInfo()));
			$req->execute(array($_GET['email']));
			
			// On vient récupérer son tout nouveau userId
			$req = $bdd->prepare('SELECT ID  FROM user WHERE email = ?') or die(print_r($bdd->errorInfo()));
			$req->execute(array($_GET['email']));
			$Id = $req->fetch();
			$userId = $Id[0];
			
			$req = $bdd->prepare('INSERT INTO facebook_account(ID_user, facebook_id, hashed_token, token_expires, token_date, first_name, last_name, gender) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?)') or die(print_r($bdd->errorInfo()));
			$req->execute(array(
				$userId,
				$_GET['facebookUserId'],
				sha1($_GET['accessToken']),
				$_GET['tokenEpiration'],
				$_GET['firstName'],
				$_GET['lastName'],
				$_GET['gender']
			));
			setcookie('sessionType', 'facebook', time() + 31*24*3600, "/", null, false, true);
			setcookie('currentSession', $_GET['email'].'='.sha1($_GET['accessToken']), time() + 31*24*3600, "/", null, false, true);
			echo('successAddNewUser='. sha1($_GET['accessToken']) . 'And session type = '. $_COOKIE['sessionType'] . 'And current session = '. $_COOKIE['currentSession']);
		}

	}