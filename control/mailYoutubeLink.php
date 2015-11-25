<?php

require '../vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
include_once('../model/get_curator_name.php'); // returns $curatorName
//echo($curatorName);

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->CharSet = 'UTF-8';
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.mail.yahoo.com';  				// Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'arthur.rougier@yahoo.com';                 // SMTP username
$mail->Password = 'Kfht5pjj';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->From = 'contact@soundpark.fm';
$mail->FromName = 'Arthur et Thomas';
$mail->addAddress('thomas.bouttefort@gmail.com', 'Thomas');     // Add a recipient  
$mail->addReplyTo('contact@soundpark.fm', 'Arthur et Thomas');


$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Youtube link from '.$curatorName;
$mail->Body    = "<head>
    <title>Soundpark</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <style>

		*{ margin:0; }

		@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,300,600);

		h1, h2, h3, h4, h5, h6 {
		  margin: 10px 0;
		  font-family: inherit;
		  font-weight: bold;
		  line-height: 30px;
		  color: inherit;
		  text-rendering: optimizelegibility; }
		  h1 small, h2 small, h3 small, h4 small, h5 small, h6 small {
		    font-weight: normal;
		    line-height: 1;
		    color: #999999; }


		select,
		textarea,
		input[type='text'],
		input[type='password'],
		input[type='datetime'],
		input[type='datetime-local'],
		input[type='date'],
		input[type='month'],
		input[type='time'],
		input[type='week'],
		input[type='number'],
		input[type='email'],
		input[type='url'],
		input[type='search'],
		input[type='tel'],
		input[type='color'],
		.uneditable-input {
		  display: inline-block;
		  height: 20px;
		  padding: 4px 6px;
		  font-size: 14px;
		  line-height: 20px;
		  color: #555555;
		  -webkit-border-radius: 4px;
		  -moz-border-radius: 4px;
		  border-radius: 4px;
		  vertical-align: middle; }

		textarea,
		input[type='text'],
		input[type='password'],
		input[type='datetime'],
		input[type='datetime-local'],
		input[type='date'],
		input[type='month'],
		input[type='time'],
		input[type='week'],
		input[type='number'],
		input[type='email'],
		input[type='url'],
		input[type='search'],
		input[type='tel'],
		input[type='color'],
		.uneditable-input {
		  background-color: white;
		  border: 1px solid white;
		  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		  -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		  -webkit-transition: border linear 0.2s, box-shadow linear 0.2s;
		  -moz-transition: border linear 0.2s, box-shadow linear 0.2s;
		  -o-transition: border linear 0.2s, box-shadow linear 0.2s;
		  transition: border linear 0.2s, box-shadow linear 0.2s; }

		  textarea:focus,
		  input[type='text']:focus,
		  input[type='password']:focus,
		  input[type='datetime']:focus,
		  input[type='datetime-local']:focus,
		  input[type='date']:focus,
		  input[type='month']:focus,
		  input[type='time']:focus,
		  input[type='week']:focus,
		  input[type='number']:focus,
		  input[type='email']:focus,
		  input[type='url']:focus,
		  input[type='search']:focus,
		  input[type='tel']:focus,
		  input[type='color']:focus,
		  .uneditable-input:focus {
		    border-color: white;
		    outline: 0;
		    outline: thin dotted \9;
		    /* IE6-9 */
		    -webkit-box-shadow: inset 0 1px 1px white, 0 0 8px white;
		    -moz-box-shadow: inset 0 1px 1px white, 0 0 8px white;
		    box-shadow: inset 0 1px 1px white, 0 0 8px white; }
		  
		input[type='file'],
		input[type='image'],
		input[type='submit'],
		input[type='reset'],
		input[type='button'],
		input[type='radio'],
		input[type='checkbox'] {
		  width: auto; }



		.container {
		margin-right: auto;
		margin-left: auto;
		*zoom: 1; }
		.container:before, .container:after {
		display: table;
		content: '';
		line-height: 0; }
		.container:after {
		clear: both; }

		.container-fluid {
		padding-right: 20px;
		padding-left: 20px;
		*zoom: 1; }
		.container-fluid:before, .container-fluid:after {
		display: table;
		content: '';
		line-height: 0; }
		.container-fluid:after {
		clear: both; }


		#logo
		{
			width: 400px;
			margin-top: 30px;
			margin-bottom: 30px;
		}

		h1, h2, h3 {
		  font-family: 'Code';
		  text-align: center;
		  font-weight: normal; }

		#container
		{
		  margin: 15px 40px 15px 40px;
		  text-align: center;
		}

		p, ul, li
		{
			font-family: 'Open Sans';
			color: #797979;
		}

    </style>

 </head>



<div id='container'>

	<img id='logo' src='http://soundpark.fm/assets/pictures/logo.png'/></br>

	<p>Youtube link, gros :</br></br>
	".$curatorName." vient d'envoyer ".$_POST['curator_track']."</br></br></p>

</div>

";


$mail->AltBody = "Youtube link: ".$curatorName." vient d'envoyer ".$_POST['curator_track'];

if(!$mail->send()) {
    echo 'Message could not be sent';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else 
{
	$str = urlencode("Your youtube tune has been submitted, thanks!");
	echo("<script> window.location.href = '../view/curator_index.php?message=".$str."'; </script>");
	//include('http://localhost:8888/view/curatorDropPage.php?message=success');
}

