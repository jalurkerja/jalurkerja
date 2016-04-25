<?php 
	include_once "common.php";
	if(isset($_GET["just_signup"]) || $_GET["just_signup"] != "" ){
		$signup_email = $db->fetch_single_data("users","email",array("id" => $__user_id));
		
		if($db->fetch_single_data("users","token",array("id" => $__user_id)) == ""){
			$token = ""; for($xx = 0;$xx < 40; $xx++){ $token .= rand(0,9); }
			$signup_email_token = base64_encode($signup_email."|".$token);
			
			$db->addtable("users");$db->where("id",$__user_id);
			$db->addfield("token");$db->addvalue($token);$db->update();

			include_once "func.sendingmail.php";
			$body = "Dear Pencari Kerja,<br><br>
	Terima Kasih atas registrasi Anda di website JalurKerja.com.<br>
	Silakan klik link berikut untuk verifikasi email Anda:<br><br>
	<a href='http://www.jalurkerja.com/verification.php?token=".$signup_email_token."'>www.jalurkerja.com/verification.php?token=".$signup_email_token."</a><br><br><br>
	Salah Hangat,<br><br><br>
	Customer Service<br>
	JalurKerja.com";

			sendingmail("Email Konfirmasi - JalurKerja.com",$signup_email,$body);
		}
	}
	
	if(isset($_POST["save_just_signup"])){
		$birthplace = explode(":",$_POST["birthplace"]);
		
		$db->addtable("locations");$db->addfield("id");$db->where("province_id",$birthplace[0]);$db->where("location_id",$birthplace[1]);$db->limit(0);
		$birthplace_id = $db->fetch_data(false,0);
		
		$location = explode(":",$_POST["location"]);
		$province_id = $location[0]; $location_id = $location[1];
		$db->addtable("seeker_profiles");
		$db->addfield("first_name");$db->addvalue($_POST["first_name"]);
		$db->addfield("middle_name");$db->addvalue($_POST["middle_name"]);
		$db->addfield("last_name");$db->addvalue($_POST["last_name"]);
		$db->addfield("address");$db->addvalue($_POST["address"]);
		$db->addfield("province_id");$db->addvalue($province_id);
		$db->addfield("location_id");$db->addvalue($location_id);
		$db->addfield("zipcode");$db->addvalue($_POST["zipcode"]);
		$db->addfield("phone");$db->addvalue($_POST["phone"]);
		$db->addfield("cellphone");$db->addvalue($_POST["cellphone"]);
		$db->addfield("fax");$db->addvalue($_POST["fax"]);
		$db->addfield("web");$db->addvalue($_POST["web"]);
		$db->addfield("birthdate");$db->addvalue($_POST["birthdate"]);
		$db->addfield("birthplace");$db->addvalue($birthplace_id);
		$db->addfield("nationality");$db->addvalue($_POST["nationality"]);
		$db->addfield("gender_id");$db->addvalue($_POST["gender_id"]);
		$db->addfield("marital_status_id");$db->addvalue($_POST["marital_status_id"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($__username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->addfield("photo");$db->addvalue($__user_id.".".pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));
		$db->where("user_id",$__user_id);
		$updating = $db->update();
		include_once "head.php";
		if($updating["affected_rows"] >= 0){
			move_uploaded_file($_FILES['photo']['tmp_name'], "seekers_photo/".$__user_id.".".pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));
			?> <script> popup_message("<?=$v->words("your_profile_successfully_saved");?>","","window.location='<?=$_SERVER["PHP_SELF"];?>';"); </script><?php
		} else {
			?> <script> popup_message("<?=$v->words("your_profile_fails_to_be_saved");?>","error_message","window.location='<?=$_SERVER["PHP_SELF"];?>';"); </script><?php
		}
	}
	
?>
