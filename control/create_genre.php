<?php

	include_once("../model/connect_sql.php");

	$req=$bdd->prepare('INSERT INTO genres (ID_genre,name) VALUES(NULL,?)');
	$req->execute(array($_POST['genre_name']));


	if ($_POST['source'] == "admin_genres") 
		{
			header('Location: ../view/admin_genres.php?message=successAdd');
		}
