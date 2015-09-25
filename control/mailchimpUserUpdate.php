<?php

/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/

if((isset($_POST['user_email']) or isset($_GET['user_email'])) AND (isset($_POST['new_user_email']) or isset($_GET['new_user_email'])))
{
	if(isset($_POST['user_email']))
	{
		$userEmail =  $_POST['user_email'];
		$newUserEmail = $_POST['new_user_email'];
	}
	else if(isset($_GET['user_email']))
	{
		$userEmail =  $_GET['user_email'];
		$newUserEmail = $_GET['new_user_email'];
	}

	include('../vendor/drewm/mailchimp-api/MailChimp.php');
	$MailChimp = new \Drewm\MailChimp(getenv('MAILCHIMP_API_KEY'));
	$result = $MailChimp->call('lists/update-member', array(
	                'id'                => '6b7043da5e',
	                'email'             => array('email'=>$userEmail),
	                'merge_vars'        => array('LINKID'=>$newUserEmail, 'new-email'=>$newUserEmail),
	                'double_optin'      => false,
	                'update_existing'   => false,
	                'replace_interests' => false,
	                'send_welcome'      => false
	            ));

	//print_r($result);
	//$resultDecoded = json_decode($result, true);
	//print_r($resultDecoded);

	if($result['status']=='error')
	{
		header('Location: ../view/landing.php?error=1');
	}
}

else
{
	//echo("souci pas d'email man");
	header('Location: ../view/landing.php');
}



