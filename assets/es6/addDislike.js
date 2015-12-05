function addDislike(songId)
{
    var currentUser = getCookie('current_user'); //user.email
    //console.log('Dislike current user = '+currentUser);

    var xhrAddDislike = new XMLHttpRequest();
    var xhrAddDislike2 = new XMLHttpRequest();

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

module.exports = addDislike;