<?php include_once "iframe_header.php"; ?>
<div class="card">
	<div id="title"><?=$v->words("languages");?></div>
	<div style="height:30px;"></div>
	<div id="content">
		<table width="100%" id="table_content"><tr><td align="center">
			<?php
				$db->addtable("seeker_languages"); $db->where("user_id",$_GET["user_id"]);$db->order("id");
				$seeker_languages = $db->fetch_data(true);
				if(count($seeker_languages) > 0) {
					foreach($seeker_languages as $key => $arr_seeker_languages) {
						$id_seeker_languages = $arr_seeker_languages["id"];
						
						$speaking_level 	= $db->fetch_single_data("level","name_".$__locale,array("id" => $arr_seeker_languages["speaking_level_id"]));
						$writing_level	= $db->fetch_single_data("level","name_".$__locale,array("id" => $arr_seeker_languages["writing_level_id"]));
						if($arr_seeker_languages["language_id"] > 0) {
							$language 	= $db->fetch_single_data("languages","name_".$__locale,array("id" => $arr_seeker_languages["language_id"]));
						} else {
							$language 	= $arr_seeker_languages["school_name"];
						}
						
						$_e  = "<div class='seeker_profile_sp_detail'>";
						$_e .= "<br>";
						$_e .= "	<div id='sp_container'>";
						$_e .= "		<div id='sp_degree_major'>".$language."</div>";
						$_e .= "		<div id='sp_gpa'>".$v->words("speaking_level")." : ".$speaking_level."</div>";
						$_e .= "		<div id='sp_gpa'>".$v->words("writing_level")." : ".$writing_level."</div>";
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
