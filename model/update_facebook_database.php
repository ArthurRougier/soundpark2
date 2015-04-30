<?php

	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/

	// on commence par voir quel type de user c'est dans le cas d'un inscription plus tard

	if(isset($_GET['curator']))
	{
		if($_GET['curator'] == 'true')
		{
			$curator = 2;
		}
		else
		{
			$curator = 1;
		}
		
	}

	if(isset($_GET['accessToken']) AND isset($_GET['tokenEpiration']) AND isset($_GET['facebookUserId']) AND isset($_GET['email']) AND isset($_GET['gender']) AND isset($_GET['lastName']) AND isset($_GET['firstName']))
	{
		include_once('../model/connect_sql.php');
		//on vient tester si l'user à déjà un compte ou si c'est sa première
		//$req = $bdd->prepare('SELECT facebook_id  FROM facebook_account WHERE email = ?') or die(print_r($bdd->errorInfo()));

		$req = $bdd->prepare('SELECT ID_user FROM facebook_account WHERE facebook_id = ?') or die(print_r($bdd->errorInfo()));
		$req->execute(array($_GET['facebookUserId']));
		if($result = $req->fetch()) // si le facebook id existe, sinon tester facebook
		{
			$ID_user = $result[0];

			//on commence par mettre à jour ses infos fb

			$req = $bdd->prepare('UPDATE facebook_account SET hashed_token=?, token_expires=?, token_date=NOW(), first_name=?, last_name=?, gender=? WHERE facebook_id = ?') or die(print_r($bdd->errorInfo()));
			$req->execute(array(
				sha1($_GET['accessToken']),
				$_GET['tokenEpiration'],
				$_GET['firstName'],
				$_GET['lastName'],
				$_GET['gender'],
				$_GET['facebookUserId']
			));
			setcookie('sessionType', 'facebook', time() + 31*24*3600, "/", null, false, true);
			setcookie('currentSession', $_GET['email'].'='.sha1($_GET['accessToken']), time() + 31*24*3600, "/", null, false, true);
			setcookie('current_user', $_GET['email'], time() + 31*24*3600, "/", null, false, false);

			//ok il à un compte fb. Y-a t-il un email renvoyé par l'API fb?
			if($_GET['email'] != 'unprecised') // si oui
			{

				//ensuite on vient tester si on a bien un email pour ce gars

				$req = $bdd->prepare('SELECT email FROM user WHERE ID = ?') or die(print_r($bdd->errorInfo()));
				$req->execute(array($ID_user));
				if($email = $req->fetch()) // si oui, on renvoit le message qui va bien
				{
					//echo(gettype($email[0]));
					if($email[0]=='') // gerer le cas ou il y a une string vide à la place de NULL
					{
						$req = $bdd->prepare('UPDATE user SET email=? WHERE ID = ?') or die(print_r($bdd->errorInfo()));
						$req->execute(array($_GET['email'], $ID_user));
						echo('successUpdateFbAndEmail='. sha1($_GET['accessToken']) . 'And session type = '. $_COOKIE['sessionType'] . 'And current session = '. $_COOKIE['currentSession']);
					}
					else
					{
						echo('successUpdateFb='. sha1($_GET['accessToken']) . 'And session type = '. $_COOKIE['sessionType'] . 'And current session = '. $_COOKIE['currentSession']);
					}
					
				}
				else // sinon, on vient renseigner son email avec l'email qu'a donné fb
				{
					$req = $bdd->prepare('UPDATE user SET email=? WHERE ID = ?') or die(print_r($bdd->errorInfo()));
					$req->execute(array($ID_user));
					echo('successUpdateFbAndEmail='. sha1($_GET['accessToken']) . 'And session type = '. $_COOKIE['sessionType'] . 'And current session = '. $_COOKIE['currentSession']);
				}
			}
			else // le mec n'a pas d'email dans la BDD en plus... On renvoit un message adapté
			{
				echo('successUpdateFbButNoEmail='. sha1($_GET['accessToken']) . 'And session type = '. $_COOKIE['sessionType'] . 'And current session = '. $_COOKIE['currentSession']);
			}
		}

		else if($_GET['email'] != 'unprecised') //Bon le mec n'a pas encore de FB. FB renvoit-il un email ?
		{	
			//Oui, du coup, on check si le mec à un compte SP
			$req = $bdd->prepare('SELECT email, ID  FROM user WHERE email = ?') or die(print_r($bdd->errorInfo()));
			$req->execute(array($_GET['email']));
			if($res = $req->fetch())  // si oui, on lui relie un nouveau compte fb à son compte SP
			{
				$ID_user = $res[1];
				$req = $bdd->prepare('INSERT INTO facebook_account(ID_user, facebook_id, hashed_token, token_expires, token_date, first_name, last_name, gender) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?)') or die(print_r($bdd->errorInfo()));
				$req->execute(array(
					$ID_user,
					$_GET['facebookUserId'],
					sha1($_GET['accessToken']),
					$_GET['tokenEpiration'],
					$_GET['firstName'],
					$_GET['lastName'],
					$_GET['gender']
				));
				setcookie('sessionType', 'facebook', time() + 31*24*3600, "/", null, false, true);
				setcookie('currentSession', $_GET['email'].'='.sha1($_GET['accessToken']), time() + 31*24*3600, "/", null, false, true);
				setcookie('current_user', $_GET['email'], time() + 31*24*3600, "/", null, false, false);
				echo('successAddFb='. sha1($_GET['accessToken']) . 'And session type = '. $_COOKIE['sessionType'] . 'And current session = '. $_COOKIE['currentSession']);
			}
			else // bon, on va lui créer un compte SP avec cet email inconnu pour le moment, edge case de la mort
			{
				//on lui crée un compte SP
				$req = $bdd->prepare('INSERT INTO user(email, type, subscription_date) VALUES (?, ?, NOW())') or die(print_r($bdd->errorInfo()));
				$req->execute(array($_GET['email'], $curator));
			
				
				// On vient récupérer son tout nouveau userId
				$req = $bdd->query('SELECT LAST_INSERT_ID() FROM user') or die(print_r($bdd->errorInfo()));
				$Id = $req->fetch();
				$ID_user = $Id[0];

				// et on lui relie son fb au petit malin
				
				$req = $bdd->prepare('INSERT INTO facebook_account(ID_user, facebook_id, hashed_token, token_expires, token_date, first_name, last_name, gender) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?)') or die(print_r($bdd->errorInfo()));
				$req->execute(array(
					$ID_user,
					$_GET['facebookUserId'],
					sha1($_GET['accessToken']),
					$_GET['tokenEpiration'],
					$_GET['firstName'],
					$_GET['lastName'],
					$_GET['gender']
				));
				setcookie('sessionType', 'facebook', time() + 31*24*3600, "/", null, false, true);
				setcookie('currentSession', $_GET['email'].'='.sha1($_GET['accessToken']), time() + 31*24*3600, "/", null, false, true);
				setcookie('current_user', $_GET['email'], time() + 31*24*3600, "/", null, false, false);
				echo('successAddNewUserButEmail='. sha1($_GET['accessToken']) . 'And session type = '. $_COOKIE['sessionType'] . 'And current session = '. $_COOKIE['currentSession']);
			}
			
		}
		else
		{
			//on lui crée un compte SP
			$req = $bdd->prepare('INSERT INTO user(type, subscription_date) VALUES (?, NOW())') or die(print_r($bdd->errorInfo()));
			$req->query(array($curator));
		
			
			// On vient récupérer son tout nouveau userId
			$req = $bdd->query('SELECT LAST_INSERT_ID() FROM user') or die(print_r($bdd->errorInfo()));
			$Id = $req->fetch();
			$ID_user = $Id[0];

			// et on lui relie son fb au petit malin
			
			$req = $bdd->prepare('INSERT INTO facebook_account(ID_user, facebook_id, hashed_token, token_expires, token_date, first_name, last_name, gender) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?)') or die(print_r($bdd->errorInfo()));
			$req->execute(array(
				$ID_user,
				$_GET['facebookUserId'],
				sha1($_GET['accessToken']),
				$_GET['tokenEpiration'],
				$_GET['firstName'],
				$_GET['lastName'],
				$_GET['gender']
			));
			setcookie('sessionType', 'facebook', time() + 31*24*3600, "/", null, false, true);
			setcookie('currentSession', $_GET['email'].'='.sha1($_GET['accessToken']), time() + 31*24*3600, "/", null, false, true);
			setcookie('current_user', $_GET['email'], time() + 31*24*3600, "/", null, false, false);
			echo('successAddNewUser='. sha1($_GET['accessToken']) . 'And session type = '. $_COOKIE['sessionType'] . 'And current session = '. $_COOKIE['currentSession']);
		}
	}

