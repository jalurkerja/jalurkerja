<?php include_once "head.php";?>
<?php include_once "opportunities_js.php";?>
<div class="bo_title">Add Opportunity</div>
<?php
	if(isset($_POST["save"])){
		if(@$_POST["company_id"] == ""){
			javascript("alert('Pastikan data terisi dengan benar!');");
		} else {
			$insert_success = false;
			foreach(@$_POST["locations"] as $key => $location){
				$_POST["location"] = $location;
				if($key == 0) $group_id = 0;
				$db->addtable("opportunities");
				$db->addfield("group_id");				$db->addvalue($group_id);
				$db->addfield("company_id");			$db->addvalue(@$_POST["company_id"]);
				$db->addfield("title_id");				$db->addvalue(@$_POST["title_id"]);
				$db->addfield("title_en");				$db->addvalue(@$_POST["title_en"]);
				$db->addfield("job_type_id");			$db->addvalue(@$_POST["job_type_id"]);
				$db->addfield("industry_id");			$db->addvalue(@$_POST["industry_id"]);
				$db->addfield("web");					$db->addvalue(@$_POST["web"]);
				$db->addfield("company_description");	$db->addvalue(@$_POST["company_description"]);
				$location_id = explode(":",$_POST["location"]);
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
				$db->addfield("name");					$db->addvalue(@$_POST["company_name"]);
				$db->addfield("salary_min");			$db->addvalue(@$_POST["salary_min"]);
				$db->addfield("salary_max");			$db->addvalue(@$_POST["salary_max"]);
				$db->addfield("is_syariah");			$db->addvalue(@$_POST["is_syariah"]);
				$db->addfield("is_freshgraduate");		$db->addvalue(@$_POST["is_freshgraduate"]);
				$db->addfield("requirement");			$db->addvalue(@$_POST["requirement"]);
				$db->addfield("contact_person");		$db->addvalue(@$_POST["contact_person"]);
				$db->addfield("description");			$db->addvalue(@$_POST["description"]);
				$db->addfield("closing_date");			$db->addvalue(@$_POST["closing_date"]);
				$db->addfield("posted_at");				$db->addvalue(@$_POST["posted_at"]);
				$db->addfield("is_question");			$db->addvalue(@$_POST["is_question"]);
				$db->addfield("matched_applicant");		$db->addvalue(@$_POST["matched_applicant"]);
				$db->addfield("unmatched_applicant");	$db->addvalue(@$_POST["unmatched_applicant"]);
				$db->addfield("expired_in_months");		$db->addvalue(@$_POST["expired_in_months"]);
				$db->addfield("expired_date");			$db->addvalue(@$_POST["expired_date"]);
				$db->addfield("email_format");			$db->addvalue(@$_POST["email_format"]);
				$db->addfield("is_emailing_unmatched");	$db->addvalue(@$_POST["is_emailing_unmatched"]);
				$db->addfield("created_at");			$db->addvalue(date("Y-m-d H:i:s"));
				$db->addfield("created_by");			$db->addvalue($__username);
				$db->addfield("created_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
				$db->addfield("updated_at");			$db->addvalue(date("Y-m-d H:i:s"));
				$db->addfield("updated_by");			$db->addvalue($__username);
				$db->addfield("updated_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
				$inserting = $db->insert();
				$insert_id = $inserting["insert_id"];
				if($key == 0) $group_id = $insert_id;
				if($inserting["affected_rows"] >= 0){
					$db->addtable("opportunity_filter_categories");
					$db->addfield("opportunity_id");	$db->addvalue($insert_id);
					$db->addfield("location");			$db->addvalue(1);
					$db->addfield("job_function");		$db->addvalue(1);
					$db->addfield("experience_years");	$db->addvalue(1);
					$db->addfield("job_level");			$db->addvalue(1);
					$db->addfield("degree");			$db->addvalue(1);
					$db->addfield("major");				$db->addvalue(0);
					$db->addfield("age");				$db->addvalue(0);
					$db->addfield("salary");			$db->addvalue(0);
					$db->addfield("industry");			$db->addvalue(0);
					$db->addfield("gender");			$db->addvalue(0);
					$db->insert();
					
					if($_FILES['logo']['tmp_name']) {
						move_uploaded_file($_FILES['logo']['tmp_name'], "../opportunity_logo/".$insert_id.".".pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));
						$db->addtable("opportunities");$db->where("id",$insert_id);
						$db->addfield("logo");$db->addvalue($insert_id.".".pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));$db->update();
					}
					$error_message = "Data Berhasil tersimpan";
					$insert_success = true;
				} else {
					$error_message = "Data gagal tersimpan";
				}
			}
			javascript("alert('".$error_message."');");
			if($insert_success) javascript("window.location='opportunities_edit.php?id=".$group_id."';");
		}
	}
	
	$txt_company 				= $f->input("company_name",@$_POST["company_name"],"style='width:300px;' autocomplete='off' onkeyup='loadSelectCompanies(this.value,event.keyCode);'");
	$txt_company 				.= "	<div style=\"position:absolute;display:none;\" id=\"div_select_company\">
										<table style=\"border:grey solid 1px; background-color:#EFEFEF;\">
											<tr><td id=\"select_company\"></td></tr>
										</table>
										</div>";
	$txt_company_id				= $f->input("company_id",@$_POST["company_id"],"readonly style='width:300px;' autocomplete='off'");
	$txt_title_id 				= $f->input("title_id",@$_POST["title_id"]);
	$txt_title_en 				= $f->input("title_en",@$_POST["title_en"]);
	$sel_job_type 				= $f->select("job_type_id",$db->fetch_select_data("job_type","id","name_en"),@$_POST["job_type_id"]);
	$sel_industry				= $f->select("industry_id",$db->fetch_select_data("industries","id","name_en",array(),array("name_en")),@$_POST["industry_id"]);
	$txt_web	 				= $f->input("web",@$_POST["web"]);
	$txt_company_description	= $f->textarea("company_description",@$_POST["company_description"]);
	$sel_location 				= $f->select("location",$db->fetch_select_data("locations","concat(province_id,':',location_id) as location_id","name_en",array(),array("name_en")),@$_POST["location"]);
	$sm_locations 				= $f->select_multiple("locations",$db->fetch_select_data("locations","concat(province_id,':',location_id) as location_id","name_en",array(),array("name_en")),@$_POST["locations"],"style='height:200px;'");
	$sm_job_levels 				= $f->select_multiple("job_level_ids",$db->fetch_select_data("job_level","id","name_en"),@$_POST["job_level_ids"],"style='height:200px;'");
	$sel_function				= $f->select("job_function_id",$db->fetch_select_data("job_functions","id","name_en",array(),array("name_en")),@$_POST["job_function_id"]);
	$sel_degree					= $f->select("degree_id",$db->fetch_select_data("degree","id","name_en",array("id" => "0:>")),@$_POST["degree_id"]);
	$majors = $db->fetch_select_data("majors","id","name_en"); asort($majors);
	$sm_majors	 				= $f->select_multiple("major_ids",$majors,@$_POST["major_ids"],"style='height:200px;'");
	$txt_experience				= $f->input("experience_years",@$_POST["experience_years"]);
	
	$arrgender[1] = "Male";$arrgender[2] = "Female";
	$sm_gender 					= $f->select_multiple("gender",$arrgender,@$_POST["gender"],"style='height:40px;'");
	
	$arrage[""] = "-";
	for($xx = 14 ; $xx < 75 ; $xx++) { $arrage[$xx] = $xx; }
	$sel_ages 					= $f->select("age_min",$arrage,@$_POST["age_min"])." - ".$f->select("age_max",$arrage,@$_POST["age_max"]);
	
	$txt_email					= $f->input("email",@$_POST["email"]);
	$txt_name					= $f->input("name",@$_POST["name"]);
	
	$db->addtable("salaries"); $db->addfield("id");$db->addfield("salary"); $db->order("id");
	foreach ($db->fetch_data() as $key => $arrsalary){
		$salaries[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
	}
	$salary_range 				= $f->select("salary_min",$salaries,@$_POST["salary_min"]) ." - ". 
								  $f->select("salary_max",$salaries,@$_POST["salary_max"]);
	
	$chk_syariah				= $f->input("is_syariah","1","type='checkbox'");
	$chk_freshgraduate			= $f->input("is_freshgraduate","1","type='checkbox'");
	$txt_requirement			= $f->textarea("requirement",@$_POST["requirement"]);
	$txt_contact_person			= $f->input("contact_person",@$_POST["contact_person"]);
	$txt_description			= $f->textarea("description",@$_POST["description"]);
	$date_closing_date			= $f->input_tanggal("closing_date",@$_POST["closing_date"]);
	$date_posted_at				= $f->input_tanggal("posted_at",@$_POST["posted_at"]);
	$txt_logo 					= $f->input("logo","","type='file'");
?>
<?=$f->start("","POST","","enctype='multipart/form-data'");?>
	<?=$t->start("","editor_content");?>
		<?=$t->row(array("Company Name",$txt_company));?>
		<?=$t->row(array("Company Id",$txt_company_id));?>
		<?=$t->row(array("Title (Indonesia)",$txt_title_id));?>
		<?=$t->row(array("Title (English)",$txt_title_en));?>
		<?=$t->row(array("Job Type",$sel_job_type));?>
		<?=$t->row(array("Industry",$sel_industry));?>
		<?=$t->row(array("Web",$txt_web));?>
		<?=$t->row(array("Company Description",$txt_company_description));?>
		<?=$t->row(array("Location",$sm_locations));?>
		<?=$t->row(array("Job Level",$sm_job_levels));?>
		<?=$t->row(array("Job Function",$sel_function));?>
		<?=$t->row(array("Degree",$sel_degree));?>
		<?=$t->row(array("Majors",$sm_majors));?>
		<?=$t->row(array("Experiences year",$txt_experience));?>
		<?=$t->row(array("Gender",$sm_gender));?>
		<?=$t->row(array("Ages",$sel_ages));?>
		<?=$t->row(array("Email",$txt_email));?>
		<?=$t->row(array("Salaries",$salary_range));?>
		<?=$t->row(array("Is Syariah",$chk_syariah));?>
		<?=$t->row(array("Is Fresh Graduate",$chk_freshgraduate));?>
		<?=$t->row(array("Requirement",$txt_requirement));?>
		<?=$t->row(array("Contact Person",$txt_contact_person));?>
		<?=$t->row(array("Description",$txt_description));?>
		<?=$t->row(array("Posted At",$date_posted_at));?>
		<?=$t->row(array("Closing Date",$date_closing_date));?>
		<?=$t->row(array("Logo",$txt_logo."<br>Biarkan kosong jika ingin menggunakan company logo"));?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
<?php include_once "footer.php";?>