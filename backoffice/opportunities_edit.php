<?php include_once "head.php";?>
<?php include_once "opportunities_js.php";?>
<div class="bo_title">Add Opportunity</div>
<?php
	if(isset($_POST["save"])){
		$db->addtable("opportunities");			$db->where("id",$_GET["id"]);
		$db->addfield("company_id");			$db->addvalue($_POST["company_id"]);
		$db->addfield("title_id");				$db->addvalue($_POST["title_id"]);
		$db->addfield("title_en");				$db->addvalue($_POST["title_en"]);
		$db->addfield("job_type_id");			$db->addvalue($_POST["job_type_id"]);
		$db->addfield("job_category_id");		$db->addvalue($_POST["job_category_id"]);
		$db->addfield("industry_id");			$db->addvalue($_POST["industry_id"]);
		$db->addfield("web");					$db->addvalue($_POST["web"]);
		$db->addfield("company_description");	$db->addvalue($_POST["company_description"]);
		$location_id = explode(":",$_POST["location"]);
		$db->addfield("province_id");			$db->addvalue($location_id[0]);
		$db->addfield("location_id");			$db->addvalue($location_id[1]);
		$db->addfield("job_level_ids");			$db->addvalue(sel_to_pipe($_POST["job_level_ids"]));
		$db->addfield("job_function_id");		$db->addvalue($_POST["job_function_id"]);
		$db->addfield("degree_id");				$db->addvalue($_POST["degree_id"]);
		$db->addfield("major_ids");				$db->addvalue(sel_to_pipe($_POST["major_ids"]));
		$db->addfield("experience_years");		$db->addvalue($_POST["experience_years"]);
		$db->addfield("email");					$db->addvalue($_POST["email"]);
		$db->addfield("name");					$db->addvalue($_POST["company_name"]);
		$db->addfield("salary_min");			$db->addvalue($_POST["salary_min"]);
		$db->addfield("salary_max");			$db->addvalue($_POST["salary_max"]);
		$db->addfield("requirement");			$db->addvalue($_POST["requirement"]);
		$db->addfield("contact_person");		$db->addvalue($_POST["contact_person"]);
		$db->addfield("description");			$db->addvalue($_POST["description"]);
		$db->addfield("closing_date");			$db->addvalue($_POST["closing_date"]);
		$db->addfield("posted_at");				$db->addvalue($_POST["posted_at"]);
		$db->addfield("is_question");			$db->addvalue($_POST["is_question"]);
		$db->addfield("matched_applicant");		$db->addvalue($_POST["matched_applicant"]);
		$db->addfield("unmatched_applicant");	$db->addvalue($_POST["unmatched_applicant"]);
		$db->addfield("expired_in_months");		$db->addvalue($_POST["expired_in_months"]);
		$db->addfield("expired_date");			$db->addvalue($_POST["expired_date"]);
		$db->addfield("email_format");			$db->addvalue($_POST["email_format"]);
		$db->addfield("is_emailing_unmatched");	$db->addvalue($_POST["is_emailing_unmatched"]);
		$db->addfield("created_at");			$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("created_by");			$db->addvalue($__username);
		$db->addfield("created_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->addfield("updated_at");			$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");			$db->addvalue($__username);
		$db->addfield("updated_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$updating = $db->update();
		if($updating["affected_rows"] >= 0){
			if($_FILES['logo']['tmp_name']) {
				move_uploaded_file($_FILES['logo']['tmp_name'], "../opportunity_logo/".$_GET["id"].".".pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));
				$db->addtable("opportunities");$db->where("id",$_GET["id"]);
				$db->addfield("logo");$db->addvalue($_GET["id"].".".pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));$db->update();
			}
			javascript("alert('Data Berhasil tersimpan');");
		} else {
			javascript("alert('Data gagal tersimpan');");
		}
	}
	
	$db->addtable("opportunities");	$db->where("id",$_GET["id"]); $db->limit(1);
	$opportunity = $db->fetch_data();
	
	$txt_company 				= $f->input("company_name",$opportunity["name"],"style='width:300px;' autocomplete='off' onkeyup='loadSelectCompanies(this.value,event.keyCode);'").$f->input("company_id",$opportunity["company_id"],"type='hidden'");
	$txt_company 				.= "	<div style=\"position:absolute;display:none;\" id=\"div_select_company\">
										<table style=\"border:grey solid 1px; background-color:#EFEFEF;\">
											<tr><td id=\"select_company\"></td></tr>
										</table>
										</div>";
	$txt_title_id 				= $f->input("title_id",$opportunity["title_id"]);
	$txt_title_en 				= $f->input("title_en",$opportunity["title_en"]);
	$sel_job_type 				= $f->select("job_type_id",$db->fetch_select_data("job_type","id","name_en"),$opportunity["job_type_id"]);
	$sel_category				= $f->select("job_category_id",$db->fetch_select_data("job_categories","id","name_en"),$opportunity["job_category_id"]);
	$sel_industry				= $f->select("industry_id",$db->fetch_select_data("industries","id","name_en"),$opportunity["industry_id"]);
	$txt_web	 				= $f->input("web",$opportunity["web"]);
	$txt_company_description	= $f->textarea("company_description",$opportunity["company_description"]);
	$sel_location 				= $f->select("location",$db->fetch_select_data("locations","concat(province_id,':',location_id) as location_id","name_en"),$opportunity["province_id"].":".$opportunity["location_id"]);
	$sm_job_levels 				= $f->select_multiple("job_level_ids",$db->fetch_select_data("job_level","id","name_en"),pipetoarray($opportunity["job_level_ids"]));
	$sel_function				= $f->select("job_function_id",$db->fetch_select_data("job_functions","id","name_en"),$opportunity["job_function_id"]);
	$sel_degree					= $f->select("degree_id",$db->fetch_select_data("degree","id","name_en"),$opportunity["degree_id"]);
	$majors = $db->fetch_select_data("majors","id","name_en"); asort($majors);
	$sm_majors	 				= $f->select_multiple("major_ids",$majors,pipetoarray($opportunity["major_ids"]));
	$txt_experience				= $f->input("experience_years",$opportunity["experience_years"]);
	$txt_email					= $f->input("email",$opportunity["email"]);
	$txt_name					= $f->input("name",$opportunity["name"]);
	
	$salaries					= $db->fetch_select_data("salaries","id","salary");
	$salary_range 				= $f->select("salary_min",$salaries,$opportunity["salary_min"]) ." - ". 
								  $f->select("salary_max",$salaries,$opportunity["salary_max"]);
								  
	$txt_requirement			= $f->textarea("requirement",$opportunity["requirement"]);
	$txt_contact_person			= $f->input("contact_person",$opportunity["contact_person"]);
	$txt_description			= $f->textarea("description",$opportunity["description"]);
	$date_closing_date			= $f->input_tanggal("closing_date",$opportunity["closing_date"]);
	$date_posted_at				= $f->input_tanggal("posted_at",$opportunity["posted_at"]);
	
	if(@filesize("../opportunity_logo/".$opportunity["logo"])>4096) 
		$logo = "<img src='../opportunity_logo/".$opportunity["logo"]."' width='150'><br>"; 
	else $logo = "";
	$txt_logo = $logo.$f->input("logo","","type='file'");
?>
<?=$f->start("","POST","","enctype='multipart/form-data'");?>
	<?=$t->start("","editor_content");?>
		<?=$t->row(array("Company Name",$txt_company));?>
		<?=$t->row(array("Title (Indonesia)",$txt_title_id));?>
		<?=$t->row(array("Title (English)",$txt_title_en));?>
		<?=$t->row(array("Job Type",$sel_job_type));?>
		<?=$t->row(array("Category",$sel_category));?>
		<?=$t->row(array("Industry",$sel_industry));?>
		<?=$t->row(array("Web",$txt_web));?>
		<?=$t->row(array("Company Description",$txt_company_description));?>
		<?=$t->row(array("Location",$sel_location));?>
		<?=$t->row(array("Job Level",$sm_job_levels));?>
		<?=$t->row(array("Job Function",$sel_function));?>
		<?=$t->row(array("Degree",$sel_degree));?>
		<?=$t->row(array("Majors",$sm_majors));?>
		<?=$t->row(array("Experiences year",$txt_experience));?>
		<?=$t->row(array("Email",$txt_email));?>
		<?=$t->row(array("Salaries",$salary_range));?>
		<?=$t->row(array("Requirement",$txt_requirement));?>
		<?=$t->row(array("Contact Person",$txt_contact_person));?>
		<?=$t->row(array("Description",$txt_description));?>
		<?=$t->row(array("Closing Date",$date_closing_date));?>
		<?=$t->row(array("Posted At",$date_posted_at));?>
		<?=$t->row(array("Logo",$txt_logo));?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
<?php include_once "footer.php";?>