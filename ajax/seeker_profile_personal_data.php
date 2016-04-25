<?php
if($_mode == "edit_personal_data") $edit_personal_data = true; else $edit_personal_data=false;
if($_mode == "add_work_experience") $add_work_experience = true; else $add_work_experience=false;
if($_mode == "edit_work_experience") $edit_work_experience = true; else $edit_work_experience=false;
if($_mode == "add_certification") $add_certification = true; else $add_certification=false;
if($_mode == "edit_certification") $edit_certification = true; else $edit_certification=false;
if($_mode == "add_education") $add_education = true; else $add_education=false;
if($_mode == "edit_education") $edit_education = true; else $edit_education=false;
if($_mode == "add_language") $add_language = true; else $add_language=false;
if($_mode == "edit_language") $edit_language = true; else $edit_language=false;
if($_mode == "add_skill") $add_skill = true; else $add_skill=false;
if($_mode == "edit_skill") $edit_skill = true; else $edit_skill=false;
if($_mode == "add_summary") $add_summary = true; else $add_summary=false;
if($_mode == "edit_summary") $edit_summary = true; else $edit_summary=false;
		
$db->addtable("seeker_profiles"); $db->where("user_id",$__user_id); $db->limit(1); $arr_seeker_profile = $db->fetch_data();
?>
<div class="card">
	<div id="title">
		<?=$v->words("personal_data");?>
		<?php if(!isset($_print_view)){ ?><div style="float:right"><?=$f->input("print_view",$v->w("print_view"),"style='width:150px;' type='button' onclick='print_view();'","btn_post");?></div><?php } ?>
	</div>
	<div id="content">
		<?php
			$db->addtable("locations"); $db->addfield("name_".$__locale); 
			$db->where("province_id",@$arr_seeker_profile["province_id"]); $db->where("location_id",@$arr_seeker_profile["location_id"]);$db->limit(1);
			$location = $db->fetch_data(false,0);
			$db->addtable("locations"); $db->addfield("name_".$__locale); $db->where("id",@$arr_seeker_profile["birthplace"]);$db->limit(1);
			$birthplace = $db->fetch_data(false,0);
			$db->addtable("gender"); $db->addfield("name_".$__locale); $db->where("id",@$arr_seeker_profile["gender_id"]);$db->limit(1);
			$gender = $db->fetch_data(false,0);
			$db->addtable("marital_status"); $db->addfield("name_".$__locale); $db->where("id",@$arr_seeker_profile["marital_status_id"]);$db->limit(1);
			$marital_status = $db->fetch_data(false,0);
			
			$rows = array();
			if(!$edit_personal_data){
				$rows[] = array($v->words("fullname"),$v->capitalize(@$arr_seeker_profile["first_name"]." ".@$arr_seeker_profile["middle_name"]." ".@$arr_seeker_profile["last_name"]));
				$rows[] = array($v->words("address"),chr13tobr(@$arr_seeker_profile["address"]));
				$rows[] = array($v->words("location"),$location);
				$rows[] = array($v->words("zipcode"),@$arr_seeker_profile["zipcode"]);
				$rows[] = array($v->words("phone"),@$arr_seeker_profile["phone"]);
				$rows[] = array($v->words("cellphone"),@$arr_seeker_profile["cellphone"]);
				$rows[] = array($v->words("fax"),@$arr_seeker_profile["fax"]);
				$rows[] = array($v->words("web"),@$arr_seeker_profile["web"]);
				$rows[] = array($v->words("birthplace"),$birthplace);
				$rows[] = array($v->words("birthdate"),format_tanggal(@$arr_seeker_profile["birthdate"],"dMY"));
				$rows[] = array($v->words("nationality"),@$arr_seeker_profile["nationality"]);
				$rows[] = array($v->words("gender"),$gender);
				$rows[] = array($v->words("marital_status"),$marital_status);
			} else {				
				$arrlocations 		= fetch_locations();				
				$genders 			= $db->fetch_select_data("gender","id","name_".$__locale);
				$arr_marital_status = $db->fetch_select_data("marital_status","id","name_".$__locale);
				$birthplace_id = province_location_format_id(@$arr_seeker_profile["birthplace"]);
				
				$rows[] = array($v->words("first_name"),$f->input("first_name",@$arr_seeker_profile["first_name"]));
				$rows[] = array($v->words("middle_name"),$f->input("middle_name",@$arr_seeker_profile["middle_name"]));
				$rows[] = array($v->words("last_name"),$f->input("last_name",@$arr_seeker_profile["last_name"]));
				$rows[] = array($v->words("address"),$f->textarea("address",@$arr_seeker_profile["address"]));
				$rows[] = array($v->words("location"),$f->select("location",$arrlocations,@$arr_seeker_profile["province_id"].":".@$arr_seeker_profile["location_id"]));
				$rows[] = array($v->words("zipcode"),$f->input("zipcode",@$arr_seeker_profile["zipcode"]));
				$rows[] = array($v->words("phone"),$f->input("phone",@$arr_seeker_profile["phone"]));
				$rows[] = array($v->words("cellphone"),$f->input("cellphone",@$arr_seeker_profile["cellphone"]));
				$rows[] = array($v->words("fax"),$f->input("fax",@$arr_seeker_profile["fax"]));
				$rows[] = array($v->words("web"),$f->input("web",@$arr_seeker_profile["web"]));
				$rows[] = array($v->words("birthplace"),$f->select("birthplace",$arrlocations,$birthplace_id));
				$rows[] = array($v->words("birthdate"),$f->input_tanggal("birthdate",@$arr_seeker_profile["birthdate"]));
				$rows[] = array($v->words("nationality"),$f->input("nationality",@$arr_seeker_profile["nationality"]));
				$rows[] = array($v->words("gender"),$f->select("gender_id",$genders,@$arr_seeker_profile["gender_id"]));
				$rows[] = array($v->words("marital_status"),$f->select("marital_status_id",$arr_marital_status,@$arr_seeker_profile["marital_status_id"]));
			}
			$btn_edit_personal_data = $t->row(array($f->input("edit",$v->words("edit"),"type='button' onclick=\"edit_personal_data();\"","btn_post")),array("align='right'"));
			$btn_save_cancel_personal_data = $t->row(
												array(
													$f->input("save",$v->words("save"),"type='button' onclick=\"save_personal_data();\"","btn_post")." ".
													$f->input("cancel",$v->words("cancel"),"type='button' onclick=\"load_profile();\"","btn_post")
												),
												array("align='right'")
											);
			
			$nav_personal_data = (!$edit_personal_data) ? $btn_edit_personal_data : $btn_save_cancel_personal_data;
			$nav_personal_data = $t->start("","","navigation") . $nav_personal_data . $t->end();
		?>
		<?php if(@filesize("seekers_photo/".@$arr_seeker_profile["photo"])>4096){ ?>
			<div id="photo"><img id="photo" src="seekers_photo/<?=@$arr_seeker_profile["photo"];?>" style="height:150px;"></div>
		<?php } else if(@file_exists("seekers_photo/nophoto.png")) { ?>
			<div id="photo"><img id="photo" src="seekers_photo/nophoto.png" style="height:150px;"></div>
		<?php } ?>
		
		<?php if(@filesize("../seekers_photo/".@$arr_seeker_profile["photo"])>4096){ ?>
			<div id="photo"><img id="photo" src="seekers_photo/<?=@$arr_seeker_profile["photo"];?>" style="height:150px;"></div>
		<?php } else if(@file_exists("../seekers_photo/nophoto.png")) { ?>
			<div id="photo"><img id="photo" src="seekers_photo/nophoto.png" style="height:150px;"></div>
		<?php } ?>
		<div id="photo_nav"><?=$f->input("photo_nav",$v->w("edit"),"type='button' onclick=\"edit_photo('".$__user_id."');\"","btn_post");?></div>
		
		<table width="100%"><tr><td align="center">
			<?=(!$edit_personal_data && !isset($_print_view)) ? $nav_personal_data : "";?>
			<?=$f->start("personal_data_form");?>
				<?=$f->input("saving_personal_data_form","1","type='hidden'");?>
				<?=$t->start("","","content_data");?>
				<?php foreach($rows as $row) { echo $t->row($row); } ?>
				<?=$t->end();?>
			<?=$f->end();?>
			<?=($edit_personal_data) ? $nav_personal_data : "";?>
		</td></tr></table>
	</div>
</div>
<div style="height:20px;"></div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div class="card">
	<div id="title"><?=$v->words("work_experience");?></div>
	<div id="content">
		<table width="100%"><tr><td align="center">
			<?php 
				$btn_add_work_experience = $t->row(array($f->input("add",$v->words("add"),"type='button' onclick=\"add_work_experience();\"","btn_post")),array("align='right'"));
				$btn_save_cancel_add_work_experience = $t->row(
													array(
														$f->input("save",$v->words("save"),"type='button' onclick=\"save_add_work_experience();\"","btn_post")." ".
														$f->input("cancel",$v->words("cancel"),"type='button' onclick=\"load_profile();\"","btn_post").
														"<div style='height:20px;'></div>"
													),
													array("align='right'")
												);
				
				$btn_nav = (!$add_work_experience) ? $btn_add_work_experience : $btn_save_cancel_add_work_experience;
				$btn_nav = $t->start("","","navigation") . $btn_nav . $t->end();
				
				if($add_work_experience) {
					$db->addtable("salaries"); 
					$db->addfield("id");$db->addfield("salary"); $db->order("id");
					$arrsalariesfrom[0] = $v->words("salary")." ".$v->words("from");
					$arrsalariesto[0] = $v->words("salary")." ".$v->words("to");
					foreach ($db->fetch_data() as $key => $arrsalary){
						$arrsalariesfrom[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
						$arrsalariesto[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
					}
					
					$jobtypes = 		$db->fetch_select_data("job_type","id","name_".$__locale,array()); 						$jobtypes[0] = "";ksort($jobtypes);
					$joblevels = 		$db->fetch_select_data("job_level","id","name_".$__locale,array("id" => "0:>"));		$joblevels[0] = "";ksort($joblevels);
					$jobfunctions = 	$db->fetch_select_data("job_functions","id","name_".$__locale,array("id" => "0:>"));	$jobfunctions[0] = "";asort($jobfunctions);
					$jobcategories = 	$db->fetch_select_data("job_categories","id","name_".$__locale,array("parent_id" => "0:>"));	$jobcategories[null] = "";asort($jobcategories);
					$industries = 		$db->fetch_select_data("industries","id","name_".$__locale,array("id" => "0:>"));		$industries[0] = "";asort($industries);
					
					$rows = array();
					$rows[] = array($v->words("company_name"),$f->input("company_name"));
					$rows[] = array($v->words("work_periode"),$f->input_tanggal("startdate","","","","","desc")."<span id='end_date_work_experience'> - ".$f->input_tanggal("enddate","","","","","desc")."</span> ".$f->input("enddate_current","","type='checkbox' onclick='chk_still_work_here(this);'")." ".$v->words("still_work_here"));
					$rows[] = array($v->words("position"),$f->input("position"));
					$rows[] = array($v->words("salary"),$f->select("salary_min",$arrsalariesfrom) ." - ". $f->select("salary_max",$arrsalariesto));
					$rows[] = array($v->words("job_type"),$f->select("job_type_id",$jobtypes));
					$rows[] = array($v->words("job_level"),$f->select("job_level_id",$joblevels));
					$rows[] = array($v->words("job_function"),$f->select("job_function_id",$jobfunctions));
					$rows[] = array($v->words("industry"),$f->select("industry_id",$industries));
					$rows[] = array($v->words("work_descriptions"),$f->textarea("description"));
					
					echo $f->start("add_work_experience_form");
						echo $f->input("saving_add_work_experience_form","1","type='hidden'");
						echo $t->start("","","content_data");
						foreach($rows as $row) { echo $t->row($row); }
						echo $t->end();
					echo $f->end();
				} 
				
				if(isset($_print_view)) $btn_nav="<br>";
				echo (!$add_work_experience) ? "<div style=\"position:relative;top:-35px;\">".$btn_nav."</div>" : $btn_nav;
			?>
		</td></tr></table>
		<br>
		<table width="100%" id="table_content"><tr><td align="center">
			<?php
				$db->addtable("seeker_experiences"); $db->where("user_id",$__user_id);$db->order("startdate");
				$seeker_experiences = $db->fetch_data(true);
				if(count($seeker_experiences) > 0) {
					foreach($seeker_experiences as $key => $arr_seeker_experiences) {
						$id_seeker_experiences = $arr_seeker_experiences["id"];
						
						$btn_edit_work_experience = $t->row(array($f->input("edit",$v->words("edit"),"type='button' onclick=\"edit_work_experience('".$id_seeker_experiences."');\"","btn_post")),array("align='right'"));
						if(isset($_print_view)) $btn_edit_work_experience="<br>";
						$btn_save_cancel_edit_work_experience = 
							$t->row(
								array(
									$f->input("save",$v->words("save"),"type='button' onclick=\"save_edit_work_experience('".$id_seeker_experiences."');\"","btn_post")." ".
									$f->input("delete",$v->words("delete"),"type='button' onclick=\"delete_work_experience('".$id_seeker_experiences."');\"","btn_post")." ".
									$f->input("cancel",$v->words("cancel"),"type='button' onclick=\"load_profile();\"","btn_post")
								),
								array("align='right'")
							);
							
						$rows = array();
						if($edit_work_experience && $id_seeker_experiences == $_GET["id"]){
							$db->addtable("salaries"); 
							$db->addfield("id");$db->addfield("salary"); $db->order("id");
							$arrsalariesfrom[0] = $v->words("salary")." ".$v->words("from");
							$arrsalariesto[0] = $v->words("salary")." ".$v->words("to");
							foreach ($db->fetch_data() as $key => $arrsalary){
								$arrsalariesfrom[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
								$arrsalariesto[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
							}
							$jobtypes = 		$db->fetch_select_data("job_type","id","name_".$__locale,array()); 						$jobtypes[0] = "";ksort($jobtypes);
							$joblevels = 		$db->fetch_select_data("job_level","id","name_".$__locale,array("id" => "0:>"));		$joblevels[0] = "";ksort($joblevels);
							$jobfunctions = 	$db->fetch_select_data("job_functions","id","name_".$__locale,array("id" => "0:>"));	$jobfunctions[0] = "";asort($jobfunctions);
							$jobcategories = 	$db->fetch_select_data("job_categories","id","name_".$__locale,array("parent_id" => "0:>"));	$jobcategories[0] = "";asort($jobcategories);
							$industries = 		$db->fetch_select_data("industries","id","name_".$__locale,array("id" => "0:>"));		$industries[0] = "";asort($industries);
							
							$db->addtable("seeker_experiences"); $db->where("id",$id_seeker_experiences);$db->limit(1);
							$arr_we = $db->fetch_data();
							$is_enddate_visible = ($arr_we["enddate"] <= 0) ? "style='visibility:hidden;'" : "";
							$is_enddate_checked = ($arr_we["enddate"] <= 0) ? "checked" : "";
							
							$rows = array();
							$rows[] = array($v->words("company_name"),$f->input("company_name",$arr_we["company_name"]));
							$rows[] = array($v->words("work_periode"),$f->input_tanggal("startdate",$arr_we["startdate"],"","","","desc")."<span id='end_date_work_experience' ".$is_enddate_visible."> - ".$f->input_tanggal("enddate",$arr_we["enddate"],"","","","desc")."</span> ".$f->input("enddate_current","","type='checkbox' ".$is_enddate_checked." onclick='chk_still_work_here(this);'")." ".$v->words("still_work_here"));
							$rows[] = array($v->words("position"),$f->input("position",$arr_we["position"]));
							$rows[] = array($v->words("salary"),$f->select("salary_min",$arrsalariesfrom,$arr_we["salary_min"]) ." - ". $f->select("salary_max",$arrsalariesto,$arr_we["salary_max"]));
							$rows[] = array($v->words("job_type"),$f->select("job_type_id",$jobtypes,$arr_we["job_type_id"]));
							$rows[] = array($v->words("job_level"),$f->select("job_level_id",$joblevels,$arr_we["job_level_id"]));
							$rows[] = array($v->words("job_function"),$f->select("job_function_id",$jobfunctions,$arr_we["job_function_id"]));
							$rows[] = array($v->words("industry"),$f->select("industry_id",$industries,$arr_we["industry_id"]));
							$rows[] = array($v->words("work_descriptions"),$f->textarea("description",$arr_we["description"]));
							
							echo $f->start("edit_work_experience_form");
								echo $f->input("saving_edit_work_experience_form","1","type='hidden'");
								echo $f->input("id_seeker_experiences",$id_seeker_experiences,"type='hidden'");
								echo $t->start("","","content_data");
								foreach($rows as $row) { echo $t->row($row); }
								echo $t->end();
							echo $f->end();
							echo $t->start("","","navigation") . $btn_save_cancel_edit_work_experience . $t->end();
							echo "<div style='height:20px;'></div>";
						} else {
							$job_type 		= $db->fetch_single_data("job_type","name_".$__locale,array("id" => $arr_seeker_experiences["job_type_id"]));
							$job_level 		= $db->fetch_single_data("job_level","name_".$__locale,array("id" => $arr_seeker_experiences["job_level_id"]));
							$job_function 	= $db->fetch_single_data("job_functions","name_".$__locale,array("id" => $arr_seeker_experiences["job_function_id"]));
							$industry 		= $db->fetch_single_data("industries","name_".$__locale,array("id" => $arr_seeker_experiences["industry_id"]));
							
							$_wk  = "<div class='seeker_profile_sp_detail'>";
							$_wk .= 	$t->start("","","navigation") . $btn_edit_work_experience . $t->end();
							$_wk .= "	<div id='sp_container'>";
							$_wk .= "		<div id='sp_position'>".$arr_seeker_experiences["position"].$v->words("at").$arr_seeker_experiences["company_name"]." (".$industry.")</div>";
							$_wk .= "		<div id='sp_range_date'>".format_range_tanggal($arr_seeker_experiences["startdate"],$arr_seeker_experiences["enddate"])."</div>";
							$_wk .= "		<div id='sp_salary'>".salary_min_max($arr_seeker_experiences["salary_min"],$arr_seeker_experiences["salary_max"])."</div>";
							$_wk .= "		<div id='sp_job_type_level'>".$job_type." - ".$job_level."</div>";
							$_wk .= "		<div id='sp_job_fucntion_category'>".$job_function."</div>";
							$_wk .= "		<div id='sp_description'>".chr13tobr($arr_seeker_experiences["description"])."</div>";
							$_wk .= "	</div>";
							$_wk .= "</div><div style='height:20px;'></div>";
							
							echo $_wk;
						}
					}
				} 
			?>
		</td></tr></table>
	</div>
</div>
<div style="height:20px;"></div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div class="card">
	<div id="title"><?=$v->words("certification");?></div>
	<div id="content">
		<table width="100%"><tr><td align="center">
			<?php 
				$btn_add_certification = $t->row(array($f->input("add",$v->words("add"),"type='button' onclick=\"add_certification();\"","btn_post")),array("align='right'"));
				$btn_save_cancel_add_certification = $t->row(
													array(
														$f->input("save",$v->words("save"),"type='button' onclick=\"save_add_certification();\"","btn_post")." ".
														$f->input("cancel",$v->words("cancel"),"type='button' onclick=\"load_profile();\"","btn_post").
														"<div style='height:20px;'></div>"
													),
													array("align='right'")
												);
				
				$btn_nav = (!$add_certification) ? $btn_add_certification : $btn_save_cancel_add_certification;
				$btn_nav = $t->start("","","navigation") . $btn_nav . $t->end();
				
				if($add_certification) {					
					$rows = array();
					$rows[] = array($v->words("name"),$f->input("name"));
					$rows[] = array($v->words("description"),$f->textarea("description"));
					$rows[] = array($v->words("issued_at"),$f->input_tanggal("issued_at","","","","","desc"));
					$rows[] = array($v->words("issued_by"),$f->input("issued_by"));
					
					echo $f->start("add_certification_form");
						echo $f->input("saving_add_certification_form","1","type='hidden'");
						echo $t->start("","","content_data");
						foreach($rows as $row) { echo $t->row($row); }
						echo $t->end();
					echo $f->end();
				} 
				
				if(isset($_print_view)) $btn_nav="<br>";
				echo (!$add_certification) ? "<div style=\"position:relative;top:-35px;\">".$btn_nav."</div>" : $btn_nav;
			?>
		</td></tr></table>
		<br>
		<table width="100%" id="table_content"><tr><td align="center">
			<?php
				$db->addtable("seeker_certifications"); $db->where("user_id",$__user_id);$db->order("issued_at");
				$seeker_certifications = $db->fetch_data(true);
				if(count($seeker_certifications) > 0) {
					foreach($seeker_certifications as $key => $arr_seeker_certifications) {
						$id_seeker_certifications = $arr_seeker_certifications["id"];
						
						$btn_edit_certification = $t->row(array($f->input("edit",$v->words("edit"),"type='button' onclick=\"edit_certification('".$id_seeker_certifications."');\"","btn_post")),array("align='right'"));
						if(isset($_print_view)) $btn_edit_certification="<br>";
						$btn_save_cancel_edit_certification = 
							$t->row(
								array(
									$f->input("save",$v->words("save"),"type='button' onclick=\"save_edit_certification('".$id_seeker_certifications."');\"","btn_post")." ".
									$f->input("delete",$v->words("delete"),"type='button' onclick=\"delete_certification('".$id_seeker_certifications."');\"","btn_post")." ".
									$f->input("cancel",$v->words("cancel"),"type='button' onclick=\"load_profile();\"","btn_post")
								),
								array("align='right'")
							);
							
						$rows = array();
						if($edit_certification && $id_seeker_certifications == $_GET["id"]){							
							$db->addtable("seeker_certifications"); $db->where("id",$id_seeker_certifications);$db->limit(1);
							$arr_cert = $db->fetch_data();
							$rows = array();
							$rows[] = array($v->words("name"),$f->input("name",$arr_cert["name"]));
							$rows[] = array($v->words("description"),$f->textarea("description",$arr_cert["description"]));
							$rows[] = array($v->words("issued_at"),$f->input_tanggal("issued_at",$arr_cert["issued_at"],"","","","desc"));
							$rows[] = array($v->words("issued_by"),$f->input("issued_by",$arr_cert["issued_by"]));
							
							echo $f->start("edit_certification_form");
								echo $f->input("saving_edit_certification_form","1","type='hidden'");
								echo $f->input("id_seeker_certifications",$id_seeker_certifications,"type='hidden'");
								echo $t->start("","","content_data");
								foreach($rows as $row) { echo $t->row($row); }
								echo $t->end();
							echo $f->end();
							echo $t->start("","","navigation") . $btn_save_cancel_edit_certification . $t->end();
							echo "<div style='height:20px;'></div>";
						} else {							
							$_cert  = "<div class='seeker_profile_sp_detail'>";
							$_cert .= 	$t->start("","","navigation") . $btn_edit_certification . $t->end();
							$_cert .= "	<div id='sp_container'>";
							$_cert .= "		<div id='sp_position'>".$arr_seeker_certifications["name"]."</div>";
							$_cert .= "		<div id='sp_range_date'>".format_tanggal($arr_seeker_certifications["issued_at"])." (".$arr_seeker_certifications["issued_by"].")</div>";
							$_cert .= "		<div id='sp_description'>".chr13tobr($arr_seeker_certifications["description"])."</div>";
							$_cert .= "	</div>";
							$_cert .= "</div><div style='height:20px;'></div>";
							
							echo $_cert;
						}
					}
				} 
			?>
		</td></tr></table>
	</div>
</div>
<div style="height:20px;"></div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div class="card">
	<div id="title"><?=$v->words("education");?></div>
	<div id="content">
		<table width="100%"><tr><td align="center">
			<?php 
				$btn_add_education = $t->row(array($f->input("add",$v->words("add"),"type='button' onclick=\"add_education();\"","btn_post")),array("align='right'"));
				$btn_save_cancel_add_education = $t->row(
													array(
														$f->input("save",$v->words("save"),"type='button' onclick=\"save_add_education();\"","btn_post")." ".
														$f->input("cancel",$v->words("cancel"),"type='button' onclick=\"load_profile();\"","btn_post").
														"<div style='height:20px;'></div>"
													),
													array("align='right'")
												);
				
				$btn_nav = (!$add_education) ? $btn_add_education : $btn_save_cancel_add_education;
				$btn_nav = $t->start("","","navigation") . $btn_nav . $t->end();
				
				if($add_education) {
					
					$schools = 			$db->fetch_select_data("schools","id","name_".$__locale,array()); 						$schools[0] = "";asort($schools);
					$degrees = 			$db->fetch_select_data("degree","id","name_".$__locale,array()); 						$degrees[0] = "";ksort($degrees);
					$majors = 			$db->fetch_select_data("majors","id","name_".$__locale,array()); 						$majors[0] = "";asort($majors);
					
					$school_input = $f->input("school_id","","type='hidden'").$f->input("school_name","","autocomplete='off' onkeyup='loadSelectSchools(this.value,event.keyCode);'");
					$school_input .= "	<div style=\"position:absolute;display:none;\" id=\"div_select_school\">
										  <table style=\"border:grey solid 1px; background-color:#EFEFEF;\">
											<tr><td id=\"select_school\"></td></tr>
										  </table>
										</div>";
					
					$rows = array();
					$rows[] = array($v->words("university_school"),$school_input);
					$rows[] = array($v->words("school_periode"),$f->input("start_year")."<span id='school_graduated_year'> - ".$f->input("graduated_year")."</span> ".$f->input("graduated_year_current","","type='checkbox' onclick='chk_still_school_here(this);'")." ".$v->words("still_school_here"));
					$rows[] = array($v->words("degree"),$f->select("degree_id",$degrees));
					$rows[] = array($v->words("major"),$f->select("major_id",$majors));
					$rows[] = array($v->words("gpa"),$f->input("gpa"));
					$rows[] = array($v->words("honors"),$f->textarea("honors"));
					
					echo $f->start("add_education_form");
						echo $f->input("saving_add_education_form","1","type='hidden'");
						echo $t->start("","","content_data");
						foreach($rows as $row) { echo $t->row($row); }
						echo $t->end();
					echo $f->end();
				} 
				
				if(isset($_print_view)) $btn_nav="<br>";
				echo (!$add_education) ? "<div style=\"position:relative;top:-35px;\">".$btn_nav."</div>" : $btn_nav;
			?>
		</td></tr></table>
		<br>
		<table width="100%" id="table_content"><tr><td align="center">
			<?php
				$db->addtable("seeker_educations"); $db->where("user_id",$__user_id);$db->order("seqno");
				$seeker_educations = $db->fetch_data(true);
				if(count($seeker_educations) > 0) {
					foreach($seeker_educations as $key => $arr_seeker_educations) {
						$id_seeker_educations = $arr_seeker_educations["id"];
						
						$btn_edit_education = $t->row(array($f->input("edit",$v->words("edit"),"type='button' onclick=\"edit_education('".$id_seeker_educations."');\"","btn_post")),array("align='right'"));
						if(isset($_print_view)) $btn_edit_education="<br>";
						$btn_save_cancel_edit_education = 
							$t->row(
								array(
									$f->input("save",$v->words("save"),"type='button' onclick=\"save_edit_education('".$id_seeker_educations."');\"","btn_post")." ".
									$f->input("delete",$v->words("delete"),"type='button' onclick=\"delete_education('".$id_seeker_educations."');\"","btn_post")." ".
									$f->input("cancel",$v->words("cancel"),"type='button' onclick=\"load_profile();\"","btn_post")
								),
								array("align='right'")
							);
							
						$rows = array();
						if($edit_education && $id_seeker_educations == $_GET["id"]){
							$db->addtable("seeker_educations"); $db->where("id",$id_seeker_educations);$db->limit(1);
							$arr_e = $db->fetch_data();
							
							$schools = 			$db->fetch_select_data("schools","id","name_".$__locale,array()); 						$schools[0] = "";asort($schools);
							$degrees = 			$db->fetch_select_data("degree","id","name_".$__locale,array()); 						$degrees[0] = "";ksort($degrees);
							$majors = 			$db->fetch_select_data("majors","id","name_".$__locale,array()); 						$majors[0] = "";asort($majors);
							
							if($arr_e["school_id"] > 0) {
								$school 	= $db->fetch_single_data("schools","name_".$__locale,array("id" => $arr_e["school_id"]));
							} else {
								$school 	= $arr_e["school_name"];
							}
							
							$school_input = $f->input("school_id",$arr_e["school_id"],"type='hidden'").$f->input("school_name",$school,"autocomplete='off' onkeyup='loadSelectSchools(this.value,event.keyCode);'");
							$school_input .= "	<div style=\"position:absolute;display:none;\" id=\"div_select_school\">
												  <table style=\"border:grey solid 1px; background-color:#EFEFEF;\">
													<tr><td id=\"select_school\"></td></tr>
												  </table>
												</div>";
												
							$is_graduated_year_visible = ($arr_e["graduated_year"] <= 0) ? "style='visibility:hidden;'" : "";
							$is_graduated_year_checked = ($arr_e["graduated_year"] <= 0) ? "checked" : "";
							$rows = array();
							$rows[] = array($v->words("university_school"),$school_input);
							$rows[] = array($v->words("school_periode"),$f->input("start_year",$arr_e["start_year"])."<span id='school_graduated_year' ".$is_graduated_year_visible."> - ".$f->input("graduated_year",$arr_e["graduated_year"])."</span> ".$f->input("graduated_year_current","","type='checkbox' ".$is_graduated_year_checked." onclick='chk_still_school_here(this);'")." ".$v->words("still_school_here"));
							$rows[] = array($v->words("degree"),$f->select("degree_id",$degrees,$arr_e["degree_id"]));
							$rows[] = array($v->words("major"),$f->select("major_id",$majors,$arr_e["major_id"]));
							$rows[] = array($v->words("gpa"),$f->input("gpa",$arr_e["gpa"]));
							$rows[] = array($v->words("honors"),$f->textarea("honors",$arr_e["honors"]));
							
							echo $f->start("edit_education_form");
								echo $f->input("saving_edit_education_form","1","type='hidden'");
								echo $f->input("id_seeker_educations",$id_seeker_educations,"type='hidden'");
								echo $t->start("","","content_data");
								foreach($rows as $row) { echo $t->row($row); }
								echo $t->end();
							echo $f->end();
							echo $t->start("","","navigation") . $btn_save_cancel_edit_education . $t->end();
							echo "<div style='height:20px;'></div>";
						} else {
							$degree 		= $db->fetch_single_data("degree","name_".$__locale,array("id" => $arr_seeker_educations["degree_id"]));
							$major 			= $db->fetch_single_data("majors","name_".$__locale,array("id" => $arr_seeker_educations["major_id"]));
							if($arr_seeker_educations["school_id"] > 0) {
								$school 	= $db->fetch_single_data("schools","name_".$__locale,array("id" => $arr_seeker_educations["school_id"]));
							} else {
								$school 	= $arr_seeker_educations["school_name"];
							}
							$graduated_year = ($arr_seeker_educations["graduated_year"] > 0) ? $arr_seeker_educations["graduated_year"] : $v->words("now");
							
							$_e  = "<div class='seeker_profile_sp_detail'>";
							$_e .= 	$t->start("","","navigation") . $btn_edit_education . $t->end();
							$_e .= "	<div id='sp_container'>";
							$_e .= "		<div id='sp_degree_major'>".$degree." - ".$major."</div>";
							$_e .= "		<div id='sp_school'>".$school."</div>";
							$_e .= "		<div id='sp_range_date'>".$arr_seeker_educations["start_year"]." - ".$graduated_year."</div>";
							$_e .= "		<div id='sp_gpa'>".$arr_seeker_educations["gpa"]."</div>";
							$_e .= "		<div id='sp_description'>".chr13tobr($arr_seeker_educations["honors"])."</div>";
							$_e .= "	</div>";
							$_e .= "</div><div style='height:20px;'></div>";
							
							echo $_e;
						}
					}
				} 
			?>
		</td></tr></table>
	</div>
</div>
<div style="height:20px;"></div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div class="card">
	<div id="title"><?=$v->words("languages");?></div>
	<div id="content">
		<table width="100%"><tr><td align="center">
			<?php 
				$btn_add_language = $t->row(array($f->input("add",$v->words("add"),"type='button' onclick=\"add_language();\"","btn_post")),array("align='right'"));
				$btn_save_cancel_add_language = $t->row(
													array(
														$f->input("save",$v->words("save"),"type='button' onclick=\"save_add_language();\"","btn_post")." ".
														$f->input("cancel",$v->words("cancel"),"type='button' onclick=\"load_profile();\"","btn_post").
														"<div style='height:20px;'></div>"
													),
													array("align='right'")
												);
				
				$btn_nav = (!$add_language) ? $btn_add_language : $btn_save_cancel_add_language;
				$btn_nav = $t->start("","","navigation") . $btn_nav . $t->end();
				
				if($add_language) {
					
					$languages 	= $db->fetch_select_data("languages","id","name_".$__locale,array()); 	$languages[0] = "";asort($languages);
					$levels 	= $db->fetch_select_data("level","id","name_".$__locale,array()); 		$levels[0] = "";ksort($levels);
					
					$language_input = $f->input("language_id","","type='hidden'").$f->input("language_name","","autocomplete='off' onkeyup='loadSelectLanguages(this.value,event.keyCode);'");
					$language_input .= "<div style=\"position:absolute;display:none;\" id=\"div_select_language\">
										  <table style=\"border:grey solid 1px; background-color:#EFEFEF;\">
											<tr><td id=\"select_language\"></td></tr>
										  </table>
										</div>";
					
					$rows = array();
					$rows[] = array($v->words("language"),$language_input);
					$rows[] = array($v->words("speaking_level"),$f->select("speaking_level_id",$levels));
					$rows[] = array($v->words("writing_level"),$f->select("writing_level_id",$levels));
					
					echo $f->start("add_language_form");
						echo $f->input("saving_add_language_form","1","type='hidden'");
						echo $t->start("","","content_data");
						foreach($rows as $row) { echo $t->row($row); }
						echo $t->end();
					echo $f->end();
				} 
				
				if(isset($_print_view)) $btn_nav="<br>";
				echo (!$add_language) ? "<div style=\"position:relative;top:-35px;\">".$btn_nav."</div>" : $btn_nav;
			?>
		</td></tr></table>
		<br>
		<table width="100%" id="table_content"><tr><td align="center">
			<?php
				$db->addtable("seeker_languages"); $db->where("user_id",$__user_id);$db->order("id");
				$seeker_languages = $db->fetch_data(true);
				if(count($seeker_languages) > 0) {
					foreach($seeker_languages as $key => $arr_seeker_languages) {
						$id_seeker_languages = $arr_seeker_languages["id"];
						
						$btn_edit_language = $t->row(array($f->input("edit",$v->words("edit"),"type='button' onclick=\"edit_language('".$id_seeker_languages."');\"","btn_post")),array("align='right'"));
						if(isset($_print_view)) $btn_edit_language="<br>";
						$btn_save_cancel_edit_language = 
							$t->row(
								array(
									$f->input("save",$v->words("save"),"type='button' onclick=\"save_edit_language('".$id_seeker_languages."');\"","btn_post")." ".
									$f->input("delete",$v->words("delete"),"type='button' onclick=\"delete_language('".$id_seeker_languages."');\"","btn_post")." ".
									$f->input("cancel",$v->words("cancel"),"type='button' onclick=\"load_profile();\"","btn_post")
								),
								array("align='right'")
							);
							
						$rows = array();
						if($edit_language && $id_seeker_languages == $_GET["id"]){
							$db->addtable("seeker_languages"); $db->where("id",$id_seeker_languages);$db->limit(1);
							$arr_e = $db->fetch_data();
							
							$languages 	= $db->fetch_select_data("languages","id","name_".$__locale,array()); 	$languages[0] = "";asort($languages);
							$levels 	= $db->fetch_select_data("level","id","name_".$__locale,array()); 		$levels[0] = "";ksort($levels);
							if($arr_e["language_id"] > 0) {
								$language 	= $db->fetch_single_data("languages","name_".$__locale,array("id" => $arr_e["language_id"]));
							} else {
								$language 	= $arr_e["language_name"];
							}
							
							$language_input = $f->input("language_id",$arr_e["language_id"],"type='hidden'").$f->input("language_name",$language,"autocomplete='off' onkeyup='loadSelectLanguages(this.value,event.keyCode);'");
							$language_input .= "<div style=\"position:absolute;display:none;\" id=\"div_select_language\">
												  <table style=\"border:grey solid 1px; background-color:#EFEFEF;\">
													<tr><td id=\"select_language\"></td></tr>
												  </table>
												</div>";
												
							$rows = array();
							
							$rows[] = array($v->words("language"),$language_input);
							$rows[] = array($v->words("speaking_level"),$f->select("speaking_level_id",$levels,$arr_e["speaking_level_id"]));
							$rows[] = array($v->words("writing_level"),$f->select("writing_level_id",$levels,$arr_e["writing_level_id"]));
							
							echo $f->start("edit_language_form");
								echo $f->input("saving_edit_language_form","1","type='hidden'");
								echo $f->input("id_seeker_languages",$id_seeker_languages,"type='hidden'");
								echo $t->start("","","content_data");
								foreach($rows as $row) { echo $t->row($row); }
								echo $t->end();
							echo $f->end();
							echo $t->start("","","navigation") . $btn_save_cancel_edit_language . $t->end();
							echo "<div style='height:20px;'></div>";
						} else {
							$speaking_level 	= $db->fetch_single_data("level","name_".$__locale,array("id" => $arr_seeker_languages["speaking_level_id"]));
							$writing_level	= $db->fetch_single_data("level","name_".$__locale,array("id" => $arr_seeker_languages["writing_level_id"]));
							if($arr_seeker_languages["language_id"] > 0) {
								$language 	= $db->fetch_single_data("languages","name_".$__locale,array("id" => $arr_seeker_languages["language_id"]));
							} else {
								$language 	= $arr_seeker_languages["school_name"];
							}
							
							$_e  = "<div class='seeker_profile_sp_detail'>";
							$_e .= 	$t->start("","","navigation") . $btn_edit_language . $t->end();
							$_e .= "	<div id='sp_container'>";
							$_e .= "		<div id='sp_degree_major'>".$language."</div>";
							$_e .= "		<div id='sp_gpa'>".$v->words("speaking_level")." : ".$speaking_level."</div>";
							$_e .= "		<div id='sp_gpa'>".$v->words("writing_level")." : ".$writing_level."</div>";
							$_e .= "	</div>";
							$_e .= "</div><div style='height:20px;'></div>";
							
							echo $_e;
						}
					}
				} 
			?>
		</td></tr></table>
	</div>
</div>
<div style="height:20px;"></div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div class="card">
	<div id="title"><?=$v->words("skills");?></div>
	<div id="content">
		<table width="100%"><tr><td align="center">
			<?php 
				$btn_add_skill = $t->row(array($f->input("add",$v->words("add"),"type='button' onclick=\"add_skill();\"","btn_post")),array("align='right'"));
				$btn_save_cancel_add_skill = $t->row(
													array(
														$f->input("save",$v->words("save"),"type='button' onclick=\"save_add_skill();\"","btn_post")." ".
														$f->input("cancel",$v->words("cancel"),"type='button' onclick=\"load_profile();\"","btn_post").
														"<div style='height:20px;'></div>"
													),
													array("align='right'")
												);
				
				$btn_nav = (!$add_skill) ? $btn_add_skill : $btn_save_cancel_add_skill;
				$btn_nav = $t->start("","","navigation") . $btn_nav . $t->end();
				
				if($add_skill) {
					$levels 	= $db->fetch_select_data("level","id","name_".$__locale,array()); 		$levels[0] = "";ksort($levels);
					
					$rows = array();
					$rows[] = array($v->words("skill"),$f->input("name"));
					$rows[] = array($v->words("skill_level"),$f->select("level_id",$levels));
					
					echo $f->start("add_skill_form");
						echo $f->input("saving_add_skill_form","1","type='hidden'");
						echo $t->start("","","content_data");
						foreach($rows as $row) { echo $t->row($row); }
						echo $t->end();
					echo $f->end();
				} 
				
				if(isset($_print_view)) $btn_nav="<br>";
				echo (!$add_skill) ? "<div style=\"position:relative;top:-35px;\">".$btn_nav."</div>" : $btn_nav;
			?>
		</td></tr></table>
		<br>
		<table width="100%" id="table_content"><tr><td align="center">
			<?php
				$db->addtable("seeker_skills"); $db->where("user_id",$__user_id);$db->order("id");
				$seeker_skills = $db->fetch_data(true);
				if(count($seeker_skills) > 0) {
					foreach($seeker_skills as $key => $arr_seeker_skills) {
						$id_seeker_skills = $arr_seeker_skills["id"];
						
						$btn_edit_skill = $t->row(array($f->input("edit",$v->words("edit"),"type='button' onclick=\"edit_skill('".$id_seeker_skills."');\"","btn_post")),array("align='right'"));
						if(isset($_print_view)) $btn_edit_skill="<br>";
						$btn_save_cancel_edit_skill = 
							$t->row(
								array(
									$f->input("save",$v->words("save"),"type='button' onclick=\"save_edit_skill('".$id_seeker_skills."');\"","btn_post")." ".
									$f->input("delete",$v->words("delete"),"type='button' onclick=\"delete_skill('".$id_seeker_skills."');\"","btn_post")." ".
									$f->input("cancel",$v->words("cancel"),"type='button' onclick=\"load_profile();\"","btn_post")
								),
								array("align='right'")
							);
							
						$rows = array();
						if($edit_skill && $id_seeker_skills == $_GET["id"]){
							$db->addtable("seeker_skills"); $db->where("id",$id_seeker_skills);$db->limit(1);
							$arr_e = $db->fetch_data();
							
							$levels 	= $db->fetch_select_data("level","id","name_".$__locale,array()); 		$levels[0] = "";ksort($levels);
							
							$rows = array();							
							$rows[] = array($v->words("skill"),$f->input("name",$arr_e["name"]));
							$rows[] = array($v->words("skill_level"),$f->select("level_id",$levels,$arr_e["level_id"]));
							
							echo $f->start("edit_skill_form");
								echo $f->input("saving_edit_skill_form","1","type='hidden'");
								echo $f->input("id_seeker_skills",$id_seeker_skills,"type='hidden'");
								echo $t->start("","","content_data");
								foreach($rows as $row) { echo $t->row($row); }
								echo $t->end();
							echo $f->end();
							echo $t->start("","","navigation") . $btn_save_cancel_edit_skill . $t->end();
							echo "<div style='height:20px;'></div>";
						} else {
							$skill_level 	= $db->fetch_single_data("level","name_".$__locale,array("id" => $arr_seeker_skills["level_id"]));
							
							$_e  = "<div class='seeker_profile_sp_detail'>";
							$_e .= 	$t->start("","","navigation") . $btn_edit_skill . $t->end();
							$_e .= "	<div id='sp_container'>";
							$_e .= "		<div id='sp_degree_major'>".$arr_seeker_skills["name"]."</div>";
							$_e .= "		<div id='sp_gpa'>".$v->words("skill_level")." : ".$skill_level."</div>";
							$_e .= "	</div>";
							$_e .= "</div><div style='height:20px;'></div>";
							
							echo $_e;
						}
					}
				} 
			?>
		</td></tr></table>
	</div>
</div>
<div style="height:20px;"></div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div class="card">
	<div id="title"><?=$v->words("summary");?></div>
	<div id="content">
		<table width="100%"><tr><td align="center">
			<?php
				$db->addtable("seeker_summary"); $db->where("user_id",$__user_id);$db->order("id");
				$seeker_summary = $db->fetch_data(true);
				if(count($seeker_summary) > 0) {
					foreach($seeker_summary as $key => $arr_seeker_summary) {
						$id_seeker_summary = $arr_seeker_summary["id"];
						
						$btn_edit_summary = $t->row(array($f->input("edit",$v->words("edit"),"type='button' onclick=\"edit_summary('".$id_seeker_summary."');\"","btn_post")),array("align='right'"));
						if(isset($_print_view)) $btn_edit_summary="<br>";
						$btn_save_cancel_edit_summary = 
							$t->row(
								array(
									$f->input("save",$v->words("save"),"type='button' onclick=\"save_edit_summary('".$id_seeker_summary."');\"","btn_post")." ".
									$f->input("cancel",$v->words("cancel"),"type='button' onclick=\"load_profile();\"","btn_post").
														"<div style='height:20px;'></div>"
								),
								array("align='right'")
							);
							
						$rows = array();
						if($edit_summary && $id_seeker_summary == $_GET["id"]){
							$db->addtable("seeker_summary"); $db->where("id",$id_seeker_summary);$db->limit(1);
							$arr_e = $db->fetch_data();
							
							$rows = array();							
							$rows[] = array($f->textarea("summaries",$arr_e["summaries"]));
							
							echo $f->start("edit_summary_form");
								echo $f->input("saving_edit_summary_form","1","type='hidden'");
								echo $f->input("id_seeker_summary",$id_seeker_summary,"type='hidden'");
								echo $t->start("","","content_data");
								foreach($rows as $row) { echo $t->row($row); }
								echo $t->end();
							echo $f->end();
							echo $t->start("","","navigation") . $btn_save_cancel_edit_summary . $t->end();
							echo "<div style='height:20px;'></div>";
						} else {
							
							$_e  = "<div class='seeker_profile_sp_detail'>";
							$_e .= 	$t->start("","","navigation") . $btn_edit_summary . $t->end();
							$_e .= "	<div id='sp_container'>";
							$_e .= "		<div id='sp_description'>".chr13tobr($arr_seeker_summary["summaries"])."</div>";
							$_e .= "	</div>";
							$_e .= "</div><div style='height:20px;'></div>";
							
							echo $_e;
						}
					}
				} 
			?>
		</td></tr></table>
	</div>
</div>
<div style="height:20px;"></div>