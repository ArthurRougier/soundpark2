/* Tracking playlist main controlers */



document.getElementById('play').addEventListener('click', function () {
	var playerPositionLogs = document.getElementById('player_position').innerHTML;
	var curatorLogs = document.getElementsByClassName('curator')[(playerPositionLogs - 1)].firstChild.lastChild.innerHTML.split(":")[1];
	//console.log(curatorLogs);
	var trackId = getCurrentTrackId(); // Renvoit le TrackID en lecture, fonction dans player2.js
	mixpanel.track("Play/Pause Clicked", {
		fullUrl: window.location.href,
		"userId": userId,
		"playlistPosition": playerPositionLogs,
		"curator": curatorLogs,
		"trackId": trackId
		});
}, false);

document.getElementById('minus_one').addEventListener('click', function () {
	var playerPositionLogs = document.getElementById('player_position').innerHTML;
	var curatorLogs = document.getElementsByClassName('curator')[(playerPositionLogs - 1)].firstChild.lastChild.innerHTML.split(":")[1];
	var trackId = getCurrentTrackId(); // Renvoit le TrackID en lecture, fonction dans player2.js
	mixpanel.track("Dislike Clicked", {
		fullUrl: window.location.href,
		"userId": userId,
		"playlistPosition": playerPositionLogs,
		"curator": curatorLogs,
		"trackId": trackId
		});
}, false);

document.getElementById('plus_one').addEventListener('click', function () {
	var playerPositionLogs = document.getElementById('player_position').innerHTML;
	var curatorLogs = document.getElementsByClassName('curator')[(playerPositionLogs - 1)].firstChild.lastChild.innerHTML.split(":")[1];
	var trackId = getCurrentTrackId(); // Renvoit le TrackID en lecture, fonction dans player2.js
	//console.log(trackId);
	mixpanel.track("Like Clicked", {
		fullUrl: window.location.href,
		"userId": userId,
		"playlistPosition": playerPositionLogs,
		"curator": curatorLogs,
		"trackId": trackId
		});
}, false);

document.getElementById('right_arrow_icon').addEventListener('click', function () {
	var playerPositionLogs = document.getElementById('player_position').innerHTML;
	var curatorLogs = document.getElementsByClassName('curator')[(playerPositionLogs - 1)].firstChild.lastChild.innerHTML.split(":")[1];
	//console.log(curatorLogs);
	var trackId = getCurrentTrackId(); // Renvoit le TrackID en lecture, fonction dans player2.js
	mixpanel.track("Next Clicked", {
		"fullUrl": window.location.href,
		"trackId": songTable[position-1],
		"userId": userId,
		"playlistPosition": playerPositionLogs,
		"curator": curatorLogs,
		"trackId": trackId
		});
}, false);

document.getElementById('left_arrow_icon').addEventListener('click', function () {
	var playerPositionLogs = document.getElementById('player_position').innerHTML;
	var curatorLogs = document.getElementsByClassName('curator')[(playerPositionLogs - 1)].firstChild.lastChild.innerHTML.split(":")[1];
	var trackId = getCurrentTrackId(); // Renvoit le TrackID en lecture, fonction dans player2.js
	mixpanel.track("Previous Clicked", {
		"fullUrl": window.location.href,
		"trackId": songTable[position+1],
		"userId": userId,
		"playlistPosition": playerPositionLogs,
		"curator": curatorLogs,
		"trackId": trackId
		});
}, false);


/* Tracking sharing icons */


for (var i = 0 ; i < document.getElementsByClassName('socialIconFb').length; i++)
	{
		document.getElementsByClassName('socialIconFb')[i].addEventListener('click', function() 
	    { 
	    	mixpanel.track("Share song with facebook Clicked", {
			"fullUrl": window.location.href,
			"trackId": songTable[position],
			"userId": userId
			});

		}, false);
	}

for (var i = 0 ; i < document.getElementsByClassName('socialIconTwitter').length; i++)
	{
		document.getElementsByClassName('socialIconTwitter')[i].addEventListener('click', function() 
	    { 
	    	mixpanel.track("Share song with Twitter Clicked", {
			"fullUrl": window.location.href,
			"trackId": songTable[position],
			"userId": userId
			});

		}, false);
	}

for (var i = 0 ; i < document.getElementsByClassName('socialIconEmail').length; i++)
	{
		document.getElementsByClassName('socialIconEmail')[i].addEventListener('click', function() 
	    { 
	    	mixpanel.track("Share song with Email Clicked", {
			"fullUrl": window.location.href,
			"trackId": songTable[position],
			"userId": userId
			});

		}, false);
	}

for (var i = 0 ; i < document.getElementsByClassName('socialIconSoundcloud').length; i++)
	{
		document.getElementsByClassName('socialIconSoundcloud')[i].addEventListener('click', function() 
	    { 
	    	mixpanel.track("Listen song on Soundcloud Clicked", {
			"fullUrl": window.location.href,
			"trackId": songTable[position],
			"userId": userId
			});

		}, false);
	}









