<?php

	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);


	switch ($lang)
	{
		case "fr":
		    //echo "PAGE FR";
		    require($_SERVER['DOCUMENT_ROOT'].'/control/fr_lang.php');//include check session FR
		    break;
		case "en":
		    //echo "PAGE EN";
		    require($_SERVER['DOCUMENT_ROOT'].'/control/en_lang.php');
		    break;        
		default:
		    //echo "PAGE EN - Setting Default";
		   require($_SERVER['DOCUMENT_ROOT'].'/control/en_lang.php');//include EN in all other cases of different lang detection
		    break;
	}