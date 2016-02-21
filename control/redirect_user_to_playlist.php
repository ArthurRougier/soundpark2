<?php
	if(sessionTestFacebook() OR sessionTestClassic())
	{
		header('Location: ../radio');
	}
	else
	{
		//echo('kjoh');
	}
