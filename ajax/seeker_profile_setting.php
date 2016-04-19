<div class="card">
	<div id="title"><?=$v->w("change_password");?></div>
	<div id="content">
		<table width="100%"><tr><td align="center">
			<?php
				$rows = array();
				$rows[] = array( $v->w("current_password"),$f->input("current_password","","type='password'") );
				$rows[] = array( $v->w("new_password"),$f->input("new_password","","type='password'") );
				$rows[] = array( $v->w("confirm_password"),$f->input("confirm_password","","type='password'") );
				echo $f->start("edit_change_password");
					echo $f->input("saving_edit_change_password_form","1","type='hidden'");
					echo $t->start("","","content_data");
					foreach($rows as $row) { echo $t->row($row); }
					echo $t->end();
				echo $f->end();
				echo $t->start("","","navigation") . $f->input("save",$v->words("save"),"type='button' onclick=\"save_edit_change_password();\"","btn_post") . $t->end();
				echo "<div style='height:20px;'></div>";
			?>			
		</td></tr></table>
	</div>
</div>
<div style="height:20px;"></div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div class="card">
	<div id="title"><?=$v->w("application");?></div>
	<div id="content">
		<table width="100%"><tr><td align="center">
			<?php
				$db->addtable("seeker_summary");$db->where("user_id",$__user_id);$db->limit(0); $seeker_summary = $db->fetch_data();
				$availabilities = $db->fetch_select_data("availability","id","name_".$__locale);
				$rows = array();
				//$rows[] = array( $v->w("available_date"),$f->input_tanggal("available_date",$seeker_summary["available_date"]) );
				$rows[] = array( $v->w("availability"),$f->select("availability_id",$availabilities,$seeker_summary["availability_id"]) );
				$rows[] = array( $v->w("cover_letter"),$f->textarea("cover_letter",$seeker_summary["cover_letter"]) );
				echo $f->start("edit_application");
					echo $f->input("saving_edit_application_form","1","type='hidden'");
					echo $t->start("","","content_data");
					foreach($rows as $row) { echo $t->row($row); }
					echo $t->end();
				echo $f->end();
				echo $t->start("","","navigation") . $f->input("save",$v->words("save"),"type='button' onclick=\"save_edit_application();\"","btn_post") . $t->end();
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
				$db->addtable("seeker_setting");$db->where("user_id",$__user_id);$db->limit(0); $seeker_setting = $db->fetch_data();
				$rows = array();
				$checked = ($seeker_setting["get_job_alert"] == "1") ? "checked" : "";
				$rows[] = array( $f->input("get_job_alert","1","type='checkbox' ".$checked)." ".$v->w("get_job_alert") );
				$checked = ($seeker_setting["get_newsletter"] == "1") ? "checked" : "";
				$rows[] = array( $f->input("get_newsletter","1","type='checkbox' ".$checked)." ".$v->w("get_newsletter") );
				echo $f->start("edit_setting");
					echo $f->input("saving_edit_setting_form","1","type='hidden'");
					echo $t->start("","","content_data");
					foreach($rows as $row) { echo $t->row($row); }
					echo $t->end();
				echo $f->end();
				echo $t->start("","","navigation") . $f->input("save",$v->words("save"),"type='button' onclick=\"save_edit_setting();\"","btn_post") . $t->end();
				echo "<div style='height:20px;'></div>";
			?>			
		</td></tr></table>
	</div>
</div>
<div style="height:20px;"></div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------->