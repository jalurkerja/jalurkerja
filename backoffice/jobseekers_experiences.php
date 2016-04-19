<?php include_once "iframe_header.php"; ?>
<div class="card">
	<div id="title"><?=$v->words("work_experience");?></div>
	<div style="height:30px;"></div>
	<div id="content">
		<table width="100%" id="table_content"><tr><td align="center">
			<?php
				$db->addtable("seeker_experiences"); $db->where("user_id",$_GET["user_id"]);$db->order("startdate");
				$seeker_experiences = $db->fetch_data(true);
				if(count($seeker_experiences) > 0) {
					foreach($seeker_experiences as $key => $arr_seeker_experiences) {
						$id_seeker_experiences = $arr_seeker_experiences["id"];
						
						$job_type 		= $db->fetch_single_data("job_type","name_".$__locale,array("id" => $arr_seeker_experiences["job_type_id"]));
						$job_level 		= $db->fetch_single_data("job_level","name_".$__locale,array("id" => $arr_seeker_experiences["job_level_id"]));
						$job_function 	= $db->fetch_single_data("job_functions","name_".$__locale,array("id" => $arr_seeker_experiences["job_function_id"]));
						$job_category 	= $db->fetch_single_data("job_categories","name_".$__locale,array("id" => $arr_seeker_experiences["job_category_id"]));
						$industry 		= $db->fetch_single_data("industries","name_".$__locale,array("id" => $arr_seeker_experiences["industry_id"]));
						
						$_wk  = "<div class='seeker_profile_sp_detail'>";
						$_wk .= "<br>";
						$_wk .= "	<div id='sp_container'>";
						$_wk .= "		<div id='sp_position'>".$arr_seeker_experiences["position"].$v->words("at").$arr_seeker_experiences["company_name"]." (".$industry.")</div>";
						$_wk .= "		<div id='sp_range_date'>".format_range_tanggal($arr_seeker_experiences["startdate"],$arr_seeker_experiences["enddate"])."</div>";
						$_wk .= "		<div id='sp_salary'>".salary_min_max($arr_seeker_experiences["salary_min"],$arr_seeker_experiences["salary_max"])."</div>";
						$_wk .= "		<div id='sp_job_type_level'>".$job_type." - ".$job_level."</div>";
						$_wk .= "		<div id='sp_job_fucntion_category'>".$job_function." - ".$job_category."</div>";
						$_wk .= "		<div id='sp_description'>".chr13tobr($arr_seeker_experiences["description"])."</div>";
						$_wk .= "	</div>";
						$_wk .= "</div><div style='height:20px;'></div>";
						
						echo $_wk;
					}
				} 
			?>
		</td></tr></table>
	</div>
</div>

<?php include_once "iframe_footer.php"; ?>
