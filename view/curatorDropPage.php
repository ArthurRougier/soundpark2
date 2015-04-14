<?php
session_start();
include_once ('../model/connect_sql.php');
include($_SERVER['DOCUMENT_ROOT'].'/control/session_check.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/control/control_user.php');	
require('../control/decide_lang.php');
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
  <head>
    <title>Soundpark Curator's space</title>
    <link href="../assets/curatorDropPage.css" media="all" rel="stylesheet" />
    <link rel="shortcut icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">
	<link rel="icon" href="http://soundpark.fm/assets/pictures/favicon.ico" type="image/x-icon">
    <script type="text/javascript" src="../assets/jquery-1.3.2.min.js"></script>
    <script src="http://connect.soundcloud.com/sdk.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
 </head>
 
	<body>
		<header>
			<h1>SOUNDPARK.FM</h1>
			<h2><?php echo TXT_CURATORSDROPPAGE_HEADLINE; ?></h2>
		</header>
		<div id="container">
			<h3><?php echo TXT_CURATORSDROPPAGE_HELPMESSAGE; ?></h3>
			<img id="explainArrow" src="../assets/pictures/explain_arrow.png">
			<div id="drop_space">
				<?php
					if(isset($_GET['curatorId']) AND ($_GET['curatorId']!=""))
					{
						?>
						<form accept-charset="UTF-8" action="../control/register_curator_track.php" class="new_user" id="new_user" method="post">
						<input autofocus="autofocus" placeholder="URL of your tune. Soundcloud prefered! But youtube compatible." id="curator_track" name="curator_track"  type="url" autocorrect="off" autocapitalize="off"/>
						<input name="commit" type="submit" value="Go" />
						<input type="hidden" value="<?php echo($_GET['curatorId']) ?>" name="ID_curator">
						<input type="hidden" value="dropPage" name="source">
						</form>
						<?php
					}
				?>
				
			</div>
		</div>
		<footer>
			<?php 
				if(isset($_GET['message']))
				{
					if($_GET['message'] == "successAdd")
					{
	
						echo('<h2 id="message"><img id="checkMark" src="../assets/pictures/check_icon.svg" /></br>'. TXT_CURATORSDROPPAGE_SUCCESSADD .'</h2></br>');
						
					}
					else if($_GET['message'] == "notWorking")
					{
						echo('<h2 id="message"><img id="crossMark" src="../assets/pictures/cross_dropPage.svg" /></br>'. TXT_CURATORSDROPPAGE_NOTWORKING .'</h2></br>');
					}
					else if($_GET['message'] == "notStreamable")
					{
						echo('<h2 id="message"><img id="crossMark" src="../assets/pictures/cross_dropPage.svg" /></br>'. TXT_CURATORSDROPPAGE_NOTSTREAMABLE .'</h2></br>');
					}
					else if($_GET['message'] == "badLink")
					{
						echo('<h2 id="message"><img id="crossMark" src="../assets/pictures/cross_dropPage.svg" /></br>'. TXT_CURATORSDROPPAGE_BADLINK .'</h2></br>');
					}
				}
				if(!isset($_GET['curatorId']) OR $_GET['curatorId']=="")
				{
					echo('<h2 id="message"><img id="crossMark" src="../assets/pictures/cross_dropPage.svg" /></br>'. TXT_CURATORSDROPPAGE_NOCURATORID .'</h2></br>');
				}
			?>

		</footer>		
</body>
</html>


