<div class="card">
	<div id="content">
		<table width="100%"><tr><td align="center">
		<?php
			$db->addtable("applied_opportunities");$db->where("user_id",$__user_id);$db->order("created_at DESC");
			$applied_opportunities = $db->fetch_data(true);
			echo $t->start("","","content_data");
			echo $t->header(array("No","Opportunity Id","Company Name","Title","Industry","Auto Applied","Applied At"));
			if(count($applied_opportunities) > 0){
				foreach($applied_opportunities as $key => $applied_opportunity){
					$opportunity_id = $applied_opportunity["opportunity_id"];
					$industry_id = $db->fetch_single_data("opportunities","industry_id",array("id" => $opportunity_id));
					$industry = $db->fetch_single_data("industries","name_".$__locale,array("id" => $industry_id));
					$salary_min = $db->fetch_single_data("opportunities","salary_min",array("id" => $opportunity_id));
					$salary_max = $db->fetch_single_data("opportunities","salary_max",array("id" => $opportunity_id));
					$salary = salary_min_max($salary_min,$salary_max);
					$is_autoapplied = ($applied_opportunity["is_autoapplied"] == 1) ? "Yes" : "No";
					echo $t->row(array($key + 1,
								  "<a href='searchjob.php?opportunity_id=".$opportunity_id."'>".$opportunity_id."</a>",
								  $db->fetch_single_data("opportunities","name",array("id" => $opportunity_id)),
								  $db->fetch_single_data("opportunities","title_".$__locale,array("id" => $opportunity_id)),
								  $industry,
								  $is_autoapplied,
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