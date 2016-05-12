<?php
if(isset($_GET["logout_action"])){
	
	$db->addtable("log_histories"); 
	$db->addfield("user_id");$db->addvalue($__user_id);
	$db->addfield("email");$db->addvalue($__username);
	$db->addfield("x_mode");$db->addvalue(2);
	$db->addfield("log_at");$db->addvalue(date("Y-m-d H:i:s"));
	$db->addfield("log_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
	$db->insert(); 
	
	$_SESSION=array();
	session_destroy();
	
	?> <script language="javascript"> window.location='index.php'; </script><?php
}
if(isset($_POST["login_action"])){
	$db->addtable("users");
	$db->addfield("id");
	$db->addfield("password");
	$db->addfield("company_profiles_id");
	$db->addfield("locale");
	$db->addfield("is_confirmed");
	$db->addfield("sign_in_count");
	$db->addfield("current_sign_in_at");
	$db->addfield("last_sign_in_at");
	$db->addfield("current_sign_in_ip");
	$db->addfield("last_sign_in_ip");
	$db->where("email",str_replace(" ","",$_POST["username"]));
	$db->limit(1);
	$users = $db->fetch_data();
	if(count($users) > 0){
		if($users["password"] == base64_encode($_POST["password"])){
			$_SESSION["errormessage"] = "";
			$_SESSION["username"] = $_POST["username"];
			$_SESSION["isloggedin"] = 1;
			$_SESSION["user_id"] = $users["id"];
			$_SESSION["is_seeker"] = true;
			setcookie("locale",$users["locale"]);
			
			$db->addtable("cso_profiles");
			$db->addfield("id");
			$db->addfield("name");
			$db->where("user_id",$users["id"]);
			$db->limit(1);
			$cso_profiles = $db->fetch_data();
			if(count($cso_profiles) > 0) { //merupakan user CSO
				$_SESSION["cso_id"] = $cso_profiles["id"];			
				$_SESSION["cso_name"] = $cso_profiles["name"];			
			}
			
			$db->addtable("seeker_profiles");
			$db->addfield("first_name");
			$db->where("user_id",$users["id"]);
			$db->limit(1);
			$seeker_profiles = $db->fetch_data();
			$_SESSION["first_name"] = @$seeker_profiles["first_name"];
			
			if($users["company_profiles_id"]!=""){
				$db->addtable("company_profiles");
				$db->addfield("name");
				$db->addfield("first_name");
				$db->where("id",$users["company_profiles_id"]);
				$db->limit(1);
				$company_profiles = $db->fetch_data();
				if(count($company_profiles) >0) { //merupakan company
					$_SESSION["company_profiles_id"] = $users["company_profiles_id"];
					$_SESSION["company_first_name"] = $company_profiles["first_name"];
					$_SESSION["company_name"] = $company_profiles["name"];
					$_SESSION["first_name"] = $company_profiles["name"];
					$_SESSION["is_seeker"] = false;
				}
			}
			
			$db->addtable("users"); 
			$db->where("id",$users["id"]);
			$db->addfield("sign_in_count");$db->addvalue($users["sign_in_count"] + 1);
			$db->addfield("current_sign_in_at");$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("last_sign_in_at");$db->addvalue($users["current_sign_in_at"]);
			$db->addfield("current_sign_in_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$db->addfield("last_sign_in_ip");$db->addvalue($users["current_sign_in_ip"]);
			$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("updated_by");$db->addvalue($_POST["username"]);
			$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$db->update(); 
			
			
			$db->addtable("log_histories"); 
			$db->addfield("user_id");$db->addvalue($users["id"]);
			$db->addfield("email");$db->addvalue($_POST["username"]);
			$db->addfield("x_mode");$db->addvalue(1);
			$db->addfield("log_at");$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("log_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$db->insert(); 
			
			$db->addtable("seeker_profiles");$db->where("user_id",$users["id"]);$db->limit(1);
			if(count($db->fetch_data(true)) == 0) { 
				$db->addtable("seeker_profiles");
				$db->addfield("user_id");$db->addvalue($users["id"]);
				$db->addfield("created_at");$db->addvalue(date("Y-m-d H:i:s"));
				$db->addfield("created_by");$db->addvalue($_POST["username"]);
				$db->addfield("created_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
				$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
				$db->addfield("updated_by");$db->addvalue($_POST["username"]);
				$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
				$db->insert(); 
			}
			
			$db->addtable("seeker_summary");$db->where("user_id",$users["id"]);$db->limit(1);
			if(count($db->fetch_data(true)) == 0) { 
				$db->addtable("seeker_summary");
				$db->addfield("user_id");$db->addvalue($users["id"]);
				$db->addfield("created_at");$db->addvalue(date("Y-m-d H:i:s"));
				$db->addfield("created_by");$db->addvalue($_POST["username"]);
				$db->addfield("created_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
				$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
				$db->addfield("updated_by");$db->addvalue($_POST["username"]);
				$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
				$db->insert(); 
			}
			
			$db->addtable("seeker_setting");$db->where("user_id",$users["id"]);$db->limit(1);
			if(count($db->fetch_data(true)) == 0) { 
				$db->addtable("seeker_setting");
				$db->addfield("user_id");$db->addvalue($users["id"]);
				$db->addfield("get_job_alert");$db->addvalue(1);
				$db->addfield("get_newsletter");$db->addvalue(1);
				$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
				$db->addfield("updated_by");$db->addvalue($_POST["username"]);
				$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
				$db->insert(); 
			}

			if(isset($_POST["email_verification"])) {
				?> <script language="javascript"> window.location='<?=basename($_SERVER["PHP_SELF"]);?>?email_confirmed=1'; </script><?php
			}else if(!isset($_POST["opportunity_id"]) || $_POST["opportunity_id"] == "") {
				?> <script language="javascript"> window.location='<?=basename($_SERVER["PHP_SELF"]);?>?<?=$_SERVER["QUERY_STRING"];?>'; </script><?php
			} else {
				echo $f->start("form_apply_after_login","POST",basename($_SERVER["PHP_SELF"])); echo $f->input("apply_after_login",$_POST["opportunity_id"],"type='hidden'"); echo $f->end();
				?> <script language="javascript"> form_apply_after_login.submit(); </script><?php
			}
			exit();
		} else {
			$_SESSION["errormessage"] = $v->words("error_wrong_username_password");
		}
	} else {
		$_SESSION["errormessage"] = $v->words("error_wrong_username_password");
	}
	?> <script language="javascript"> window.location='<?=basename($_SERVER["PHP_SELF"]);?>'; </script><?php
	exit();
}
?>