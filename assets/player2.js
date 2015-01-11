
/* UI part of player : SLIDER */

$(document).ready(function(){
	s = new slider("#galerie");
});



var slider = function(id){
	var self=this;
	this.div = $(id);
	this.slider = this.div.find(".slider");
	this.lengthCach = this.div.width();
	console.log('LengthCachà : '+this.lengthCach);
	this.largeur=0;
	this.div.find(".sound_box").each(function(){
		self.largeur+= parseInt($(this).css("width"));
		self.largeur+=parseInt($(this).css("margin-left"));
		self.largeur+=parseInt($(this).css("margin-right"));
		console.log('Inlargeur : '+self.largeur);
	});
	console.log('largeur : '+this.largeur);
	this.prec = this.div.find('.previous');
	this.suiv = this.div.find('.next');
	this.precParent = this.div.find('#left_arrow');
	this.suivParent = this.div.find('#right_arrow');
	//alert(this.suiv.html());
	this.saut=(this.lengthCach)+4;
	this.steps = Math.ceil(this.largeur/this.saut);
	//alert(this.steps);
	this.courant = 0;
	this.prec.hide();
	this.precParent.hide();

	this.slideRight = function(){
			if(self.courant<(self.steps-1)){
			self.courant++;
			self.slider.animate({
				left:-self.courant*self.saut
			},400);
			/*if(self.courant==(self.steps-1))
			{
				self.suiv.fadeOut();
				self.suivParent.fadeOut();
			}*/
			self.prec.fadeIn();
			self.precParent.fadeIn();
		}
	}
	this.slideLeft = function(){
		if(self.courant>0)
		{
			self.courant--;
			self.slider.animate({
				left:-self.courant*self.saut
			},400);
			/*if(self.courant==(self.steps-2))
			{
				self.suiv.fadeIn();
				self.suivParent.fadeIn();
			}*/
			if(self.courant==0)
			{
				self.prec.fadeOut();
				self.precParent.fadeOut();
			}
		}
		else
		{
			//alert("fini");
		}
	}

}


/* Audio part of player */


SC.initialize({

    client_id: "17f3a8c69cb36c955df82f908611e27e"
});

var onPlay = false;
var position = 0;

var trackIds = document.getElementsByClassName('trackIds');
var songTable = [];


for(var i = 0 ; i<trackIds.length ; i++)
{
	songTable[i] = trackIds[i].innerHTML;
}
//alert(songTable.length);

var currentTrack;
updateCurrentTrack(songTable[0]);
getLikeState();
var coverWidth = document.getElementById('sound_cover1').offsetWidth;


if(window.matchMedia("(max-width: 480px)").matches)
{
	document.getElementById('play').value='play';
}

$('#play').click(function() //Gestion du bouton de lecture/pause en toggle
{
	if ($(this).val() == "play") 
	{
		$(this).val("pause");
		playCurrentTrack();
		if(!onPlay)
		{
			onPlay = true;
		} 
	}
	else {
		$(this).val("play");
		pauseCurrentTrack();
	}
});


function updateCurrentTrack(trackId) 
{
	
	SC.stream("/tracks/"+trackId,{onfinish: function(){ 
			nextTrack();
			mixpanel.track("Automatic Next", {
				"fullUrl": window.location.href,
				"TrackId": trackId
			});
		}}, function(sound){
		
		currentTrack = sound;
		if ($('#play').val() == "pause") 
		{	

			if(window.matchMedia("(min-width: 480px)").matches )
			{
				onPlay=true;
  				currentTrack.play();	
			}
			else if (document.getElementById('play').value==='pause')
			{
				onPlay=true;
  				currentTrack.play();
			}
				
		}
		

		setTimeout(function() { // on lui dit ici d'attendre un peu que le son se lance avant de lancer la detection d'évènements de position, sinon duration marche pas
			
			var playerPosition = document.getElementById('player_position').innerHTML;
			for(var index = 1 ; index < (currentTrack.durationEstimate/1000) ; index++)
			{
				currentTrack.onPosition(index*1000, function(eventPosition)
				{
					//console.log(this.id+' reached '+eventPosition);

					/* On change le formatage du compteur temps ici pour afficher mn:sec */

					var minutes = (eventPosition / 60000) | (0);
					var seconds = eventPosition/1000 - minutes * 60;
					if(seconds < 10)
					{
						seconds = '0'+seconds;
					}
					if(!minutes)
					{
						document.getElementById('track_position'+ playerPosition).innerHTML = seconds;
					}
					else
					{
						document.getElementById('track_position'+ playerPosition).innerHTML = minutes + ':' + seconds;
					}

					/* END On change le formatage du compteur temps ici pour afficher mn:sec */

					/*On fait avancer l'overlay*/

					var coverWidth = document.getElementById('sound_cover'+ playerPosition).offsetWidth;
					var step = (eventPosition/1000*coverWidth/(currentTrack.durationEstimate/1000));
					//console.log(coverWidth);
					//document.getElementById('track_position'+ playerPosition).style.width=(step+"px");
					//document.getElementById('cover_overlay'+ playerPosition).style.display="inline-block";
					//document.getElementById('blurred_sound_cover'+ playerPosition).style.display="inline-block";
					//document.getElementById('track_position'+ playerPosition).style.display="inline-block";
					document.getElementById('blurred_sound_cover_container'+ playerPosition).style.width=(step+"px");
					document.getElementById('cover_overlay'+ playerPosition).style.width=((step)+"px");
					/*END On fait avancer l'overlay*/
				});
			}

			/* Position navigation with click */

			var playerPosition = document.getElementById('player_position').innerHTML;
			var TranparentOverlayDiv = document.getElementById('transparent_overlay'+ playerPosition);
			TranparentOverlayDiv.addEventListener('click', function (e) 
			{
					clearDropdownMenu();
					var mousePos = {'x': e.layerX, 'y': e.layerY};
					//console.log(mousePos['x']);
					var aimedPositionMs = (mousePos['x']*(currentTrack.durationEstimate/coverWidth));
					currentTrack.setPosition(aimedPositionMs);
					document.getElementById('blurred_sound_cover_container'+ playerPosition).style.width=(mousePos['x']+"px");
					document.getElementById('cover_overlay'+ playerPosition).style.width=(mousePos['x']+"px");
	
					
			}, false);
			

			/* END position navigation with click */


		},1000);

		
		
	});
}

function playCurrentTrack()
{
	if(onPlay)
	{
		currentTrack.resume();
	}
	else
	{
		currentTrack.play();
	}
	
}

function pauseCurrentTrack()
{
	currentTrack.pause();
}

function nextTrack()
{
	clearDropdownMenu();
	currentTrack.stop();
	onPlay=false;
	if(position<(songTable.length-1))
	{
		position++;
		document.getElementById('blurred_sound_cover_container'+ position).style.width="0";
		document.getElementById('cover_overlay'+ position).style.width="0";
		updateCurrentTrack(songTable[position]);
		updatePlayerPosition(songTable[position]);
		s.slideRight();
		getLikeState();
		//g.disappear();
	}
	else
	{
		location.href="../view/end.php";
	}
	
}

function previousTrack()
{
	clearDropdownMenu();
	currentTrack.stop();
	onPlay=false;
	document.getElementById('blurred_sound_cover_container'+ (position+1)).style.width="0";
	document.getElementById('cover_overlay'+ (position+1)).style.width="0";
	position--;
	updateCurrentTrack(songTable[position]);
	updatePlayerPosition(songTable[position]);
	s.slideLeft();
	//g.disappear();
	getLikeState();
}

function resetPositionOverlay()
{
	document.getElementById('blurred_sound_cover_container'+ position).style.width="0";
	document.getElementById('cover_overlay'+ position).style.width="0";
}






function getCurrentTrackId()
{
	return songTable[position];
}


/* Track like state for a given user */


function getLikeState()
{
	xhr = new XMLHttpRequest();
	xhr2 = new XMLHttpRequest();
	var trackId = getCurrentTrackId(); // Renvoit le TrackID en lecture, fonction dans player2.js
    var currentUser = getCookie('current_user') //user.email
    xhr.open('GET', '../model/get_like_state.php?trackId='+trackId+'&currentUser='+currentUser); // On test si le son a déjà été liké par currentUser
    xhr.onreadystatechange = function() 
	{ // On gère ici une requête asynchrone

        if(xhr.readyState == 4 && xhr.status == 200) 
        { // Si le fichier est chargé sans erreur
            //console.log(xhr.responseText);
            var likeStamp = document.getElementById("plus_one");
            if(xhr.responseText == 'TRUE') // Si le son est déjà liké par currentUser
            {
                //console.log('coucou3');
            	likeStamp.style.background="url(http://soundpark.fm/assets/pictures/heart_like_pressed.png)";
            	likeStamp.style.backgroundSize="cover";
            	xhr2.open('GET', '../model/get_dislike_state.php?trackId='+trackId+'&currentUser='+currentUser); // On test si le son a déjà été disliké par currentUser
                xhr2.send(null)
        	}
            else // Si le son n'est pas déjà liké par currentUser
            {
                likeStamp.style.background="url(http://soundpark.fm/assets/pictures/heart_like.png)";
                likeStamp.style.backgroundSize="cover";
                //console.log('youou');
                xhr2.open('GET', '../model/get_dislike_state.php?trackId='+trackId+'&currentUser='+currentUser); // On test si le son a déjà été disliké par currentUser
                xhr2.send(null)
            }
        }
    };

    xhr2.onreadystatechange = function() 
	{ // On gère ici une requête asynchrone

        
        if(xhr2.readyState == 4 && xhr2.status == 200) 
        { // Si le fichier est chargé sans erreur
        	var dislikeStamp = document.getElementById("minus_one");
        	if(xhr2.responseText == 'TRUE')
        	{
	        	dislikeStamp.style.background="url(http://soundpark.fm/assets/pictures/cross_dislike.png)";
	        	dislikeStamp.style.backgroundSize="cover";
        	}
        	else
        	{		
	        	dislikeStamp.style.background="url(http://soundpark.fm/assets/pictures/cross_dislike.png)";
	        	dislikeStamp.style.backgroundSize="cover";
        	}	
        }
    };

    xhr.send(null); // La requête est prête, on envoie tout !
}


/* Player dropdown menu for social icons */


var indexDropdownMenu = 0;
var toggledDropdownMenu = false;
var fill = function(){
  var dots = document.getElementsByClassName('circle');
  if(!toggledDropdownMenu)
    {
		var playerPosition = document.getElementById('player_position').innerHTML;
		var socialIconFb = document.getElementById('socialIconFb'+ playerPosition);
		var socialIconTwitter = document.getElementById('socialIconTwitter'+ playerPosition);
		var socialIconEmail = document.getElementById('socialIconEmail'+ playerPosition);
		var socialIconSoundcloud = document.getElementById('socialIconSoundcloud'+ playerPosition);
	    var shareButtonText = document.getElementById('shareButtonText'+ playerPosition);  
	    shareButtonText.style.display= "none";
    	setTimeout(function () {   
	        dots[indexDropdownMenu].style.backgroundColor = "white";
	        indexDropdownMenu++;                    
	        if (indexDropdownMenu < dots.length) {          
	           fill();       
	        }
	        else
	        {
	          setTimeout(function () {   
	          
	          	var playerPosition = document.getElementById('player_position').innerHTML;
	            var dm = document.getElementById('dropdown-menu-overlay'+ playerPosition);  
	            dm.style.opacity= "0.7";
	            dm.style.height= "30vh";
	            var indexDropdownMenuIcons = 0;
 				var fillSocialIcons = function(){
 					console.log('1 : '+ indexDropdownMenuIcons);
 					setTimeout(function () { 
				        if(indexDropdownMenuIcons === 0)
				        {
				        	socialIconFb.style.display = "inline-block";
				        	console.log('2 : '+ indexDropdownMenuIcons);
				        	indexDropdownMenuIcons++;
				        	fillSocialIcons();
				        } 
				        else if (indexDropdownMenuIcons === 1) 
			        	{
							socialIconTwitter.style.display = "inline-block";
							indexDropdownMenuIcons++;
							fillSocialIcons();
			        	} 
			        	else if (indexDropdownMenuIcons === 2) 
			        	{
							socialIconEmail.style.display = "inline-block";
							indexDropdownMenuIcons++;
							fillSocialIcons();
			        	}  
			        	else if (indexDropdownMenuIcons === 3) 
			        	{
							socialIconSoundcloud.style.display = "inline-block";
							indexDropdownMenuIcons = 0;
			        	}     
			        }, 10) 	
 				}
 				fillSocialIcons();
	            toggledDropdownMenu = true;
	            indexDropdownMenu = 0
	           }, 10)  
	        }
      
      	}, 30)
    }
  else
    {
      	setTimeout(function () {   
	        dots[(dots.length)-(indexDropdownMenu+1)].style.backgroundColor = "transparent";   
	      
	        indexDropdownMenu++;                    
	        if (indexDropdownMenu < dots.length) {          
	           fill();       
	        }
	        else
	        {
	       		
				var playerPosition = document.getElementById('player_position').innerHTML;
				var socialIconFb = document.getElementById('socialIconFb'+ playerPosition);
				var socialIconTwitter = document.getElementById('socialIconTwitter'+ playerPosition);
				var socialIconEmail = document.getElementById('socialIconEmail'+ playerPosition);
				var socialIconSoundcloud = document.getElementById('socialIconSoundcloud'+ playerPosition);
				var indexDropdownMenuIcons = 0;
	        	var unfillSocialIcons = function(){
	 					console.log('3 : '+ indexDropdownMenuIcons);
	 					setTimeout(function () { 
					        if(indexDropdownMenuIcons === 3)
					        {
					        	socialIconFb.style.display = "none";
					        	console.log('4 : '+ indexDropdownMenuIcons);
					        	indexDropdownMenuIcons++;	
					        	unfillSocialIcons();		        	
					        } 
					        else if (indexDropdownMenuIcons === 2) 
				        	{
								socialIconTwitter.style.display = "none";
								indexDropdownMenuIcons++;
								unfillSocialIcons();
				        	} 
				        	else if (indexDropdownMenuIcons === 1) 
				        	{
								socialIconEmail.style.display = "none";
								indexDropdownMenuIcons++;
								unfillSocialIcons();
				        	}  
				        	else if (indexDropdownMenuIcons === 0) 
				        	{
								socialIconSoundcloud.style.display = "none";
								indexDropdownMenuIcons++;
								unfillSocialIcons();
				        	} 
				        	else if(indexDropdownMenuIcons === 4)
				        	{
				        		var playerPosition = document.getElementById('player_position').innerHTML;  
					            var dm = document.getElementById('dropdown-menu-overlay'+ playerPosition);  
					            dm.style.opacity= "0.2";
					            dm.style.height= "2.61vh";
					           
					            indexDropdownMenuIcons++;	
					        	unfillSocialIcons();
				        	}  
				        	else if(indexDropdownMenuIcons === 5)
				        	{
					            indexDropdownMenu = 0;
					            var playerPosition = document.getElementById('player_position').innerHTML;
					            var shareButtonText = document.getElementById('shareButtonText'+ playerPosition);  
					            shareButtonText.style.display= "inline-block";
					            toggledDropdownMenu = false;
				        	}  
				        }, 70) 	
	 			}
	 			unfillSocialIcons();      
	        }
     	}, 30)
    }
}


function clearDropdownMenu()
{
	var dots = document.getElementsByClassName('circle');
	for(index = 0 ; index < dots.length ; index++)
	{
		 dots[index].style.backgroundColor = "transparent";  
	}
	var playerPosition = document.getElementById('player_position').innerHTML;  
    var dm = document.getElementById('dropdown-menu-overlay'+ playerPosition);  
    dm.style.opacity= "0.2";
    dm.style.height= "2.61vh";
    var playerPosition = document.getElementById('player_position').innerHTML;
    var shareButtonText = document.getElementById('shareButtonText'+ playerPosition);  
    shareButtonText.style.display= "inline-block";
    toggledDropdownMenu = false;
    indexDropdownMenu = 0
    var playerPosition = document.getElementById('player_position').innerHTML;
				var socialIconFb = document.getElementById('socialIconFb'+ playerPosition);
				var socialIconTwitter = document.getElementById('socialIconTwitter'+ playerPosition);
				var socialIconEmail = document.getElementById('socialIconEmail'+ playerPosition);
				var socialIconSoundcloud = document.getElementById('socialIconSoundcloud'+ playerPosition);
				var indexDropdownMenuIcons = 0;
	        	var unfillSocialIcons = function(){
	 					console.log('3 : '+ indexDropdownMenuIcons);
	 					setTimeout(function () { 
					        if(indexDropdownMenuIcons === 3)
					        {
					        	socialIconFb.style.display = "none";
					        	console.log('4 : '+ indexDropdownMenuIcons);
					        	indexDropdownMenuIcons++;	
					        	unfillSocialIcons();		        	
					        } 
					        else if (indexDropdownMenuIcons === 2) 
				        	{
								socialIconTwitter.style.display = "none";
								indexDropdownMenuIcons++;
								unfillSocialIcons();
				        	} 
				        	else if (indexDropdownMenuIcons === 1) 
				        	{
								socialIconEmail.style.display = "none";
								indexDropdownMenuIcons++;
								unfillSocialIcons();
				        	}  
				        	else if (indexDropdownMenuIcons === 0) 
				        	{
								socialIconSoundcloud.style.display = "none";
								indexDropdownMenuIcons++;
								unfillSocialIcons();
				        	} 
				        	else if(indexDropdownMenuIcons === 4)
				        	{
				        		var playerPosition = document.getElementById('player_position').innerHTML;  
					            var dm = document.getElementById('dropdown-menu-overlay'+ playerPosition);  
					            dm.style.opacity= "0.2";
					            dm.style.height= "2.61vh";
					           
					            indexDropdownMenuIcons++;	
					        	unfillSocialIcons();
				        	}  
				        	else if(indexDropdownMenuIcons === 5)
				        	{
					            indexDropdownMenu = 0;
					            var playerPosition = document.getElementById('player_position').innerHTML;
					            var shareButtonText = document.getElementById('shareButtonText'+ playerPosition);  
					            shareButtonText.style.display= "inline-block";
					            toggledDropdownMenu = false;
				        	}  
				        }, 30) 	
	 			}
	 			unfillSocialIcons();   
}



