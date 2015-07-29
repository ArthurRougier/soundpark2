<?php

	include_once("../model/connect_sql.php");

	$req=$bdd->prepare('INSERT INTO tags (ID_tags,name,type) VALUES(NULL,?,?)');
	$req->execute(array($_POST['tag_name'],$_POST['tag_type']));


	if ($_POST['source'] == "admin_genres") 
		{
			header('Location: ../view/admin_genres.php?message=successAdd');
		}
