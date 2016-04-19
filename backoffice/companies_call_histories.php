<?php include_once "iframe_header.php"; ?>
<?php
	if(isset($_POST["save"])){
		$db->addtable("call_histories");
		$db->addfield("user_id");			$db->addvalue($__user_id);
		$db->addfield("company_id");		$db->addvalue($_GET["id"]);
		$db->addfield("contact_name");		$db->addvalue($_POST["contact_name"]);
		$db->addfield("contact_number");	$db->addvalue($_POST["contact_number"]);
		$db->addfield("subject");			$db->addvalue($_POST["subject"]);
		$db->addfield("call_category_id");	$db->addvalue($_POST["call_category_id"]);
		$db->addfield("notes");				$db->addvalue($_POST["notes"]);
		$db->addfield("next_call");			$db->addvalue($_POST["next_call"]." ".$_POST["next_call_time"]);
		$db->addfield("created_at");		$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("created_by");		$db->addvalue($__username);
		$db->addfield("created_ip");		$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			$db->addtable("company_profiles");$db->where("id",$_GET["id"]);
			$db->addfield("cso_user_id	");	$db->addvalue($__user_id);
			$db->addfield("updated_at");	$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("updated_by");	$db->addvalue($__username);
			$db->addfield("updated_ip");	$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$db->update();
			javascript("alert('Call History Saved');");
		} else {
			javascript("alert('Call History Failed to be Saved');");
		}
	}
	$contact_name = $db->fetch_single_data("company_profiles","concat(first_name,' ',middle_name,' ',last_name) as pic",array("id" => $_GET["id"]));
	$contact_number = $db->fetch_single_data("company_profiles","phone",array("id" => $_GET["id"]));
?>
<?=$f->start();?>
	<?=$t->start("","call_histories_form");?>
	<?=$t->row( ["Contact Name",	$f->input("contact_name",$contact_name)] );?>
	<?=$t->row( ["Contact Number",	$f->input("contact_number",$contact_number)] );?>
	<?=$t->row( ["Subject",			$f->input("subject")] );?>
	<?=$t->row( ["Call Category",	$f->select("call_category_id",$db->fetch_select_data("call_category","id","name"))] );?>
	<?=$t->row( ["Notes",			$f->textarea("notes")] );?>
	<?=$t->row( ["Next Call",		$f->input_tanggal("next_call",date("Y-m-d"))."&nbsp;&nbsp;&nbsp;".$f->input_time("next_call_time",date("H:i"))] );?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?>
<?=$f->end();?>
<br>
<?=$t->start("","data_content");?>
<?=$t->header(["No","Contact Name","Contact Number","Calling At","CSO","Subject","Call Category","Notes","Next Call"]);?>
<?php
	$db->addtable("call_histories");$db->where("company_id",$_GET["id"]);$db->order("id DESC");$db->limit(100);
	foreach($db->fetch_data() as $key => $call_history){
		echo $t->row(	[$key+1,
						$call_history["contact_name"],
						$call_history["contact_number"],
						format_tanggal($call_history["created_at"],"dMY",true),
						$db->fetch_single_data("cso_profiles","name",array("user_id" => $call_history["user_id"])),
						$call_history["subject"],
						$db->fetch_single_data("call_category","name",array("id" => $call_history["call_category_id"])),
						chr13tobr($call_history["notes"]),
						format_tanggal($call_history["next_call"],"dMY",true)] );
	}
?>
<?=$t->end();?>
<?php include_once "iframe_footer.php"; ?>
