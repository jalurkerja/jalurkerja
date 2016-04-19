<?php include_once "iframe_header.php"; ?>
<div class="card">
	<div id="title"><?=$v->words("skills");?></div>
	<div style="height:30px;"></div>
	<div id="content">
		<table width="100%" id="table_content"><tr><td align="center">
			<?php
				$db->addtable("seeker_skills"); $db->where("user_id",$_GET["user_id"]);$db->order("id");
				$seeker_skills = $db->fetch_data(true);
				if(count($seeker_skills) > 0) {
					foreach($seeker_skills as $key => $arr_seeker_skills) {
						$id_seeker_skills = $arr_seeker_skills["id"];
						
						$skill_level 	= $db->fetch_single_data("level","name_".$__locale,array("id" => $arr_seeker_skills["level_id"]));
							
						$_e  = "<div class='seeker_profile_sp_detail'>";
						$_e .= "<br>";
						$_e .= "	<div id='sp_container'>";
						$_e .= "		<div id='sp_degree_major'>".$arr_seeker_skills["name"]."</div>";
						$_e .= "		<div id='sp_gpa'>".$v->words("skill_level")." : ".$skill_level."</div>";
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
