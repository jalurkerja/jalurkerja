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

	if(isset($_POST["saving_add_advertising"])){
		$db->addtable("company_profiles");$db->where("id",$__company_id);$db->limit(1);$company_profile = $db->fetch_data();
		
		$db->addtable("opportunities");
		$db->addfield("company_id");			$db->addvalue(@$__company_id);
		$db->addfield("title_id");				$db->addvalue(@$_POST["title"]);
		$db->addfield("title_en");				$db->addvalue(@$_POST["title"]);
		$db->addfield("job_type_id");			$db->addvalue(@$_POST["job_type_id"]);
		$db->addfield("industry_id");			$db->addvalue(@$_POST["industry_id"]);
		$db->addfield("web");					$db->addvalue($company_profile["web"]);
		$db->addfield("company_description");	$db->addvalue($company_profile["description"]);
		$location_id = explode(":",@$_POST["location"]);
		$db->addfield("province_id");			$db->addvalue($location_id[0]);
		$db->addfield("location_id");			$db->addvalue($location_id[1]);
		$db->addfield("job_level_ids");			$db->addvalue(sel_to_pipe(@$_POST["job_level_ids"]));
		$db->addfield("job_function_id");		$db->addvalue(@$_POST["job_function_id"]);
		$db->addfield("degree_id");				$db->addvalue(@$_POST["degree_id"]);
		$db->addfield("major_ids");				$db->addvalue(sel_to_pipe(@$_POST["major_ids"]));
		$db->addfield("experience_years");		$db->addvalue(@$_POST["experience_years"]);
		$db->addfield("gender");				$db->addvalue(sel_to_pipe(@$_POST["gender"]));
		$db->addfield("age_min");				$db->addvalue(@$_POST["age_min"]);
		$db->addfield("age_max");				$db->addvalue(@$_POST["age_max"]);
		$db->addfield("email");					$db->addvalue(@$_POST["email"]);
		$db->addfield("name");					$db->addvalue($company_profile["name"]);
		$db->addfield("salary_min");			$db->addvalue(@$_POST["salary_min"]);
		$db->addfield("salary_max");			$db->addvalue(@$_POST["salary_max"]);
		$db->addfield("is_syariah");			$db->addvalue(@$_POST["is_syariah"]);
		$db->addfield("is_freshgraduate");		$db->addvalue(@$_POST["is_freshgraduate"]);
		$db->addfield("requirement");			$db->addvalue(@$_POST["requirement"]);
		$db->addfield("contact_person");		$db->addvalue(@$_POST["contact_person"]);
		$db->addfield("description");			$db->addvalue(@$_POST["description"]);
		$db->addfield("closing_date");			$db->addvalue(@$_POST["closing_date"]);
		$db->addfield("posted_at");				$db->addvalue(@$_POST["posted_at"]);
		$db->addfield("is_question");			$db->addvalue(0);
		$db->addfield("created_at");			$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("created_by");			$db->addvalue($__username);
		$db->addfield("created_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->addfield("updated_at");			$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");			$db->addvalue($__username);
		$db->addfield("updated_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			echo $inserting["insert_id"];
		} else {
			echo "0";
		}
	}

	if(isset($_POST["saving_edit_advertising"])){
		$db->addtable("company_profiles");$db->where("id",$__company_id);$db->limit(1);$company_profile = $db->fetch_data();
		
		$db->addtable("opportunities");$db->where("id",@$_POST["opportunity_id"]);
		$db->addfield("company_id");			$db->addvalue(@$__company_id);
		$db->addfield("title_id");				$db->addvalue(@$_POST["title"]);
		$db->addfield("title_en");				$db->addvalue(@$_POST["title"]);
		$db->addfield("job_type_id");			$db->addvalue(@$_POST["job_type_id"]);
		$db->addfield("industry_id");			$db->addvalue(@$_POST["industry_id"]);
		$db->addfield("web");					$db->addvalue($company_profile["web"]);
		$db->addfield("company_description");	$db->addvalue($company_profile["description"]);
		$location_id = explode(":",@$_POST["location"]);
		$db->addfield("province_id");			$db->addvalue($location_id[0]);
		$db->addfield("location_id");			$db->addvalue($location_id[1]);
		$db->addfield("job_level_ids");			$db->addvalue(sel_to_pipe(@$_POST["job_level_ids"]));
		$db->addfield("job_function_id");		$db->addvalue(@$_POST["job_function_id"]);
		$db->addfield("degree_id");				$db->addvalue(@$_POST["degree_id"]);
		$db->addfield("major_ids");				$db->addvalue(sel_to_pipe(@$_POST["major_ids"]));
		$db->addfield("experience_years");		$db->addvalue(@$_POST["experience_years"]);
		$db->addfield("gender");				$db->addvalue(sel_to_pipe(@$_POST["gender"]));
		$db->addfield("age_min");				$db->addvalue(@$_POST["age_min"]);
		$db->addfield("age_max");				$db->addvalue(@$_POST["age_max"]);
		$db->addfield("email");					$db->addvalue(@$_POST["email"]);
		$db->addfield("name");					$db->addvalue($company_profile["name"]);
		$db->addfield("salary_min");			$db->addvalue(@$_POST["salary_min"]);
		$db->addfield("salary_max");			$db->addvalue(@$_POST["salary_max"]);
		$db->addfield("is_syariah");			$db->addvalue(@$_POST["is_syariah"]);
		$db->addfield("is_freshgraduate");		$db->addvalue(@$_POST["is_freshgraduate"]);
		$db->addfield("requirement");			$db->addvalue(@$_POST["requirement"]);
		$db->addfield("contact_person");		$db->addvalue(@$_POST["contact_person"]);
		$db->addfield("description");			$db->addvalue(@$_POST["description"]);
		$db->addfield("closing_date");			$db->addvalue(@$_POST["closing_date"]);
		$db->addfield("posted_at");				$db->addvalue(@$_POST["posted_at"]);
		$db->addfield("updated_at");			$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");			$db->addvalue($__username);
		$db->addfield("updated_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$updating = $db->update();
		if($updating["affected_rows"] >= 0){
			echo $_POST["opportunity_id"];
		} else {
			echo "0";
		}
	}

	if(isset($_POST["saving_add_advertising2"])){
		$db->addtable("opportunity_filter_categories");$db->where("opportunity_id",$_POST["opportunity_id"]);$db->delete_();
		
		$job_level 			= (isset($_POST["job_level"])) ? "1":"0";
		$job_function 		= (isset($_POST["job_function"])) ? "1":"0";
		$location 			= (isset($_POST["location"])) ? "1":"0";
		$degree 			= (isset($_POST["degree"])) ? "1":"0";
		$major 				= (isset($_POST["major"])) ? "1":"0";
		$age 				= (isset($_POST["age"])) ? "1":"0";
		$salary 			= (isset($_POST["salary"])) ? "1":"0";
		$industry 			= (isset($_POST["industry"])) ? "1":"0";
		$gender 			= (isset($_POST["gender"])) ? "1":"0";
		$experience_years 	= (isset($_POST["experience_years"])) ? "1":"0";
		
		$db->addtable("opportunity_filter_categories");
		$db->addfield("opportunity_id");	$db->addvalue($_POST["opportunity_id"]);
		$db->addfield("job_level");			$db->addvalue($job_level);
		$db->addfield("job_function");		$db->addvalue($job_function);
		$db->addfield("location");			$db->addvalue($location);
		$db->addfield("degree");			$db->addvalue($degree);
		$db->addfield("major");				$db->addvalue($major);
		$db->addfield("age");				$db->addvalue($age);
		$db->addfield("salary");			$db->addvalue($salary);
		$db->addfield("industry");			$db->addvalue($industry);
		$db->addfield("gender");			$db->addvalue($gender);
		$db->addfield("experience_years");	$db->addvalue($experience_years);
		$inserting = $db->insert();
		echo $inserting["affected_rows"];
	}
	
	if($_mode == "generate_token"){ echo $db->generate_token($_GET["id_key"]); }

	if(	$_mode == "load_profile" || 
		$_mode == "edit_company_profile" || 
		$_mode == "edit_company_description" || 
		$_mode == "edit_company_join_reason"
	){ include_once "company_profile_data.php"; }
	
	if( $_mode == "load_applicant_management"
	){ include_once "company_profile_applicant_management.php"; }
	
	if( $_mode == "load_advertising"
	){ include_once "company_profile_advertising.php"; }
?>
