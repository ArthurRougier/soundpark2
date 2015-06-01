

<?php

include_once ('../control/connect_sql.php');
$req=$bdd->prepare('SELECT type FROM user WHERE ID=?');
$req->execute(array($_COOKIE['current_user']));
$resultat=$req->fetch();
//echo $_COOKIE['current_user'];
//Prévoir et tester si onboarded

include_once ('../model/get_user_complete_name.php'); // gives $completeName
include_once ('../model/get_user_facebook_picture.php');

?>

<div class="container-dropdown">
  <ul>
    <li class="dropdown">
      <input type="checkbox" id="dropdownCheckbox" />

      <!-- !!!! Do photo fb catcher / div lettersy -->

	  <a href="#" data-toggle="dropdown">
	  <?php 
      	if(strlen($completeName) > 13)
      	{
      		echo(mb_substr($completeName, 0, 13) . '...');
      	}
      	else
      	{
      		echo($completeName);
      	} 
      	if(isset($pictureUrl) && strlen($pictureUrl) > 10)
      	{
      		echo('<img id="toggler" src="'.$pictureUrl.'"/>');
      	}
      	else
      	{
      		echo('<div id="togglerDiv">'.ucfirst(mb_substr($completeName, 0, 1)).'</div>');
      	}
  		?>

	
  		</a>
      	<ul class="account-dropdown-menu">
      	<?php 
      	if ($resultat[0]==2)
		{
			echo '<li><a href="../view/curator_index.php">Curator space</a></li>';
		}
		else
		{
			echo '<li><a href="#" onclick="curatorPopup()">Become a curator</a></li>';
		}
		?> 
        <li><a href="../view/settings.php">My account</a></li>
        <li><a href="../control/logout.php">Log out</a></li>
      </ul>
    </li>
  </ul>
</div>

<?php
/*


*/

