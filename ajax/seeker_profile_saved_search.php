<div class="card">
	<div id="content">
		<table width="100%"><tr><td align="center">
		<?php
			$db->addtable("saved_search");$db->where("user_id",$__user_id);$db->order("created_at DESC");
			$saved_searches = $db->fetch_data(true);
			echo $t->start("","","content_data");
			echo $t->header(array("No","Notes","Job Types","Job Levels","Job Functions","Job Category","Industries","Saved At"));
			if(count($saved_searches) > 0){
				foreach($saved_searches as $key => $saved_search){
					echo $t->row(array($key + 1,
								  "<a href='searchjob.php?opportunity_id=".$opportunity_id."'>".$opportunity_id."</a>",
								  $db->fetch_single_data("opportunities","name",array("id" => $opportunity_id)),
								  $db->fetch_single_data("opportunities","title_".$__locale,array("id" => $opportunity_id)),
								  $industry,
								  format_tanggal($applied_opportunity["created_at"],"dMY",true),
								 ),array("align='right'",""));
				}
			}
			echo $t->end();
		?>
		</td></tr></table>
	</div>
</div>
<div style="height:20px;"></div>