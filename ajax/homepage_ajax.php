<?php 
	include_once "../common.php"; 
	
	$_mode = $_GET["mode"];
	
	if($_mode == "signup"){ echo $js->signup($_GET["namalengkap"],$_GET["email"],$_GET["password"],$_GET["repassword"]); }
?>
