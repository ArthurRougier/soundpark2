var ProgressBar = function(barSelectors, totalBarSelector, timeDivSelector, totalTime, clickContainerSelector){ // total time in seconds
	this.barSelector			= barSelectors || [];
	this.totalBarSelector 		= totalBarSelector || "";
	this.timeDivSelector 		= timeDivSelector || "";
	this.clickContainerSelector = clickContainerSelector || "";
	this.totalTime				= totalTime || 0;

	thatProgressBar = this;


}

ProgressBar.prototype = {

	prepareProgressBarPositionSetter: function (){
		
		var clickContainerSelector 	= document.querySelector(thatProgressBar.timeDivSelector);


		clickContainerSelector.addEventListener('click', function(){
			var coverWidth 			= document.querySelector(thatProgressBar.totalBarSelector).offsetWidth;
			var mousePos 			= {'x': e.layerX, 'y': e.layerY};
			//console.log(mousePos['x']);
			var aimedPosition = (mousePos['x']*(thatProgressBar.totalTime / coverWidth));
			// To keep in the main player attribute that.currentTrack.setPosition(aimedPositionMs);
			// To keep in the main player attribute  document.getElementById('blurred_sound_cover_container'+ playerPosition).style.width=(mousePos['x']+"px");
			document.getElementById(thatProgressBar.barSelector).style.width=(mousePos['x']+"px");
			mixpanel.track("Progression bar hit", {
				"fullUrl": window.location.href,
				"trackId": that.trackList[(that.position-1)].trackID,
				"jumpedTo": that.position
			});
			
		}, false);


		dislikeButton.addEventListener('click', function(){
			addDislike(thatLiker.PlayerLinked.masterJson[thatLiker.PlayerLinked.position - 1].id)
		}, false);

	}
}





