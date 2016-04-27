<?php
	function company_profile_applicant_management_list($key_id,$tabid,$keyword,$sort,$page){
		global $__locale,$__user_id,$v,$t,$db,$f;
		
		//collect data to temp_applicant_management
		$db->addtable("temp_applicant_management");$db->where("user_id_view",$__user_id);$db->delete_();
		
		$db->addtable("opportunities");$db->where("id",$key_id);$db->limit(1);
		$opportunity = $db->fetch_data();
		
		$db->addtable("opportunity_filter_categories");$db->where("opportunity_id",$key_id);$db->limit(1);
		$filter_categories = $db->fetch_data();
		
		$whereclause = "opportunity_id = '".$key_id."'";
		$db->addtable("applied_opportunities");$db->awhere($whereclause);
		$applied_opportunities = $db->fetch_data(true);
		$maxrow = count($applied_opportunities);
		foreach($applied_opportunities as $key => $applied_opportunity){
			$matched_categories = "";
			$user_id = $applied_opportunity["user_id"];
			$db->addtable("seeker_profiles");$db->where("user_id",$user_id);$db->limit(1);
			$seeker_profile = $db->fetch_data();
			$match_level_1 = 0; $match_level_2 = 0;
			if($filter_categories["job_level"]){
				$match_level_2++;$innerwhere = "";
				foreach(pipetoarray($opportunity["job_level_ids"]) as $value){ $innerwhere .= "job_level_id = '".$value."' OR "; }
				if($innerwhere != "") $innerwhere = substr($innerwhere,0,-3);
				$db->addtable("seeker_experiences");$db->addfield("count(0)"); $db->awhere("user_id = '".$user_id."' AND (".$innerwhere.")");
				$hsl = $db->fetch_data(); if($hsl[0] > 0){ $match_level_1++; $matched_categories .= "job_level, ";}
			}
			if($filter_categories["job_function"]){
				$match_level_2++;
				$db->addtable("seeker_experiences");$db->addfield("count(0)"); $db->awhere("user_id = '".$user_id."' AND job_function_id = '".$opportunity["job_function_id"]."'");
				$hsl = $db->fetch_data(); if($hsl[0] > 0){ $match_level_1++; $matched_categories .= "job_function, ";}
			}
			if($filter_categories["location"]){
				$match_level_2++;
				$db->addtable("seeker_profiles");$db->addfield("count(0)"); $db->awhere("user_id = '".$user_id."' AND province_id = '".$opportunity["province_id"]."' AND location_id = '".$opportunity["location_id"]."'");
				$hsl = $db->fetch_data(); if($hsl[0] > 0){ $match_level_1++; $matched_categories .= "location, ";}
			}
			if($filter_categories["degree"]){
				$match_level_2++;
				$db->addtable("seeker_educations");$db->addfield("count(0)"); $db->awhere("user_id = '".$user_id."' AND degree_id = '".$opportunity["degree_id"]."'");
				$hsl = $db->fetch_data(); if($hsl[0] > 0){ $match_level_1++; $matched_categories .= "degree, ";}
			}
			if($filter_categories["major"]){
				$match_level_2++;$innerwhere = "";
				foreach(pipetoarray($opportunity["major_ids"]) as $value){ $innerwhere .= "major_id = '".$value."' OR "; }
				if($innerwhere != "") $innerwhere = substr($innerwhere,0,-3);
				$db->addtable("seeker_educations");$db->addfield("count(0)"); $db->awhere("user_id = '".$user_id."' AND (".$innerwhere.")");
				$hsl = $db->fetch_data(); if($hsl[0] > 0){ $match_level_1++; $matched_categories .= "major, ";}
			}
			$db->addtable("seeker_profiles");$db->addfield("birthdate"); $db->awhere("user_id = '".$user_id."'"); $hsl = $db->fetch_data();
			$datediff = date_diff(date_create(date("Y-m-d H:i:s")),date_create($hsl["birthdate"]),true); $age = floor($datediff->days/365);
			if($filter_categories["age"]){
				$match_level_2++;
				if($age >= $opportunity["age_min"] && $age <= $opportunity["age_max"]){ $match_level_1++; $matched_categories .= "age, ";}
			}
			if($filter_categories["salary"]){
				$match_level_2++;
				$db->addtable("seeker_desires");$db->addfield("count(0)"); $db->awhere("user_id = '".$user_id."' AND salary_min <= '".$opportunity["salary_max"]."' AND salary_max >= '".$opportunity["salary_min"]."'");
				$hsl = $db->fetch_data(); if($hsl[0] > 0){ $match_level_1++; $matched_categories .= "salary, ";}
			}
			if($filter_categories["industry"]){
				$match_level_2++;
				$db->addtable("seeker_experiences");$db->addfield("count(0)"); $db->awhere("user_id = '".$user_id."' AND industry_id = '".$opportunity["industry_id"]."'");
				$hsl = $db->fetch_data(); if($hsl[0] > 0){ $match_level_1++; $matched_categories .= "industry, ";}
			}
			if($filter_categories["gender"]){
				$match_level_2++;$innerwhere = "";
				foreach(pipetoarray($opportunity["gender"]) as $value){ $innerwhere .= "gender_id = '".$value."' OR "; }
				if($innerwhere != "") $innerwhere = substr($innerwhere,0,-3);
				$db->addtable("seeker_profiles");$db->addfield("count(0)"); $db->awhere("user_id = '".$user_id."' AND (".$innerwhere.")");
				$hsl = $db->fetch_data(true); if($hsl[0] > 0){ $match_level_1++; $matched_categories .= "gender, ";}
			}
			$startdate = $db->fetch_single_data("seeker_experiences","startdate",array("user_id" => $user_id),array("startdate"));
			$enddate = $db->fetch_single_data("seeker_experiences","enddate",array("user_id" => $user_id),array("enddate"));
			$stillwork = $db->fetch_single_data("seeker_experiences","count(0)",array("user_id" => $user_id,"enddate" => "0000-00-00 00:00:00"));
			if($stillwork == 1) $enddate = date("Y-m-d H:i:s");
			$datediff = date_diff(date_create($enddate),date_create($startdate),true); $experience_years = floor($datediff->days/365);
			if($filter_categories["experience_years"]){
				$match_level_2++;
				if($experience_years >= $opportunity["experience_years"]){ $match_level_1++; $matched_categories .= "experience_years, ";}
			}
			$match_level = $match_level_1."/".$match_level_2;
			$name = $seeker_profile["first_name"]." ".$seeker_profile["middle_name"]." ".$seeker_profile["last_name"];
			$gender_id = $seeker_profile["gender_id"];
			$province_id = $seeker_profile["province_id"];
			$location_id = $seeker_profile["location_id"];
			$applied_date = $applied_opportunities["created_at"];
			$db->addtable("seeker_experiences");$db->where("user_id",$user_id);$db->order("startdate DESC");$db->limit(1);
			$last_seeker_experiences = $db->fetch_data();
			$position = $last_seeker_experiences["position"];
			$company_name = $last_seeker_experiences["company_name"];
			$job_level_id = $last_seeker_experiences["job_level_id"];
			$job_function_id = $last_seeker_experiences["job_function_id"];
			$salary_min =  $db->fetch_single_data("seeker_desires","salary_min",array("user_id" => $user_id));
			$salary_max =  $db->fetch_single_data("seeker_desires","salary_max",array("user_id" => $user_id));
			$db->addtable("seeker_educations");$db->where("user_id",$user_id);$db->order("graduated_year DESC");$db->limit(1);
			$last_seeker_educations = $db->fetch_data();
			$degree_id = $last_seeker_educations["degree_id"];
			$major_id = $last_seeker_educations["major_id"];
			$photo = $seeker_profile["photo"]; if($photo == "") $photo = "nophoto.png";
			$applicant_status_id = $applied_opportunities["applicant_status_id"];
			
			$db->addtable("temp_applicant_management");
			$db->addfield("user_id_view");$db->addvalue($__user_id);
			$db->addfield("opportunity_id");$db->addvalue($key_id);
			$db->addfield("user_id");$db->addvalue($user_id);
			$db->addfield("match_level");$db->addvalue($match_level);
			$db->addfield("matched_categories");$db->addvalue($matched_categories);
			$db->addfield("name");$db->addvalue($name);
			$db->addfield("gender_id");$db->addvalue($gender_id);
			$db->addfield("age");$db->addvalue($age);
			$db->addfield("province_id");$db->addvalue($province_id);
			$db->addfield("location_id");$db->addvalue($location_id);
			$db->addfield("applied_date");$db->addvalue($applied_date);
			$db->addfield("position");$db->addvalue($position);
			$db->addfield("company_name");$db->addvalue($company_name);
			$db->addfield("job_level_id");$db->addvalue($job_level_id);
			$db->addfield("job_function_id");$db->addvalue($job_function_id);
			$db->addfield("experience_years");$db->addvalue($experience_years);
			$db->addfield("salary_min");$db->addvalue($salary_min);
			$db->addfield("salary_max");$db->addvalue($salary_max);
			$db->addfield("degree_id");$db->addvalue($degree_id);
			$db->addfield("major_id");$db->addvalue($major_id);
			$db->addfield("photo");$db->addvalue($photo);
			$db->addfield("applicant_status_id");$db->addvalue($applicant_status_id);
			$db->insert();
		}
		//end collect data to temp_applicant_management
		
		$return  = "";
		$return .= "";
		$arrsortby = array(
						 "applied_date" => $v->w("applied_date")." (A - Z)",
						 "applied_date DESC" => $v->w("applied_date")." (Z - A)",
						 "experience_years DESC" => $v->w("work_experience")." (Z - A)",
						 "experience_years" => $v->w("work_experience")." (A - Z)",
						 "match_level DESC" => $v->w("match_level")." (Z - A)",
						 "match_level" => $v->w("match_level")." (A - Z)",
						);
		$sel_sortby = $f->select("orderby",$arrsortby,$sort,"onchange=\"load_applicant_management('".$tabid."','".$keyword."',this.value,'1','".$key_id."');\"");
		
		$return .= "<table width='100%'><tr><td align='right' nowrap>".$v->w("sort_by")." : ".$sel_sortby."</td></tr></table>";
		$return .= "<div style='margin:10px;width:950px;' class='seeker_profile_sp_detail'>";
		$return .= 		$t->start("style='width:950px;'","","content_data");
		$return .= 			$t->header(array(	"%",
												$v->w("candidate_profile"),
												$v->w("work_experience"),
												$v->w("experience_years"),
												$v->w("expected_salary")."<br>(IDR)(.000)",
												$v->w("education"),
												$v->w("photo"),
												$v->w("resume_status")
											),array("style='font-size:11px;'"));
		
		$whereclause = "user_id_view = '".$__user_id."'";
		$db->addtable("temp_applicant_management");$db->awhere($whereclause);
		$start = getStartRow($page,$db->searchjob_limit);
		$db->limit($start.",".$db->searchjob_limit);
		if(!$sort) $sort = "applied_date"; $db->order($sort);
		$t_a_ms= $db->fetch_data(true);
		$rows = array();
		foreach($t_a_ms as $t_a_m){
			$gender = $db->fetch_single_data("gender","name_".$__locale,array("id" => $t_a_m["gender_id"]));
			$location = $db->fetch_single_data("locations","name_".$__locale,array("province_id" => $t_a_m["province_id"],"location_id" => $t_a_m["location_id"]));
			$job_level = $db->fetch_single_data("job_level","name_".$__locale,array("id" => $t_a_m["job_level_id"]));
			$job_function = $db->fetch_single_data("job_functions","name_".$__locale,array("id" => $t_a_m["job_function_id"]));
			$degree = $db->fetch_single_data("degree","name_".$__locale,array("id" => $t_a_m["degree_id"]));
			$major = $db->fetch_single_data("majors","name_".$__locale,array("id" => $t_a_m["major_id"]));
			$matched_categories = str_replace(",","<br>",$t_a_m["matched_categories"]);
			$applicant_status_id = ($t_a_m["applicant_status_id"] > 0) ? $db->fetch_single_data("applicant_status","name",array("id" => $t_a_m["applicant_status_id"])) : $v->w("unviewed");
			$rows[] = array(
							$t_a_m["match_level"],
							
							"<b>".$t_a_m["name"]."</b><br>".
							$gender.", ".$t_a_m["age"]." ".$v->w("years")."<br>".
							$location."<br>".
							$v->w("applied_date")." :".format_tanggal($t_a_m["applied_date"]),
							
							"<b>".$t_a_m["position"]."</b><br>".
							$t_a_m["company_name"]."<br>".
							$job_level."<br>".
							$job_function,
							
							$t_a_m["experience_years"]." ".$v->w("years"),
							
							number_format($t_a_m["salary_min"]/1000,0,",",".")." - ".number_format($t_a_m["salary_max"]/1000,0,",","."),
							
							"<b>".$degree."</b><br>".
							$major,
							
							"<img width='60' src='seekers_photo/".$t_a_m["photo"]."'>",
							
							$applicant_status_id
						);
		}
		
		foreach($rows as $row) { $return .= $t->row($row,array("style='width:5px;font-size:11px;' valign='top'")); }
		$return .= 		$t->end();
		$return .= "</div>";
		$return .= "<div style='margin:10px;width:950px;text-align:center;' class='whitecard'>";
		$return .= paging($db->searchjob_limit,$maxrow,$page,"paging");
		$return .= "</div>";
		return $return;
	}
?>