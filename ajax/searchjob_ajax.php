<?php 
	include_once "../common.php"; 
	
	if(isset($_GET["mode"])){ $_mode = $_GET["mode"]; } else { $_mode = ""; }
	
	if(isset($_POST["post_data"])){ parse_str($_POST["post_data"],$_POST); }
	
	if($_mode == "isapplied"){ echo $js->is_applied($_GET["user_id"],$_GET["opportunity_id"]); }
	if($_mode == "issaved"){ echo $js->is_saved($_GET["user_id"],$_GET["opportunity_id"]); }
	
	if($_mode == "apply_on_company_page"){ echo $js->opportunity_belongs_to_company($_GET["opportunity_id"],$__company_profiles_id); }
	
	if($_mode == "apply"){		
		$opportunity_id = $_GET["opportunity_id"];
		$email = $_GET["email"];
		if($__company_profiles_id != "" && $email == ""){
			//cek apakah opportunity id milik company tersebut
			$db->addtable("opportunities");
			$db->addfield("id");
			$db->where("id",$opportunity_id);
			$db->where("company_id",$__company_profiles_id);
			$db->limit(1);
			$company = $db->fetch_data();
			if($company["id"] == $opportunity_id){
				echo "need_email:".$opportunity_id;
			}else{
				echo $js->apply_opportunity($__user_id,$opportunity_id);
			}
		} else {
			if($email){
				$db->addtable("users"); $db->addfield("id"); $db->where("email",$email); $db->limit(1);
				$user_id = $db->fetch_data(false,0);
			} else { 
				$user_id = $__user_id;
			}
			echo $js->apply_opportunity($user_id,$opportunity_id);
		}
	}

	if($_mode == "save"){
		$opportunity_id = $_GET["opportunity_id"];
		echo $js->save_opportunity($__user_id,$opportunity_id);
	}

	if($_mode == "loading_paging"){
		if($_GET["maxrow"] > 0){
			$return  = "<div class='whitecard' style='text-align:center'>";
			$return .= paging($db->searchjob_limit,$_GET["maxrow"],1,"paging");
			$return .= "</div>";
			echo $return;
		}
	}
	
	if($_mode == "list" || $_POST["searchjobpage_searching"]){
		$whereclause = "";
		if(isset($_POST["keyword"]) && $_POST["keyword"]!=""){
			$keyword = $_POST["keyword"];
			$whereclause .= "(
								title_id LIKE '%$keyword%' OR
								title_en LIKE '%$keyword%' OR
								web LIKE '%$keyword%' OR
								company_description LIKE '%$keyword%' OR
								name LIKE '%$keyword%' OR
								requirement LIKE '%$keyword%' OR
								description LIKE '%$keyword%'
							) AND ";
		}
		
		if(isset($_POST["job_function"])){
			$whereclauseinner = "";
			foreach($_POST["job_function"] as $job_function_id => $val){ $whereclauseinner .= "job_function_id = $job_function_id OR "; }
			if($whereclauseinner !="" ) $whereclause .= "(".substr($whereclauseinner,0,-3).") AND ";
		}

		if(isset($_POST["work_location"])){
			$whereclauseinner = "";
			foreach($_POST["work_location"] as $location_id => $val){
				$location_id = explode(":",$location_id);
				$whereclauseinner .= "(province_id = ".$location_id[0]." AND location_id = ".$location_id[1].") OR "; 
			}
			if($whereclauseinner !="" ) $whereclause .= "(".substr($whereclauseinner,0,-3).") AND ";
		}
		
		if(isset($_POST["job_level"])){
			$whereclauseinner = "";
			foreach($_POST["job_level"] as $job_level_id => $val){ $whereclauseinner .= "job_level_ids LIKE '%|".$job_level_id."|%' OR "; }
			if($whereclauseinner !="" ) $whereclause .= "(".substr($whereclauseinner,0,-3).") AND ";
		}
		
		if(isset($_POST["industries"])){
			$whereclauseinner = "";
			foreach($_POST["industries"] as $industry_id => $val){ $whereclauseinner .= "industry_id = $industry_id OR "; }
			if($whereclauseinner !="" ) $whereclause .= "(".substr($whereclauseinner,0,-3).") AND ";
		}
		
		if(isset($_POST["education_level"])){
			$whereclauseinner = "";
			foreach($_POST["education_level"] as $degree_id => $val){ $whereclauseinner .= "degree_id = $degree_id OR "; }
			if($whereclauseinner !="" ) $whereclause .= "(".substr($whereclauseinner,0,-3).") AND ";
		}
		
		if(isset($_POST["work_experience"])){
			$whereclauseinner = "";
			foreach($_POST["work_experience"] as $work_experience => $val){ $whereclauseinner .= "experience_years = $work_experience OR "; }
			if($whereclauseinner !="" ) $whereclause .= "(".substr($whereclauseinner,0,-3).") AND ";
		}
		
		if(isset($_POST["job_type"])){
			$whereclauseinner = "";
			foreach($_POST["job_type"] as $job_type_id => $val){ $whereclauseinner .= "job_type_id = $job_type_id OR "; }
			if($whereclauseinner !="" ) $whereclause .= "(".substr($whereclauseinner,0,-3).") AND ";
		}

		if(isset($_POST["salary_from"]) && $_POST["salary_from"] > 0){ $whereclause .= "salary_max >= '".$_POST["salary_from"]."' AND ";}
		if(isset($_POST["salary_to"]) && $_POST["salary_to"] > 0){ $whereclause .= "salary_min <= '".$_POST["salary_to"]."' AND ";}
		if(isset($_POST["chk_syariah"])){ $whereclause .= "is_syariah = '1' AND "; }
		if(isset($_POST["chk_fresh_graduate"])){ $whereclause .= "is_freshgraduate = '1' AND "; }
		
		
		if($whereclause != "") $whereclause = substr($whereclause,0,-4);
		
		/////echo $whereclause;

		$return = "";
		//counting//
		$db->addtable("opportunities");
		if($whereclause != "") $db->awhere($whereclause);
		$db->limit(300);//di kasih limit biar ga kepanjangan pagingnya
		$maxrow = count($db->fetch_data(true)) * 1;
		$return = "<div id='opportunities_maxrow' style='display:none'>".$maxrow."</div>";
		
		if(isset($_POST["searchjob_page"])) $searchjob_page = $_POST["searchjob_page"] * 1;
		if($searchjob_page == 0) $searchjob_page = 1;
		$return .= "<div id='opportunities_page' style='display:none'>$searchjob_page</div>";		
		//end counting//
		
		//SEARCH CRITERIA
		$return .= "<div id='opportunities_search_criteria' style='display:none;'>";
		$return .= "<div class='whitecard' style='width:200px;min-height:100px;'>";
		$return .= "<h3><b>".$v->w("your_search_criteria")." :</b></h3>";
		$return .= $t->start();
		
		if(isset($_POST["keyword"]) && $_POST["keyword"]!=""){
			$return .= $t->row(array("<b>".$v->w("keyword").":</b>"),array("colspan='2'"));
			$return .= $t->row(array("&nbsp;",$_POST["keyword"]),array(""));
		}
		
		if(isset($_POST["job_function"])){
			$job_function_criteria = "";
			foreach($_POST["job_function"] as $job_function_id => $val){ 
				$job_function_criteria .= $db->fetch_single_data("job_functions","name_".$__locale,array("id" => $job_function_id)).", ";
			}
			$return .= $t->row(array("<b>".$v->w("job_function").":</b>"),array("colspan='2'"));
			$return .= $t->row(array("&nbsp;",$job_function_criteria),array("style='white-space:pre-wrap;'"));
		}
		
		if(isset($_POST["work_location"])){
			$work_location_criteria = "";
			foreach($_POST["work_location"] as $work_location => $val){ 
				$location = explode(":",$work_location);
				$work_location_criteria .= $db->fetch_single_data("locations","name_".$__locale,array("province_id" => $location[0],"location_id" => $location[1])).", ";
			}
			$return .= $t->row(array("<b>".$v->w("work_location").":</b>"),array("colspan='2'"));
			$return .= $t->row(array("&nbsp;",$work_location_criteria),array("style='white-space:pre-wrap;'"));
		}
		
		if(isset($_POST["job_level"])){
			$job_level_criteria = "";
			foreach($_POST["job_level"] as $job_level => $val){ 
				$job_level_criteria .= $db->fetch_single_data("job_level","name_".$__locale,array("id" => $job_level)).", ";
			}
			$return .= $t->row(array("<b>".$v->w("job_level").":</b>"),array("colspan='2'"));
			$return .= $t->row(array("&nbsp;",$job_level_criteria),array("style='white-space:pre-wrap;'"));
		}
		
		if(isset($_POST["industries"])){
			$industries_criteria = "";
			foreach($_POST["industries"] as $industry => $val){ 
				$industries_criteria .= $db->fetch_single_data("industries","name_".$__locale,array("id" => $industry)).", ";
			}
			$return .= $t->row(array("<b>".$v->w("industry").":</b>"),array("colspan='2'"));
			$return .= $t->row(array("&nbsp;",$industries_criteria),array("style='white-space:pre-wrap;'"));
		}
		
		if(isset($_POST["education_level"])){
			$education_level_criteria = "";
			foreach($_POST["education_level"] as $education_level => $val){ 
				$education_level_criteria .= $db->fetch_single_data("degree","name_".$__locale,array("id" => $education_level)).", ";
			}
			$return .= $t->row(array("<b>".$v->w("education_level").":</b>"),array("colspan='2'"));
			$return .= $t->row(array("&nbsp;",$education_level_criteria),array("style='white-space:pre-wrap;'"));
		}
		
		if(isset($_POST["work_experience"])){
			$work_experience_criteria = "";
			foreach($_POST["work_experience"] as $work_experience => $val){ $work_experience_criteria .= $work_experience." ".$v->w("years").", "; }
			$work_experience_criteria = substr($work_experience_criteria,0,-2);
			$return .= $t->row(array("<b>".$v->w("work_experience").":</b>"),array("colspan='2'"));
			$return .= $t->row(array("&nbsp;",$work_experience_criteria),array("style='white-space:pre-wrap;'"));
		}
		
		if(isset($_POST["job_type"])){
			$job_type_criteria = "";
			foreach($_POST["job_type"] as $job_type => $val){ 
				$job_type_criteria .= $db->fetch_single_data("degree","name_".$__locale,array("id" => $job_type)).", ";
			}
			$return .= $t->row(array("<b>".$v->w("job_type").":</b>"),array("colspan='2'"));
			$return .= $t->row(array("&nbsp;",$job_type_criteria),array(""));
		}
		
		if($_POST["salary_from"] > 0 || $_POST["salary_to"] > 0){
			$return .= $t->row(array("<b>".$v->w("salary").":</b>"),array("colspan='2'"));
			$salaries = salary_min_max($_POST["salary_from"],$_POST["salary_to"]*1);
			$return .= $t->row(array("&nbsp;",$salaries),array("style='white-space:pre-wrap;'"));
		}

		if($_POST["chk_syariah"] == 1){ $return .= $t->row(array("<i>- ".$v->w("show_only_syariah_opportunities")."</i>"),array("colspan='2'")); }
		if($_POST["chk_fresh_graduate"] == 1){ $return .= $t->row(array("<i>- ".$v->w("show_fresh_graduate_opportunities")."</i>"),array("colspan='2'")); }
		
		$return .= $t->end();
		$return .= "</div>";
		$return .= "</div>";
		//END SEARCH CRITERIA
		
		if($maxrow > 0){
			//loading//
			$db->addtable("opportunities");
			if($whereclause != "") $db->awhere($whereclause);
			$start = getStartRow($_POST["searchjob_page"],$db->searchjob_limit);
			$db->limit($start.",".$db->searchjob_limit);
			if($_POST["searchjob_order"] == "" || !isset($_POST["searchjob_order"])) $_POST["searchjob_order"] = "posted_at DESC";
			$db->order($_POST["searchjob_order"]);
			$opportunities = $db->fetch_data(true);
			//end loading//
			
			foreach($opportunities as $key => $opportunity){
				$db->addtable("locations");
				$db->addfield("name_".$__locale);
				$db->where("province_id",$opportunity["province_id"]);
				$db->where("location_id",$opportunity["location_id"]);
				$location = $db->fetch_data(false,0);
				if($__isloggedin) { 
					$db->addtable("seeker_desires");$db->where("user_id",$__user_id);$db->limit(1);
					$seeker_desires = $db->fetch_data();
					if(@$seeker_desires["salary_max"] > 0 && @$seeker_desires["salary_min"] <= @$seeker_desires["salary_max"]){
						if(@$seeker_desires["salary_min"] > $opportunity["salary_max"]) {
							$salaries = "<font style='font-size:10px;color:grey;'>".$v->w("below_expectation")."</font>";
						} else if($seeker_desires["salary_max"] < @$opportunity["salary_min"]) {
							$salaries = "<font style='font-weight:bolder;color:#FF6808;'>".$v->w("above_expectation")."</font>";
						} else {
							$salaries = "<font style='font-weight:bolder;'>".$v->w("meet_expectation")."</font>";
						}
					} else {
						$salaries = "<i>".$v->w("please_update_your_salary_expectation")."</i>";
					}
				} else {
					$salaries = $v->w("login_for_find_out_salary");
				}
				$industry = $db->fetch_single_data("industries","name_".$__locale,array("id" => $opportunity["industry_id"]));
				$job_function = $db->fetch_single_data("job_functions","name_".$__locale,array("id" => $opportunity["job_function_id"]));
				$company_profile_logo = $db->fetch_single_data("company_profiles","logo",array("id" => $opportunity["company_id"]));
				
				if($opportunity["logo"]!="" && @file_exists("../opportunity_logo/".$opportunity["logo"])){
					$logo = "<img src='opportunity_logo/".$opportunity["logo"]."' height='120' style='max-width:120px;'>";
				} elseif($company_profile_logo != "" && @file_exists("../company_logo/".$company_profile_logo)){
					$logo = "<img src='company_logo/".$company_profile_logo."' height='120' style='max-width:120px;'>";
				} else {
					$logo = "<img src='company_logo/no_logo.png' height='120'>";
				}
				
				$return .= "<div id='container' onclick='load_detail_opportunity(\"".$opportunity["id"]."\");'>";
				$return .= "	<div id='logo'>".$logo."</div>";
				$return .= "	<div id='title'><table><tr><td width='360'>".$opportunity["title_".$__locale]."</td></tr></table></div>";
				$return .= "	<div id='detail'><u>".$opportunity["name"]."</u> - ".$location."</div>";
				$return .= "	<div id='detail'>".$v->words("work_experience")." : ".$opportunity["experience_years"]." ".$v->words("years")."</div>";
				$return .= "	<div id='detail'><table><tr><td width='360'>".$v->words("salary_offer")." : ".$salaries."</td></tr></table></div>";
				$return .= "	<div id='detail'>".$v->words("industry")." : ".$industry."&nbsp;&nbsp;&bull;&nbsp;&nbsp;".$job_function."</div>";
				$return .= "</div>";
				$return .= "<div id='ending'></div><br>";
			}
			echo $return;
		} else {
			echo "<div id='opportunities_maxrow' style='display:none'>0</div>
				  <div id='opportunities_page' style='display:none'>1</div>
				  <div class='empty_result'>".$v->w("empty_result")."</div>
				 ";
			echo $return;
		}
	}
?>
