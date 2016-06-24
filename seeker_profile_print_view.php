<?php include_once "head.php";?>
<script>
	bodyid.style.backgroundColor = "white";
</script>
<br>
<?php
	$token = $db->fetch_single_data("tokens","token",array("id_key" => $_GET["user_id"],"ip" => $_SERVER["REMOTE_ADDR"]));
	$db->generate_token($_GET["user_id"]);
	if($token != $_GET["token"] && false){
		echo "INVALID TOKEN!";
		echo "<script> alert('INVALID TOKEN!'); </script>";
		echo "<script> window.close(); </script>";
		exit();
	}
?>
<table><tr><td style="width:20px;"></td><td valign="top"><div id="applicant_resume"></div></td></tr></table>
<script> get_ajax("ajax/applicant_resume_ajax.php?user_id=<?=$_GET["user_id"];?>","applicant_resume"); </script>