<?php 
session_start();
include_once ('../model/connect_sql.php');
include($_SERVER['DOCUMENT_ROOT'].'/control/session_check.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/control/control_user.php');

$req=$bdd->prepare('SELECT curator.ID FROM curator, user WHERE curator.ID_user=user.id AND user.id=?');
$req->execute(array($_COOKIE['current_user']));
$resultat=$req->fetch();

$_SESSION['id_curator']=$resultat[0];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
  <head>
    <title>Soundpark</title>
    <link href="/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <script type="text/javascript" src="../assets/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="../Sortable/Sortable.min.js"></script>
    <script src="http://connect.soundcloud.com/sdk.js"></script>
    <link href="../assets/BO.css" media="all" rel="stylesheet" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
 </head>
 
	<body>
		<header>
			<h1>Soundpark.<span style="color: white;">fm</span></h1>
			<ul>
				<li><a id="playlist_tab" href="../view/frommail.php">Playlist</a></li>
			</ul>
		</header>

		<aside>
			<ul>
				<li style="box-shadow: 0 0 0 1px rgb(232, 232, 232) inset; background-color: rgba(83, 25, 49, 0.05);"><a id="aside0" style="border-left: 8px solid #531931;" href="#">Email Settings</a></li>
				<li><a id="aside1" href="#">Password</a></li>
			</ul>
		</aside>

		<div id="container">
			<?php 
				//Code permettant de faire un retour sur le post
				if(isset($_GET['message']))
				{
					echo('<h1>'.$_GET['message'].' !</h1></br>');
				}
			?>
			<div id="tab0">
				<h2>Email Settings</h2>
				<h3> Your email address can be used to sign in to Soundpark as well as facebook login. It is also where we will send you updates you choose below. </h3>
					<form accept-charset="UTF-8" action="../control/change_user_email.php" name="changeEmail" id="changeEmail" method="post">
						<input value="<?php include_once('../control/display_user_email.php');?>" id="email" name="new_user_email"  type="email"/>
						<input type="hidden" value="<?php echo $userEmail; ?>" name="user_email">
						<button class="submitButton" alt="submit"> SAVE </button>
					</form>
			</div>
			<div class="hidden" id="tab1">
				<h2>Password</h2>
				<?php include_once('../control/display_password_options.php'); ?>
			</div>

		</div>

		<footer>
			
		</footer>
		<script src="../assets/BO_styles_handler.js"></script>
		<script>
			function validatePassword() {
				var currentPassword,newPassword,confirmPassword,output = true;

				currentPassword = document.frmChange.currentPassword;
				newPassword = document.frmChange.newPassword;
				confirmPassword = document.frmChange.confirmPassword;

				if(!currentPassword.value) {
					currentPassword.focus();
					document.getElementById("currentPassword").innerHTML = "required";
					output = false;
				}
				else if(!newPassword.value) {
					newPassword.focus();
					document.getElementById("newPassword").innerHTML = "required";
					output = false;
				}
				else if(!confirmPassword.value) {
					confirmPassword.focus();
					document.getElementById("confirmPassword").innerHTML = "required";
					output = false;
				}
				if(newPassword.value != confirmPassword.value) {
					newPassword.value="";
					confirmPassword.value="";
					newPassword.focus();
					document.getElementById("confirmPassword").innerHTML = "not same";
					output = false;
				} 	
				return output;
			}

			function ctaToField()
			{
				var cta = document.getElementById('passwordFieldCreation');
				if (!cta.classList.contains('field'))
				{
					cta.className = "field";
					cta.innerHTML = '<input id="setPasswordField" name="setPassword"  placeholder="type a password" type="password" autocorrect="off" autocapitalize="off" autofocus/><button id="submitSetPassword" class="submitButton" alt="submit"> GO! </button>';
				}
				
			}			
		</script>
	
</script> </script>
</body>
</html>