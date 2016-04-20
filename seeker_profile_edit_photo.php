<script src="scripts/jquery-1.10.1.min.js"></script>
<?php 
	include_once "common.php";
	if(!$__user_id) javascript("window.close();");
	
	if(isset($_POST["save"])){
		move_uploaded_file($_FILES['file_photo']['tmp_name'], "seekers_photo/".$__user_id.".".pathinfo($_FILES['file_photo']['name'],PATHINFO_EXTENSION));
		$db->addtable("seeker_profiles");$db->where("user_id",$__user_id);
		$db->addfield("photo");$db->addvalue($__user_id.".".pathinfo($_FILES['file_photo']['name'],PATHINFO_EXTENSION));
		$db->update();
		javascript("window.close();");
	}
	
	$db->addtable("seeker_profiles"); $db->where("user_id",$__user_id); $db->limit(1); $arr_seeker_profile = $db->fetch_data();
	if(!isset($arr_seeker_profile["photo"]) || $arr_seeker_profile["photo"] == "") $arr_seeker_profile["photo"] = "nophoto.png";
	echo $f->start("","POST","","enctype='multipart/form-data'");
		echo $t->start("width='100%'");
			echo $t->row(array('<img id="photo" src="seekers_photo/'.$arr_seeker_profile["photo"].'" style="height:150px;">'),array("align='center'"));
			echo $t->row(array($f->input("file_photo","","type='file'")),array("align='center'"));
			echo $t->row(array($f->input("save",$v->w("save"),'type="submit" tabindex="17"',"btn_sign")),array("align='center'"));
		echo $t->end();
	echo $f->end();
?>