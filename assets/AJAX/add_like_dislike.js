function addLike(songId)
{

    if(songId)
    {
        var currentUser = getCookie('current_user') //user.email
        //console.log('like current user = '+currentUser);

        xhrAddLike = new XMLHttpRequest();
        xhrAddLike2 = new XMLHttpRequest();
        
        xhrAddLike.open('GET', '../model/get_like_state.php?songId='+songId+'&currentUser='+currentUser); // On test si le son a déjà été liké par currentUser
        xhrAddLike.onreadystatechange = function() 
        { // On gère ici une requête asynchrone

            if(xhrAddLike.readyState == 4 && xhrAddLike.status == 200) 
            { // Si le fichier est chargé sans erreur
                //console.log(xhrAddLike.responseText);
                var likeStamp = document.getElementById("plus_one");
                var dislikeStamp = document.getElementById("minus_one");
                
                if(xhrAddLike.responseText != 'TRUE') // Si le son n'est pas déjà liké par currentUser
                {
                    //g.appear();
                    //console.log(xhrAddLike.responseText);
                    xhrAddLike2.open('GET', '../control/add_like.php?songId='+songId+'&currentUser='+currentUser); // fichier à modifier: tester si le son est disliké est si oui, effacer en meme temps le dislike
                    xhrAddLike2.send(null);
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
                    //console.log(xhrAddLike.responseText);
                    xhrAddLike2.open('GET', '../control/remove_like.php?songId='+songId+'&currentUser='+currentUser); // fichier à modifier: tester si le son est disliké est si oui, effacer en meme temps le dislike
                    xhrAddLike2.send(null);
                    likeStamp.style.background="url(http://soundpark.fm/assets/pictures/heart_like.png)";
                    likeStamp.style.backgroundSize="contain";
                    likeStamp.style.backgroundRepeat="no-repeat";
                    dislikeStamp.style.background="url(http://soundpark.fm/assets/pictures/cross_dislike.png)";
                    dislikeStamp.style.backgroundSize="contain";
                    dislikeStamp.style.backgroundRepeat="no-repeat";
                }
            }
        };

        xhrAddLike2.onreadystatechange = function() 
        { // On gère ici une requête asynchrone

            if(xhrAddLike2.readyState == 4 && xhrAddLike.status == 200) 
            { // Si le fichier est chargé sans erreur
                //console.log(xhrAddLike2.responseText);
            }
        };


        xhrAddLike.send(null); // La requête est prête, on envoie tout !
    }
    

}

function addDislike(songId)
{
    var currentUser = getCookie('current_user'); //user.email
    //console.log('Dislike current user = '+currentUser);

	xhrAddDislike = new XMLHttpRequest();
	xhrAddDislike2 = new XMLHttpRequest();

	xhrAddDislike.open('GET', '../model/get_dislike_state.php?songId='+songId+'&currentUser='+currentUser);
	xhrAddDislike.onreadystatechange = function() 
	{ // On gère ici une requête asynchrone

        if(xhrAddDislike.readyState == 4 && xhrAddDislike.status == 200) 
        { // Si le fichier est chargé sans erreur
            //console.log(xhrAddDislike.responseText);
            var likeStamp = document.getElementById("plus_one");
            var dislikeStamp = document.getElementById("minus_one");
            if(xhrAddDislike.responseText != 'TRUE')
            {
            	xhrAddDislike2.open('GET', '../control/add_dislike.php?songId='+songId+'&currentUser='+currentUser); // fichier à modifier: tester si le son est disliké est si oui, effacer en meme temps le dislike
            	xhrAddDislike2.send(null);
            	dislikeStamp.style.background="url(http://soundpark.fm/assets/pictures/cross_dislike.png)";
                dislikeStamp.style.backgroundSize="cover";
                likeStamp.style.background="url(http://soundpark.fm/assets/pictures/heart_like.png)";
                likeStamp.style.backgroundSize="cover";
                //nextTrack();
                $('#nextHandler').trigger('click');
        	}
        	//else if(dislikeStamp.style.display!="block" && likeStamp.style.display=="block")
            else 
    		{
				//console.log('disnull');
                xhrAddDislike2.open('GET', '../control/remove_dislike.php?songId='+songId+'&currentUser='+currentUser); // fichier à modifier: tester si le son est disliké est si oui, effacer en meme temps le dislike
                xhrAddDislike2.send(null);
                dislikeStamp.style.background="url(http://soundpark.fm/assets/pictures/cross_dislike.png)";
                dislikeStamp.style.backgroundSize="cover";
                likeStamp.style.background="url(http://soundpark.fm/assets/pictures/heart_like.png)";
                likeStamp.style.backgroundSize="cover";
    		}
        }
    };

	xhrAddDislike2.onreadystatechange = function() 
	{ // On gère ici une requête asynchrone

        if(xhrAddDislike2.readyState == 4 && xhrAddDislike2.status == 200) 
        { // Si le fichier est chargé sans erreur
        	//console.log(xhrAddDislike2.responseText);
        }
    };


    xhrAddDislike.send(null); // La requête est prête, on envoie tout !

}