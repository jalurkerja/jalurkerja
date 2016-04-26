<?php 
	include_once "../common.php"; 
	
	if(isset($_GET["mode"])){ $_mode = $_GET["mode"]; } else { $_mode = ""; }
	
	if(isset($_POST["post_data"])){ parse_str($_POST["post_data"],$_POST); }
	if(isset($_POST["saving_company_profile_form"])){
		$arrlocation = explode(":",$_POST["location"]);
		$province_id = $arrlocation[0];
		$location_id = $arrlocation[1];
		$db->addtable("company_profiles");
		$db->addfield("name");$db->addvalue($_POST["name"]);
		$db->addfield("address");$db->addvalue($_POST["address"]);
		$db->addfield("province_id");$db->addvalue($province_id);
		$db->addfield("location_id");$db->addvalue($location_id);
		$db->addfield("zipcode");$db->addvalue($_POST["zipcode"]);
		$db->addfield("industry_id");$db->addvalue($_POST["industry_id"]);
		$db->addfield("phone");$db->addvalue($_POST["phone"]);
		$db->addfield("fax");$db->addvalue($_POST["fax"]);
		$db->addfield("email");$db->addvalue($_POST["email"]);
		$db->addfield("web");$db->addvalue($_POST["web"]);
		$db->addfield("first_name");$db->addvalue($_POST["first_name"]);
		$db->addfield("middle_name");$db->addvalue($_POST["middle_name"]);
		$db->addfield("last_name");$db->addvalue($_POST["last_name"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($__username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->where("id",$__company_id);
		$updating = $db->update();
		echo $updating["affected_rows"];
	}
	
	if(isset($_POST["saving_company_description_form"])){
		$db->addtable("company_profiles");
		$db->addfield("description");$db->addvalue($_POST["description"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($__username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->where("id",$__company_id);
		$updating = $db->update();
		echo $updating["error"];
	}
	
	if(isset($_POST["saving_company_join_reason_form"])){
		$db->addtable("company_profiles");
		$db->addfield("join_reason");$db->addvalue($_POST["join_reason"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($__username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->where("id",$__company_id);
		$updating = $db->update();
		echo $updating["affected_rows"];
	}

	if(	$_mode == "load_profile" || 
		$_mode == "edit_company_profile" || 
		$_mode == "edit_company_description" || 
		$_mode == "edit_company_join_reason"
	){ include_once "company_profile_data.php"; }
	
	if( $_mode == "load_applicant_management"
	){ include_once "company_profile_applicant_management.php"; }
?>
