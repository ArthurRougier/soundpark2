<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
  <head>
    <title>Soundpark</title>
    <link href="/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <script type="text/javascript" src="../assets/jquery-1.3.2.min.js"></script>
    
    
    <link href="../assets/BO_theo.css" media="all" rel="stylesheet" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    
 </head>
 
	<body>
		<header>
			<h1>Soundpark.<span style="color: white;">fm</span></h1>
			<ul>
				<li><a id="log_in_tab" style="color: white; border-bottom: 1px solid white;" href="curators_sign_in.php">Log In</a></li>
			</ul>
		</header>

		<aside>
			<ul>
				<li><a style="color: #531931; " href="bo_curators_new_theo.php">This Week TBD</a></li>
				<li><a style="color: #531931;" href="bo_curators_history_theo.php">History TBD TBD</a></li>
			<ul>
		</aside>

		<div id="container">
			
			<div id="LogInBox">
				<h2> Log In - Soundpark.fm </h2>
				<h2> Curators Golden Space </h2>
				
				<form action="../control/log_in.php" method="post">
				<p>
					<p>Pseudo: <input type="text" name="pseudo" value="pseudo"/></p>
					<p>Password: <input type="password" name="pass" /></p>
					<p><input type="submit" value="Log In" /></p>
				</p>
				</form>

			</div>	
		</div>

		<footer>
			
		</footer>		
</body>
<script type="text/javascript" src="../assets/player_bo.js"></script>
</html>