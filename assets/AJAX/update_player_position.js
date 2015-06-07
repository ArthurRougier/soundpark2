function updatePlayerPosition(trackId){
    document.getElementById('share_url').innerHTML = ("http://soundpark.fm/view/fromshare.php?trackId=" + trackId); // On met à jour le lien share aussi au passage
	xhrUPP = new XMLHttpRequest();
    //console.log(trackId);
    
    var urlPlayerPosition = '../control/display_player_position.php?trackId='+trackId;
    if(getParameterByName('playlistId') > 0)
    {
        urlPlayerPosition = urlPlayerPosition + '&playlistId=' + getParameterByName('playlistId');
    }
    //console.log(urlPlayerPosition);
	xhrUPP.open('GET', urlPlayerPosition);


    xhrUPP.addEventListener('readystatechange', function() 
    {
        if (xhrUPP.readyState == 4 && xhrUPP.status == 200) 
        {
            ////console.log(xhrUPP.responseText);
            document.getElementById('player_position').innerHTML = xhrUPP.responseText; // Et on affiche !
        }
        else if (xhrUPP.readyState == 4 && xhrUPP.status != 200) 
        { // En cas d'erreur !

        //console.log('Une erreur est survenue !\n\nCode :' + xhrUPP.status + '\nTexte : ' + xhrUPP.statusText);

        }
        else if (xhrUPP.readyState != 4)
        { // En cas d'erreur !

            //console.log(xhrUPP.readyState);
            document.getElementById('player_position').innerHTML = 2; // Et on affiche !

        }
    }, false);


    xhrUPP.send(null); // La requête est prête, on envoie tout !
    //console.log('sent');


}