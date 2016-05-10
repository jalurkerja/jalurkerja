<?php 
	include_once "../common.php"; 
	
	if(isset($_GET["mode"])){ $_mode = $_GET["mode"]; } else { $_mode = ""; }
	
	if(isset($_POST["post_data"])){ parse_str($_POST["post_data"],$_POST); }
	if(isset($_POST["saving_personal_data_form"])){
		$arrlocation = explode(":",$_POST["location"]);
		$province_id = $arrlocation[0];
		$location_id = $arrlocation[1];
		$arrbirthplace = explode(":",$_POST["birthplace"]);
		$db->addtable("locations");$db->addfield("id");$db->where("province_id",$arrbirthplace[0]);$db->where("location_id",$arrbirthplace[1]);$db->limit(1);
		$birthplace_id = $db->fetch_data(false,0);
		$db->addtable("seeker_profiles");
		$db->addfield("first_name");$db->addvalue(str_replace("'","''",$_POST["first_name"]));
		$db->addfield("middle_name");$db->addvalue(str_replace("'","''",$_POST["middle_name"]));
		$db->addfield("last_name");$db->addvalue(str_replace("'","''",$_POST["last_name"]));
		$db->addfield("address");$db->addvalue(str_replace("'","''",$_POST["address"]));
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
		$db->where("user_id",$__user_id);
		$updating = $db->update();
		echo $updating["affected_rows"];
	}
	
	if(isset($_POST["saving_add_work_experience_form"])){
		$db->addtable("seeker_experiences");
		$db->addfield("user_id");$db->addvalue($__user_id);
		$db->addfield("company_name");$db->addvalue($_POST["company_name"]);
		$db->addfield("position");$db->addvalue($_POST["position"]);
		$db->addfield("salary_min");$db->addvalue($_POST["salary_min"]);
		$db->addfield("salary_max");$db->addvalue($_POST["salary_max"]);
		$db->addfield("job_type_id");$db->addvalue($_POST["job_type_id"]);
		$db->addfield("job_level_id");$db->addvalue($_POST["job_level_id"]);
		$db->addfield("job_function_id");$db->addvalue($_POST["job_function_id"]);
		$db->addfield("job_category_id");$db->addvalue($_POST["job_category_id"]);
		$db->addfield("industry_id");$db->addvalue($_POST["industry_id"]);
		$db->addfield("description");$db->addvalue($_POST["description"]);
		$db->addfield("startdate");$db->addvalue($_POST["startdate"]);
		$db->addfield("enddate");$db->addvalue($_POST["enddate"]);
		$db->addfield("created_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("created_by");$db->addvalue($__username);
		$db->addfield("created_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($__username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$inserting = $db->insert();
		echo $inserting["affected_rows"];
	}
	
	if(isset($_POST["saving_edit_work_experience_form"])){
		$id_seeker_experiences = $_POST["id_seeker_experiences"];
		$db->addtable("seeker_experiences");
		$db->addfield("company_name");$db->addvalue($_POST["company_name"]);
		$db->addfield("position");$db->addvalue($_POST["position"]);
		$db->addfield("salary_min");$db->addvalue($_POST["salary_min"]);
		$db->addfield("salary_max");$db->addvalue($_POST["salary_max"]);
		$db->addfield("job_type_id");$db->addvalue($_POST["job_type_id"]);
		$db->addfield("job_level_id");$db->addvalue($_POST["job_level_id"]);
		$db->addfield("job_function_id");$db->addvalue($_POST["job_function_id"]);
		$db->addfield("job_category_id");$db->addvalue($_POST["job_category_id"]);
		$db->addfield("industry_id");$db->addvalue($_POST["industry_id"]);
		$db->addfield("description");$db->addvalue($_POST["description"]);
		$db->addfield("startdate");$db->addvalue($_POST["startdate"]);
		$db->addfield("enddate");$db->addvalue($_POST["enddate"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($__username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->where("id",$id_seeker_experiences);
		$db->where("user_id",$__user_id);
		$updating = $db->update();
		echo $updating["affected_rows"];
	}

	if( $_mode == "deleting_work_experience"){
		$id_seeker_experiences = $_GET["id_seeker_experiences"];
		$db->addtable("seeker_experiences");
		$db->where("id",$id_seeker_experiences);
		$db->where("user_id",$__user_id);
		$deleting = $db->delete_();
		echo $deleting["affected_rows"];
	}
	
	if(isset($_POST["saving_add_certification_form"])){
		$seqno = $db->fetch_single_data("seeker_certifications","seqno",array("user_id" => $__user_id),array("seqno DESC"));
		$seqno++;
		$db->addtable("seeker_certifications");
		$db->addfield("user_id");$db->addvalue($__user_id);
		$db->addfield("seqno");$db->addvalue($seqno);
		$db->addfield("name");$db->addvalue($_POST["name"]);
		$db->addfield("description");$db->addvalue($_POST["description"]);
		$db->addfield("issued_at");$db->addvalue($_POST["issued_at"]);
		$db->addfield("issued_by");$db->addvalue($_POST["issued_by"]);
		$db->addfield("created_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("created_by");$db->addvalue($__username);
		$db->addfield("created_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($__username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$inserting = $db->insert();
		echo $inserting["affected_rows"];
	}
	
	if(isset($_POST["saving_edit_certification_form"])){
		$id_seeker_certifications = $_POST["id_seeker_certifications"];
		$db->addtable("seeker_certifications");
		$db->addfield("name");$db->addvalue($_POST["name"]);
		$db->addfield("description");$db->addvalue($_POST["description"]);
		$db->addfield("issued_at");$db->addvalue($_POST["issued_at"]);
		$db->addfield("issued_by");$db->addvalue($_POST["issued_by"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($__username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->where("id",$id_seeker_certifications);
		$db->where("user_id",$__user_id);
		$updating = $db->update();
		echo $updating["affected_rows"];
	}

	if( $_mode == "deleting_certification"){
		$id_seeker_certifications = $_GET["id_seeker_certifications"];
		$db->addtable("seeker_certifications");
		$db->where("id",$id_seeker_certifications);
		$db->where("user_id",$__user_id);
		$deleting = $db->delete_();
		echo $deleting["affected_rows"];
	}
	
	if(isset($_POST["saving_add_education_form"])){
		$seqno = $db->fetch_single_data("seeker_educations","seqno",array("user_id" => $__user_id),array("seqno DESC"));
		$seqno++;
		$db->addtable("seeker_educations");
		$db->addfield("user_id");$db->addvalue($__user_id);
		$db->addfield("seqno");$db->addvalue($seqno);
		$db->addfield("school_id");$db->addvalue($_POST["school_id"]);
		$db->addfield("school_name");$db->addvalue($_POST["school_name"]);
		$db->addfield("start_year");$db->addvalue($_POST["start_year"]);
		$db->addfield("graduated_year");$db->addvalue($_POST["graduated_year"]);
		$db->addfield("degree_id");$db->addvalue($_POST["degree_id"]);
		$db->addfield("major_id");$db->addvalue($_POST["major_id"]);
		$db->addfield("gpa");$db->addvalue($_POST["gpa"]);
		$db->addfield("honors");$db->addvalue($_POST["honors"]);
		$db->addfield("created_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("created_by");$db->addvalue($__username);
		$db->addfield("created_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($__username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$inserting = $db->insert();
		echo $inserting["affected_rows"];
	}
	
	if(isset($_POST["saving_edit_education_form"])){
		$id_seeker_educations = $_POST["id_seeker_educations"];
		$db->addtable("seeker_educations");
		$db->addfield("school_id");$db->addvalue($_POST["school_id"]);
		$db->addfield("school_name");$db->addvalue($_POST["school_name"]);
		$db->addfield("start_year");$db->addvalue($_POST["start_year"]);
		$db->addfield("graduated_year");$db->addvalue($_POST["graduated_year"]);
		$db->addfield("degree_id");$db->addvalue($_POST["degree_id"]);
		$db->addfield("major_id");$db->addvalue($_POST["major_id"]);
		$db->addfield("gpa");$db->addvalue($_POST["gpa"]);
		$db->addfield("honors");$db->addvalue($_POST["honors"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($__username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->where("id",$id_seeker_educations);
		$db->where("user_id",$__user_id);
		$updating = $db->update();
		echo $updating["affected_rows"];
	}

	if( $_mode == "deleting_education"){
		$id_seeker_educations = $_GET["id_seeker_educations"];
		$db->addtable("seeker_educations");
		$db->where("id",$id_seeker_educations);
		$db->where("user_id",$__user_id);
		$deleting = $db->delete_();
		echo $deleting["affected_rows"];
	}
	
	if($_mode == "loadSelectSchool"){
		$_name = "%".str_replace(" ","%",$_GET["name"])."%";
		$schools = $db->fetch_select_data("schools","id","name_".$__locale,array("name_".$__locale => "$_name:LIKE"),array(),10);
		foreach($schools as $id_school => $name_school){ 
			$return .= "<div onclick=\"pickSelectSchoolList('".$id_school."','".$name_school."');\">".$name_school."</div>";
		}
		echo $return;
	}
	
	if(isset($_POST["saving_add_language_form"])){
		$db->addtable("seeker_languages");
		$db->addfield("user_id");$db->addvalue($__user_id);
		$db->addfield("language_id");$db->addvalue($_POST["language_id"]);
		$db->addfield("language_name");$db->addvalue($_POST["language_name"]);
		$db->addfield("speaking_level_id");$db->addvalue($_POST["speaking_level_id"]);
		$db->addfield("writing_level_id");$db->addvalue($_POST["writing_level_id"]);
		$db->addfield("created_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("created_by");$db->addvalue($__username);
		$db->addfield("created_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($__username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$inserting = $db->insert();
		echo $inserting["affected_rows"];
	}
	
	if(isset($_POST["saving_edit_language_form"])){
		$id_seeker_languages = $_POST["id_seeker_languages"];
		$db->addtable("seeker_languages");
		$db->addfield("language_id");$db->addvalue($_POST["language_id"]);
		$db->addfield("language_name");$db->addvalue($_POST["language_name"]);
		$db->addfield("speaking_level_id");$db->addvalue($_POST["speaking_level_id"]);
		$db->addfield("writing_level_id");$db->addvalue($_POST["writing_level_id"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($__username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->where("id",$id_seeker_languages);
		$db->where("user_id",$__user_id);
		$updating = $db->update();
		echo $updating["affected_rows"];
	}

	if( $_mode == "deleting_language"){
		$id_seeker_languages = $_GET["id_seeker_languages"];
		$db->addtable("seeker_languages");
		$db->where("id",$id_seeker_languages);
		$db->where("user_id",$__user_id);
		$deleting = $db->delete_();
		echo $deleting["affected_rows"];
	}
	
	if($_mode == "loadSelectLanguages"){
		$_name = "%".str_replace(" ","%",$_GET["name"])."%";
		$languages = $db->fetch_select_data("languages","id","name_".$__locale,array("name_".$__locale => "$_name:LIKE"),array(),10);
		foreach($languages as $id_language => $name_language){ 
			$return .= "<div onclick=\"pickSelectLanguageList('".$id_language."','".$name_language."');\">".$name_language."</div>";
		}
		echo $return;
	}
	
	if(isset($_POST["saving_add_skill_form"])){
		$db->addtable("seeker_skills");
		$db->addfield("user_id");$db->addvalue($__user_id);
		$db->addfield("name");$db->addvalue($_POST["name"]);
		$db->addfield("level_id");$db->addvalue($_POST["level_id"]);
		$db->addfield("created_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("created_by");$db->addvalue($__username);
		$db->addfield("created_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($__username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$inserting = $db->insert();
		echo $inserting["affected_rows"];
	}
	
	if(isset($_POST["saving_edit_skill_form"])){
		$id_seeker_skills = $_POST["id_seeker_skills"];
		$db->addtable("seeker_skills");
		$db->addfield("name");$db->addvalue($_POST["name"]);
		$db->addfield("level_id");$db->addvalue($_POST["level_id"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($__username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->where("id",$id_seeker_skills);
		$db->where("user_id",$__user_id);
		$updating = $db->update();
		echo $updating["affected_rows"];
	}

	if( $_mode == "deleting_skill"){
		$id_seeker_skills = $_GET["id_seeker_skills"];
		$db->addtable("seeker_skills");
		$db->where("id",$id_seeker_skills);
		$db->where("user_id",$__user_id);
		$deleting = $db->delete_();
		echo $deleting["affected_rows"];
	}
	
	if(isset($_POST["saving_edit_summary_form"])){
		$id_seeker_summary = $_POST["id_seeker_summary"];
		$db->addtable("seeker_summary");
		$db->addfield("summaries");$db->addvalue($_POST["summaries"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($__username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->where("id",$id_seeker_summary);
		$db->where("user_id",$__user_id);
		$updating = $db->update();
		echo $updating["affected_rows"];
	}

	if(	$_mode == "load_profile" || 
		$_mode == "edit_personal_data" || 
		$_mode == "add_work_experience" || 
		$_mode == "edit_work_experience" || 
		$_mode == "add_certification" || 
		$_mode == "edit_certification" ||
		$_mode == "add_education" || 
		$_mode == "edit_education" ||
		$_mode == "add_language" || 
		$_mode == "edit_language" ||
		$_mode == "add_skill" || 
		$_mode == "edit_skill" ||
		$_mode == "edit_summary"
	){ include_once "seeker_profile_personal_data.php"; }
	
	if(	$_mode == "load_setting_general" ){ 				include_once "seeker_profile_setting.php"; }
	
	if($_mode == "load_setting_desires" ){ 					include_once "seeker_profile_setting_desires.php"; }
	
	if($_mode == "load_setting_membership"){ 				echo ""; }
	
	if($_mode == "load_documents_saved_search"){ 			include_once "seeker_profile_saved_search.php"; }
	if($_mode == "load_documents_saved_opporunities"){ 		include_once "seeker_profile_saved_opporunities.php"; }
	if($_mode == "load_documents_applied_opporunities"){ 	include_once "seeker_profile_applied_opporunities.php"; }
?>
