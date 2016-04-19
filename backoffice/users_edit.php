<?php include_once "head.php";?>
<div class="bo_title">Edit User</div>
<?php
	if(isset($_POST["save"])){
		$db->addtable("users");					$db->where("id",$_GET["id"]);
		$db->addfield("email");					$db->addvalue($_POST["email"]);
		if($_POST["password"] !="" ) {
			$db->addfield("password");			$db->addvalue(base64_encode($_POST["password"]));
		}
		$db->addfield("company_profiles_id");	$db->addvalue($_POST["company_profiles_id"]);
		$db->addfield("locale");				$db->addvalue($_POST["locale"]);
		$db->addfield("updated_at");			$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");			$db->addvalue($__username);
		$db->addfield("updated_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
		if($db->update()["affected_rows"] >= 0){
			if($_POST["cso_name"] != ""){
				$db->addtable("cso_profiles");	$db->where("user_id",$_GET["id"]);
				$db->addfield("name");	$db->addvalue($_POST["cso_name"]);
				$db->update();
			}
			javascript("alert('Data Berhasil tersimpan');");
			javascript("window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';");
		} else {
			javascript("alert('Data gagal tersimpan');");
		}
	}
	
	$db->addtable("users");$db->where("id",$_GET["id"]);$db->limit(1);$users = $db->fetch_data();
	$txt_email 					= $f->input("email",$users["email"]);
	$txt_password 				= $f->input("password","","type='password'");
	$txt_company_profiles_id 	= $f->input("company_profiles_id",$users["company_profiles_id"]);
	$txt_cso_name 				= $f->input("cso_name",$db->fetch_single_data("cso_profiles","name",array("user_id" => $_GET["id"])));
	$sel_locale 				= $f->select("locale",array("id" => "Indonesian","en" => "English"),$users["locale"]);
?>
<?=$f->start();?>
	<?=$t->start("","editor_content");?>
		<?=$t->row(array("Email",$txt_email));?>
		<?=$t->row(array("Password",$txt_password));?>
		<?=$t->row(array("Company Profiles Id",$txt_company_profiles_id));?>
		<?=$t->row(array("CSO Name",$txt_cso_name));?>
		<?=$t->row(array("Locale",$sel_locale));?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
<?php include_once "footer.php";?>