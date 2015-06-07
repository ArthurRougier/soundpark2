SC.initialize({

    client_id: "17f3a8c69cb36c955df82f908611e27e"
});

var position = 0;

var trackIds = document.getElementsByClassName('trackId');
var songTable = [];


for(var i = 0 ; i<trackIds.length ; i++)
{
	songTable[i] = trackIds[i].value;
}
//console.log(songTable);
//alert(songTable.length);

var currentTrack;
var onplay = 0;
//updateCurrentTrack(songTable[0]);



$('.playPauseIcon').click(function() //Gestion du bouton de lecture/pause en toggle
{
	if(onplay)
	{
		var oldIndex = index;
	}
	if(Number(this.id.slice(-2))==this.id.slice(-2))
	{
		index = this.id.slice(-2); 
		//console.log('double - index = '+index);
	}
	else
	{
		index = this.id.slice(-1); 
		//console.log('simple - index = '+index);
	}
	//index = this.id.slice(-1); // On récupère la position du son dans la liste
	trackId = document.getElementById('trackId'+index).value;
	if (this.className === "playPauseIcon play") 
	{
			
		if(!onplay)
		{
			onplay = 1;
			playCurrentTrack(trackId);
			this.className = "playPauseIcon pause";
		}
		else
		{
			if(currentTrack.sID.indexOf(trackId) >= 0)
			{
				currentTrack.togglePause(trackId);
				this.className = "playPauseIcon pause";
			}
			else
			{
				//currentTrack.sID.substring(9).split("-")[0];
				removeProgressionBar(oldIndex);
				var icons = document.getElementsByClassName('playPauseIcon');
				for(var indexbis = 0 ; indexbis < icons.length ; indexbis++)
				{
					icons[indexbis].className = "playPauseIcon play";
				}
				currentTrack.stop();
				//console.log('yes');
				playCurrentTrack(trackId);
				this.className = "playPauseIcon pause";
			}
		}
	}
		
	
	else {
		this.className = "playPauseIcon play";
		currentTrack.togglePause(trackId);
	}

});



function playCurrentTrack(trackId)
{

	SC.stream("/tracks/"+trackId,
		{
	  		onfinish: function() 
	  		{
	    		nextTrack();
	  		},
	  		onload: function()
	  		{
	  				// Barre de progression

	  				//On enleve le "Loading..."
							var compteurLoaded=0;
							if (compteurLoaded==0)
							{
								//document.getElementById('progressionBar'+ index).innerHTML ="";
								compteurLoaded=1;
							}
					//Non opérationnel car on vient efface la ProgressioBarPosition		


					for(var indexFor = 1 ; indexFor < (currentTrack.durationEstimate/1000) ; indexFor++)
					{
						currentTrack.onPosition(indexFor*1000, function(eventPosition)
						{
							//console.log(this.id+' reached '+eventPosition);

							/* On change le formatage du compteur temps ici pour afficher mn:sec */

							var minutes = (eventPosition / 60000) | (0);
							var seconds = eventPosition/1000 - minutes * 60;
							var minutesTot = (currentTrack.durationEstimate / 60000) | (0);
							var secondsTot = parseInt(currentTrack.durationEstimate/1000 - minutesTot * 60);
							if(seconds < 10)
							{
								seconds = '0'+seconds;
							}
							if(!minutes)
							{
								document.getElementById('progressionBarPosition'+ index).innerHTML = seconds +' / ' + minutesTot + ':' + secondsTot;
							}
							else
							{
								document.getElementById('progressionBarPosition'+ index).innerHTML = minutes + ':' + seconds +' / ' + minutesTot + ':' + secondsTot;
							}


							var minutesTot = (currentTrack.durationEstimate / 60000) | (0);
							var secondsTot = currentTrack.durationEstimate/1000 - minutes * 60;
							

							/* END On change le formatage du compteur temps ici pour afficher mn:sec */

							/*On fait avancer l'overlay*/

							
							var progBarWidth = (document.getElementById('progressionBar'+ index).offsetWidth);
							var progBarPosition = document.getElementById('progressionBarPosition'+ index);
							var step = (eventPosition/1000*progBarWidth/(currentTrack.durationEstimate/1000));
							progBarPosition.style.width=(step+"px");
							/*END On fait avancer l'overlay*/
							

						});
					}

					/* Position navigation with click */

					var progBar = document.getElementById('progressionBar'+ index);
					var progBarWidth = (document.getElementById('progressionBar'+ index).offsetWidth);
					var progBarPosition = document.getElementById('progressionBarPosition'+ index);
					progBar.addEventListener('click', function (e) 
					{
							durationBeforeJump = currentTrack.position;
							if(window.location.href.indexOf("new") > 0)
							{
								var mousePos = {'x': (e.layerX-50), 'y': e.layerY};
							}
							else if(window.location.href.indexOf("histo") > 0)
							{
								var mousePos = {'x': (e.layerX-50), 'y': e.layerY};
							}
							else 
							{
								var mousePos = {'x': (e.layerX-50), 'y': e.layerY};
							}
							
							//console.log(mousePos['x']);
							var aimedPositionMs = (mousePos['x']*(currentTrack.durationEstimate/progBarWidth));
							currentTrack.setPosition(aimedPositionMs);
							progBarPosition.style.width=(mousePos['x']+"px");	
					}, false);
					

					/* END position navigation with click */
	  		}
		}, 
		function(sound)
		{
  			currentTrack = sound;
  			currentTrack.play(trackId);
		}
	);
	
	/* On créé les divisions de la barre de prog */
	var currentLine = document.getElementById('li'+index);
	var progressionBar = document.createElement('div');
	progressionBar.id = 'progressionBar'+index;
	progressionBar.className = 'progressionBar';
	//progressionBar.innerHTML = 'Loading...';
	progressionBar.style.textAlign = "left";
	progressionBar.style.width = ((currentLine.offsetWidth)-50);
	progressionBar.style.marginLeft = '50px';
	progressionBar.style.marginTop = '2px';
	progressionBar.style.height = '20px';
	progressionBar.style.background = "#ffecf4";

	var progressionBarPosition = document.createElement('span'); // On crée le compteur interne 
	progressionBarPosition.id = 'progressionBarPosition'+index;
	progressionBarPosition.className = 'progressionBarPosition';
	//progressionBarPosition.innerHTML = 'Loading...';
	progressionBarPosition.style.width = "0px";
	progressionBarPosition.style.height = "20px";
	progressionBarPosition.style.background = "#fcc4db";
	progressionBarPosition.style.float = "left";
	progressionBarPosition.style.textAlign = "left";
	progressionBarPosition.style.display = "inline-block";
	progressionBarPosition.style.overflow = "hidden";
	progressionBar.appendChild(progressionBarPosition); // On insere le compteur dans la div progression Bar
	currentLine.appendChild(progressionBar);
}

function nextTrack()
{
	//console.log('nextTrack');
	removeProgressionBar(index);
	if(!(index >= (songTable.length - 1)))
	{
		document.getElementById('playPauseIcon'+index).className = "playPauseIcon play";
		index++;
		trackId = document.getElementById('trackId'+index).value;
		document.getElementById('playPauseIcon'+index).className = "playPauseIcon pause";
		playCurrentTrack(trackId);

	}
	else
	{
		onplay = 0;
		document.getElementById('playPauseIcon'+index).className = "playPauseIcon play";
		index = 0;
	}
}

function removeProgressionBar(indexBar)
{
	var currentLine = document.getElementById('li'+indexBar);
	var currentProgressionBar = document.getElementById('progressionBar'+indexBar);
	currentLine.removeChild(currentProgressionBar);
}

