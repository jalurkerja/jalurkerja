<?php include_once "head.php"; ?>
<?php
	$signup_email 	= $db->fetch_single_data("users","email",array("id" => $__user_id));
	$token 			= $db->fetch_single_data("users","token",array("id" => $__user_id));
	
	$signup_email_token = base64_encode($signup_email."|".$token);

	include_once "func.sendingmail.php";
	$body = "Dear Pencari Kerja,<br><br>
Terima Kasih atas registrasi Anda di website JalurKerja.com.<br>
Silakan klik link berikut untuk verifikasi email Anda:<br><br>
<a href='http://www.jalurkerja.com/verification.php?token=".$signup_email_token."'>www.jalurkerja.com/verification.php?token=".$signup_email_token."</a><br><br><br>
Salah Hangat,<br><br><br>
Customer Service<br>
JalurKerja.com";

	sendingmail("Email Konfirmasi - JalurKerja.com",$signup_email,$body);
	echo "Email Sent";
?>
<script>window.close();</script>