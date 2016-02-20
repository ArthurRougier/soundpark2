<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if(isset($_POST['user_email']) OR isset($userEmail) OR isset($_GET['user_email']))
{
	if(isset($_POST['user_email']))
	{
		$userEmail = $_POST['user_email'];
	}
	else if(isset($_GET['user_email']))
	{
		$userEmail = $_GET['user_email'];
	}
	include('../vendor/drewm/mailchimp-api/MailChimp.php');
	include_once('../model/get_curator_information.php');
	$MailChimp = new \Drewm\MailChimp(getenv('MAILCHIMP_API_KEY'));
	$result = $MailChimp->call('lists/subscribe', array(
	                'id'                => '87a57f2f7b',
	                'email'             => array('email'=>$userEmail),
	                'merge_vars'        => array('LINKID'=>$userEmail, 'FNAME'=>$curatorpseudo, 'CURATORID'=>$curatorId),
	                'double_optin'      => false,
	                'update_existing'   => false,
	                'replace_interests' => false,
	                'send_welcome'      => false
	            ));
	//$resultDecoded = json_decode($result, true);
	//print_r($result);
	if($result['status']=='error')
	{
		//print_r($result);
		header('Location: ../view/landing.php?error=1');
	}
}

else
{
	header('Location: ../view/landing.php');
}



