<div class="card">
	<div id="title"><?=$v->w("job_desires");?></div>
	<div id="content">
		<table width="100%"><tr><td align="center">
			<?php
				$db->addtable("seeker_desires");$db->where("user_id",$__user_id);$db->limit(0); $seeker_desires = $db->fetch_data();
				
				$job_types = $db->fetch_select_data("job_type","id","name_".$__locale);
				$sb_job_types = $f->select_box("job_types",$v->w("job_type"),$job_types,pipetoarray($seeker_desires["job_type_ids"]),220,200,999,5,26,12,"grey");
				$sb_job_types_selected = $db->selected_to_string("job_type","id","name_".$__locale,$seeker_desires["job_type_ids"],"<br>");
				
				$job_levels = $db->fetch_select_data("job_level","id","name_".$__locale);
				$sb_job_levels = $f->select_box("job_levels",$v->w("job_level"),$job_levels,pipetoarray($seeker_desires["job_level_ids"]),220,200,998,5,26,12,"grey");
				$sb_job_levels_selected = $db->selected_to_string("job_level","id","name_".$__locale,$seeker_desires["job_level_ids"],"<br>");
				
				
				$job_functions = $db->fetch_select_data("job_functions","id","name_".$__locale);
				$sb_job_functions = $f->select_box("job_functions",$v->w("job_function"),$job_functions,pipetoarray($seeker_desires["job_function_ids"]),220,200,997,5,26,12,"grey");
				$sb_job_functions_selected = $db->selected_to_string("job_functions","id","name_".$__locale,$seeker_desires["job_function_ids"],"<br>");
				
				$job_categories = $db->fetch_select_data("job_categories","id","name_".$__locale);
				$sb_job_categories = $f->select_box("job_categories",$v->w("job_category"),$job_categories,pipetoarray($seeker_desires["job_category_ids"]),220,200,996,5,26,12,"grey");
				$sb_job_categories_selected = $db->selected_to_string("job_categories","id","name_".$__locale,$seeker_desires["job_category_ids"],"<br>");
				
				$industries = $db->fetch_select_data("industries","id","name_".$__locale);
				$sb_industries = $f->select_box("industries",$v->w("industry"),$industries,pipetoarray($seeker_desires["industry_ids"]),220,200,995,5,26,12,"grey");
				$sb_industries_selected = $db->selected_to_string("industries","id","name_".$__locale,$seeker_desires["industry_ids"],"<br>");
				
				$db->addtable("locations"); $db->addfield("province_id");$db->addfield("location_id");$db->addfield("name_".$__locale); 
				$db->where("id",1,"i",">");$db->order("seqno");
				foreach ($db->fetch_data() as $key => $arrlocation){
					if($arrlocation[1]>0){
						$locations[$arrlocation[0].":".$arrlocation[1]] = "&nbsp;&nbsp;".$arrlocation[2];
					} else {
						$locations[$arrlocation[0].":".$arrlocation[1]] = "<b>".$arrlocation[2]."</b>";
					}
				}				
				$arr_location_ids = pipetoarray($seeker_desires["location_ids"]);
				$sb_locations = $f->select_box("locations",$v->w("location"),$locations,$arr_location_ids,220,200,994,5,26,12,"grey");
				$sb_locations_selected = "";
				if(count($arr_location_ids) > 0) {
					foreach($arr_location_ids as $location_id) {
						$arr_location_id = explode(":",$location_id);
						$location = $db->fetch_single_data("locations","name_".$__locale,array("province_id" => $arr_location_id[0],"location_id" => $arr_location_id[1]));
						$sb_locations_selected .= $location."<br>";
					}
				}
				
				$db->addtable("salaries"); 
				$db->addfield("id");$db->addfield("salary"); $db->order("id");
				$arrsalariesfrom[0] = $v->words("salary")." ".$v->words("from");
				$arrsalariesto[0] = $v->words("salary")." ".$v->words("to");
				foreach ($db->fetch_data() as $key => $arrsalary){
					$arrsalariesfrom[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
					$arrsalariesto[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
				}
				$salary_range = $f->select("salary_min",$arrsalariesfrom,$seeker_desires["salary_min"]) ." - ". $f->select("salary_max",$arrsalariesto,$seeker_desires["salary_max"]);
				
				
				
				$rows = array();
				$rows[] = array( $v->w("job_type"),$sb_job_types."<br><br>".$sb_job_types_selected );
				$rows[] = array( $v->w("job_level"),$sb_job_levels."<br><br>".$sb_job_levels_selected );
				$rows[] = array( $v->w("job_function"),$sb_job_functions."<br><br>".$sb_job_functions_selected );
				$rows[] = array( $v->w("job_category"),$sb_job_categories."<br><br>".$sb_job_categories_selected );
				$rows[] = array( $v->w("industry"),$sb_industries."<br><br>".$sb_industries_selected );
				$rows[] = array( $v->w("location"),$sb_locations."<br><br>".$sb_locations_selected );
				$rows[] = array( $v->w("salary"),$salary_range );
				echo $f->start("edit_desires");
					echo $f->input("saving_edit_desires_form","1","type='hidden'");
					echo $t->start("","","content_data");
					foreach($rows as $row) { echo $t->row($row,array('style="vertical-align:top;height:30px;"')); }
					echo $t->end();
				echo $f->end();
				echo $t->start("","","navigation") . $f->input("save",$v->w("save"),"type='button' onclick=\"save_edit_desires();\"","btn_post") . $t->end();
				echo "<div style='height:20px;'></div>";
				
			?>			
		</td></tr></table>
	</div>
</div>
<div style="height:20px;"></div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------->
