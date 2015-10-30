var Liker = function(likeDislikeSelectors, playerLinked){
	this.likeDislikeSelectors	= likeDislikeSelectors || [];
	this.likeSelector 			= likeDislikeSelectors[0];
	this.dislikeSelector 		= likeDislikeSelectors[1];
	this.PlayerLinked 			= playerLinked || {} 
	thatLiker = this;
	this.prepareLikeDislikeButtons(this.likeSelector, this.dislikeSelector); // initialize like and dislike buttons by adding listeners 
}

Liker.prototype = {

	prepareLikeDislikeButtons: function (likeSelector, dislikeSelector){
		var likeButton 		= document.querySelector(likeSelector);
		var dislikeButton 	= document.querySelector(dislikeSelector);

		likeButton.addEventListener('click', function(){
			addLike(thatLiker.PlayerLinked.masterJson[thatLiker.PlayerLinked.position - 1].id)
		}, false);

		dislikeButton.addEventListener('click', function(){
			addDislike(thatLiker.PlayerLinked.masterJson[thatLiker.PlayerLinked.position - 1].id)
		}, false);
	}
}

module.exports = Liker;