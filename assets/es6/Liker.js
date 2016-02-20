var addLike       	= require('./addLike.js');
var addDislike     	= require('./addDislike.js');


var Liker = function(likeDislikeSelectors, playerLinked){
	this.likeDislikeSelectors	= likeDislikeSelectors || [];
	this.likeSelector 			= likeDislikeSelectors[0];
	this.dislikeSelector 		= likeDislikeSelectors[1];
	this.PlayerLinked 			= playerLinked || {} 
	var thatLiker 				= this;
	this.prepareLikeDislikeButtons(this.likeSelector, this.dislikeSelector); // initialize like and dislike buttons by adding listeners 
}

Liker.prototype = {

	prepareLikeDislikeButtons: function (likeSelector, dislikeSelector){
		var thatLiker		= this;
		var likeButton 		= document.querySelector(likeSelector);
		var dislikeButton 	= document.querySelector(dislikeSelector);

		likeButton.addEventListener('click', function(){
			addLike(thatLiker.PlayerLinked.trackList[thatLiker.PlayerLinked.position - 1].id)
			thatLiker.PlayerLinked.trackList[thatLiker.PlayerLinked.position - 1].isLiked = true;
		}, false);

		dislikeButton.addEventListener('click', function(){
			addDislike(thatLiker.PlayerLinked.trackList[thatLiker.PlayerLinked.position - 1].id)
			thatLiker.PlayerLinked.trackList[thatLiker.PlayerLinked.position - 1].isLiked = false;
		}, false);
	}
}

module.exports = Liker;