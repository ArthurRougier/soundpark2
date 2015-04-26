<?php
	 include_once('../model/get_curators_photo.php'); // give us $res
	 while($res = $req->fetch())
	 {
	 	echo('<div class="curatorPhotoPlaceHolder"><img src="'.$res[0].'" class="curatorPhoto" />');
	 	echo('<div class="curatorPhotoOverlay"><span class="helper"></span><p>'.$res[1].'</p></div></div>');
	 }
	
	