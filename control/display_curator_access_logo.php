<?php

include_once ('../control/connect_sql.php');
$req=$bdd->prepare('SELECT type FROM user WHERE email=?');
$req->execute(array($_COOKIE['current_user']));
$resultat=$req->fetch();

if ($resultat[0]==2)
{
	echo '<div id="curator_link">';
	echo	'<a href="../view/curator_index.php"><img id="curator_link_img" src="../assets/pictures/audacity.png" style="cursor:pointer"></a>';
	echo '</div>';
}

?>