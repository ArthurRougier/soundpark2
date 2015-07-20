<?php

	include_once("../model/connect_sql.php");


	$req=$bdd->prepare('SELECT ID, Id_Song, mail FROM automatic_next');
	$req->execute();

	$compteur=0;
	$supprime=0;

	while ($liste_automatic=$req->fetch())

{
	//echo 'l ID de automatic next qui va etre traité est '.$liste_automatic[0];

	if ($liste_automatic[2]!=NULL AND is_numeric($liste_automatic[2])==false) 
	{
		//on va chercher l'id correspondant au mail

		$req2=$bdd->prepare('SELECT id FROM user WHERE email=?');
		$req2->execute(array($liste_automatic[2]));
		$id_du_mail=$req2->fetch();


		//echo 'l ID du mail à insérer est '.$id_du_mail[0];

		//on le remplace dans automatic next
		$req3=$bdd->prepare('UPDATE automatic_next SET mail=? WHERE ID=?');
		$req3->execute(array($id_du_mail[0],$liste_automatic[0]));

		$compteur=$compteur+1;
	}
	elseif ($liste_automatic[2]==NULL)
	{
		$req4=$bdd->prepare('DELETE FROM automatic_next WHERE ID=?');
		$req4->execute(array($liste_automatic[0]));
		$supprime=$supprime+1;
	}

}

echo 'Nombre de lignes traitées : '.$compteur;
echo 'Nombre de lignes supprimees : '.$supprime;

?>
