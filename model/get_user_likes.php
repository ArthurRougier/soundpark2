<?php
	if(isset($_GET['currentUser']))
	{
		include_once('connect_sql.php');
		$req=$bdd->prepare('SELECT trackId FROM song, `like`, user WHERE user.email = ? AND user.ID = `like`.ID_user AND `like`.ID_song = song.ID');
		$req->execute(array($_GET['currentUser']));
		$i = 0;
		while($rep = $req->fetch())
		{
			$userTrackIdsLike[$i] = $rep[0];
			$i++;
		}
		foreach($userTrackIdsLike as $value)
		{
			echo ($value.'-');
		}
	}

	