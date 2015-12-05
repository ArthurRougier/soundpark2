var urlValidityTester = function(url, callback){

		if (
				/(youtube\.com\/(v\/|embed\/|(?:.*)?[\?\&]v=)|youtu\.be\/)([a-zA-Z0-9_\-]+)/.test(url)
				|| /\/yt\/([a-zA-Z0-9_\-]+)/.test(url)
				|| /youtube\.com\/attribution_link\?.*v\%3D([^ \%]+)/.test(url)
				|| /youtube.googleapis.com\/v\/([a-zA-Z0-9_\-]+)/.test(url)
			)
		callback(RegExp.lastParen); 

		else if(url.toLowerCase().indexOf("soundcloud") > -1)
		{
			SC.get('/resolve', { url: url }, function(track)
			{
				if(!track.streamable)
				{
					callback(false);
				}
				else
				{
					callback(track.id);
				}
			});
		}

		else
		{
			callback(false);
		}
}

module.exports = urlValidityTester;