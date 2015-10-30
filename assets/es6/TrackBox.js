var TrackBox = function(index, TrackInfo){
	if(!TrackInfo)
	{
		return "missing track information";
	}
	else
	{
		this.trackIndex		= index || 0;
		this.trackCover 	= TrackInfo.trackCover || "";
		this.trackPlayer 	= TrackInfo.trackPlayer || "";
		this.trackTitle 	= TrackInfo.trackTitle || "";
		this.curatorPseudo 	= TrackInfo.curatorPseudo || "";
		this.curatorLink 	= TrackInfo.curatorLink || "";
		this.curatorPic 	= TrackInfo.curatorPic || "";

		this.listDomElement	= document.createElement('li');
		this.listDomElement.setAttribute('id','slide'+(this.trackIndex));
		this.listDomElement.setAttribute('class','slide');
			var songBox = document.createElement('div');
			songBox.setAttribute('id','sound_box'+(this.trackIndex));
			songBox.setAttribute('class','sound_box');
				var coverContainer = document.createElement('div');
				coverContainer.setAttribute('id','cover_container'+(this.trackIndex));
				coverContainer.setAttribute('class','cover_container');
					var soundCover = document.createElement('img');
					soundCover.setAttribute('id','sound_cover'+(this.trackIndex));
					soundCover.setAttribute('class','sound_cover');	
					this.trackPlayer == 'soundcloud' ? soundCover.setAttribute('src',this.trackCover) : soundCover.setAttribute('src','');
					var blurredCoverContainer = document.createElement('div');
					blurredCoverContainer.setAttribute('id', 'blurred_sound_cover_container'+(this.trackIndex));		
					blurredCoverContainer.setAttribute('class','blurred_sound_cover_container');
					if(this.trackPlayer == 'soundcloud')	
					{
						var blurredSoundCover = document.createElement('img');
						blurredSoundCover.setAttribute('id','blurred_sound_cover'+(this.trackIndex));
						blurredSoundCover.setAttribute('class','blurred_sound_cover');	
						blurredSoundCover.setAttribute('src', this.trackCover);
						blurredCoverContainer.appendChild(blurredSoundCover);
					}	
					var coverOverlay = document.createElement('div');
					coverOverlay.setAttribute('id','cover_overlay'+(this.trackIndex));
					coverOverlay.setAttribute('class','cover_overlay');
						var trackPosition = document.createElement('div');
						trackPosition.setAttribute('id','track_position'+(this.trackIndex));
						trackPosition.setAttribute('class','track_position');
						trackPosition.innerHTML = '0:00';
						coverOverlay.appendChild(trackPosition);
					var transparentOverlay = document.createElement('div');
					transparentOverlay.setAttribute('id','transparent_overlay'+(this.trackIndex));
					transparentOverlay.setAttribute('class','transparent_overlay');

					coverContainer.appendChild(soundCover);
					coverContainer.appendChild(blurredCoverContainer);
					coverContainer.appendChild(coverOverlay);
					coverContainer.appendChild(transparentOverlay);

				var soundInformations = document.createElement('div');
				soundInformations.setAttribute('id','sound_informations'+(this.trackIndex));
				soundInformations.setAttribute('class','sound_informations');
					var curatorLink = document.createElement('a');
					curatorLink.setAttribute('href',this.curatorLink);
					curatorLink.setAttribute('target','_blank');
						var curatorTextTitle = document.createElement('h3');
						curatorTextTitle.setAttribute('class','curator');
							var curatorText  = document.createElement('div');
							curatorText.setAttribute('class','curatorText');
								var curatorSpan = document.createElement('span');
								curatorSpan.style.backgroundColor = "black";
								curatorSpan.innerHTML = "Curator: " + this.curatorPseudo;
								var curatorStuff = document.createElement('div');
								curatorStuff.setAttribute('class', 'curatorStuff');
									var curatorPicture = document.createElement('img');
									curatorPicture.setAttribute('class','curatorPicture');	
									curatorPicture.setAttribute('src', this.curatorPic);
									curatorStuff.appendChild(curatorPicture);
								curatorText.appendChild(curatorSpan);
								curatorText.appendChild(curatorStuff);
							curatorTextTitle.appendChild(curatorText);
						curatorLink.appendChild(curatorTextTitle);
					var songTitle = document.createElement('h3');
					songTitle.setAttribute('class','title');
						var titleText = document.createElement('div');
						titleText.setAttribute('class','titleText');
							var titleSpan = document.createElement('span');
							titleSpan.setAttribute('class','titleText');
							titleSpan.style.backgroundColor = "black";
							titleSpan.innerHTML = this.trackTitle;
							titleText.appendChild(titleSpan);
						songTitle.appendChild(titleText);
					soundInformations.appendChild(curatorLink);
					soundInformations.appendChild(songTitle);
				songBox.appendChild(coverContainer);
				songBox.appendChild(soundInformations);
			this.listDomElement.appendChild(songBox);
		return this;
	}
}

module.exports = TrackBox;
