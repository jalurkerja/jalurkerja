<?php
	include_once "../common.php";
	$id = $_GET["id"];
	$_mode = $_GET["mode"];
	$field = "status";
	if($_mode == "onprogress") $field = "progressed";
	$return = $db->fetch_single_data("mailer",$field,array("id" => $id));
	if($_mode !=""){ echo $return; } else {
		if($return == 0) echo "Unsend";
		if($return == 1) echo "Progress";
		if($return == 2) echo "Sent";
	}
?>