<?php include_once "head.php";?>
<?php include_once "jobseekers_js.php";?>
<div class="bo_title">View Job Seeker</div>
<?=$f->input("seeker_experiences","Seeker Experiences","type='button' onclick='seeker_experiences();'");?>&nbsp;
<?=$f->input("seeker_certifications","Seeker Certifications","type='button' onclick='seeker_certifications();'");?>&nbsp;
<?=$f->input("seeker_educations","Seeker Educations","type='button' onclick='seeker_educations();'");?>&nbsp;
<?=$f->input("seeker_languages","Seeker Languages","type='button' onclick='seeker_languages();'");?>&nbsp;
<?=$f->input("seeker_skills","Seeker Skills","type='button' onclick='seeker_skills();'");?>&nbsp;
<?=$f->input("seeker_summary","Seeker Summary","type='button' onclick='seeker_summary();'");?>&nbsp;<br>
<?=$f->input("seeker_desires","Seeker Desires","type='button' onclick='seeker_desires();'");?>&nbsp;
<?=$f->input("general_settings","Seeker Settings","type='button' onclick='general_settings();'");?>&nbsp;
<?=$f->input("memberships","Seeker Memberships","type='button' onclick='memberships();'");?>&nbsp;
<?=$f->input("saved_search","Saved Search","type='button' onclick='saved_search();'");?>&nbsp;
<?=$f->input("saved_opportunities","Saved Opportunitites","type='button' onclick='saved_opportunities();'");?>&nbsp;
<?=$f->input("applied_opportunities","Applied Opportunitites","type='button' onclick='applied_opportunities();'");?>&nbsp;
<?php	
	$db->addtable("seeker_profiles");$db->where("user_id",$_GET["user_id"]);$db->limit(1);$seeker_profiles = $db->fetch_data();	
	if(@filesize("../seekers_photo/".$seeker_profiles["photo"])>4096) 
		$photo = "<img src='../seekers_photo/".$seeker_profiles["photo"]."' width='150'><br>"; 
	else $photo = "";	
?>
<?=$t->start("","editor_content");?>
	<?=$t->row(array("First Name",$seeker_profiles["first_name"]));?>
	<?=$t->row(array("Middle Name",$seeker_profiles["middle_name"]));?>
	<?=$t->row(array("Last Name",$seeker_profiles["last_name"]));?>
	<?=$t->row(array("Address",chr13tobr($seeker_profiles["address"])));?>
	<?=$t->row(array("Location",$db->fetch_single_data("locations","name_en",array("concat(province_id,':',location_id)" => $seeker_profiles["province_id"].":".$seeker_profiles["location_id"]))));?>
	<?=$t->row(array("Zip Code",$seeker_profiles["zipcode"]));?>
	<?=$t->row(array("Phone",$seeker_profiles["phone"]));?>
	<?=$t->row(array("CellPhone",$seeker_profiles["cellphone"]));?>
	<?=$t->row(array("Fax",$seeker_profiles["fax"]));?>
	<?=$t->row(array("Web",$seeker_profiles["web"]));?>
	<?=$t->row(array("Birth Place",$db->fetch_single_data("locations","name_en",array("id" => $seeker_profiles["birthplace"]))));?>
	<?=$t->row(array("Birth Date",format_tanggal($seeker_profiles["birthdate"],"dMY")));?>
	<?=$t->row(array("Nationality",$seeker_profiles["nationality"]));?>
	<?=$t->row(array("Gender",$db->fetch_single_data("gender","name_en",array("id" => $seeker_profiles["gender_id"]))));?>
	<?=$t->row(array("Marital Status",$db->fetch_single_data("marital_status","name_en",array("id" => $seeker_profiles["marital_status_id"]))));?>
	<?=$t->row(array("Photo",$photo));?>
<?=$t->end();?>
<?=$f->input("save","Save","type='submit'");?>&nbsp;
<?=$f->input("edit","Edit","type='button' onclick=\"window.location='".str_replace("_view","_edit",$_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"]."';\"");?>&nbsp;
<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_view","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?php include_once "footer.php";?>