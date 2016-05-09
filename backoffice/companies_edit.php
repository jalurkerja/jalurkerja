<?php include_once "head.php";?>
<div class="bo_title">Edit Companies</div>
<?php
	if(isset($_POST["save"])){
		$db->addtable("company_profiles");$db->where("id",$_GET["id"]);
		$db->addfield("name");$db->addvalue(@$_POST["name"]);
		$db->addfield("industry_id");$db->addvalue(@$_POST["industry_id"]);
		$location_id = explode(":",@$_POST["location"]);
		$db->addfield("province_id");		$db->addvalue($location_id[0]);
		$db->addfield("location_id");		$db->addvalue($location_id[1]);
		$db->addfield("address");			$db->addvalue(str_replace("'","''",@$_POST["address"]));
		$db->addfield("zipcode");			$db->addvalue(@$_POST["zipcode"]);
		$db->addfield("phone");				$db->addvalue(@$_POST["phone"]);
		$db->addfield("fax");				$db->addvalue(@$_POST["fax"]);
		$db->addfield("web");				$db->addvalue(@$_POST["web"]);
		$db->addfield("email");				$db->addvalue(@$_POST["email"]);
		$db->addfield("description");		$db->addvalue(str_replace("'","''",@$_POST["description"]));
		$db->addfield("first_name");		$db->addvalue(@$_POST["first_name"]);
		$db->addfield("middle_name");		$db->addvalue(@$_POST["middle_name"]);
		$db->addfield("last_name");			$db->addvalue(@$_POST["last_name"]);
		$db->addfield("join_reason");		$db->addvalue(str_replace("'","''",@$_POST["join_reason"]));
		$db->addfield("expired_post_at");	$db->addvalue(@$_POST["expired_post_at"]);
		$db->addfield("expired_search_at");	$db->addvalue(@$_POST["expired_search_at"]);
		$db->addfield("max_opportunity");	$db->addvalue(@$_POST["max_opportunity"]);
		if(@$_POST["max_opportunity"] < 0) {
			$db->addfield("remain_opportunity");	$db->addvalue("-1");
		}
		$db->addfield("max_applicant");		$db->addvalue(@$_POST["max_applicant"]);
		$db->addfield("bill_pic");			$db->addvalue(@$_POST["bill_pic"]);
		$db->addfield("bill_name");			$db->addvalue(@$_POST["bill_name"]);
		$db->addfield("bill_address");		$db->addvalue(@$_POST["bill_address"]);
		$db->addfield("bill_zipcode");		$db->addvalue(@$_POST["bill_zipcode"]);
		$db->addfield("npwp");				$db->addvalue(@$_POST["npwp"]);
		$db->addfield("npwp_address");		$db->addvalue(@$_POST["npwp_address"]);
		$db->addfield("npwp_zipcode");		$db->addvalue(@$_POST["npwp_zipcode"]);
		$db->addfield("nppkp");				$db->addvalue(@$_POST["nppkp"]);
		$db->addfield("status_id");			$db->addvalue(@$_POST["status_id"]);
		$db->addfield("updated_at");		$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");		$db->addvalue($__username);
		$db->addfield("updated_ip");		$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$updating = $db->update();
		if($updating["affected_rows"] >= 0){
			if($_FILES['logo']['tmp_name']) {
				move_uploaded_file($_FILES['logo']['tmp_name'], "../company_logo/".$_GET["id"].".".pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));
				$db->addtable("company_profiles");$db->where("id",$_GET["id"]);
				$db->addfield("logo");$db->addvalue($_GET["id"].".".pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));$db->update();
			}
			
			if($_FILES['header_image']['tmp_name']) {
				move_uploaded_file($_FILES['header_image']['tmp_name'], "../company_header/".$insert_id.".".pathinfo($_FILES['header_image']['name'],PATHINFO_EXTENSION));
				$db->addtable("company_profiles");$db->where("id",$insert_id);
				$db->addfield("header_image");$db->addvalue($insert_id.".".pathinfo($_FILES['header_image']['name'],PATHINFO_EXTENSION));$db->update();
			}
			javascript("alert('Data Berhasil tersimpan');");
		} else {
			javascript("alert('Data gagal tersimpan');");
		}
	}
	
	$db->addtable("company_profiles");$db->where("id",$_GET["id"]);$db->limit(1);$company_profile = $db->fetch_data();
	$txt_name = $f->input("name",@$company_profile["name"]);
	$sel_industry = $f->select("industry_id",$db->fetch_select_data("industries","id","name_en",array(),array("name_en")),@$company_profile["industry_id"]);
	$sel_location = $f->select("location",$db->fetch_select_data("locations","concat(province_id,':',location_id) as location_id","name_en",array(),array("name_en")),@$company_profile["province_id"].":".@$company_profile["location_id"]);
	$txt_address = $f->textarea("address",@$company_profile["address"]);
	$txt_zipcode = $f->input("zipcode",@$company_profile["zipcode"]);
	$txt_phone = $f->input("phone",@$company_profile["phone"]);
	$txt_fax = $f->input("fax",@$company_profile["fax"]);
	$txt_web = $f->input("web",@$company_profile["web"]);
	$txt_email = $f->input("email",@$company_profile["email"]);
	$txt_description = $f->textarea("description",@$company_profile["description"]);
	$txt_first_name = $f->input("first_name",@$company_profile["first_name"]);
	$txt_middle_name = $f->input("middle_name",@$company_profile["middle_name"]);
	$txt_last_name = $f->input("last_name",@$company_profile["last_name"]);
	$txt_join_reason = $f->textarea("join_reason",@$company_profile["join_reason"]);
	$date_expired_post_at = $f->input_tanggal("expired_post_at",@$company_profile["expired_post_at"]);
	$date_expired_search_at = $f->input_tanggal("expired_search_at",@$company_profile["expired_search_at"]);
	$txt_maximum_opportunity = $f->input("max_opportunity",@$company_profile["max_opportunity"]);
	$txt_maximum_applicant = $f->input("max_applicant",@$company_profile["max_applicant"]);
	$txt_bill_pic = $f->input("bill_pic",@$company_profile["bill_pic"]);
	$txt_bill_name = $f->input("bill_name",@$company_profile["bill_name"]);
	$txt_bill_address = $f->textarea("bill_address",@$company_profile["bill_address"]);
	$txt_bill_zipcode = $f->input("bill_zipcode",@$company_profile["bill_zipcode"]);
	$txt_npwp = $f->input("npwp",@$company_profile["npwp"]);
	$txt_npwp_address = $f->textarea("npwp_address",@$company_profile["npwp_address"]);
	$txt_npwp_zipcode = $f->input("npwp_zipcode",@$company_profile["npwp_zipcode"]);
	$txt_nppkp = $f->input("nppkp",@$company_profile["nppkp"]);
	$status = $db->fetch_select_data("status","id","name");
	$sel_status = $f->select("status_id",$status,@$company_profile["status_id"],"style='height:20px;'");
	if(@filesize("../company_logo/".@$company_profile["logo"])>4096) 
		$logo = "<img src='../company_logo/".@$company_profile["logo"]."' width='150'><br>"; 
	else $logo = "";
	$txt_logo = $logo.$f->input("logo","","type='file'");
	if(@filesize("../company_header/".@$company_profile["header_image"])>4096) 
		$header_image = "<img src='../company_header/".@$company_profile["header_image"]."' height='100'><br>"; 
	else $header_image = "";
	$txt_header_image = $header_image.$f->input("header_image","","type='file'");
	
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
		<?=$t->row(array("Status",$sel_status));?>
		<?=$t->row(array("Logo",$txt_logo));?>
		<?=$t->row(array("Company Header Image",$txt_header_image));?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
<?php include_once "footer.php";?>