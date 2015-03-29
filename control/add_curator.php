<?php

	include_once('../model/connect_sql.php');


//if(isset($_POST['pseudo']) AND isset($_POST['genre']) AND isset($_POST['link']))
if(isset($_POST['pseudo']) AND isset($_POST['genre']) AND isset($_POST['link']) AND isset($_FILES['avatar']) AND $_FILES['avatar']['error'] == 0)
{

	//script avatar
	// Testons si le fichier n'est pas trop gros
    if ($_FILES['avatar']['size'] <= 1000000)
    {

            // Testons si l'extension est autorisée
            $infosfichier = pathinfo($_FILES['avatar']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
            if (in_array($extension_upload, $extensions_autorisees))
            {
            		
                    // On peut valider le fichier et le stocker définitivement
            		$avatarPath = ('../assets/pictures/uploaded_avatars/' . $_POST['pseudo'] . '.' . $extension_upload);
                    $req = $bdd->prepare('INSERT INTO curator(genre, pseudo, avatar_url, link) VALUES(:genre, :pseudo, :avatar_url, :link)');
					$req->execute(array(
						'genre' => $_POST['genre'],
						'pseudo' => $_POST['pseudo'],
						'avatar_url' => $avatarPath,
						'link' => $_POST['link']
						));
					//print_r('lolo');
					$test =   move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarPath);
					if($test)
					{
						header('Location: ../view/create_curator.php?addCurator=TRUE');
					}
					else
					{
						echo($_FILES['userfile']['error']);
						//print_r('nono');
					}

						
					
            }
            else
            {
            	//print_r('nini');
            	echo($_FILES['avatar']['name']);
            	echo('extension not supported for profiles pics');
            }
    }
    else
    {
    	echo ('trop gros, coquin');
    }

	
}

else
{
	echo('poulpe');
}
