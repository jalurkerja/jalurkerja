<?php 
	include_once "head.php";
	$_GET["token"] = $db->generate_token($_GET["id"]);
	javascript("openwindow('../opportunity_detail.php?id=".$_GET["id"]."&token=".$_GET["token"]."');");
	?><script> window.location='<?=str_replace("_view","_list",$_SERVER["PHP_SELF"]);?>'; </script> <?php
	include_once "footer.php";
?>