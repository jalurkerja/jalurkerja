<?php include_once "iframe_header.php"; ?>
<div class="card">
	<div id="title"><?=$v->words("work_organization");?></div>
	<div style="height:30px;"></div>
	<div id="content">
		<table width="100%" id="table_content"><tr><td align="center">
			<?php
				$db->addtable("seeker_organizations"); $db->where("user_id",$_GET["user_id"]);$db->order("startyear");
				$seeker_organizations = $db->fetch_data(true);
				if(count($seeker_organizations) > 0) {
					foreach($seeker_organizations as $key => $arr_seeker_organizations) {
						$id_seeker_organizations = $arr_seeker_organizations["id"];
						
						$_wk  = "<div class='seeker_profile_sp_detail'>";
						$_wk .= "<br>";
						$_wk .= "	<div id='sp_container'>";
						$_wk .= "		<div id='sp_position'>".$arr_seeker_organizations["position"].$v->words("at").$arr_seeker_organizations["name"]."</div>";
						$_wk .= "		<div id='sp_range_date'>".$arr_seeker_organizations["startyear"]." - ".$arr_seeker_organizations["endyear"]."</div>";
						$_wk .= "		<div id='sp_description'>".chr13tobr($arr_seeker_organizations["description"])."</div>";
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
