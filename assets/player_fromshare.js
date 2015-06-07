
SC.initialize({
    client_id: "17f3a8c69cb36c955df82f908611e27e"
});

var onPlay = false;
var position = 0;



    var trackId = document.getElementById('trackId').innerHTML;
    //console.log(document.getElementById('trackId').innerHTML);
    var currentTrack;
	updateCurrentTrack(trackId);

	$('#play').click(function() //Gestion du bouton de lecture/pause en toggle
	{
		//console.log('lala');
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
			updateCurrentTrack(trackId);
			$('#play').val("play"); 
			}}, function(sound){
			currentTrack = sound;
			if ($('#play').val() == "pause") 
			{	
				onPlay=true;
				pause = true;
				currentTrack.play();
				currentTrack.pause();
			}
		});
	}


	function playCurrentTrack()
	{
		var wraper = document.getElementById('cover_wrapper');
		wraper.style.opacity="0.05";
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
		var wraper = document.getElementById('cover_wrapper');
		wraper.style.opacity="0.7";
		currentTrack.pause();
		pause = false;
	}


	function getCurrentTrackId()
	{
		return songTable[position];
	}
 


var wraper = document.getElementById('cover_wrapper');

wraper.addEventListener('mouseover', function() {
	this.style.opacity="0.7";
	//console.log('mouseover');
}, false);

wraper.addEventListener('mouseout', function() {
	if(pause)
	{
		this.style.opacity="0.05";
	}
	//console.log('mouseover');
}, false);



	


				
			



	//alert(trackId);








