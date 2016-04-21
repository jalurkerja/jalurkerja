<?php 
	include_once "../common.php"; 
	
	if(isset($_GET["mode"])){ $_mode = $_GET["mode"]; } else { $_mode = ""; }
	
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
	
	if($_mode == "list"){
		$db->addtable("opportunities"); 
		$db->limit($db->searchjob_limit);
		$opportunities = $db->fetch_data();
		$return = "";
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
				$logo = "<img src='opportunity_logo/".$opportunity["logo"]."' height='120'>";
			} elseif($company_profile_logo != "" && @file_exists("../company_logo/".$company_profile_logo)){
				$logo = "<img src='company_logo/".$company_profile_logo."' height='120'>";
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
	}
	
	if($_mode == "detail"){
		$opportunity_id = $_GET["opportunity_id"];
		$db->addtable("opportunities"); $db->where("id",$opportunity_id);$db->limit(1);
		$opportunity = $db->fetch_data();
		$return = "";
		if(isset($opportunity[0])){
			foreach($opportunity as $field => $value){ 
				if(!is_numeric($field)) $return .= "<div id='opportunity__".$field."'>".$value."</div>"; 
			}
			
			$db->addtable("industries"); $db->addfield("name_".$__locale);$db->where("id",$opportunity["industry_id"]);$db->limit(1);
			$return .= "<div id='opportunity__industry'>".$db->fetch_data(false,0)."</div>";
			
			$db->addtable("job_functions"); $db->addfield("name_".$__locale);$db->where("id",$opportunity["job_function_id"]);$db->limit(1);
			$return .= "<div id='opportunity__job_function'>".$db->fetch_data(false,0)."</div>";
			
			$db->addtable("job_level"); $db->addfield("name_".$__locale); $db->where("id",$opportunity["job_level_ids"],"i","in");
			$job_levels = $db->fetch_data();
			$return .= "<div id='opportunity__job_levels'>";
				if(is_array($job_levels[0])){ foreach($job_levels as $job_level){ $return .= $job_level[0].", "; } $return = substr($return,0,-2);
				} else { $return .= $job_levels[0]; }
			$return .= "</div>";
			
			$db->addtable("degree"); $db->addfield("name_".$__locale);$db->where("id",$opportunity["degree_id"]);$db->limit(1);
			$return .= "<div id='opportunity__degree'>".$db->fetch_data(false,0)."</div>";
			
			$db->addtable("majors"); $db->addfield("name_".$__locale); $db->where("id",$opportunity["major_ids"],"i","in");
			$majors = $db->fetch_data();
			$return .= "<div id='opportunity__majors'>";
				if(is_array($majors[0])){ foreach($majors as $job_level){ $return .= $job_level[0].", "; } $return = substr($return,0,-2);
				} else { $return .= $majors[0]; }
			$return .= "</div>";
			
			$return .= "<div id='opportunity__salary_offer'>".salary_min_max($opportunity["salary_min"],$opportunity["salary_max"])."</div>";
			$return .= "<div id='opportunity__posted_date'>".format_tanggal($opportunity["posted_at"],"dMY")."</div>";
			$return .= "<div id='opportunity__closing_date2'>".format_tanggal($opportunity["closing_date"],"dMY")."</div>";
			$return .= "<div id='opportunity__descriptions'>".str_replace(array(chr(13).chr(10),chr(13)),"<br>",$opportunity["description"])."</div>";
			$return .= "<div id='opportunity__requirements'>".str_replace(array(chr(13).chr(10),chr(13)),"<br>",$opportunity["requirement"])."</div>";
			
		} else {
			$return .= "<div id='opportunity__id'>NULL</div>";
		}
		echo $return;
	}
?>
