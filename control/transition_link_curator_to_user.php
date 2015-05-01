<?php
	include_once ('../model/connect_sql.php');
	
	if(isset($_POST['user_email']))
	{
		$_POST['user_email'] = htmlspecialchars($_POST['user_email']);
		if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['user_email']))
		{
			$req = $bdd->prepare('SELECT id FROM user WHERE email=?');
			$req->execute(array($_POST['user_email']));
			$resultat = $req->fetch();

			if ($resultat[0])
			{
				$type='2';
				$req = $bdd->prepare('UPDATE user SET type=? WHERE id=?');
				$req->execute(array($type,$resultat[0]));

				$req = $bdd->prepare('UPDATE curator SET ID_user=? WHERE ID=?');
				$req->execute(array($resultat[0],$_GET['curatorId']));
				
				$req = $bdd->prepare('SELECT EXISTS(SELECT password FROM user WHERE email = ?)');
				$req->execute(array($_POST['user_email']));
				$exists = $req->fetch();
				if ($exists[0])
				{
					header('Location: ../view/frommail.php');
				}
				else
				{
					header('Location: ../transition_password.php?pwd='.$_POST['user_email']);
				}
			}
			else
			{
				//Nous ne vous trouvons pas dans la base de données
				header("Location: ../view/transition_curator_account.php?curatorId=".$_GET['curatorId']."&message=We can't find your email. Are you sure you typed the good one?");
			}
		}
		else
		{
			//rediriger avec une wrong adress
			header("Location: ../view/transition_curator_account.php?curatorId=".$_GET['curatorId']."&message=Wrong email adress. Please try again!");
		}
	}
	else
	{
		//Pas de mail transmis
		header("Location: ../view/transition_curator_account.php?curatorId=".$_GET['curatorId']."&message=Wrong email adress. Please try again!");
	}
	
?>