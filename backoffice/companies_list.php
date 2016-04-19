<?php include_once "head.php";?>
<?php include_once "companies_js.php";?>
<div class="bo_title">Companies</div>
<div id="bo_expand" onclick="toogle_bo_filter();">[+] View Filter</div>
<div id="bo_filter">
	<div id="bo_filter_container">
		<?=$f->start("filter","GET");?>
			<?=$t->start();?>
			<?php
				$txt_name = $f->input("txt_name",$_GET["txt_name"]);
				$industries = $db->fetch_select_data("industries","id","name_en");
				$sm_industries = $f->select_multiple("sm_industries",$industries,$_GET["sm_industries"]);
				$db->addtable("locations");$db->addfield("province_id,location_id,name_en");
				foreach($db->fetch_data() as $location){ $locations[$location[0].":".$location[1]] = $location[2]; }
				$sm_locations = $f->select_multiple("sm_locations",$locations,$_GET["sm_locations"]);
				$txt_email = $f->input("txt_email",$_GET["txt_email"]);
				$txt_user_email = $f->input("txt_user_email",$_GET["txt_user_email"]);
				$status = $db->fetch_select_data("status","id","name");$status[null] = "ALL";
				$sel_status = $f->select("sel_status",$status,$_GET["sel_status"],"style='height:20px;'");
				$txt_cso = $f->input("txt_cso",$_GET["txt_cso"]);
			?>
			<?=$t->row(array("Name",$txt_name));?>
			<?=$t->row(array("Industries",$sm_industries));?>
			<?=$t->row(array("Loacations",$sm_locations));?>
			<?=$t->row(array("Email",$txt_email));?>
			<?=$t->row(array("User Email",$txt_user_email));?>
			<?=$t->row(array("Status",$sel_status));?>
			<?=$t->row(array("CSO",$txt_cso));?>
			<?=$t->end();?>
			<?=$f->input("page","1","type='hidden'");?>
			<?=$f->input("sort",$_GET["sort"],"type='hidden'");?>
			<?=$f->input("do_filter","Load","type='submit'");?>
			<?=$f->input("reset","Reset","type='button' onclick=\"window.location='?';\"");?>
		<?=$f->end();?>
	</div>
</div>

<?php
	$whereclause = "";
	if($_GET["txt_name"]!="") $whereclause .= "name LIKE '"."%".str_replace(" ","%",$_GET["txt_name"])."%"."' AND ";
	if(count($_GET["sm_industries"]) > 0){
		$innerwhere = "";
		foreach($_GET["sm_industries"] as $selected){ $innerwhere .= "industry_id = '".$selected."' OR "; }
		$whereclause .= "(".substr($innerwhere,0,-3).") AND ";
	}	
	if(count($_GET["sm_locations"]) > 0){
		$innerwhere = "";
		foreach($_GET["sm_locations"] as $selected){ 
			$arrselected = explode(":",$selected);
			if($arrselected[1] == 0){
				$innerwhere .= "(province_id = '".$arrselected[0]."' AND location_id = '".$arrselected[1]."') OR "; 
			}else{
				$innerwhere .= "(province_id = '".$arrselected[0]."') OR "; 
			}
		}
		$whereclause .= "(".substr($innerwhere,0,-3).") AND ";
	}
	if($_GET["txt_email"]!="") $whereclause .= "email LIKE '%".$_GET["txt_email"]."%' AND ";
	if($_GET["txt_user_email"]!="") {
		$db->addtable("users");$db->addfield("company_profiles_id");$db->awhere("email LIKE '%".$_GET["txt_user_email"]."%' AND company_profiles_id > 0");
		$companies_users = $db->fetch_data(true);
		$innerwhere = "";
		foreach($companies_users as $cu){ $innerwhere .= $cu[0].","; } $innerwhere = substr($innerwhere,0,-1);
		$whereclause .= "id IN (".$innerwhere.") AND ";
	}
	if($_GET["sel_status"] != ""){
		$whereclause .= "status_id = '".$_GET["sel_status"]."' AND ";
	}
	if($_GET["txt_cso"]!="") {
		$db->addtable("cso_profiles");$db->addfield("user_id");$db->awhere("name LIKE '%".$_GET["txt_cso"]."%'");
		$cso_profiles = $db->fetch_data(true);
		$innerwhere = "";
		foreach($cso_profiles as $cso){ $innerwhere .= $cso[0].","; } $innerwhere = substr($innerwhere,0,-1);
		$whereclause .= "cso_user_id IN (".$innerwhere.") AND ";
	}
	
	$db->addtable("company_profiles");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($_max_counting);
	$maxrow = count($db->fetch_data(true));
	$start = getStartRow($_GET["page"],$_rowperpage);
	$paging = paging($_rowperpage,$maxrow,$_GET["page"],"paging");
	
	$db->addtable("company_profiles");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($start.",".$_rowperpage);
	if($_GET["sort"] != "") $db->order($_GET["sort"]);
	$company_profiles = $db->fetch_data(true);
?>
	<?=$f->input("add","Add","type='button' onclick=\"window.location='companies_add.php';\"");?>
	<?=$paging;?>
	<?=$t->start("","data_content");?>
	<?=$t->header(array("No",
						"<div onclick=\"sorting('name');\">Name</div>",
						"<div onclick=\"sorting('industry_id');\">Industry</div>",
						"<div onclick=\"sorting('email');\">Email</div>",
						"Location",
						"PIC",
						"Phone",
						"Users",
						"<div onclick=\"sorting('status_id');\">Status</div>",
						"<div onclick=\"sorting('cso_user_id');\">CSO</div>",
						""));?>
	<?php foreach($company_profiles as $no => $company_profile){ ?>
		<?php
			$industry = $db->fetch_single_data("industries","name_en",array("id" => $company_profile["industry_id"]));
			$db->addtable("locations"); $db->addfield("name_en"); $db->where("province_id",$company_profile["province_id"]); $db->where("location_id",$company_profile["location_id"]); $db->limit(1);
			$location = $db->fetch_data(false,0);
			$pic = $company_profile["first_name"]." ".$company_profile["middle_name"]." ".$company_profile["last_name"];
			$db->addtable("users");$db->addfield("email");$db->where("company_profiles_id",$company_profile["id"]);
			$users = $db->fetch_data(true);
			$admin_users = "";
			$sel_status = $f->select("sel_status",$status,$company_profile["status_id"],"style='height:20px;' onchange=\"change_status('".$company_profile["id"]."',this.value);\"");
			foreach($users as $user){ $admin_users .= $user[0]."<br>"; } $admin_users = substr($admin_users,0,-4);
			$cso = $db->fetch_single_data("cso_profiles","name",array("user_id" => $company_profile["cso_user_id"]));
			$actions = "<a href=\"companies_view.php?id=".$company_profile["id"]."\">View</a> | 
						<a href=\"companies_edit.php?id=".$company_profile["id"]."\">Edit</a>
						";
		?>
		<?=$t->row(
					array($no+$start+1,"<a href=\"companies_view.php?id=".$company_profile["id"]."\">".$company_profile["name"]."</a>",$industry,$company_profile["email"],$location,$pic,$company_profile["phone"],$admin_users,$sel_status,$cso,$actions),
					array("align='right' valign='top'","")
				);?>
	<?php } ?>
	<?=$t->end();?>
	<?=$paging;?>
	
<?php include_once "footer.php";?>