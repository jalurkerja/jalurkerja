<?php include_once "head.php";?>
<script>
	bodyid.style.backgroundColor = "white";
	function load_applicant_resume(){
		get_ajax("ajax/applicant_resume_ajax.php?opportunity_id=<?=$_GET["opportunity_id"];?>&user_id=<?=$_GET["userid"];?>","applicant_resume");
	}
</script>
<br>
<center>
<?php
	$token = $db->fetch_single_data("tokens","token",array("id_key" => $_GET["userid"],"ip" => $_SERVER["REMOTE_ADDR"]));
	$db->generate_token($_GET["userid"]);
	if($token != $_GET["token"] && false){
		echo "INVALID TOKEN!";
		echo "<script> alert('INVALID TOKEN!'); </script>";
		echo "<script> window.close(); </script>";
		exit();
	}
	include_once "classes/tabular.php";
	$tab1 = new Tabular("applicant");
	$tab1->set_border_width(1);
	$tab1->set_tab_width(158);
	$tab1->set_area_width(1000);
	$tab1->set_area_height(50);
	$tab1->setnoborder();
	$tab1->add_tab_title($v->w("applicant_resume"),"load_applicant_resume();");
	$tab1->add_tab_title($v->w("applicant_process"),"load_applicant_process();");
	$tab1->add_tab_container("<div id='applicant_resume'></div>");
	$tab1->add_tab_container("<div id='applicant_process'></div>");
	$tab1->set_bordercolor("#0CB31D");
	echo $tab1->draw();
?>
</center>