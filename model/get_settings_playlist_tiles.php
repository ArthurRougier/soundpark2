<?php
	
	if(isset($_COOKIE['current_user']))
	{
		$req = $bdd->query('SELECT ID, date_start, date_end FROM playlist WHERE date_end <= NOW() ORDER BY ID DESC');
	}


	