<?php
echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n";
define('GUSER', 'kingofdelphi1992@gmail.com'); // GMail username
define('GPWD', 'CodeCracker1234'); // GMail password
require_once "vendor/autoload.php";
function smtpmailer($to, $from, $from_name, $subject, $body) { 
	global $error;
	$mail = new PHPMailer();  // create a new object
    $mail->SMTPDebug = 8;
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587; 
	$mail->Username = GUSER;  
	$mail->Password = GPWD;           
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}
smtpmailer('uttam_khanal12@hotmail.com', 'kingofdelphi1992@mail.com', 'hi', 'test mail message', 'Hello World!');
echo $error;

