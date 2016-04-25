<?php
	include_once "head.php";	
	include_once "scripts/searchjob_js.php";
	$token = $db->fetch_single_data("tokens","token",array("id_key" => $_GET["id"],"ip" => $_SERVER["REMOTE_ADDR"]));
	$db->generate_token($_GET["id"]);
	if($token != $_GET["token"] && false){
		echo "INVALID TOKEN!";
		echo "<script> alert('INVALID TOKEN!'); </script>";
		echo "<script> window.close(); </script>";
		exit();
	}
	$db->addtable("opportunities"); $db->where("id",$_GET["id"]); $opportunity = $db->fetch_data();
	$db->addtable("company_profiles"); $db->where("id",$opportunity["company_id"]); $company_profile = $db->fetch_data();
	if($company_profile["header_image"] != "" && file_exists("company_header/".$company_profile["header_image"])){
		$company_header = $opportunity["header_image"];
	} else {
		$company_header = "nocompanyheader.jpg";
	}
	
	if($opportunity["logo"] != "" && file_exists("opportunity_logo/".$opportunity["logo"])){
		$logo = "opportunity_logo/".$opportunity["logo"];
	} else if($company_profile["logo"] != "" && file_exists("company_logo/".$company_profile["logo"])){
		$logo = "company_logo/".$company_profile["logo"];
	} else {
		$logo = "company_logo/no_logo.png";
	}
	
	if(!$__isloggedin){
		$salaries = $v->w("login_for_find_out_salary");
	} else {
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
	}
	
?>
<center>
	<table cellpadding="0" cellspacing="0" width="100%" class="card">
		<tr><td colspan="4"><img src="company_header/<?=$company_header;?>" width="100%"></td></tr>
		<tr><td><br></td></tr>
		<tr>
			<td align="center" valign="middle" width="190"><img src="<?=$logo;?>" width="120"></td>
			<td width="10"><div style="width:10px;"></div></td>
			<td valign="top" width="450">
				<div style="font-size:30px;font-weight:bolder;"><?=$opportunity["title_".$__locale];?></div>
				<div style="font-size:20px;font-weight:bolder;"><?=$opportunity["name"];?></div>
				<br>
				<div style="font-size:15px;font-weight:bolder;"><?=$db->fetch_single_data("locations","name_".$__locale,array("province_id" => $opportunity["province_id"],"location_id" => $opportunity["location_id"]));?></div>
				<div style="font-size:13px;"><?=$salaries;?></div>
			</td>
			<td width="350" valign="middle">
				<?php if($opportunity["is_syariah"] == 1){ ?> <img style="position:absolute;left:550px;" src='icons/syariah_stamp.png' height='80'> <?php } ?>
				<?php $apply_classname = ($js->is_applied($__user_id,$_GET["id"]) > 0) ? "jobtools_btn_disabled" : "jobtools_btn"; ?>
				<input id="applybtn1" type="button" value="<?=$v->w("apply");?>" class="<?=$apply_classname;?>" onclick="apply('<?=$_GET["id"];?>');">
				<div style="height:10px;"></div>
				<?php $save_classname = ($js->is_saved($__user_id,$_GET["id"]) > 0) ? "jobtools_btn_disabled" : "jobtools_btn"; ?>
				<input id="savebtn1" type="button" value="<?=$v->w("save");?>" class="<?=$save_classname;?>" onclick="save('<?=$_GET["id"];?>');">
			</td>
		</tr>
		<tr><td><br></td></tr>
	</table>
	<br>
	<table cellpadding="10" cellspacing="10" width="100%" class="card">
		<tr>
			<td valign="top" width="220" style="font-size:13px;">
				<table cellpadding="5" cellspacing="5" style="width:220px;" class="seeker_profile_sp_detail">
					<tr>
						<td>
							<?=$v->w("job_function");?> :<br>
							&bull;&nbsp;<?=$db->fetch_single_data("job_functions","name_".$__locale,array("id" => $opportunity["job_function_id"]));?>
							<br><br>
							<?=$v->w("industry");?> :<br>
							&bull;&nbsp;<?=$db->fetch_single_data("industries","name_".$__locale,array("id" => $opportunity["industry_id"]));?>
							<br><br>
							<?=$v->w("job_level");?> :<br>
							<?php foreach(pipetoarray($opportunity["job_level_ids"]) as $key => $job_level_id){ ?>
								&bull;&nbsp;<?=$db->fetch_single_data("job_level","name_".$__locale,array("id" => $job_level_id));?><br>
							<?php } ?>
							<br>
							<?=$v->w("education");?> :<br>
							&bull;&nbsp;<?=$db->fetch_single_data("degree","name_".$__locale,array("id" => $opportunity["degree_id"]));?>
							<br><br>
							<?=$v->w("major");?> :<br>
							<?php foreach(pipetoarray($opportunity["major_ids"]) as $key => $major_id){ ?>
								&bull;&nbsp;<?=$db->fetch_single_data("majors","name_".$__locale,array("id" => $major_id));?><br>
							<?php } ?>
							<br>
							<?=$v->w("gender");?> :<br>
							<?php foreach(pipetoarray($opportunity["gender"]) as $key => $gender_id){ ?>
								&bull;&nbsp;<?=$db->fetch_single_data("gender","name_".$__locale,array("id" => $gender_id));?><br>
							<?php } ?>
							<br>
							<?php if($opportunity["age_min"] > 0 || $opportunity["age_max"] > 0){ if($opportunity["age_max"] == 0) $opportunity["age_max"] = $v->w("infinite");?>
								<?=$v->w("age_limit");?> :<br>
								&bull;&nbsp;<?=$opportunity["age_min"];?> - <?=$opportunity["age_max"];?>
								<br><br>
							<?php } ?>
							<?=$v->w("work_experience");?> :<br>
							&bull;&nbsp;<?=$opportunity["experience_years"]." ".$v->w("years");?><br>
							<?php if($opportunity["is_freshgraduate"] == 1){ echo $v->w("available_for_fresh_graduate"); } ?>
						</td>
					</tr>
				</table>
			</td>
			<td valign="top" width="700" style="font-size:13px;">
				<table cellpadding="5" cellspacing="5" style="width:690px;" class="seeker_profile_sp_detail">
					<tr>
						<td>
							<b><?=$v->w("requirements");?> :</b><br><br>
							<?=chr13tobr($opportunity["requirement"]);?>
						</td>
					</tr>
				</table>
				<br>
				<table cellpadding="5" cellspacing="5" style="width:690px;" class="seeker_profile_sp_detail">
					<tr>
						<td>
							<b><?=$v->w("job_description");?> :</b><br><br>
							<?=chr13tobr($opportunity["description"]);?>
						</td>
					</tr>
				</table>
				<br>
				<table cellpadding="5" cellspacing="5" style="width:690px;" class="seeker_profile_sp_detail">
					<tr>
						<td>
							<b><?=$v->w("aboutus");?> :</b><br><br>
							<?=chr13tobr($opportunity["company_description"]);?>
						</td>
					</tr>
				</table>
				<br>
				<table cellpadding="5" cellspacing="5" style="width:690px;" class="seeker_profile_sp_detail">
					<tr>
						<td>
							<b><?=$v->w("reason_join_our_company");?> :</b><br><br>
							<?=chr13tobr($company_profile["join_reason"]);?>
						</td>
					</tr>
				</table>
				<br><br>
				<input id="applybtn2" type="button" value="<?=$v->w("apply");?>" class="<?=$apply_classname;?>" style="width:340px;" onclick="apply('<?=$_GET["id"];?>');">
				&nbsp;
				<input id="savebtn2" type="button" value="<?=$v->w("save");?>" class="<?=$save_classname;?>" style="width:340px;" onclick="save('<?=$_GET["id"];?>');">
			</td>
		</tr>
	</table>
</center>
</body>
</html>