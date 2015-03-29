<?php
	if(isset($_GET['pwd']))
	{
		if($_GET['pwd'] != $password[0])
		{
			header('Location: ../view/landing.php');
		}
	}
	else
	{
		header('Location: ../view/landing.php');
	}