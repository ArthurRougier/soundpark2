<?php 
	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/
	//echo($_COOKIE['sessionType']);	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
  <head>
    <title>Soundpark</title>
    <link href="../assets/frommail8.css" media="all" rel="stylesheet" />
    <link href="../assets/css_dropdown_menu.css" media="all" rel="stylesheet" />
    
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

    <link rel="shortcut icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">
	<link rel="icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">


    <script src="http://connect.soundcloud.com/sdk.js"></script>
    <script type="text/javascript" src="../assets/jquery.js"></script>
    <script type="text/javascript" src="../assets/cookies.js"></script>
    <script type="text/javascript" src="../assets/date.js"></script>
    <script type="text/javascript" src="../assets/AJAX/update_player_position.js"></script>
    <script type="text/javascript" src="../assets/AJAX/add_like_dislike.js"></script>
    <script type="text/javascript" src="../assets/AJAX/record_automatic_next.js"></script>
    <script type="text/javascript" src="../assets/AJAX/display_user_past_likes.js"></script>
    <!--<script type="text/javascript" src="../zeroclipboard-2.1.6/dist/ZeroClipboard.min.js"></script>-->
    

	<!--Intercom integration-->
	
		
	   
	<!-- end Intersom -->

	<!--Google fonts integration-->
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>

    <!-- start Mixpanel -->

		

		<script type="text/javascript">

		</script>

	<!-- end Mixpanel -->


 </head>
 
	<body>
		<header>

			<h1>SOUNDPARK.FM</h1>
				
		</header>
		
		<div class="container" id="container"> 

			
		</div>
		
		<footer>
	
		</footer>		
</body>
    <script type="text/javascript" src="../assets/popUps.js"></script>
    <script src="../assets/player3.js"></script>


    <script>
    var trackListTest = ['https://soundcloud.com/nicolashaelg/nicolas-haelg-alfie-rhodes-callin-your-name-feat-syren-1',
    'https://soundcloud.com/thefallingapple/tracy-chapman-fast-car-bauke-top-remix',
    'https://www.youtube.com/watch?v=JrlfFTS9kGU'];

    var playerTest = new Player(trackListTest);
    </script>
</html>