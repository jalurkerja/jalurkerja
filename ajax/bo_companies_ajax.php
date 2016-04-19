<?php 
	include_once "../common.php"; 
	
	$_mode = $_GET["mode"];
	
	if(isset($_POST["post_data"])){ parse_str($_POST["post_data"],$_POST); }

	if( $_mode == "change_status"){
		$id = $_GET["id"];
		$value = $_GET["value"];
		if($__cso_id > 0){
			$db->addtable("company_profiles");
			$db->where("id",$id);
			$db->addfield("status_id");$db->addvalue($value);
			$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("updated_by");$db->addvalue($__username);
			$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$updating = $db->update();
			echo $updating["affected_rows"];
		}
	}
?>
