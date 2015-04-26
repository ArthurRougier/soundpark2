
SC.initialize({

    client_id: "17f3a8c69cb36c955df82f908611e27e"
});

var onPlay = false;
var position = 0;
var pause = false;


var trackIds = document.getElementsByClassName('trackIds');
var songTable = [];

for(var i = 0 ; i<trackIds.length ; i++)
{
	songTable[i] = trackIds[i].innerHTML;
}


var currentTrack;
updateCurrentTrack(songTable[0]);



$('.playPauseButton').click(function() //Gestion du bouton de lecture/pause en toggle
{
	if(!onPlay)
	{
		if ($(this).hasClass("play")) 
		{
			position = this.id.slice(-1) -1;

			$('.playPauseButton')[(this.id.slice(-1))-1].classList.toggle('play');
			$('.playPauseButton')[(this.id.slice(-1))-1].classList.toggle('pause');
			console.log(songTable[this.id.slice(-1)-1]);
			updateCurrentTrack(songTable[this.id.slice(-1) -1]);
			
			playCurrentTrack();
			if(!onPlay)
			{
				onPlay = true;
			}
			 //console.log('hfvez');	
		}
		else {
			$('.playPauseButton')[(this.id.slice(-1))-1].classList.toggle('play');
			$('.playPauseButton')[(this.id.slice(-1))-1].classList.toggle('pause');
			pauseCurrentTrack();
		}
	}
	else
	{
		if((this.id.slice(-1) -1) == position)
		{
			$('.playPauseButton')[(this.id.slice(-1))-1].classList.toggle('play');
			$('.playPauseButton')[(this.id.slice(-1))-1].classList.toggle('pause');
			pauseCurrentTrack();
			console.log('hgvskj');
		}
		else
		{
			currentTrack.stop();
			if(pause)
			{
				$('.playPauseButton')[position].classList.toggle('play');
				$('.playPauseButton')[position].classList.toggle('pause');
				document.getElementById('cover_wrapper'+(position+1)).style.opacity = "0.2";
			}
			position = this.id.slice(-1) -1;
			$('.playPauseButton')[position].classList.toggle('play');
			$('.playPauseButton')[position].classList.toggle('pause');
			document.getElementById('cover_wrapper'+(position+1)).style.opacity="0.2";
			updateCurrentTrack(songTable[position]);
		}
	}
	
});


function updateCurrentTrack(trackId) 
{

	SC.stream("/tracks/"+trackId,{onfinish: function(){ 
		
		nextTrack();
		
		}}, function(sound){
		currentTrack = sound;
		if (document.getElementsByClassName('playPauseButton')[position].classList.contains("pause")) 
		{	
			
			onPlay=true;
			pause = true;
			currentTrack.play();

		}

	});
}

function playCurrentTrack()
{
	var wrapers = $('.cover_wrapper');
	for(var i = 0 ; i < wrapers.length ; i++)
	{
		wrapers[position].style.opacity="0.2";
	}
	if(onPlay)
	{
		currentTrack.resume();
		pause = true;
	}
	else
	{
		currentTrack.play();
		onPlay=true;
		pause = true;
	}
	
}

function pauseCurrentTrack()
{
	var wrapers = $('.cover_wrapper');
	wrapers[position].style.opacity="0.2";
	currentTrack.pause();
	pause = false;
}

function nextTrack()
{
	currentTrack.stop();
	onPlay=false;

	if(position<(songTable.length-1))
	{
		$('.playPauseButton')[position].classList.toggle('play');
		$('.playPauseButton')[position].classList.toggle('pause');
		document.getElementById('cover_wrapper'+(position+1)).style.opacity = "0.2";
		position++;
		console.log(songTable[position]);
		$('.playPauseButton')[position].classList.toggle('play');
		$('.playPauseButton')[position].classList.toggle('pause');
		document.getElementById('cover_wrapper'+(position+1)).style.opacity="0.05";
		updateCurrentTrack(songTable[position]);
	}

	else
	{
		console.log('fini');
		//location.href="../view/end.php";
	}
	
}

function previousTrack()
{
	currentTrack.stop();
	onPlay=false;
	position--;
	updateCurrentTrack(songTable[position]);
	s.slideLeft();

	
}

function getCurrentTrackId()
{
	return songTable[position];
}


var wrapers = $('.cover_wrapper');

		
for(var i = 0 ; i < wrapers.length ; i++)
{

	wrapers[i].addEventListener('mouseover', function(){

			this.style.opacity="0.7";

	}, false)


	wrapers[i].addEventListener('mouseout', function(){
		//console.log($(this).parent().index());
		if($(this).parent().index()==(position+1))
		{
			if(pause)
			{
				this.style.opacity="0.2";
			}
			else
			{
				this.style.opacity="0.2";
			}
				
		}
		else
		{
			this.style.opacity="0.2";
		}

	}, false)

	
}
		
		








