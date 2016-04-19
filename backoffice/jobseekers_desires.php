<?php include_once "iframe_header.php"; ?>
<div class="card">
	<div id="title"><?=$v->w("job_desires");?></div>
	<div id="content">
		<table width="100%"><tr><td align="center">
			<?php
				$db->addtable("seeker_desires");$db->where("user_id",$_GET["user_id"]);$db->limit(0); $seeker_desires = $db->fetch_data();
				
				$sb_job_types_selected = $db->selected_to_string("job_type","id","name_".$__locale,$seeker_desires["job_type_ids"],"<br>");
				$sb_job_levels_selected = $db->selected_to_string("job_level","id","name_".$__locale,$seeker_desires["job_level_ids"],"<br>");
				$sb_job_functions_selected = $db->selected_to_string("job_functions","id","name_".$__locale,$seeker_desires["job_function_ids"],"<br>");
				$sb_job_categories_selected = $db->selected_to_string("job_categories","id","name_".$__locale,$seeker_desires["job_category_ids"],"<br>");
				$sb_industries_selected = $db->selected_to_string("industries","id","name_".$__locale,$seeker_desires["industry_ids"],"<br>");
				$sb_locations_selected = "";
				$arr_location_ids = pipetoarray($seeker_desires["location_ids"]);
				foreach($arr_location_ids as $location_id) {
					$arr_location_id = explode(":",$location_id);
					$location = $db->fetch_single_data("locations","name_".$__locale,array("province_id" => $arr_location_id[0],"location_id" => $arr_location_id[1]));
					$sb_locations_selected .= $location."<br>";
				}
				
				$rows = array();
				$rows[] = array( $v->w("job_type"),$sb_job_types_selected );
				$rows[] = array( $v->w("job_level"),$sb_job_levels_selected );
				$rows[] = array( $v->w("job_function"),$sb_job_functions_selected );
				$rows[] = array( $v->w("job_category"),$sb_job_categories_selected );
				$rows[] = array( $v->w("industry"),$sb_industries_selected );
				$rows[] = array( $v->w("location"),$sb_locations_selected );
				$rows[] = array( $v->w("salary"),salary_min_max($seeker_desires["salary_min"],$seeker_desires["salary_min"]) );
				echo $f->start("edit_desires");
					echo $f->input("saving_edit_desires_form","1","type='hidden'");
					echo $t->start("","","content_data");
					foreach($rows as $row) { echo $t->row($row,array('style="vertical-align:top;height:30px;"')); }
					echo $t->end();
				echo $f->end();				
			?>			
		</td></tr></table>
	</div>
</div>

<?php include_once "iframe_footer.php"; ?>
