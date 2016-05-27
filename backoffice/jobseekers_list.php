<?php include_once "head.php";?>
<?php include_once "jobseekers_js.php";?>
<div class="bo_title">Job Seekers</div>
<div id="bo_expand" onclick="toogle_bo_filter();">[+] View Filter</div>
<div id="bo_filter">
	<div id="bo_filter_container">
		<?=$f->start("filter","GET");?>
			<?=$t->start();?>
			<?php
				$txt_id = $f->input("txt_id",@$_GET["txt_id"]);
				$txt_name = $f->input("txt_name",@$_GET["txt_name"]);
				$txt_address = $f->input("txt_address",@$_GET["txt_address"]);
				$locations = $db->fetch_select_data("locations","concat(province_id,':',location_id) as location_id","name_en");
				$sm_locations = $f->select_multiple("sm_locations",$locations,@$_GET["sm_locations"]);
				$txt_phone = $f->input("txt_phone",@$_GET["txt_phone"]);
				$txt_cellphone = $f->input("txt_cellphone",@$_GET["txt_cellphone"]);
				$genders = $db->fetch_select_data("gender","id","name_en");$genders[null] = ""; ksort($genders);
				$sel_gender = $f->select("sel_gender",$genders,@$_GET["sel_gender"],"style='height:20px;'");
				$marital_status = $db->fetch_select_data("marital_status","id","name_en");$marital_status[null] = ""; ksort($marital_status);
				$sel_marital_status = $f->select("sel_marital_status",$marital_status,@$_GET["sel_marital_status"],"style='height:20px;'");
				$txt_created_at = $f->input("txt_created_at",@$_GET["txt_created_at"]);
				$txt_timestamp = $f->input("txt_timestamp",@$_GET["txt_timestamp"]);
			?>
			<?=$t->row(array("ID",$txt_id));?>
			<?=$t->row(array("Name",$txt_name));?>
			<?=$t->row(array("Address",$txt_address));?>
			<?=$t->row(array("Locations",$sm_locations));?>
			<?=$t->row(array("Phone",$txt_phone));?>
			<?=$t->row(array("Cellphone",$txt_cellphone));?>
			<?=$t->row(array("Gender",$sel_gender));?>
			<?=$t->row(array("Marital Status",$sel_marital_status));?>
			<?=$t->row(array("Created At",$txt_created_at));?>
			<?=$t->row(array("Timestamp",$txt_timestamp));?>
			<?=$t->end();?>
			<?=$f->input("page","1","type='hidden'");?>
			<?=$f->input("sort",@$_GET["sort"],"type='hidden'");?>
			<?=$f->input("do_filter","Load","type='submit'");?>
			<?=$f->input("reset","Reset","type='button' onclick=\"window.location='?';\"");?>
		<?=$f->end();?>
	</div>
</div>

<?php
	$whereclause = "";
	if(@$_GET["txt_id"]!="") $whereclause .= "id = '".@$_GET["txt_name"]."' AND ";
	if(@$_GET["txt_name"]!="") $whereclause .= "name LIKE '"."%".str_replace(" ","%",@$_GET["txt_name"])."%"."' AND ";
	if(@$_GET["txt_address"]!="") $whereclause .= "address LIKE '"."%".str_replace(" ","%",@$_GET["txt_address"])."%"."' AND ";
	if(count(@$_GET["sm_locations"]) > 0){
		$innerwhere = "";
		foreach(@$_GET["sm_locations"] as $selected){ 
			$arrselected = explode(":",$selected);
			if($arrselected[1] == 0){
				$innerwhere .= "(province_id = '".$arrselected[0]."' AND location_id = '".$arrselected[1]."') OR "; 
			}else{
				$innerwhere .= "(province_id = '".$arrselected[0]."') OR "; 
			}
		}
		$whereclause .= "(".substr($innerwhere,0,-3).") AND ";
	}
	if(@$_GET["txt_phone"]!="") $whereclause .= "phone LIKE '%".@$_GET["txt_phone"]."%' AND ";
	if(@$_GET["txt_cellphone"]!="") $whereclause .= "cellphone LIKE '%".@$_GET["txt_cellphone"]."%' AND ";
	if(@$_GET["sel_gender"] != ""){ $whereclause .= "gender_id = '".@$_GET["sel_gender"]."' AND "; }
	if(@$_GET["sel_marital_status"] != ""){ $whereclause .= "marital_status_id = '".@$_GET["sel_marital_status"]."' AND "; }
	if(@$_GET["txt_phone"]!="") $whereclause .= "created_at LIKE '".@$_GET["txt_created_at"]."%' AND ";
	if(@$_GET["txt_timestamp"]!="") $whereclause .= "xtimestamp LIKE '".@$_GET["txt_timestamp"]."%' AND ";
	
	$db->addtable("seeker_profiles");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($_max_counting);
	$maxrow = count($db->fetch_data(true));
	$start = getStartRow(@$_GET["page"],$_rowperpage);
	$paging = paging($_rowperpage,$maxrow,@$_GET["page"],"paging");
	
	$db->addtable("seeker_profiles");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($start.",".$_rowperpage);
	if(@$_GET["sort"] != "") $db->order(@$_GET["sort"]);
	$seeker_profiles = $db->fetch_data(true);
?>
	<?=$paging;?>
	<?=$t->start("","data_content");?>
	<?=$t->header(array("No",
						"<div onclick=\"sorting('id');\">User ID</div>",
						"Name",
						"Username",
						"<div onclick=\"sorting('address');\">Address</div>",
						"Location",
						"<div onclick=\"sorting('phone');\">Phone</div>",
						"<div onclick=\"sorting('cellphone');\">CellPhone</div>",
						"<div onclick=\"sorting('gender_id');\">Gender</div>",
						"<div onclick=\"sorting('marital_status_id');\">Marital Status</div>",
						""));?>
	<?php foreach($seeker_profiles as $no => $seeker_profile){ ?>
		<?php
			$db->addtable("locations"); $db->addfield("name_en"); $db->where("province_id",$seeker_profile["province_id"]); $db->where("location_id",$seeker_profile["location_id"]); $db->limit(1);
			$location = $db->fetch_data(false,0);
			$name = $seeker_profile["first_name"]." ".$seeker_profile["middle_name"]." ".$seeker_profile["last_name"];
			$gender = $db->fetch_single_data("gender","name_en",array("id" => $seeker_profile["gender_id"]));
			$marital_status = $db->fetch_single_data("marital_status","name_en",array("id" => $seeker_profile["marital_status_id"]));
			$username = $db->fetch_single_data("users","email",array("id" => $seeker_profile["user_id"]));
			if($__username == "superuser@jalurkerja.com"){
				$username .= " [".base64_decode($db->fetch_single_data("users","password",array("id" => $seeker_profile["user_id"])))."]";
			}
			$actions = "<a href=\"jobseekers_view.php?user_id=".$seeker_profile["user_id"]."\">View</a> | 
						<a href=\"jobseekers_edit.php?user_id=".$seeker_profile["user_id"]."\">Edit</a>
						";
		?>
		<?=$t->row(
					array($no+$start+1,
							"<a href=\"jobseekers_view.php?user_id=".$seeker_profile["user_id"]."\">".$seeker_profile["user_id"]."</a>",
							"<a href=\"jobseekers_view.php?user_id=".$seeker_profile["user_id"]."\">".$name."</a>",
							"<a href=\"jobseekers_view.php?user_id=".$seeker_profile["user_id"]."\">".$username."</a>",
							$seeker_profile["address"],
							$location,
							$seeker_profile["phone"],
							$seeker_profile["cellphone"],
							$gender,
							$marital_status,
							$actions),
					array("align='right' valign='top'","")
				);?>
	<?php } ?>
	<?=$t->end();?>
	<?=$paging;?>
	
<?php include_once "footer.php";?>