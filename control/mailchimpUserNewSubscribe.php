<?php

if(isset($_POST['user_email']))
{
	include('../vendor/drewm/mailchimp-api/MailChimp.php');
	$MailChimp = new \Drewm\MailChimp('b325e66745372713e98fc83055649de9-us8');
	$result = $MailChimp->call('lists/subscribe', array(
	                'id'                => '6b7043da5e',
	                'email'             => array('email'=>$_POST['user_email']),
	                'merge_vars'        => array('LINKID'=>$_POST['user_email']),
	                'double_optin'      => false,
	                'update_existing'   => false,
	                'replace_interests' => false,
	                'send_welcome'      => false,
	            ));
	$resultDecoded = json_decode($result, true);
	if($resultDecoded['status']='error')
	{
		header('Location: ../view/landing.php?error=1');
	}
}

else if(isset($_GET['user_email']))
{
	include('../vendor/drewm/mailchimp-api/MailChimp.php');
	$MailChimp = new \Drewm\MailChimp('b325e66745372713e98fc83055649de9-us8');
	$result = $MailChimp->call('lists/subscribe', array(
	                'id'                => '6b7043da5e',
	                'email'             => array('email'=>$_GET['user_email']),
	                'merge_vars'        => array('LINKID'=>$_GET['user_email']),
	                'double_optin'      => false,
	                'update_existing'   => false,
	                'replace_interests' => false,
	                'send_welcome'      => false,
	            ));
	$resultDecoded = json_decode($result, true);
	if($resultDecoded['status']='error')
	{
		header('Location: ../view/landing.php?error=1');
	}
}

else
{
	header('Location: ../view/landing.php');
}



