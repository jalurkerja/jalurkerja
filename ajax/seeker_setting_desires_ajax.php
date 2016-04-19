<?php 
	include_once "../common.php"; 
	
	if(isset($_GET["mode"])){ $_mode = $_GET["mode"]; } else { $_mode = ""; }
	if(isset($_POST["post_data"])){ parse_str($_POST["post_data"],$_POST); }
	
	if(isset($_POST["saving_edit_desires_form"])){
		$db->addtable("seeker_desires");$db->where("user_id",$__user_id);$db->limit(1);
		if(count($db->fetch_data(true)) == 0) {
			$db->addtable("seeker_desires");
			$db->addfield("user_id");$db->addvalue($__user_id);
			$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("updated_by");$db->addvalue($_POST["username"]);
			$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$db->insert(); 
		}
		$db->addtable("seeker_desires");
		$db->addfield("job_type_ids");$db->addvalue(sb_to_pipe($_POST["job_types"]));
		$db->addfield("job_level_ids");$db->addvalue(sb_to_pipe($_POST["job_levels"]));
		$db->addfield("job_function_ids");$db->addvalue(sb_to_pipe($_POST["job_functions"]));
		$db->addfield("job_category_ids");$db->addvalue(sb_to_pipe($_POST["job_categories"]));
		$db->addfield("industry_ids");$db->addvalue(sb_to_pipe($_POST["industries"]));
		$db->addfield("location_ids");$db->addvalue(sb_to_pipe($_POST["locations"]));
		$db->addfield("salary_min");$db->addvalue($_POST["salary_min"]);
		$db->addfield("salary_max");$db->addvalue($_POST["salary_max"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($_POST["username"]);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->where("user_id",$__user_id);
		$updating = $db->update();
		echo $updating["affected_rows"];
	}
?>