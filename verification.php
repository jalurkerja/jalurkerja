<?php 
	include_once "common.php";
	$token = explode("|",base64_decode($_GET["token"]));
	$email = $token[0]; $token = $token[1];
	$user_id = $db->fetch_single_data("users","id",array("email" => $email));
	$signup_token = $db->fetch_single_data("users","token",array("id" => $user_id));
	if($token == $signup_token) {
		$db->addtable("users");$db->where("id",$user_id);
		$db->addfield("is_confirmed");$db->addvalue(1);
		$db->addfield("confirmed_at");$db->addvalue(date("Y-m-d H:i:s"));
		$updating = $db->update();
		if($updating >= 0){
			$password = base64_decode($db->fetch_single_data("users","password",array("id" => $user_id)));
			?>
			<form method="POST" id="loginform" name="loginform" action="index.php">
				<input type="hidden" name="login_action" value="1">
				<input type="hidden" name="username" value="<?=$email;?>">
				<input type="hidden" name="password" value="<?=$password;?>">
				<input type="hidden" name="email_verification" value="1">
			</form>
			<script> loginform.submit(); </script>
			<?php
		} else {
			?> <script> window.location="index.php?verification_failed=1"; </script> <?php
		}
	} else {
		?> <script> window.location="index.php?verification_failed=1"; </script> <?php
	}
?>