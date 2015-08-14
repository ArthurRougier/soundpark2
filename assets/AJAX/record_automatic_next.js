function record_automatic_next()
{
    //console.log('coucou');

	var trackId = songTable[position - 1]; 
    //console.log(trackId);
    var currentUser = getCookie('current_user') //user.email

	xhr = new XMLHttpRequest();
    
	xhr.open('GET', '../control/record_automatic_next.php?trackId='+trackId+'&currentUser='+currentUser); // On test si le son a déjà été liké par currentUser
	
    /*xhr.onreadystatechange = function() 
	{ // On gère ici une requête asynchrone

        if(xhr.readyState == 4 && xhr.status == 200) 
        { // Si le fichier est chargé sans erreur
            //console.log(xhr.responseText);
            var likeStamp = document.getElementById("plus_one");
            var dislikeStamp = document.getElementById("minus_one");
        }
    };*/


    xhr.send(null); // La requête est prête, on envoie tout !

}
