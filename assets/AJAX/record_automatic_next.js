function record_automatic_next(songId)
{
    $.ajax({
      url: "../control/record_automatic_next.php?songId="+trackId,
      cache: false,
      
      success: function(trackListEntry) {
        console.log('autoNext registered');
      }.bind(this),

      error: function(xhr, status, err) {
        console.error("../control/record_automatic_next.php?songId=", status, err.toString());
      }.bind(this)
    });


	var xhr = new XMLHttpRequest();
    
	xhr.open('GET', '../control/record_automatic_next.php?songId='+trackId+'&currentUser='+currentUser); // On test si le son a déjà été liké par currentUser
	
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
