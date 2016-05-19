<?php include_once "head.php";?>
<div class="bo_title">Add Company</div>
<?php
	if(isset($_POST["save"])){
		$db->addtable("company_profiles");
		$db->addfield("name");$db->addvalue($_POST["name"]);
		$db->addfield("industry_id");$db->addvalue($_POST["industry_id"]);
		$location_id = explode(":",$_POST["location"]);
		$db->addfield("province_id");		$db->addvalue($location_id[0]);
		$db->addfield("location_id");		$db->addvalue($location_id[1]);
		$db->addfield("address");			$db->addvalue($_POST["address"]);
		$db->addfield("zipcode");			$db->addvalue($_POST["zipcode"]);
		$db->addfield("phone");				$db->addvalue($_POST["phone"]);
		$db->addfield("fax");				$db->addvalue($_POST["fax"]);
		$db->addfield("web");				$db->addvalue($_POST["web"]);
		$db->addfield("email");				$db->addvalue($_POST["email"]);
		$db->addfield("description");		$db->addvalue($_POST["description"]);
		$db->addfield("first_name");		$db->addvalue($_POST["first_name"]);
		$db->addfield("middle_name");		$db->addvalue($_POST["middle_name"]);
		$db->addfield("last_name");			$db->addvalue($_POST["last_name"]);
		$db->addfield("join_reason");		$db->addvalue($_POST["join_reason"]);
		$db->addfield("expired_post_at");	$db->addvalue($_POST["expired_post_at"]);
		$db->addfield("expired_search_at");	$db->addvalue($_POST["expired_search_at"]);
		$db->addfield("max_opportunity");	$db->addvalue($_POST["max_opportunity"]);
		if(@$_POST["max_opportunity"] < 0) {
			$db->addfield("remain_opportunity");	$db->addvalue("-1");
		}
		$db->addfield("max_applicant");		$db->addvalue($_POST["max_applicant"]);
		$db->addfield("bill_pic");			$db->addvalue($_POST["bill_pic"]);
		$db->addfield("bill_name");			$db->addvalue($_POST["bill_name"]);
		$db->addfield("bill_address");		$db->addvalue($_POST["bill_address"]);
		$db->addfield("bill_zipcode");		$db->addvalue($_POST["bill_zipcode"]);
		$db->addfield("npwp");				$db->addvalue($_POST["npwp"]);
		$db->addfield("npwp_address");		$db->addvalue($_POST["npwp_address"]);
		$db->addfield("npwp_zipcode");		$db->addvalue($_POST["npwp_zipcode"]);
		$db->addfield("nppkp");				$db->addvalue($_POST["nppkp"]);
		$db->addfield("created_at");		$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("created_by");		$db->addvalue($__username);
		$db->addfield("created_ip");		$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->addfield("updated_at");		$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");		$db->addvalue($__username);
		$db->addfield("updated_ip");		$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] >= 0){
			$insert_id = $inserting["insert_id"];
			if($_FILES['logo']['tmp_name']) {
				move_uploaded_file($_FILES['logo']['tmp_name'], "../company_logo/".$insert_id.".".pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));
				$db->addtable("company_profiles");$db->where("id",$insert_id);
				$db->addfield("logo");$db->addvalue($insert_id.".".pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));$db->update();
			}
			if($_FILES['header_image']['tmp_name']) {
				move_uploaded_file($_FILES['header_image']['tmp_name'], "../company_header/".$insert_id.".".pathinfo($_FILES['header_image']['name'],PATHINFO_EXTENSION));
				$db->addtable("company_profiles");$db->where("id",$insert_id);
				$db->addfield("header_image");$db->addvalue($insert_id.".".pathinfo($_FILES['header_image']['name'],PATHINFO_EXTENSION));$db->update();
			}
			javascript("alert('Data Berhasil tersimpan');");
			javascript("window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';");
		} else {
			javascript("alert('Data gagal tersimpan');");
		}
	}
	
	$txt_name = $f->input("name",$_POST["name"]);
	$sel_industry = $f->select("industry_id",$db->fetch_select_data("industries","id","name_en",array(),array("name_en")),$_POST["industry_id"]);
	$sel_location = $f->select("location",$db->fetch_select_data("locations","concat(province_id,':',location_id) as location_id","name_en",array(),array("name_en")),$_POST["location"]);
	$txt_address = $f->textarea("address",$_POST["address"]);
	$txt_zipcode = $f->input("zipcode",$_POST["zipcode"]);
	$txt_phone = $f->input("phone",$_POST["phone"]);
	$txt_fax = $f->input("fax",$_POST["fax"]);
	$txt_web = $f->input("web",$_POST["web"]);
	$txt_email = $f->input("email",$_POST["email"]);
	$txt_description = $f->textarea("description",$_POST["description"]);
	$txt_first_name = $f->input("first_name",$_POST["first_name"]);
	$txt_middle_name = $f->input("middle_name",$_POST["middle_name"]);
	$txt_last_name = $f->input("last_name",$_POST["last_name"]);
	$txt_join_reason = $f->textarea("join_reason",$_POST["join_reason"]);
	$date_expired_post_at = $f->input_tanggal("expired_post_at",$_POST["expired_post_at"]);
	$date_expired_search_at = $f->input_tanggal("expired_search_at",$_POST["expired_search_at"]);
	$txt_maximum_opportunity = $f->input("max_opportunity",$_POST["max_opportunity"]);
	$txt_maximum_applicant = $f->input("max_applicant",$_POST["max_applicant"]);
	$txt_bill_pic = $f->input("bill_pic",$_POST["bill_pic"]);
	$txt_bill_name = $f->input("bill_name",$_POST["bill_name"]);
	$txt_bill_address = $f->textarea("bill_address",$_POST["bill_address"]);
	$txt_bill_zipcode = $f->input("bill_zipcode",$_POST["bill_zipcode"]);
	$txt_npwp = $f->input("npwp",$_POST["npwp"]);
	$txt_npwp_address = $f->textarea("npwp_address",$_POST["npwp_address"]);
	$txt_npwp_zipcode = $f->input("npwp_zipcode",$_POST["npwp_zipcode"]);
	$txt_nppkp = $f->input("nppkp",$_POST["nppkp"]);
	$txt_logo = $f->input("logo","","type='file'");
	$txt_header_image = $f->input("header_image","","type='file'");
?>
<?=$f->start("","POST","","enctype='multipart/form-data'");?>
	<?=$t->start("","editor_content");?>
		<?=$t->row(array("Nama",$txt_name));?>
		<?=$t->row(array("Industry",$sel_industry));?>
		<?=$t->row(array("Location",$sel_location));?>
		<?=$t->row(array("Address",$txt_address));?>
		<?=$t->row(array("Zip Code",$txt_zipcode));?>
		<?=$t->row(array("Phone",$txt_phone));?>
		<?=$t->row(array("Fax",$txt_fax));?>
		<?=$t->row(array("Web",$txt_web));?>
		<?=$t->row(array("Email",$txt_email));?>
		<?=$t->row(array("Description",$txt_description));?>
		<?=$t->row(array("First Name",$txt_first_name));?>
		<?=$t->row(array("Middle Name",$txt_middle_name));?>
		<?=$t->row(array("Last Name",$txt_last_name));?>
		<?=$t->row(array("Reason Join Us",$txt_join_reason));?>
		<?=$t->row(array("Expired Post",$date_expired_post_at));?>
		<?=$t->row(array("Expired Search",$date_expired_search_at));?>
		<?=$t->row(array("Maximum Opportunity",$txt_maximum_opportunity));?>
		<?=$t->row(array("Maximum Applicant",$txt_maximum_applicant));?>
		<?=$t->row(array("Bill PIC",$txt_bill_pic));?>
		<?=$t->row(array("Bill Name",$txt_bill_name));?>
		<?=$t->row(array("Bill Address",$txt_bill_address));?>
		<?=$t->row(array("Bill Zipcode",$txt_bill_zipcode));?>
		<?=$t->row(array("NPWP",$txt_npwp));?>
		<?=$t->row(array("NPWP Address",$txt_npwp_address));?>
		<?=$t->row(array("NPWP Zipcode",$txt_npwp_zipcode));?>
		<?=$t->row(array("NPPKP",$txt_nppkp));?>
		<?=$t->row(array("Logo",$txt_logo));?>
		<?=$t->row(array("Company Header Image",$txt_header_image));?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
<?php include_once "footer.php";?>