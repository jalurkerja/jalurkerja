<?php include_once "head.php";?>
<script>
	bodyid.style.backgroundColor = "white";
	function load_applicant_resume(){
		get_ajax("ajax/applicant_resume_ajax.php?opportunity_id=<?=$_GET["opportunity_id"];?>&user_id=<?=$_GET["user_id"];?>","applicant_resume");
	}
	function load_applicant_process(){
		get_ajax("ajax/applicant_process_ajax.php?opportunity_id=<?=$_GET["opportunity_id"];?>&user_id=<?=$_GET["user_id"];?>","applicant_process");
	}
</script>
<br>
<center>
<?php
	$token = $db->fetch_single_data("tokens","token",array("id_key" => $_GET["user_id"],"ip" => $_SERVER["REMOTE_ADDR"]));
	$db->generate_token($_GET["user_id"]);
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
	
	if(isset($_POST["save_process_history"])){
		$user_id = $_GET["user_id"]; $opportunity_id = $_GET["opportunity_id"];
		$db->addtable("applied_opportunities");$db->where("user_id",$user_id);$db->where("opportunity_id",$opportunity_id);$db->limit(1);
		$applied_opportunities = $db->fetch_data();
		if($applied_opportunities["user_id"] == $user_id && $applied_opportunities["opportunity_id"] == $opportunity_id){
			$applied_opportunities_id = $applied_opportunities["id"];
			$applicant_status_id = $applied_opportunities["applicant_status_id"];
			$change_status = $_POST["change_status"];
			
			$db->addtable("applied_opportunities");$db->where("user_id",$user_id);$db->where("opportunity_id",$opportunity_id);
			$db->addfield("applicant_status_id");$db->addvalue($change_status);$db->update();
		
			$db->addtable("applicant_process_history");
			$db->addfield("applied_opportunities_id");$db->addvalue($applied_opportunities_id);
			$db->addfield("applicant_status_id");$db->addvalue($change_status);
			$db->addfield("user_id");$db->addvalue($user_id);
			$db->addfield("opportunity_id");$db->addvalue($opportunity_id);
			$db->addfield("status_trans");$db->addvalue("|".$applicant_status_id."||".$change_status."|");
			$db->addfield("notes");$db->addvalue($_POST["notes"]);
			$db->addfield("created_at");$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("created_by");$db->addvalue($__user_id);
			$db->addfield("created_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$db->insert();
			if($change_status == 0) {
			?> <script> alert("Process status changed");window.close(); </script> <?php
			}
			?> <script> alert("Process status changed");tab_toggle_applicant(1);load_applicant_process(); </script> <?php
		}
	}
?>
</center>