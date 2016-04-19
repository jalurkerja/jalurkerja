<?php include_once "head.php";?>
<div class="bo_title">Add User</div>
<?php
	if(isset($_POST["save"])){
		$db->addtable("users");
		$db->addfield("email");					$db->addvalue($_POST["email"]);
		$db->addfield("password");				$db->addvalue(base64_encode($_POST["password"]));
		$db->addfield("company_profiles_id");	$db->addvalue($_POST["company_profiles_id"]);
		$db->addfield("locale");				$db->addvalue($_POST["locale"]);
		$db->addfield("created_at");			$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("created_by");			$db->addvalue($__username);
		$db->addfield("created_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->addfield("updated_at");			$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");			$db->addvalue($__username);
		$db->addfield("updated_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] >= 0){
			$insert_id = $inserting["insert_id"];
			if($_POST["cso_name"] != ""){
				$db->addtable("cso_profiles");
				$db->addfield("user_id");	$db->addvalue($insert_id);
				$db->addfield("name");	$db->addvalue($_POST["cso_name"]);
				$db->insert();
			}
			javascript("alert('Data Berhasil tersimpan');");
			javascript("window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';");
		} else {
			echo $inserting["error"];
			javascript("alert('Data gagal tersimpan');");
		}
	}
	
	$txt_email 					= $f->input("email",$_POST["email"]);
	$txt_password 				= $f->input("password","","type='password'");
	$txt_company_profiles_id 	= $f->input("company_profiles_id",$_POST["company_profiles_id"]);
	$txt_cso_name 				= $f->input("cso_name",$_POST["cso_name"]);
	$sel_locale 				= $f->select("locale",array("id" => "Indonesian","en" => "English"),$_POST["locale"]);
?>
<?=$f->start();?>
	<?=$t->start("","editor_content");?>
		<?=$t->row(array("Email",$txt_email));?>
		<?=$t->row(array("Password",$txt_password));?>
		<?=$t->row(array("Company Profiles Id",$txt_company_profiles_id));?>
		<?=$t->row(array("CSO Name",$txt_cso_name));?>
		<?=$t->row(array("Locale",$sel_locale));?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
<?php include_once "footer.php";?>