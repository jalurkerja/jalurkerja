<?php include_once "iframe_header.php"; ?>
<div class="card">
	<div id="title"><?=$v->words("summary");?></div>
	<div style="height:30px;"></div>
	<div id="content">
		<table width="100%" id="table_content"><tr><td align="center">
			<?php
				$db->addtable("seeker_summary"); $db->where("user_id",$_GET["user_id"]);$db->order("id");
				$seeker_summary = $db->fetch_data(true);
				if(count($seeker_summary) > 0) {
					foreach($seeker_summary as $key => $arr_seeker_summary) {
						$id_seeker_summary = $arr_seeker_summary["id"];
						
						$_e  = "<div class='seeker_profile_sp_detail'>";
						$_e .= "<br>";
						$_e .= "	<div id='sp_container'>";
						$_e .= "		<div id='sp_description'>".chr13tobr($arr_seeker_summary["summaries"])."</div>";
						$_e .= "	</div>";
						$_e .= "</div><div style='height:20px;'></div>";
						
						echo $_e;
					}
				} 
			?>
		</td></tr></table>
	</div>
</div>

<?php include_once "iframe_footer.php"; ?>
