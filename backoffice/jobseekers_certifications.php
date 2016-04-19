<?php include_once "iframe_header.php"; ?>
<div class="card">
	<div id="title"><?=$v->words("certification");?></div>
	<div style="height:30px;"></div>
	<div id="content">
		<table width="100%" id="table_content"><tr><td align="center">
			<?php
				$db->addtable("seeker_certifications"); $db->where("user_id",$_GET["user_id"]);$db->order("issued_at");
				$seeker_certifications = $db->fetch_data(true);
				if(count($seeker_certifications) > 0) {
					foreach($seeker_certifications as $key => $arr_seeker_certifications) {
						$id_seeker_certifications = $arr_seeker_certifications["id"];
						
						$_cert  = "<div class='seeker_profile_sp_detail'>";
						$_cert .= "<br>";
						$_cert .= "	<div id='sp_container'>";
						$_cert .= "		<div id='sp_position'>".$arr_seeker_certifications["name"]."</div>";
						$_cert .= "		<div id='sp_range_date'>".format_tanggal($arr_seeker_certifications["issued_at"])." (".$arr_seeker_certifications["issued_by"].")</div>";
						$_cert .= "		<div id='sp_description'>".chr13tobr($arr_seeker_certifications["description"])."</div>";
						$_cert .= "	</div>";
						$_cert .= "</div><div style='height:20px;'></div>";
						
						echo $_cert;
					}
				} 
			?>
		</td></tr></table>
	</div>
</div>

<?php include_once "iframe_footer.php"; ?>
