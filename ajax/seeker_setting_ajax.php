<?php 
	include_once "../common.php"; 
	
	if(isset($_GET["mode"])){ $_mode = $_GET["mode"]; } else { $_mode = ""; }
	if(isset($_POST["post_data"])){ parse_str($_POST["post_data"],$_POST); }
	
	if(isset($_POST["saving_edit_change_password_form"])){
		$db->addtable("users");$db->addfield("password");$db->where("id",$__user_id);$db->limit(0);
		$current_password = base64_decode($db->fetch_data(false,0));
		if($current_password == $_POST["current_password"]){
			if($_POST["new_password"] == $_POST["confirm_password"]){
				$db->addtable("users");$db->addfield("password");$db->addvalue(base64_encode($_POST["new_password"]));$db->where("id",$__user_id);
				$updating = $db->update();
				echo $updating["affected_rows"];
			} else {
				echo "error:wrong_new_password";
			}
		} else {
			echo "error:wrong_password";
		}
	}
	
	if(isset($_POST["saving_edit_application_form"])){
		$db->addtable("seeker_summary");
		$db->addfield("available_date");$db->addvalue($_POST["available_date"]);
		$db->addfield("availability_id");$db->addvalue($_POST["availability_id"]);
		$db->addfield("cover_letter");$db->addvalue($_POST["cover_letter"]);
		$db->where("user_id",$__user_id);
		$updating = $db->update();
		echo $updating["affected_rows"];
	}
	
	if(isset($_POST["saving_edit_setting_form"])){
		$db->addtable("seeker_setting");
		$db->addfield("get_job_alert");$db->addvalue($_POST["get_job_alert"]);
		$db->addfield("get_newsletter");$db->addvalue($_POST["get_newsletter"]);
		$db->where("user_id",$__user_id);
		$updating = $db->update();
		echo $updating["affected_rows"];
	}
?>