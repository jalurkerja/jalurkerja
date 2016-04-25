<?php include_once "head.php";?>
<?php include_once "companies_js.php";?>
<div class="bo_title">View Companies</div>
<?=$f->input("call_histories","Call Histories","type='button' onclick='call_histories();'");?>
<?php
	$db->addtable("company_profiles");$db->where("id",$_GET["id"]);$db->limit(1);$company_profile = $db->fetch_data();
	if(@filesize("../company_logo/".@$company_profile["logo"])>4096) 
		$logo = "<img src='../company_logo/".@$company_profile["logo"]."' width='150'><br>"; 
	else $logo = "";	
	if(@filesize("../company_header/".@$company_profile["header_image"])>4096) 
		$header_image = "<img src='../company_header/".@$company_profile["header_image"]."' height='100'><br>"; 
	else $header_image = "";
	$industry = $db->fetch_single_data("industries","name_en",array("id" => @$company_profile["industry_id"]));
	$location = $db->fetch_single_data("locations","name_en",array("province_id" => @$company_profile["province_id"],"location_id" => @$company_profile["location_id"]));
	$status = $db->fetch_single_data("status","name",array("id" => @$company_profile["status_id"]));
	$cso = $db->fetch_single_data("cso_profiles","name",array("user_id" => @$company_profile["cso_user_id"]));
	$status = $db->fetch_select_data("status","id","name");
	$sel_status = $f->select("sel_status",$status,@$company_profile["status_id"],"style='height:20px;' onchange=\"change_status('".@$company_profile["id"]."',this.value);\"");
	
?>
<?=$t->start("","editor_content");?>
	<?=$t->row(array("Nama",@$company_profile["name"]));?>
	<?=$t->row(array("Industry",$industry));?>
	<?=$t->row(array("Location",$location));?>
	<?=$t->row(array("Address",chr13tobr(@$company_profile["address"])));?>
	<?=$t->row(array("Zip Code",@$company_profile["zipcode"]));?>
	<?=$t->row(array("Phone",@$company_profile["phone"]));?>
	<?=$t->row(array("Fax",@$company_profile["fax"]));?>
	<?=$t->row(array("Web",@$company_profile["web"]));?>
	<?=$t->row(array("Email",@$company_profile["email"]));?>
	<?=$t->row(array("Description",chr13tobr(@$company_profile["description"])));?>
	<?=$t->row(array("First Name",@$company_profile["first_name"]));?>
	<?=$t->row(array("Middle Name",@$company_profile["middle_name"]));?>
	<?=$t->row(array("Last Name",@$company_profile["last_name"]));?>
	<?=$t->row(array("Reason Join Us",@$company_profile["join_reason"]));?>
	<?=$t->row(array("Expired Post",@$company_profile["expired_post_at"]));?>
	<?=$t->row(array("Expired Search",@$company_profile["expired_search_at"]));?>
	<?=$t->row(array("Maximum Opportunity",@$company_profile["max_opportunity"]));?>
	<?=$t->row(array("Maximum Applicant",@$company_profile["max_applicant"]));?>
	<?=$t->row(array("Remain Opportunity",@$company_profile["remain_opportunity"]));?>
	<?=$t->row(array("Remain Applicant",@$company_profile["remain_applicant"]));?>
	<?=$t->row(array("Bill PIC",@$company_profile["bill_pic"]));?>
	<?=$t->row(array("Bill Name",@$company_profile["bill_name"]));?>
	<?=$t->row(array("Bill Address",chr13tobr(@$company_profile["bill_address"])));?>
	<?=$t->row(array("Bill Zipcode",@$company_profile["bill_zipcode"]));?>
	<?=$t->row(array("NPWP",@$company_profile["npwp"]));?>
	<?=$t->row(array("NPWP Address",chr13tobr(@$company_profile["npwp_address"])));?>
	<?=$t->row(array("NPWP Zipcode",@$company_profile["npwp_zipcode"]));?>
	<?=$t->row(array("NPPKP",@$company_profile["nppkp"]));?>
	<?=$t->row(array("Status",$sel_status));?>
	<?=$t->row(array("CSO",$cso));?>
	<?=$t->row(array("Logo",$logo));?>
	<?=$t->row(array("Company Header Image",$header_image));?>
<?=$t->end();?>
<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_view","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?php include_once "footer.php";?>