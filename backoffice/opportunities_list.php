<?php include_once "head.php";?>
<?php include_once "opportunities_js.php";?>
<div class="bo_title">Opportunities</div>
<div id="bo_expand" onclick="toogle_bo_filter();">[+] View Filter</div>
<div id="bo_filter">
	<div id="bo_filter_container">
		<?=$f->start("filter","GET");?>
			<?=$t->start();?>
			<?php
				$txt_opportunity_id = $f->input("txt_opportunity_id",$_GET["txt_opportunity_id"]);
				$txt_company_id 	= $f->input("txt_company_id",$_GET["txt_company_id"]);
				$txt_title 			= $f->input("txt_title",$_GET["txt_title"]);
				$sm_job_types 		= $f->select_multiple("sm_job_types",$db->fetch_select_data("job_type","id","name_en"),$_GET["sm_job_types"]);
				$sm_job_categories	= $f->select_multiple("sm_job_categories",$db->fetch_select_data("job_categories","id","name_en",array("parent_id" => "0:>")),$_GET["sm_job_categories"]);
				$sm_industries = $f->select_multiple("sm_industries",$db->fetch_select_data("industries","id","name_en"),$_GET["sm_industries"]);
				$db->addtable("locations");$db->addfield("province_id,location_id,name_en");
				foreach($db->fetch_data() as $location){ $locations[$location[0].":".$location[1]] = $location[2]; }
				$sm_locations = $f->select_multiple("sm_locations",$locations,$_GET["sm_locations"]);
				$sm_job_functions = $f->select_multiple("sm_job_functions",$db->fetch_select_data("job_functions","id","name_en"),$_GET["sm_job_functions"]);
			?>
			<?=$t->row(array("Opportunity Id",$txt_opportunity_id));?>
			<?=$t->row(array("Company Id",$txt_company_id));?>
			<?=$t->row(array("Title",$txt_title));?>
			<?=$t->row(array("Job Types",$sm_job_types));?>
			<?=$t->row(array("Job Categories",$sm_job_categories));?>
			<?=$t->row(array("Industries",$sm_industries));?>
			<?=$t->row(array("Locations",$sm_locations));?>
			<?=$t->row(array("Job Fucntions",$sm_job_functions));?>
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
	if($_GET["txt_opportunity_id"]!="") $whereclause .= "id = '".$_GET["txt_opportunity_id"]."' AND ";
	if($_GET["txt_company_id"]!="") $whereclause .= "company_id = '".$_GET["txt_company_id"]."' AND ";
	if($_GET["txt_title"]!="") $whereclause .= "(title_id LIKE '%".$_GET["txt_title"]."%' OR title_en LIKE '%".$_GET["txt_title"]."%') AND ";
	if(count($_GET["sm_job_types"]) > 0){
		$innerwhere = "";
		foreach($_GET["sm_job_types"] as $selected){ $innerwhere .= "job_type_id = '".$selected."' OR "; }
		$whereclause .= "(".substr($innerwhere,0,-3).") AND ";
	}	
	if(count($_GET["sm_job_categories"]) > 0){
		$innerwhere = "";
		foreach($_GET["sm_job_categories"] as $selected){ $innerwhere .= "job_category_id = '".$selected."' OR "; }
		$whereclause .= "(".substr($innerwhere,0,-3).") AND ";
	}	
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
	if(count($_GET["sm_job_functions"]) > 0){
		$innerwhere = "";
		foreach($_GET["sm_job_functions"] as $selected){ $innerwhere .= "job_function_id = '".$selected."' OR "; }
		$whereclause .= "(".substr($innerwhere,0,-3).") AND ";
	}
	
	$db->addtable("opportunities");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($_max_counting);
	$maxrow = count($db->fetch_data(true));
	$start = getStartRow($_GET["page"],$_rowperpage);
	$paging = paging($_rowperpage,$maxrow,$_GET["page"],"paging");
	
	$db->addtable("opportunities");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($start.",".$_rowperpage);
	if($_GET["sort"] != "") $db->order($_GET["sort"]);
	$opportunities = $db->fetch_data(true);
?>
	<?=$f->input("add","Add","type='button' onclick=\"window.location='opportunities_add.php';\"");?>
	<?=$paging;?>
	<?=$t->start("","data_content");?>
	<?=$t->header(array("No",
						"<div onclick=\"sorting('id');\">Opportunity Id</div>",
						"<div onclick=\"sorting('company_id');\">Company Id</div>",
						"<div onclick=\"sorting('company_id');\">Company Name</div>",
						"<div onclick=\"sorting('title_en');\">Title</div>",
						"<div onclick=\"sorting('job_type_id');\">Job Type</div>",
						"<div onclick=\"sorting('job_category_id');\">Job Category</div>",
						"<div onclick=\"sorting('industry_id');\">Industry</div>",
						"<div onclick=\"sorting('province_id');\">Location</div>",
						"<div onclick=\"sorting('job_function_id');\">Job Function</div>",
						"<div onclick=\"sorting('posted_at');\">Posted At</div>",
						"<div onclick=\"sorting('closing_date');\">Closing Date</div>",
						"<div onclick=\"sorting('created_at');\">Created At</div>",
						"<div onclick=\"sorting('created_by');\">Created By</div>",
						""));?>
	<?php foreach($opportunities as $no => $opportunity){ ?>
		<?php
			$job_type = $db->fetch_single_data("job_type","name_en",array("id" => $opportunity["job_type_id"]));
			$job_category = $db->fetch_single_data("job_categories","name_en",array("id" => $opportunity["job_category_id"]));
			$industry = $db->fetch_single_data("industries","name_en",array("id" => $opportunity["industry_id"]));
			$location = $db->fetch_single_data("locations","name_en",array("province_id" => $opportunity["province_id"],"location_id" => $opportunity["location_id"]));
			$job_function = $db->fetch_single_data("job_functions","name_en",array("id" => $opportunity["job_function_id"]));
			$company_name = $db->fetch_single_data("company_profiles","name",array("id" => $opportunity["company_id"]));
			
			$actions = "<a href=\"opportunities_view.php?id=".$opportunity["id"]."\">View</a> | 
						<a href=\"opportunities_edit.php?id=".$opportunity["id"]."\">Edit</a>
						";
		?>
		<?=$t->row(
					array($no+$start+1,
						"<a href=\"opportunities_view.php?id=".$opportunity["id"]."\">".$opportunity["id"]."</a>",
						$opportunity["company_id"],
						$company_name,
						$opportunity["title_en"],
						$job_type,
						$job_category,
						$industry,
						$location,
						$job_function,
						format_tanggal($opportunity["posted_at"],"dMY"),
						format_tanggal($opportunity["closing_date"],"dMY"),
						format_tanggal($opportunity["created_at"],"dMY"),
						$opportunity["created_by"],
						$actions),
					array("align='right' valign='top'","")
				);?>
	<?php } ?>
	<?=$t->end();?>
	<?=$paging;?>
	
<?php include_once "footer.php";?>