<?php include_once "iframe_header.php"; ?>
<div class="card">
	<div id="title"><?=$v->w("application");?></div>
	<div id="content">
		<table width="100%"><tr><td align="center">
			<?php
				$db->addtable("seeker_summary");$db->where("user_id",$_GET["user_id"]);$db->limit(0); $seeker_summary = $db->fetch_data();
				$rows = array();
				$rows[] = [$v->w("availability"),$db->fetch_single_data("availability","name_en",array("id" => $seeker_summary["availability_id"]))];
				$rows[] = [$v->w("cover_letter"),$f->textarea("cover_letter",$seeker_summary["cover_letter"],"disabled")];
				echo $f->start("edit_application");
					echo $f->input("saving_edit_application_form","1","type='hidden'");
					echo $t->start("","","content_data");
					foreach($rows as $row) { echo $t->row($row); }
					echo $t->end();
				echo $f->end();
				echo "<div style='height:20px;'></div>";
			?>			
		</td></tr></table>
	</div>
</div>
<div style="height:20px;"></div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div class="card">
	<div id="title"><?=$v->w("others");?></div>
	<div id="content">
		<table width="100%"><tr><td align="center">
			<?php
				$db->addtable("seeker_setting");$db->where("user_id",$_GET["user_id"]);$db->limit(0); $seeker_setting = $db->fetch_data();
				$rows = array();
				$checked = ($seeker_setting["get_job_alert"] == "1") ? "checked" : "";
				$rows[] = [$f->input("get_job_alert","1","type='checkbox' disabled ".$checked)." ".$v->w("get_job_alert")];
				$checked = ($seeker_setting["get_newsletter"] == "1") ? "checked" : "";
				$rows[] = [$f->input("get_newsletter","1","type='checkbox' disabled ".$checked)." ".$v->w("get_newsletter")];
				echo $f->start("edit_setting");
					echo $f->input("saving_edit_setting_form","1","type='hidden'");
					echo $t->start("","","content_data");
					foreach($rows as $row) { echo $t->row($row); }
					echo $t->end();
				echo $f->end();
				echo "<div style='height:20px;'></div>";
			?>			
		</td></tr></table>
	</div>
</div>
<div style="height:20px;"></div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------->
<?php include_once "iframe_footer.php"; ?>
