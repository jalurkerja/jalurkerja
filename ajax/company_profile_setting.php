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