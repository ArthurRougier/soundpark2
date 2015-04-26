<?php
	if(sessionTestFacebook() OR sessionTestClassic())
	{
		header('Location: ../view/frommail.php');
	}
	else
	{
		//echo('kjoh');
	}
