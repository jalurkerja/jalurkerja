<?php 
	include_once "../common.php";
	if($__company_id != "" && $_GET["user_id"] != ""){ $user_id = $_GET["user_id"]; } else { $user_id = $__user_id; }
	$db->addtable("seeker_profiles");$db->where("user_id",$_GET["user_id"]);$db->limit(1);
	$seeker_profile = $db->fetch_data();
	$photo = $seeker_profile["photo"];
	if($photo == "") $photo = "nophoto.png";
	$photo = "seekers_photo/".$photo;
	$db->addtable("seeker_experiences");$db->where("user_id",$user_id);$db->order("startdate DESC");$db->limit(1);
	$last_seeker_experience = $db->fetch_data();
	$last_industry = $db->fetch_single_data("industries","name_".$__locale,array("id" => $last_seeker_experience["industry_id"]));
	$birthplace = $db->fetch_single_data("locations","name_".$__locale,array("id" => $seeker_profile["birthplace"]));
	$expected_salary_min = $db->fetch_single_data("seeker_desires","salary_min",array("user_id" => $user_id));
	$expected_salary_max = $db->fetch_single_data("seeker_desires","salary_max",array("user_id" => $user_id));
	$expected_salary = salary_min_max($expected_salary_min,$expected_salary_max);
?>
<div class="card">
	<div style="height:20px;" id="title"></div>
	<img style="position:absolute;left:20px;top:50px;border:3px solid rgba(12, 179, 29, 0.3);" src="<?=$photo;?>" width="150" height="220">
	<div class="applicant_resume_header">
		<div id="name"><?=$seeker_profile["first_name"];?> <?=$seeker_profile["middle_name"];?> <?=$seeker_profile["last_name"];?></div>
		<div id="workplace">
			<?=$last_seeker_experience["position"];?> <?=$v->w("at");?> <?=$last_seeker_experience["company_name"];?> | <?=$last_industry;?> | 
			<?=$db->fetch_single_data("locations","name_".$__locale,array("province_id" => $seeker_profile["province_id"],"location_id" => $seeker_profile["location_id"]));?>
		</div>
		<div id="phone"><?=$v->w("phone");?> : <?=$seeker_profile["phone"];?></div>
		<div id="mail"><?=$v->w("email");?> : <?=$db->fetch_single_data("users","email",array("id" => $seeker_profile["user_id"]));?></div>
	</div>
	<div class="applicant_resume_header_border"></div>
	<div class="applicant_resume_profile">
		<?=$t->start();?>
		<?=$t->row(array($v->w("gender"),"&nbsp;&nbsp;:&nbsp;&nbsp;",$db->fetch_single_data("gender","name_".$__locale,array("id" => $seeker_profile["gender_id"]))));?>
		<?=$t->row(array($v->w("address"),"&nbsp;&nbsp;:&nbsp;&nbsp;",chr13tobr($seeker_profile["address"])));?>
		<?=$t->row(array($v->w("place_and_birth_date"),"&nbsp;&nbsp;:&nbsp;&nbsp;",$birthplace.", ".format_tanggal($seeker_profile["birthdate"],"dMY")));?>
		<?=$t->row(array($v->w("nationality"),"&nbsp;&nbsp;:&nbsp;&nbsp;",$seeker_profile["nationality"]));?>
		<?=$t->row(array($v->w("marital_status"),"&nbsp;&nbsp;:&nbsp;&nbsp;",$db->fetch_single_data("marital_status","name_".$__locale,array("id" => $seeker_profile["marital_status_id"]))));?>
		<?=$t->row(array($v->w("expected_salary"),"&nbsp;&nbsp;:&nbsp;&nbsp;",$expected_salary));?>
		<?=$t->row(array($v->w("web"),"&nbsp;&nbsp;:&nbsp;&nbsp;",$seeker_profile["web"]));?>
		<?=$t->row(array($v->w("last_updated"),"&nbsp;&nbsp;:&nbsp;&nbsp;",format_tanggal($seeker_profile["updated_at"],"dMY")));?>
		<?=$t->end();?>
	</div>
	<div class="applicant_resume_border"><?=$v->w("education");?></div>
	<div class="seeker_profile_sp_detail" style="margin-left:10px;width:955px;">
		<?php
			$db->addtable("seeker_educations");$db->where("user_id",$user_id); $db->order("start_year DESC");
			$seeker_educations = $db->fetch_data(true);
			$rows = array();
			foreach($seeker_educations as $seeker_education){
				if($seeker_education["graduated_year"] == "0"){
					$education_periode = $seeker_education["start_year"]." (".$v->w("still_school_here").")";
				}else{
					$education_periode = $seeker_education["start_year"]." - ".$seeker_education["graduated_year"];
				}
				$education_summary = $db->fetch_single_data("degree","name_".$__locale,array("id" => $seeker_education["degree_id"]))." - ";
				$education_summary .= $db->fetch_single_data("majors","name_".$__locale,array("id" => $seeker_education["major_id"]))."<br>";
				$education_summary .= $seeker_education["school_name"]."<br>";
				$education_summary .= $v->w("gpa")." ".$seeker_education["gpa"]."<br>";
				$education_summary .= $seeker_education["honors"]."<br>";
				$rows[] = array($education_periode,"<div style='width:100px;'></div>",$education_summary);
			}
			echo $t->start();
				foreach($rows as $row){ echo $t->row($row); }
			echo $t->end();
		?>
	</div>
	
	<div class="applicant_resume_border"><?=$v->w("work_experience");?></div>
	<div class="seeker_profile_sp_detail" style="margin-left:10px;width:955px;">
		<?php
			$db->addtable("seeker_experiences");$db->where("user_id",$user_id); $db->order("startdate DESC");
			$seeker_experiences = $db->fetch_data(true);
			foreach($seeker_experiences as $seeker_experience){
				echo format_range_tanggal($seeker_experience["startdate"],$seeker_experience["enddate"])."<br>";
				echo "<div style='margin-left:10px;font-weight:bolder;font-size:13px;'>".
					$seeker_experience["position"].$v->w("at").$seeker_experience["company_name"]."</div>".
					"<div style='margin-left:10px;font-weight:bolder;font-size:12px;'>".
					$db->fetch_single_data("job_functions","name_".$__locale,array("id" => $seeker_experience["job_function_id"]))." | ".
					$db->fetch_single_data("job_level","name_".$__locale,array("id" => $seeker_experience["job_level_id"]))." | ".
					$db->fetch_single_data("job_type","name_".$__locale,array("id" => $seeker_experience["job_type_id"]))."</div>".
					"<div style='margin-left:10px;'>".$v->w("work_descriptions")." :</div>".
					"<div style='margin-left:20px;'>".$seeker_experience["description"]."</div>".
					"<div style='height:20px;'></div>";
			}
		?>
	</div>
	
	<div class="applicant_resume_border">
	<?=$t->start();?>
	<?=$t->row(
				array($v->w("certification"),$v->w("languages"),$v->w("skills")),
				array("style='width:455px;' valign='top'","style='width:250px;' valign='top'","style='width:250px;' valign='top'")
			);?>
	<?=$t->end();?>
	</div>
	<div style="margin-left:10px;width:955px;">
	<?php
		$db->addtable("seeker_certifications");$db->where("user_id",$user_id);$db->order("issued_at DESC");
		$certifications=$db->fetch_data(true);
		$_certifications = "";
		foreach($certifications as $certification){
			$_certifications .= "<div style='margin-left:10px;font-weight:bolder;font-size:14px;'>".$certification["name"]."</div>";
			$_certifications .= "<div style='margin-left:10px;font-weight:bolder;'>".format_tanggal($certification["issued_at"],"dMY")."</div>";
			$_certifications .= "<div style='margin-left:20px;'>".$certification["description"]."</div>";
			$_certifications .= "<div style='height:20px;'></div>";
		}
		
		$db->addtable("seeker_languages");$db->where("user_id",$user_id);
		$seeker_languages=$db->fetch_data(true);
		$_languages = "";
		foreach($seeker_languages as $seeker_language){
			$_languages .= "<div style='margin-left:10px;font-weight:bolder;font-size:14px;'>".$seeker_language["language_name"]."</div>";
			$_languages .= "<div style='margin-left:20px;'>".$v->w("speaking_level")." : ".$db->fetch_single_data("level","name_".$__locale,array("id" => $seeker_language["speaking_level_id"]))."</div>";
			$_languages .= "<div style='margin-left:20px;'>".$v->w("writing_level")." : ".$db->fetch_single_data("level","name_".$__locale,array("id" => $seeker_language["writing_level_id"]))."</div>";
			$_languages .= "<div style='height:20px;'></div>";
		}
		
		$db->addtable("seeker_skills");$db->where("user_id",$user_id);
		$seeker_skills=$db->fetch_data(true);
		$_skills = "";
		foreach($seeker_skills as $seeker_skill){
			$_skills .= "<div style='margin-left:10px;font-weight:bolder;font-size:14px;'>".$seeker_skill["name"]."</div>";
			$_skills .= "<div style='margin-left:20px;'>".$v->w("skill_level")." : ".$db->fetch_single_data("level","name_".$__locale,array("id" => $seeker_skill["level_id"]))."</div>";
			$_skills .= "<div style='height:20px;'></div>";
		}
		
		echo $t->start();
		echo $t->row(
					array($_certifications,$_languages,$_skills),
					array(	"class='seeker_profile_sp_detail' style='width:455px;' valign='top'",
							"class='seeker_profile_sp_detail' style='width:250px;' valign='top'",
							"class='seeker_profile_sp_detail' style='width:250px;' valign='top'"
						)
				);
		echo $t->end();
	?>
	</div>
	
	<div class="applicant_resume_border"><?=$v->w("summary");?></div>
	<div class="seeker_profile_sp_detail" style="margin-left:10px;width:955px;">
		<?php
			$db->addtable("seeker_summary");$db->where("user_id",$user_id); $db->limit(1);
			$seeker_summary = $db->fetch_data();
			echo $t->start();
			echo $t->row(array(chr13tobr($seeker_summary["summaries"])),array("class='seeker_profile_sp_detail' style='width:955px;' valign='top'"));
			echo $t->end();
		?>
	</div>
	<div style="height:50px;"></div>
</div>