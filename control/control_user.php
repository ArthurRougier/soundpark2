<?php
	if (isset($_GET['curatorId'])) 
	{
		include_once('../model/find_curator_transition_done.php');
		if($res = $req->fetch()) 
		{
			if ($res[0]==0)
			{
				header('Location: ../view/transition_curator_account.php?curatorId='.$_GET['curatorId']);
			}
			else
			{
				 header('Location: ../view/curator_index.php');
			}
		}
	}

	if(sessionTestFacebook())
	{
		//echo(sessionTestFacebook());
	}
	else
	{
		if(sessionTestClassic())
		{
			//echo(sessionTestClassic());
		}
		else
		{
			if(isset($_GET['pwd']))		
			{
				include_once('../model/find_user_email.php');
				if($res = $req->fetch()) 
				{
					$req = $bdd->prepare('SELECT password FROM user WHERE email = ?');
					$req->execute(array($_GET['pwd']));
					if($exists = $req->fetch()) // si le password existe, sinon tester facebook
			        {
			        	if($exists[0] != '') // tester le cas de la string vide
			        	{
			        		header('Location: /login.php?source=/view/frommail.php');
			        	}
			        	else
			        	{
			        		$req = $bdd->prepare('SELECT EXISTS(SELECT facebook_account.ID FROM facebook_account, user WHERE facebook_account.ID_user = user.ID AND user.email = ?)');
				        	$req->execute(array($_GET['pwd']));
							$exists = $req->fetch();
				        	if($exists[0]) // si le password existe, sinon tester facebook
				        	{
				        		header('Location: /login.php?source=/view/frommail.php');
				        	}
				        	else
				        	{
				        		header('Location: ../transition_password.php?pwd='.$_GET['pwd']);
				        	}
			        	}
			        }  	
			        else
			        {
			        	$req = $bdd->prepare('SELECT EXISTS(SELECT facebook_account.ID FROM facebook_account, user WHERE facebook_account.ID_user = user.ID AND user.email = ?)');
			        	$req->execute(array($_GET['pwd']));
						$exists = $req->fetch();
			        	if($exists[0]) // si le password existe, sinon tester facebook
			        	{
			        		//ok
			        	}
			        	else
			        	{
			        		header('Location: ../transition_password.php?pwd='.$_GET['pwd']);
			        	}
			        }
				}

			}
			else
			{
				$url = $_SERVER['REQUEST_URI'];
				header('Location: ../login.php?source='.$url);
			}
			
		}
	}
