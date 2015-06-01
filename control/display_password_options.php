<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/model/get_user_password.php'); // returns $userHashedPassword
	if($userHashedPassword)
	{

		if(count($_POST)>0) {
			include_once('../control/change_user_password.php'); //takes $userHashedPassword
		}

		?>
		<h3> You can here change the password you are using to sign in to sounpark. Make it nice and secure!</h3>
		<form name="frmChange" accept-charset="UTF-8" action="" onSubmit="return validatePassword()" class="changePassword" id="changePassword" method="post">
			
			<div class="message"><?php if(isset($message)) { echo $message; } ?></div>
			<table border="0" cellpadding="10" cellspacing="0" width="500" align="center" class="tblSaveForm">
			<tr>
			<td width="35%"><label>Current Password</label></td>
			<td width="65%"><input name="currentPassword"  type="password" autocorrect="off" autocapitalize="off"/><span id="currentPassword"  class="required"></span></td>
			</tr>
			<tr>
			<td><label>New Password</label></td>
			<td><input name="newPassword"  type="password" autocorrect="off" autocapitalize="off"/><span id="newPassword" class="required"></span></td>
			</tr>
			<td><label>Confirm Password</label></td>
			<td><input name="confirmPassword"  type="password" autocorrect="off" autocapitalize="off"/><span id="confirmPassword" class="required"></span></td>
			</tr>
			<tr>
			<td colspan="2"><button class="submitButton" alt="submit"> GO! </button></td>
			</tr>
			</table>
			</div>						
		</form>
		<?php
	}
	else
	{
		?>
		<h3> Use your password to sign in to Soundpark on the web. Make it nice and secure!</h3>
		<form name="setPasswordFrm" accept-charset="UTF-8" action="../control/set_user_password.php" class="setPassword" id="setPassword" method="post">
		<div class="message"><?php if(isset($message)) { echo $message; } ?></div>
		<div id="passwordFieldCreation" onclick="ctaToField()"><a id="passwordCreationCTA" class="CTA" href="#"> Create a password </a></div>
		<!-- <div id="passwordFieldCreation"><input id="setPasswordField" name="setPassword"  type="password" autocorrect="off" autocapitalize="off"/></div> -->
		</form>
		<?php
	}
