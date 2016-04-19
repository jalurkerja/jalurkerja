<script> 
	get_ajax("ajax/searchjob_ajax.php?mode=list","opportunities_list"); 
	
	function load_detail_opportunity(opportunity_id){
		get_ajax("ajax/searchjob_ajax.php?mode=detail&opportunity_id="+opportunity_id,"opportunity_temp","opportunity_detail_parsing();"); 
	}
	
	function update_applybtn_class(respondval){
		if(respondval > 0){
			$("#applybtn1").removeClass('jobtools_btn').addClass('jobtools_btn_disabled');
			$("#applybtn2").removeClass('jobtools_btn').addClass('jobtools_btn_disabled');
		} else {
			$("#applybtn1").removeClass('jobtools_btn_disabled').addClass('jobtools_btn');
			$("#applybtn2").removeClass('jobtools_btn_disabled').addClass('jobtools_btn');
		}
	}
	
	function update_savebtn_class(respondval){
		if(respondval > 0){
			$("#savebtn").removeClass('jobtools_btn').addClass('jobtools_btn_disabled');
		} else {
			$("#savebtn").removeClass('jobtools_btn_disabled').addClass('jobtools_btn');
		}
	}
	
	function opportunity_detail_parsing(){
		var opportunity__id = document.getElementById("opportunity__id").innerHTML || "";
		var returnval = "";
		if(opportunity__id != "NULL"){
			get_ajax("ajax/searchjob_ajax.php?mode=isapplied&user_id=<?=$__user_id;?>&opportunity_id="+opportunity__id,"isapplied","update_applybtn_class(global_respon['isapplied']);");
			get_ajax("ajax/searchjob_ajax.php?mode=issaved&user_id=<?=$__user_id;?>&opportunity_id="+opportunity__id,"issaved","update_savebtn_class(global_respon['issaved']);");
			
			document.getElementById("opportunity_detail_empty").style.display = "none";
			document.getElementById("opportunity_detail").style.display = "block";
			
			if(opportunity__logo.innerHTML != "") {
				opportunity___logo.innerHTML 		= "<img src='company_logo/" + opportunity__logo.innerHTML + "'>";
			} else {
				opportunity___logo.innerHTML 		= "";
			}
			opportunity___name.innerHTML 			= opportunity__name.innerHTML;
			opportunity___industry.innerHTML 		= opportunity__industry.innerHTML;
			opportunity___web.innerHTML 			= "<a href='" + opportunity__web.innerHTML + "' target='_BLANK'>" + opportunity__web.innerHTML + "</a>";
			opportunity___contact_person.innerHTML 	= opportunity__contact_person.innerHTML;
			opportunity___description.innerHTML 	= opportunity__description.innerHTML;
			opportunity___title.innerHTML 			= document.getElementById("opportunity__title_<?=$__locale;?>").innerHTML;
			opportunity___job_function.innerHTML 	= opportunity__job_function.innerHTML;
			opportunity___job_levels.innerHTML 		= opportunity__job_levels.innerHTML;
			opportunity___degree.innerHTML 			= opportunity__degree.innerHTML;
			opportunity___majors.innerHTML 			= opportunity__majors.innerHTML;
			opportunity___work_experience.innerHTML = opportunity__experience_years.innerHTML + " <?=$v->words("years");?>";
			opportunity___salary_offer.innerHTML 	= opportunity__salary_offer.innerHTML;
			opportunity___posted_date.innerHTML 	= opportunity__posted_date.innerHTML;
			opportunity___closing_date.innerHTML 	= opportunity__closing_date2.innerHTML;
			opportunity___descriptions.innerHTML 	= opportunity__descriptions.innerHTML;
			if(!opportunity__descriptions.innerHTML) opportunity___descriptions.innerHTML 	= "{<?=$v->words("empty_description");?>}";
			opportunity___requirements.innerHTML 	= opportunity__requirements.innerHTML;
		} else {
			document.getElementById("opportunity_detail_empty").style.display = "block";
			document.getElementById("opportunity_detail").style.display = "none";
		}
	}
	
	function applying_on_company_page(respondval,opportunity_id) {
		if (respondval > 0){
			$.fancybox.open("<div style='overflow:auto;'>" + applying_on_company_form(opportunity_id) + "</div>");
		} else {
			popup_message("<?=$v->words("error_company_cannot_apply");?>","error_message");
		}
	}
	
	function apply_on_company_page(opportunity_id) {
		get_ajax("ajax/searchjob_ajax.php?mode=apply_on_company_page&opportunity_id="+opportunity_id,"apply_on_company_page","applying_on_company_page(global_respon['apply_on_company_page'],"+opportunity_id+");");
	}
	
	function apply(opportunity_id){
		var applybtn1 = document.getElementById("applybtn1");
		var applybtn2 = document.getElementById("applybtn2");
		if(applybtn1.className == "jobtools_btn" && applybtn2.className == "jobtools_btn"){
			<?php if (!$__isloggedin) { ?>
				show_login_form(opportunity_id);
			<?php } else if($__company_id) { ?>
				apply_on_company_page(opportunity_id,'<?=$__company_id;?>');
			<?php } else { ?>
				apply_action(opportunity_id);
			<?php } ?>
		}
	}
	
	function save(opportunity_id){
		var savebtn = document.getElementById("savebtn");
		if(savebtn.className == "jobtools_btn"){
			<?php if (!$__isloggedin) { ?>
				show_login_form(opportunity_id);
			<?php } else { ?>
				save_action(opportunity_id);
			<?php } ?>
		}
	}
	
	function success_applied(valrespond){
		if(valrespond == "1"){
			update_applybtn_class(valrespond);
			popup_message("<?=$v->words("apply_success");?>");
		} else if (valrespon.substr(0,10) == "need_email"){
			alert("butuh isi email");
		} else if (valrespon.substr(0,5) == "error"){
			alert("error : " + valrespon);
		}
	}
	
	function success_saved(valrespond){
		if(valrespond == "1"){
			update_savebtn_class(valrespond);
			popup_message("<?=$v->words("save_success");?>");
		} else if (valrespon.substr(0,5) == "error"){
			alert("error : " + valrespon);
		}
	}
		
	function apply_action(opportunity_id,email){
		email = email || "";
		get_ajax("ajax/searchjob_ajax.php?mode=apply&opportunity_id="+opportunity_id+"&email="+email,"apply_respon","success_applied(global_respon['apply_respon']);");
	}
	
	function save_action(opportunity_id,email){
		email = email || "";
		get_ajax("ajax/searchjob_ajax.php?mode=save&opportunity_id="+opportunity_id,"save_respon","success_saved(global_respon['save_respon']);");
	}

	<?php if(isset($_POST["apply_after_login"]) && $_POST["apply_after_login"] != "") { ?> $(document ).ready(function() { apply_action("<?=$_POST["apply_after_login"];?>"); }); <?php } ?>
		
	function show_login_form(opportunity_id) {
		$.fancybox.open("<div style='overflow:auto;'>" + login_form(opportunity_id) + "</div>");
	}
	
	function login_form(opportunity_id){
		opportunity_id = opportunity_id || "";
		var retval = "";
		retval += "<div class='login_form_area'>";
		retval += "	<div id='title'><?=$v->words("signin");?></div>";
		retval += "	<?=str_replace(array(chr(10),chr(13)),"",$f->start());?>";
		retval += "		<?=str_replace(array(chr(10),chr(13)),"",$t->start());?>";
		retval += "			<?=str_replace(array(chr(10),chr(13),'"'),array("","","'"),$t->row(array($v->words("email"),":",$f->input("username","",'tabindex="1" maxlength="75" autocomplete="on"',"txt_login")),array("id='td1'")));?>";
		retval += "			<?=str_replace(array(chr(10),chr(13),'"'),array("","","'"),$t->row(array($v->words("password"),":",$f->input("password","",'type="password" tabindex="2" maxlength="75" autocomplete="on"',"txt_login")),array("id='td1'")));?>";
		retval += "			<?=str_replace(array(chr(10),chr(13),'"'),array("","","'"),$t->row(array("","",$f->input("signin",$v->words("signin"),'type="submit" tabindex="3"',"btn_sign")),array("align='right'")));?>";
		retval += "			<input type='hidden' name='opportunity_id' value='" + opportunity_id + "'>";
		retval += "			<input type='hidden' name='login_action' value='1'>";
		retval += "		<?=str_replace(array(chr(10),chr(13)),"",$t->end());?>";
		retval += "	<?=str_replace(array(chr(10),chr(13)),"",$f->end());?>";
		retval += "</div>";//login_form_area
		
		return retval;
	}
	
	function applying_on_company_form(opportunity_id){
		opportunity_id = opportunity_id || "";
		var retval = "";
		retval += "<input type='hidden' id='opportunity_id' value='" + opportunity_id + "'>";
		retval += "<div class='login_form_area'>";
		retval += "	<div id='title'><?=$v->words("apply");?></div>";
		retval += "	<?=str_replace(array(chr(10),chr(13)),"",$t->start());?>";
		retval += "		<?=str_replace(array(chr(10),chr(13),'"'),array("","","'"),$t->row(array($v->words("email"),":",$f->input("email","",'tabindex="1" maxlength="75" autocomplete="on"',"txt_login")),array("id='td1'")));?>";
		retval += "		<?=str_replace(array(chr(10),chr(13),'"'),array("","","'"),$t->row(array("","",$f->input("signin",$v->words("send"),'type="button" onclick="apply_action(opportunity_id.value,email.value);"',"btn_sign")),array("align='right'")));?>";
		retval += "	<?=str_replace(array(chr(10),chr(13)),"",$t->end());?>";
		retval += "</div>";//login_form_area
		
		return retval;
	}
</script>