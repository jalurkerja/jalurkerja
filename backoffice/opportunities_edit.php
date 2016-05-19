<?php include_once "head.php";?>
<?php include_once "opportunities_js.php";?>
<div class="bo_title">Edit Opportunity</div>
<?php
	if(isset($_POST["save"])){
		if(@$_POST["company_id"] == ""){
			javascript("alert('Pastikan data terisi dengan benar!');");
		} else {
			$db->addtable("opportunities");			$db->where("id",$_GET["id"]);
			$db->addfield("company_id");			$db->addvalue(@$_POST["company_id"]);
			$db->addfield("title_id");				$db->addvalue(@$_POST["title_id"]);
			$db->addfield("title_en");				$db->addvalue(@$_POST["title_en"]);
			$db->addfield("job_type_id");			$db->addvalue(@$_POST["job_type_id"]);
			$db->addfield("industry_id");			$db->addvalue(@$_POST["industry_id"]);
			$db->addfield("web");					$db->addvalue(@$_POST["web"]);
			$db->addfield("company_description");	$db->addvalue(@$_POST["company_description"]);
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
			$updating = $db->update();
			if($updating["affected_rows"] >= 0){
				
				$db->addtable("opportunity_filter_categories");$db->where("opportunity_id",$_GET["id"]);$db->delete_();
		
				$chk_location 			= (isset($_POST["chk_location"])) ? "1":"0";
				$chk_job_level 			= (isset($_POST["chk_job_level"])) ? "1":"0";
				$chk_job_function 		= (isset($_POST["chk_job_function"])) ? "1":"0";
				$chk_degree 			= (isset($_POST["chk_degree"])) ? "1":"0";
				$chk_salary 			= (isset($_POST["chk_salary"])) ? "1":"0";
				$chk_major 				= (isset($_POST["chk_major"])) ? "1":"0";
				$chk_experience_years	= (isset($_POST["chk_experience_years"])) ? "1":"0";
				$chk_gender 			= (isset($_POST["chk_gender"])) ? "1":"0";
				$chk_industry 			= (isset($_POST["chk_industry"])) ? "1":"0";
				$chk_age 				= (isset($_POST["chk_age"])) ? "1":"0";
				
				$db->addtable("opportunity_filter_categories");
				$db->addfield("opportunity_id");	$db->addvalue($_GET["id"]);
				$db->addfield("job_level");			$db->addvalue($chk_job_level);
				$db->addfield("job_function");		$db->addvalue($chk_job_function);
				$db->addfield("location");			$db->addvalue($chk_location);
				$db->addfield("degree");			$db->addvalue($chk_degree);
				$db->addfield("major");				$db->addvalue($chk_major);
				$db->addfield("age");				$db->addvalue($chk_age);
				$db->addfield("salary");			$db->addvalue($chk_salary);
				$db->addfield("industry");			$db->addvalue($chk_industry);
				$db->addfield("gender");			$db->addvalue($chk_gender);
				$db->addfield("experience_years");	$db->addvalue($chk_experience_years);
				$db->insert();
				
				if(isset($_POST["use_company_logo"])){
					unlink("../opportunity_logo/".$db->fetch_single_data("opportunities","logo",array("id" => $_GET["id"])));
					$db->addtable("opportunities");$db->where("id",$_GET["id"]);
					$db->addfield("logo");$db->addvalue("");$db->update();
				} else {
					if($_FILES['logo']['tmp_name']) {
						move_uploaded_file($_FILES['logo']['tmp_name'], "../opportunity_logo/".$_GET["id"].".".pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));
						$db->addtable("opportunities");$db->where("id",$_GET["id"]);
						$db->addfield("logo");$db->addvalue($_GET["id"].".".pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));$db->update();
					}
				}
				javascript("alert('Data Berhasil tersimpan');");
			} else {
				javascript("alert('Data gagal tersimpan');");
			}
		}
	}
	
	$db->addtable("opportunities");	$db->where("id",$_GET["id"]); $db->limit(1);
	$opportunity = $db->fetch_data();
	
	$txt_company 				= $f->input("company_name",$opportunity["name"],"style='width:300px;' autocomplete='off' onkeyup='loadSelectCompanies(this.value,event.keyCode);'");
	$txt_company 				.= "	<div style=\"position:absolute;display:none;\" id=\"div_select_company\">
										<table style=\"border:grey solid 1px; background-color:#EFEFEF;\">
											<tr><td id=\"select_company\"></td></tr>
										</table>
										</div>";
	$txt_company_id				= $f->input("company_id",$opportunity["company_id"],"readonly style='width:300px;' autocomplete='off'");
	$txt_title_id 				= $f->input("title_id",$opportunity["title_id"]);
	$txt_title_en 				= $f->input("title_en",$opportunity["title_en"]);
	$sel_job_type 				= $f->select("job_type_id",$db->fetch_select_data("job_type","id","name_en"),$opportunity["job_type_id"]);
	$sel_industry				= $f->select("industry_id",$db->fetch_select_data("industries","id","name_en",array(),array("name_en")),$opportunity["industry_id"]);
	$txt_web	 				= $f->input("web",$opportunity["web"]);
	$txt_company_description	= $f->textarea("company_description",$opportunity["company_description"]);
	$sel_location 				= $f->select("location",$db->fetch_select_data("locations","concat(province_id,':',location_id) as location_id","name_en",array(),array("name_en")),$opportunity["province_id"].":".$opportunity["location_id"]);
	$sm_locations 				= $f->select_multiple("locations",$db->fetch_select_data("locations","concat(province_id,':',location_id) as location_id","name_en",array(),array("name_en")),$locations,"style='height:200px;'");
	$sm_job_levels 				= $f->select_multiple("job_level_ids",$db->fetch_select_data("job_level","id","name_en"),pipetoarray($opportunity["job_level_ids"]),"style='height:200px;'");
	$sel_function				= $f->select("job_function_id",$db->fetch_select_data("job_functions","id","name_en",array(),array("name_en")),$opportunity["job_function_id"]);
	$sel_degree					= $f->select("degree_id",$db->fetch_select_data("degree","id","name_en"),$opportunity["degree_id"]);
	$majors = $db->fetch_select_data("majors","id","name_en"); asort($majors);
	$sm_majors	 				= $f->select_multiple("major_ids",$majors,pipetoarray($opportunity["major_ids"]),"style='height:200px;'");
	$txt_experience				= $f->input("experience_years",$opportunity["experience_years"]);
	
	$arrgender[1] = "Male";$arrgender[2] = "Female";
	$sm_gender 					= $f->select_multiple("gender",$arrgender,pipetoarray($opportunity["gender"]),"style='height:40px;'");
	
	$arrage[""] = "-";
	for($xx = 14 ; $xx < 75 ; $xx++) { $arrage[$xx] = $xx; }
	$sel_ages 					= $f->select("age_min",$arrage,$opportunity["age_min"])." - ".$f->select("age_max",$arrage,$opportunity["age_max"]);
	
	$txt_email					= $f->input("email",$opportunity["email"]);
	$txt_name					= $f->input("name",$opportunity["name"]);
	
	$db->addtable("salaries"); $db->addfield("id");$db->addfield("salary"); $db->order("id");
	foreach ($db->fetch_data() as $key => $arrsalary){
		$salaries[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
	}
	
	$salary_range 				= $f->select("salary_min",$salaries,$opportunity["salary_min"]) ." - ". 
								  $f->select("salary_max",$salaries,$opportunity["salary_max"]);
	
	$checked = ($opportunity["is_syariah"] == "1") ? "checked":"";
	$chk_syariah				= $f->input("is_syariah","1","type='checkbox' ".$checked);
	$checked = ($opportunity["is_freshgraduate"] == "1") ? "checked":"";
	$chk_freshgraduate			= $f->input("is_freshgraduate","1","type='checkbox' ".$checked);
	
	$txt_requirement			= $f->textarea("requirement",$opportunity["requirement"]);
	$txt_contact_person			= $f->input("contact_person",$opportunity["contact_person"]);
	$txt_description			= $f->textarea("description",$opportunity["description"]);
	$date_closing_date			= $f->input_tanggal("closing_date",$opportunity["closing_date"]);
	$date_posted_at				= $f->input_tanggal("posted_at",$opportunity["posted_at"]);
	
	if(@filesize("../opportunity_logo/".$opportunity["logo"])>4096) 
		$logo = "<img src='../opportunity_logo/".$opportunity["logo"]."' width='150'><br>"; 
	else $logo = "";
	$txt_logo = $logo.$f->input("logo","","type='file'");
	$txt_logo .= "<br>".$f->input("use_company_logo","1","type='checkbox'")." Gunakan logo Company";
?>
<?=$f->start("","POST","","enctype='multipart/form-data'");?>
	<table><tr><td valign="top">
	<?=$t->start("","editor_content");?>
		<?=$t->row(array("Company Name",$txt_company));?>
		<?=$t->row(array("Company Id",$txt_company_id));?>
		<?=$t->row(array("Title (Indonesia)",$txt_title_id));?>
		<?=$t->row(array("Title (English)",$txt_title_en));?>
		<?=$t->row(array("Job Type",$sel_job_type));?>
		<?=$t->row(array("Industry",$sel_industry));?>
		<?=$t->row(array("Web",$txt_web));?>
		<?=$t->row(array("Company Description",$txt_company_description));?>
		<?=$t->row(array("Location",$sel_location));?>
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
		<?=$t->row(array("Logo",$txt_logo));?>
	<?=$t->end();?>
	</td><td valign="top">
	<?php
		$db->addtable("opportunity_filter_categories");$db->where("opportunity_id",$_GET["id"]);$db->limit(1);$filter = $db->fetch_data();
		$location 			= ($filter["location"] == 1) ? "checked" : "";
		$job_level 			= ($filter["job_level"] == 1) ? "checked" : "";
		$job_function 		= ($filter["job_function"] == 1) ? "checked" : "";
		$degree				= ($filter["degree"] == 1) ? "checked" : "";
		$salary 			= ($filter["salary"] == 1) ? "checked" : "";
		$major 				= ($filter["major"] == 1) ? "checked" : "";
		$experience_years 	= ($filter["experience_years"] == 1) ? "checked" : "";
		$gender 			= ($filter["gender"] == 1) ? "checked" : "";
		$industry 			= ($filter["industry"] == 1) ? "checked" : "";
		$age 				= ($filter["age"] == 1) ? "checked" : "";
		
		$chk_location = $f->input("chk_location","1","type='checkbox' ".$location);
		$chk_job_level = $f->input("chk_job_level","1","type='checkbox' ".$job_level);
		$chk_job_function = $f->input("chk_job_function","1","type='checkbox' ".$job_function);
		$chk_degree = $f->input("chk_degree","1","type='checkbox' ".$degree);
		$chk_salary = $f->input("chk_salary","1","type='checkbox' ".$salary);
		$chk_major = $f->input("chk_major","1","type='checkbox' ".$major);
		$chk_experience_years = $f->input("chk_experience_years","1","type='checkbox' ".$experience_years);
		$chk_gender = $f->input("chk_gender","1","type='checkbox' ".$gender);
		$chk_industry = $f->input("chk_industry","1","type='checkbox' ".$industry);
		$chk_age = $f->input("chk_age","1","type='checkbox' ".$age);
	?>
	<?=$t->start("","editor_content");?>
		<?=$t->row(array("<h3><b>Filter Category</b></h3>"),array("colspan='2' align='center'"));?>
		<?=$t->row(array("Lokasi",$chk_location));?>
		<?=$t->row(array("Fungsi Kerja",$chk_job_function));?>
		<?=$t->row(array("Rentang Gaji",$chk_salary));?>
		<?=$t->row(array("Pengalaman Kerja",$chk_experience_years));?>
		<?=$t->row(array("Industri",$chk_industry));?>
		<?=$t->row(array("Level Kerja",$chk_job_level));?>
		<?=$t->row(array("Pendidikan",$chk_degree));?>
		<?=$t->row(array("Jurusan",$chk_major));?>
		<?=$t->row(array("Jenis Kelamin",$chk_gender));?>
		<?=$t->row(array("Umur",$chk_age));?>
	<?=$t->end();?>
	</td></tr></table>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
<?php include_once "footer.php";?>