<?php
	include_once('connect_sql.php');
	include_once('../model/get_playlist_trackIds.php');
	$i = 0;
	while($trackIds = $req->fetch())
	{
		?> <div class="trackIds"><?php echo($trackIds[0]); ?></div> <?php
	}
	if($radioModeTrackIds)
	{
		while($trackIds = $req2->fetch())
		{
			?> <div class="trackIds"><?php echo($trackIds[0]); ?></div> <?php
		}
	}