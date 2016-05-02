<script> 
	function changepage(page){
		document.getElementById("page").value = page;
		search_advertising();
	}

	function add_advertising_clicked(){
		document.getElementById("add_advertising").value = 1;
		search_advertising();
	}
	
	function cancel_add_advertising(){
		document.getElementById("add_advertising").value = 0;
		search_advertising();
	}
	
	function back_add_advertising_1(){
		document.getElementById("add_advertising").value = 1;
		search_advertising();
	}
	
	function view_advertising(opportunity_id){
		get_ajax("ajax/searchjob_ajax.php?mode=generate_token&opportunity_id="+opportunity_id,"return_generate_token","openwindow('opportunity_detail.php?id="+opportunity_id+"&token='+global_respon['return_generate_token']);");
	}
	
	function edit_advertising_1(opportunity_id){
		document.getElementById("edit_advertising").value = 1;
		document.getElementById("add_opportunity_id").value = opportunity_id;
		search_advertising();
	}
	
</script>
<?php if(@$_GET["add_advertising"] == 1 || @$_GET["edit_advertising"] == 1){ include_once "company_profile_advertising_add.php"; } ?>
<div id="bo_expand" onclick="toogle_bo_filter();remove_footer('advertising');" style="cursor:pointer;">[+] View Filter</div>
<div>
	<div id="bo_filter_container" style="display:none;">
		<?=$f->start("search_advertising_form","POST");?>
			<?=$t->start();?>
			<?php
				$txt_opportunity_id = $f->input("txt_opportunity_id",@$_GET["txt_opportunity_id"]);
				$txt_title 			= $f->input("txt_title",@$_GET["txt_title"]);
				$sm_job_types 		= $f->select("sm_job_types",$db->fetch_select_data("job_type","id","name_en",array(),array(),"",true),@$_GET["sm_job_types"]);
				$sm_industries 		= $f->select("sm_industries",$db->fetch_select_data("industries","id","name_en",array("id" => "0:>"),array(),"",true),@$_GET["sm_industries"]);
				$db->addtable("locations");$db->addfield("province_id,location_id,name_en");
				$locations[""] = "";
				foreach($db->fetch_data() as $location){ $locations[$location[0].":".$location[1]] = $location[2]; }
				$sm_locations 		= $f->select("sm_locations",$locations,@$_GET["sm_locations"]);
				$sm_job_functions 	= $f->select("sm_job_functions",$db->fetch_select_data("job_functions","id","name_en",array("id" => "0:>"),array(),"",true),@$_GET["sm_job_functions"]);
				$sm_gender 			= $f->select("sm_gender",array(""=>"","1"=>"Male","2"=>"Female"),@$_GET["sm_gender"]);
				$checked			= (@$_GET["chk_is_syariah"]) ? "checked" : "";
				$chk_is_syariah 	= $f->input("chk_is_syariah","1","type='checkbox' ".$checked);
				$checked			= (@$_GET["chk_is_freshgraduate"]) ? "checked" : "";
				$chk_is_freshgraduate = $f->input("chk_is_freshgraduate","1","type='checkbox' ".$checked);
			?>
			<?=$t->row(array("Opportunity Id",$txt_opportunity_id));?>
			<?=$t->row(array("Title",$txt_title));?>
			<?=$t->row(array("Job Type",$sm_job_types));?>
			<?=$t->row(array("Industry",$sm_industries));?>
			<?=$t->row(array("Location",$sm_locations));?>
			<?=$t->row(array("Job Function",$sm_job_functions));?>
			<?=$t->row(array("Is Syariah",$chk_is_syariah));?>
			<?=$t->row(array("Is Fresh Graduate",$chk_is_freshgraduate));?>
			<?=$t->end();?>
			<?=$f->input("edit_advertising","0","type='hidden'");?>
			<?=$f->input("add_advertising","0","type='hidden'");?>
			<?=$f->input("add_opportunity_id","0","type='hidden'");?>
			<?=$f->input("searching_advertising","1","type='hidden'");?>
			<?=$f->input("page","1","type='hidden'");?>
			<?=$f->input("sort",@$_GET["sort"],"type='hidden'");?>
			<?=$f->input("do_filter","Load","type='button' onclick='search_advertising();'");?>
		<?=$f->end();?>
	</div>
</div>

<?php
	$whereclause = "company_id = '".$__company_id."'";
	if(@$_GET["txt_opportunity_id"]!="") $whereclause .= " AND id LIKE '%".$_GET["txt_opportunity_id"]."%'";
	if(@$_GET["txt_title"]!="") $whereclause .= " AND (title_id LIKE '%".$_GET["txt_title"]."%' OR title_en LIKE '%".$_GET["txt_title"]."%')";
	if(@$_GET["sm_job_types"]!="") $whereclause .= " AND job_type_id = '".$_GET["sm_job_types"]."'";
	if(@$_GET["sm_industries"]!="") $whereclause .= " AND industry_id = '".$_GET["sm_industries"]."'";
	if(@$_GET["sm_locations"]!=""){ 
		$arrselected = explode(":",$_GET["sm_locations"]);
		$whereclause .= " AND province_id = '".$arrselected[0]."' AND location_id = '".$arrselected[1]."'";
	}
	if(@$_GET["sm_job_functions"]!="") $whereclause .= " AND job_function_id = '".$_GET["sm_job_functions"]."'";
	if(isset($_GET["chk_is_syariah"])){ $whereclause .= " AND is_syariah = 1"; 	}
	if(isset($_GET["chk_is_freshgraduate"])){ $whereclause .= " AND is_freshgraduate = 1"; 	}
	
	$_max_counting = 300;
	$_rowperpage = $db->searchjob_limit;
	$_GET["sort"] = "created_at DESC";
	
	$db->addtable("opportunities");
	$db->awhere($whereclause);$db->limit($_max_counting);
	$maxrow = count($db->fetch_data(true));
	$start = getStartRow(@$_GET["page"],$_rowperpage);
	$paging = paging($_rowperpage,$maxrow,@$_GET["page"],"paging");
	
	$db->addtable("opportunities");
	$db->awhere($whereclause);$db->limit($start.",".$_rowperpage);
	if(@$_GET["sort"] != "") $db->order($_GET["sort"]);
	$opportunities = $db->fetch_data(true);
?>
	<br>
	<?php if($remain_opportunity != 0) echo $f->input("add","Add Opportunity","type='button' onclick=\"add_advertising_clicked();\""); ?>
	<?=$t->start("","","content_data");?>
	<?=$t->header(array("No",
						"Id",
						"Title/<br>Job Type/<br>Job Function",
						"Industry/<br>Location",
						"Other Info",
						"Post Range",
						"Created",
						""));?>
	<?php foreach($opportunities as $no => $opportunity){ ?>
		<?php
			$job_type = $db->fetch_single_data("job_type","name_en",array("id" => $opportunity["job_type_id"]));
			$industry = $db->fetch_single_data("industries","name_en",array("id" => $opportunity["industry_id"]));
			$location = $db->fetch_single_data("locations","name_en",array("province_id" => $opportunity["province_id"],"location_id" => $opportunity["location_id"]));
			$job_function = $db->fetch_single_data("job_functions","name_en",array("id" => $opportunity["job_function_id"]));
			$company_name = $db->fetch_single_data("company_profiles","name",array("id" => $opportunity["company_id"]));
			$gender = "";
			foreach(pipetoarray($opportunity["gender"]) as $gender_id){ $gender .= $db->fetch_single_data("gender","name_en",array("id" => $gender_id)).", "; }
			if($gender != "") $gender = substr($gender,0,-2);
			$is_syariah = ($opportunity["is_syariah"] == 1) ? "Syariah" : "";
			$is_freshgraduate = ($opportunity["is_freshgraduate"] == 1) ? "Fresh Graduate" : "";
			
			$actions = "<a href='#' onclick=\"view_advertising('".$opportunity["id"]."');\">View</a> | 
						<a href='#' onclick=\"edit_advertising_1('".$opportunity["id"]."');\">Edit</a>
						";
		?>
		<?=$t->row(
					array($no+$start+1,
						"<a href='#' onclick=\"view_advertising('".$opportunity["id"]."');\">".$opportunity["id"]."</a>",
						$opportunity["title_en"]."<br>".$job_type."<br>".$job_function,
						$industry."<br>".$is_syariah."<br>".$location,
						$gender."<br>".$is_freshgraduate,
						format_tanggal($opportunity["posted_at"]) ." -- ".format_tanggal($opportunity["closing_date"]),
						format_tanggal($opportunity["created_at"]) ."<br>".$opportunity["created_by"],
						$actions),
					array("align='right';valign='top';","")
				);?>
	<?php } ?>
	<?=$t->end();?>
	<br>
	<div class = "whitecard" style="text-align:center;"> <?=$paging;?> </div>