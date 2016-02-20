<?php
		
	if(isset($root))
	{
		include_once($root.'/model/get_curators_photo.php'); // give us $res
	}
	else
	{	
		include_once('../model/get_curators_photo.php');
	}
	 
	while($res = $req->fetch())
	{
		echo('<div class="curatorPhotoPlaceHolder"><img src="'.$res[0].'" class="curatorPhoto" data-no-retina/>');
		echo('<div class="curatorPhotoOverlay"><span class="helper"></span><p>'.$res[1].'</p></div></div>');
	}
	
	