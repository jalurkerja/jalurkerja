<?php include_once "iframe_header.php"; ?>
<div class="card">
	<div id="title"><?=$v->words("education");?></div>
	<div style="height:30px;"></div>
	<div id="content">
		<table width="100%" id="table_content"><tr><td align="center">
			<?php
				$db->addtable("seeker_educations"); $db->where("user_id",$_GET["user_id"]);$db->order("seqno");
				$seeker_educations = $db->fetch_data(true);
				if(count($seeker_educations) > 0) {
					foreach($seeker_educations as $key => $arr_seeker_educations) {
						$id_seeker_educations = $arr_seeker_educations["id"];
						
						$degree 		= $db->fetch_single_data("degree","name_".$__locale,array("id" => $arr_seeker_educations["degree_id"]));
						$major 			= $db->fetch_single_data("majors","name_".$__locale,array("id" => $arr_seeker_educations["major_id"]));
						if($arr_seeker_educations["school_id"] > 0) {
							$school 	= $db->fetch_single_data("schools","name_".$__locale,array("id" => $arr_seeker_educations["school_id"]));
						} else {
							$school 	= $arr_seeker_educations["school_name"];
						}
						$graduated_year = ($arr_seeker_educations["graduated_year"] > 0) ? $arr_seeker_educations["graduated_year"] : $v->words("now");
						
						$_e  = "<div class='seeker_profile_sp_detail'>";
						$_e .= "<br>";
						$_e .= "	<div id='sp_container'>";
						$_e .= "		<div id='sp_degree_major'>".$degree." - ".$major."</div>";
						$_e .= "		<div id='sp_school'>".$school."</div>";
						$_e .= "		<div id='sp_range_date'>".$arr_seeker_educations["start_year"]." - ".$graduated_year."</div>";
						$_e .= "		<div id='sp_gpa'>".$arr_seeker_educations["gpa"]."</div>";
						$_e .= "		<div id='sp_description'>".chr13tobr($arr_seeker_educations["honors"])."</div>";
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
