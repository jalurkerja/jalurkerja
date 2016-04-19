<?php include_once "head.php";?>
<div class="bo_title">Edit Job Seeker</div>
<?php
	if(isset($_POST["save"])){
		$db->addtable("seeker_profiles");$db->where("user_id",$_GET["user_id"]);
		$db->addfield("first_name");		$db->addvalue($_POST["first_name"]);
		$db->addfield("middle_name");		$db->addvalue($_POST["middle_name"]);
		$db->addfield("last_name");			$db->addvalue($_POST["last_name"]);
		$db->addfield("address");			$db->addvalue($_POST["address"]);
		$location_id = explode(":",$_POST["location"]);
		$db->addfield("province_id");		$db->addvalue($location_id[0]);
		$db->addfield("location_id");		$db->addvalue($location_id[1]);
		$db->addfield("zipcode");			$db->addvalue($_POST["zipcode"]);
		$db->addfield("phone");				$db->addvalue($_POST["phone"]);
		$db->addfield("cellphone");			$db->addvalue($_POST["cellphone"]);
		$db->addfield("fax");				$db->addvalue($_POST["fax"]);
		$db->addfield("web");				$db->addvalue($_POST["web"]);
		$db->addfield("birthplace");		$db->addvalue($_POST["birthplace"]);
		$db->addfield("birthdate");			$db->addvalue($_POST["birthdate"]);
		$db->addfield("nationality");		$db->addvalue($_POST["nationality"]);
		$db->addfield("gender_id");			$db->addvalue($_POST["gender_id"]);
		$db->addfield("marital_status_id");	$db->addvalue($_POST["marital_status_id"]);
		$db->addfield("updated_at");		$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");		$db->addvalue($__username);
		$db->addfield("updated_ip");		$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$updating = $db->update();
		if($updating["affected_rows"] >= 0){
			if($_FILES['photo']['tmp_name']) {
				move_uploaded_file($_FILES['photo']['tmp_name'], "../seekers_photo/".$_GET["user_id"].".".pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));
				$db->addtable("seeker_profiles");$db->where("user_id",$_GET["user_id"]);
				$db->addfield("photo");$db->addvalue($_GET["user_id"].".".pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));$db->update();
			}
			javascript("alert('Data Berhasil tersimpan');");
		} else {
			echo $updating["sql"];
			javascript("alert('Data gagal tersimpan');");
		}
	}
	
	$db->addtable("seeker_profiles");$db->where("user_id",$_GET["user_id"]);$db->limit(1);$seeker_profiles = $db->fetch_data();
	$txt_first_name = $f->input("first_name",$seeker_profiles["first_name"]);
	$txt_middle_name = $f->input("middle_name",$seeker_profiles["middle_name"]);
	$txt_last_name = $f->input("last_name",$seeker_profiles["last_name"]);
	$txt_address = $f->textarea("address",$seeker_profiles["address"]);
	$sel_location = $f->select("location",$db->fetch_select_data("locations","concat(province_id,':',location_id) as location_id","name_en"),$seeker_profiles["province_id"].":".$seeker_profiles["location_id"]);
	$txt_zipcode = $f->input("zipcode",$seeker_profiles["zipcode"]);
	$txt_phone = $f->input("phone",$seeker_profiles["phone"]);
	$txt_cellphone = $f->input("cellphone",$seeker_profiles["cellphone"]);
	$txt_fax = $f->input("fax",$seeker_profiles["fax"]);
	$txt_web = $f->input("web",$seeker_profiles["web"]);
	$sel_birthplace = $f->select("birthplace",$db->fetch_select_data("locations","id","name_en"),$seeker_profiles["birthplace"]);
	$date_birthdate = $f->input_tanggal("birthdate",$seeker_profiles["birthdate"]);
	$txt_nationality = $f->input("nationality",$seeker_profiles["nationality"]);
	$sel_gender = $f->select("gender_id",$db->fetch_select_data("gender","id","name_en"),$seeker_profiles["gender_id"]);
	$sel_marital_status = $f->select("marital_status_id",$db->fetch_select_data("marital_status","id","name_en"),$seeker_profiles["marital_status_id"]);
	if(@filesize("../seekers_photo/".$seeker_profiles["photo"])>4096) 
		$photo = "<img src='../seekers_photo/".$seeker_profiles["photo"]."' width='150'><br>"; 
	else $photo = "";
	$txt_photo = $photo.$f->input("photo","","type='file'");
	
?>
<?=$f->start("","POST","","enctype='multipart/form-data'");?>
	<?=$t->start("","editor_content");?>
		<?=$t->row(array("First Name",$txt_first_name));?>
		<?=$t->row(array("Middle Name",$txt_middle_name));?>
		<?=$t->row(array("Last Name",$txt_last_name));?>
		<?=$t->row(array("Address",$txt_address));?>
		<?=$t->row(array("Location",$sel_location));?>
		<?=$t->row(array("Zip Code",$txt_zipcode));?>
		<?=$t->row(array("Phone",$txt_phone));?>
		<?=$t->row(array("CellPhone",$txt_cellphone));?>
		<?=$t->row(array("Fax",$txt_fax));?>
		<?=$t->row(array("Web",$txt_web));?>
		<?=$t->row(array("Birth Place",$sel_birthplace));?>
		<?=$t->row(array("Birth Date",$date_birthdate));?>
		<?=$t->row(array("Nationality",$txt_nationality));?>
		<?=$t->row(array("Gender",$sel_gender));?>
		<?=$t->row(array("Marital Status",$sel_marital_status));?>
		<?=$t->row(array("Photo",$txt_photo));?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?>&nbsp;
	<?=$f->input("view","View","type='button' onclick=\"window.location='".str_replace("_edit","_view",$_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"]."';\"");?>&nbsp;
	<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
<?php include_once "footer.php";?>