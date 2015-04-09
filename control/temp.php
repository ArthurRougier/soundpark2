<?php
	setcookie('sessionType', '', time() + 31*24*3600,  "/", null, false, true);
	setcookie('currentSession', '', time() + 31*24*3600,  "/", null, false, true);
	echo($_COOKIE['sessionType']);

