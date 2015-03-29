
function facebookLogin()
{
  FB.login(function(response){
    if (response.authResponse) 
    {
      console.log('Welcome!  Fetching your information.... ');
      FB.api('/me', function(response) 
      {
       console.log('Good to see you, ' + response.name + '.');
      });
      updateFacebookDb();
    } 
    else 
    {
     console.log('User cancelled login or did not fully authorize.');
    }
  }, 
  {
    scope: 'publish_actions, email, user_friends', 
    return_scopes: true
  });
} 


function updateFacebookDb()
{
            console.log('0');

  FB.getLoginStatus(function(response)
  {
          console.log('1');

    if (response.status === 'connected') 
    {
      console.log('updateFacebookDatabase, connected');
      var accessToken = response.authResponse.accessToken;
      var tokenEpiration = response.authResponse.expireIn;
      var facebookUserId = response.authResponse.userID;
      var email = 'unprecised';
      var gender = 'unprecised';
      var firstName = 'unprecised';
      var lastName = 'unprecised';
      FB.api("/"+facebookUserId, function (response){
            if (response && !response.error) 
            {
              console.log('3');
              email = response.email;
              gender = response.gender;
              firstName = response.first_name;
              lastName = response.last_name;

              xhr = new XMLHttpRequest();
              xhr2 = new XMLHttpRequest();

              console.log('http://localhost:8888/' + 'model/update_facebook_database.php?accessToken='+accessToken+'&tokenEpiration='+tokenEpiration+'&facebookUserId='+facebookUserId+'&email='+email+'&gender='+gender+'&firstName='+firstName+'&lastName='+lastName);
              xhr.open('GET', '../model/update_facebook_database.php?accessToken='+accessToken+'&tokenEpiration='+tokenEpiration+'&facebookUserId='+facebookUserId+'&email='+email+'&gender='+gender+'&firstName='+firstName+'&lastName='+lastName); // On envoi la purée
              xhr.onreadystatechange = function() 
              { // On gère ici une requête asynchrone

                    if(xhr.readyState == 4 && xhr.status == 200) 
                    { // Si le fichier est chargé sans erreur 
                        var xhrCorrected = xhr.responseText.split("=");
                        if(xhrCorrected[0] == 'successUpdateFb') 
                        {
                          //console.log(xhrCorrected[1]);
                          createFacebookCookie(xhrCorrected[1], email);
                        }
                        else if(xhrCorrected[0] == 'successAddFb') 
                        {
                          //console.log(xhr.responseText);
                          createFacebookCookie(xhrCorrected[1], email);
                        }
                        else if(xhrCorrected[0] == 'successAddNewUser') 
                        {
                          //console.log(xhr.responseText);
                          createFacebookCookie(xhrCorrected[1], email);

                        }
                        else
                        {
                          console.log('pas la bonne reponse ajax');
                          xhr2.open('GET', '../control/mailchimpUserNewSubscribe.php?user_email='+email); // On envoi la purée
                          xhr2.send(null); // La requête est prête, on envoie tout !
                        }
                    }
              };
              xhr2.onreadystatechange = function() 
              { // On gère ici une requête asynchrone

                    if(xhr2.readyState == 4 && xhr2.status == 200) 
                    { // Si le fichier est chargé sans erreur 
                        console.log('welcome :)');
                    }
              };
              xhr.send(null); // La requête est prête, on envoie tout !
            }
          }
      );
      
    }
    else
    {
      console.log('updateFacebookDatabase, not connected');
    }
  });
}

function createFacebookCookie(fbTokenHash, email)
{
  var now = new Date();
  var time = now.getTime();
  time += 3600 * 1000 * 24 * 30;
  now.setTime(time);
  document.cookie = 'idType=facebook; expires=' + now.toUTCString() +'; path=/';
  console.log(getCookie('idType'));
  console.log(now);
  console.log(now.toUTCString());
  document.cookie = 'fbTokenHash='+fbTokenHash+'; expires=' + now.toUTCString() +'; path=/';
  console.log(getCookie('fbTokenHash'));
  document.cookie = 'email='+email+'; expires=' + now.toUTCString() +'; path=/';
  console.log(getCookie('email'));
}

  