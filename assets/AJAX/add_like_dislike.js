function addLike()
{
    console.log('coucou');

	var trackId = getCurrentTrackId(); // Renvoit le TrackID en lecture, fonction dans player2.js
    var currentUser = getCookie('current_user') //user.email

	xhr = new XMLHttpRequest();
	xhr2 = new XMLHttpRequest();
    
	xhr.open('GET', '../model/get_like_state.php?trackId='+trackId+'&currentUser='+currentUser); // On test si le son a déjà été liké par currentUser
	xhr.onreadystatechange = function() 
	{ // On gère ici une requête asynchrone

        if(xhr.readyState == 4 && xhr.status == 200) 
        { // Si le fichier est chargé sans erreur
            console.log(xhr.responseText);
            var likeStamp = document.getElementById("plus_one");
            var dislikeStamp = document.getElementById("minus_one");
            
            if(xhr.responseText != 'TRUE') // Si le son n'est pas déjà liké par currentUser
            {
                //g.appear();
                console.log(xhr.responseText);
            	xhr2.open('GET', '../control/add_like.php?trackId='+trackId+'&currentUser='+currentUser); // fichier à modifier: tester si le son est disliké est si oui, effacer en meme temps le dislike
                xhr2.send(null);
            	likeStamp.style.background="url(http://soundpark.fm/assets/pictures/heart_like_pressed.png)";
                likeStamp.style.backgroundSize="contain";
                likeStamp.style.backgroundRepeat="no-repeat";
                dislikeStamp.style.background="url(http://soundpark.fm/assets/pictures/cross_dislike.png)";
                dislikeStamp.style.backgroundSize="contain";
                dislikeStamp.style.backgroundRepeat="no-repeat";
        	}
            else
            {
                //g.appear();
                //faire une animation de hover des reseau sociaux
                console.log(xhr.responseText);
                xhr2.open('GET', '../control/remove_like.php?trackId='+trackId+'&currentUser='+currentUser); // fichier à modifier: tester si le son est disliké est si oui, effacer en meme temps le dislike
                xhr2.send(null);
                likeStamp.style.background="url(http://soundpark.fm/assets/pictures/heart_like.png)";
                likeStamp.style.backgroundSize="contain";
                likeStamp.style.backgroundRepeat="no-repeat";
                dislikeStamp.style.background="url(http://soundpark.fm/assets/pictures/cross_dislike.png)";
                dislikeStamp.style.backgroundSize="contain";
                dislikeStamp.style.backgroundRepeat="no-repeat";
            }
        }
    };

	xhr2.onreadystatechange = function() 
	{ // On gère ici une requête asynchrone

        if(xhr2.readyState == 4 && xhr.status == 200) 
        { // Si le fichier est chargé sans erreur
            console.log(xhr2.responseText);
        }
    };


    xhr.send(null); // La requête est prête, on envoie tout !

}

function addDislike()
{
	var trackId = getCurrentTrackId(); // Renvoit le TrackID en lecture, fonction dans player2.js
    var currentUser = getCookie('current_user'); //user.email

	xhr = new XMLHttpRequest();
	xhr2 = new XMLHttpRequest();

	xhr.open('GET', '../model/get_dislike_state.php?trackId='+trackId+'&currentUser='+currentUser);
	xhr.onreadystatechange = function() 
	{ // On gère ici une requête asynchrone

        if(xhr.readyState == 4 && xhr.status == 200) 
        { // Si le fichier est chargé sans erreur
            console.log(xhr.responseText);
            var likeStamp = document.getElementById("plus_one");
            var dislikeStamp = document.getElementById("minus_one");
            if(xhr.responseText != 'TRUE')
            {
            	xhr2.open('GET', '../control/add_dislike.php?trackId='+trackId+'&currentUser='+currentUser); // fichier à modifier: tester si le son est disliké est si oui, effacer en meme temps le dislike
            	xhr2.send(null);
            	dislikeStamp.style.background="url(http://soundpark.fm/assets/pictures/cross_dislike.png)";
                dislikeStamp.style.backgroundSize="cover";
                likeStamp.style.background="url(http://soundpark.fm/assets/pictures/heart_like.png)";
                likeStamp.style.backgroundSize="cover";
                nextTrack();
        	}
        	//else if(dislikeStamp.style.display!="block" && likeStamp.style.display=="block")
            else 
    		{
				console.log('disnull');
                xhr2.open('GET', '../control/remove_dislike.php?trackId='+trackId+'&currentUser='+currentUser); // fichier à modifier: tester si le son est disliké est si oui, effacer en meme temps le dislike
                xhr2.send(null);
                dislikeStamp.style.background="url(http://soundpark.fm/assets/pictures/cross_dislike.png)";
                dislikeStamp.style.backgroundSize="cover";
                likeStamp.style.background="url(http://soundpark.fm/assets/pictures/heart_like.png)";
                likeStamp.style.backgroundSize="cover";
    		}
        }
    };

	xhr2.onreadystatechange = function() 
	{ // On gère ici une requête asynchrone

        if(xhr2.readyState == 4 && xhr2.status == 200) 
        { // Si le fichier est chargé sans erreur
        	console.log(xhr2.responseText);
        }
    };


    xhr.send(null); // La requête est prête, on envoie tout !

}