<script>
	$( document ).ready(function() {
		<?php if(isset($_GET["just_signup"]) && $_GET["just_signup"] == $__username && !isset($_POST["save_just_signup"])){ ?> 
			$.fancybox.open("<div style='overflow:auto;'>" + seeker_profiles_form("<?=$_GET["just_signup"];?>") + "</div>"); 
		<?php } ?>
	});

	function signup_validation(){
		return true;
	}

	function signup(namalengkap,email,password,repassword){
		if (signup_validation()) 
			get_ajax("ajax/homepage_ajax.php?mode=signup&namalengkap="+namalengkap+"&email="+email+"&password="+password+"&repassword="+repassword,"signup_result","action_after_signup(global_respon['signup_result'],'"+email+"','"+password+"');");
		else
			popup_message("<?=$v->words("please_complete_signup_form");?>","error_message");
	}
	
	function action_after_signup(signup_result,email,password){
		if (signup_result == "error:email_already_used"){
			popup_message("<?=$v->words("email_already_used");?>","error_message");
		} else if (signup_result == "error:failed_insert_users"){
			popup_message("<?=$v->words("failed_insert_users");?>","error_message");
		} else if (signup_result == "error:password_error"){
			popup_message("<?=$v->words("password_error");?>","error_message");
		} else if (signup_result*1 > 0){
			homepage_login.action = "?just_signup=" + email;
			homepage_login.username.value = email;
			homepage_login.password.value = password;
			homepage_login.submit();
		} else {
			popup_message("<?=$v->words("failed_insert_seeker_profiles");?>","error_message");
		}
	}
	
	function seeker_profiles_form(email){
		<?php
			$db->addtable("seeker_profiles");
			$db->addfield("first_name,middle_name,last_name");
			$db->where("user_id",$__user_id);
			$db->limit(1);
			$seeker_profiles = $db->fetch_data();
			
			$db->addtable("locations"); 
			$db->addfield("province_id,location_id,name_".$__locale);
			$db->where("id",1,"i",">");$db->order("seqno");
			foreach ($db->fetch_data() as $key => $arrlocation){
				if($arrlocation[1]>0){
					$arrlocations[$arrlocation[0].":".$arrlocation[1]] = "&nbsp;&nbsp;".$arrlocation[2];
				} else {
					$arrlocations[$arrlocation[0].":".$arrlocation[1]] = "<b>".$arrlocation[2]."</b>";
				}
			}
			
			$db->addtable("gender"); $db->addfield("id,name_".$__locale);
			foreach ($db->fetch_data() as $key => $gender){ $genders[$gender[0]] = $gender[1]; }
			
			$db->addtable("marital_status"); $db->addfield("id,name_".$__locale);
			foreach ($db->fetch_data() as $key => $marital_status){ $arr_marital_status[$marital_status[0]] = $marital_status[1]; }
			
			$rows[] = $t->row(array($v->words("first_name"),":",$f->input("first_name",$seeker_profiles["first_name"],'tabindex="1"')),array("id='td1'"));
			$rows[] = $t->row(array($v->words("middle_name"),":",$f->input("middle_name",$seeker_profiles["middle_name"],'tabindex="2"')),array("id='td1'"));
			$rows[] = $t->row(array($v->words("last_name"),":",$f->input("last_name",$seeker_profiles["last_name"],'tabindex="3"')),array("id='td1'"));
			$rows[] = $t->row(array($v->words("address"),":",$f->textarea("address","",'tabindex="4"')),array("id='td1'"));
			$rows[] = $t->row(array($v->words("location"),":",$f->select("location",$arrlocations,null,'tabindex="5"')),array("id='td1'"));
			$rows[] = $t->row(array($v->words("zipcode"),":",$f->input("zipcode","",'tabindex="6"')),array("id='td1'"));
			$rows[] = $t->row(array($v->words("phone"),":",$f->input("phone","",'tabindex="7"')),array("id='td1'"));
			$rows[] = $t->row(array($v->words("cellphone"),":",$f->input("cellphone","",'tabindex="8"')),array("id='td1'"));
			$rows[] = $t->row(array($v->words("fax"),":",$f->input("fax","",'tabindex="9"')),array("id='td1'"));
			$rows[] = $t->row(array($v->words("web"),":",$f->input("web","",'tabindex="10"')),array("id='td1'"));
			$rows[] = $t->row(array($v->words("birthplace"),":",$f->select("birthplace",$arrlocations,null,'tabindex="11"')),array("id='td1'"));
			$rows[] = $t->row(array($v->words("birthdate"),":",$f->input_tanggal("birthdate","",'tabindex="12"')),array("id='td1'"));
			$rows[] = $t->row(array($v->words("nationality"),":",$f->input("nationality","",'tabindex="13"')),array("id='td1'"));
			$rows[] = $t->row(array($v->words("gender"),":",$f->select("gender_id",$genders,"",'tabindex="14"')),array("id='td1'"));
			$rows[] = $t->row(array($v->words("marital_status"),":",$f->select("marital_status_id",$arr_marital_status,"",'tabindex="15"')),array("id='td1'"));
			$rows[] = $t->row(array($v->words("photo"),":",$f->input("photo","",'type="file" tabindex="16"')),array("id='td1'"));
			$rows[] = $t->row(array("","",$f->input("signin",$v->words("save"),'type="submit" tabindex="17"',"btn_sign")),array("align='right'"));
			$additionalscript = "";
		?>
		var retval = "";
		retval += "<div class='seeker_profiles_form'>";
		retval += "	<div id='title'><?=$v->words("youre_almost_there");?></div>";
		retval += "	<?=$f->start("","POST","","enctype='multipart/form-data'");?>";
		retval += "		<table><tr><td valign='top'>";
		retval += "			<?=$t->start();?>";
		<?php for($xx=0;$xx<9;$xx++) { ?>
		retval += "			<?=str_replace('"','\"',$rows[$xx]);?>";
		<?php } ?>
		retval += "			<?=$t->end();?>";
		retval += "		</td>";
		retval += "		<td style='width:20px;'></td>";
		retval += "		<td valign='top'>";
		retval += "			<?=$t->start();?>";
		<?php 
			for($xx=9;$xx<17;$xx++) { 
				$arr = $f->inner_script($rows[$xx]);
				$rows[$xx] = $arr[0];
				$additionalscript .= $arr[1];
		?>
		retval += "			<?=$rows[$xx];?>";
		<?php } ?>
		retval += "			<?=$t->end();?>";
		retval += "		</td></tr></table>";
		retval += "		<input type='hidden' name='save_just_signup' value='1'>";
		retval += "	<?=$f->end();?>";
		retval += "</div>";//seeker_profiles_form
		
		return retval;
	}
	<?=$additionalscript;?>
</script>