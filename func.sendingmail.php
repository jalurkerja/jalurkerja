<?php
function sendingmail($subject,$address,$body) {
	require_once("phpmailer/class.phpmailer.php");
	include_once("phpmailer/class.smtp.php");
	$mail             = new PHPMailer();
	$mail->IsSMTP(); 
	$mail->Host       = "iix78.rumahweb.com";
	$mail->SMTPDebug  = 0;
	$mail->SMTPAuth   = true;
	$mail->SMTPSecure = 'ssl';
	$mail->Host       = "iix78.rumahweb.com";
	$mail->Port       = 465;
	$mail->Username   = "xxx@xxxxxxx.xxx";
	$mail->Password   = "xxxxxxx";
	$mail->SMTPKeepAlive = true;  
	$mail->Mailer = "smtp"; 
	$mail->CharSet = 'utf-8';  

	$mail->SetFrom('cs@jalurkerja.com', 'Customer Service JalurKerja.com');
	$mail->AddReplyTo("cs@jalurkerja.com","Customer Service JalurKerja.com");
	$mail->Subject    = $subject;

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";

	$mail->MsgHTML($body);

	$mail->AddAddress($address);

	if(!$mail->Send()) { return "0"; } else { return "1"; }
}
?>