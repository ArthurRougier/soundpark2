var Track = function(TrackInformation, CuratorInformation, TrackBox, PlayerObject){
	if(TrackInformation)
	{
		this.url 					= TrackInformation.URL || ""; 
		this.trackId 				= TrackInformation.trackId || 0;
		this.player 				= TrackInformation.player || "";
		this.cover 					= TrackInformation.cover || "";
		this.title 					= TrackInformation.title || ""
		this.id 					= TrackInformation.id || 0;
		this.isLiked				= TrackInformation.isLiked || false;
	}
	if(CuratorInformation)
	{
		this.curatorPseudo 			= CuratorInformation.curatorPseudo || "";
		this.curatorLink 			= CuratorInformation.curatorLink || "";
		this.curatorPic 			= CuratorInformation.curatorPic || "";
	}
	this.TrackBox				= TrackBox || {};
	this.PlayerObject			= PlayerObject || {};
	this.isPrepared 			= false;	// Youtube only: if we prepared the song in advance or not
	this.isInitialized			= false;
	this.currentIntervalId 		= 0;		// Interval for youtube progression bar
	this.currentIntervalBisId 	= 0;		// Interval for youtube next song's preparation
}

module.exports = Track;

