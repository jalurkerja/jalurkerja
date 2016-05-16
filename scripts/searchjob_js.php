<script> 
	<?php
		if(isset($_GET["get_search"]) && $_GET["get_search"]!=""){
			?>  
			$(document).ready(function() { 
				<?php if(isset($_GET["job_function"]))	{ ?> loading_select_box_job_function("serach_btn_click()"); <?php } ?>
				<?php if(isset($_GET["job_level"]))		{ ?> loading_select_box_job_level("serach_btn_click()"); <?php } ?>
				<?php if(isset($_GET["industries"]))		{ ?> loading_select_box_industries("serach_btn_click()"); <?php } ?>
				<?php if(isset($_GET["education_level"]))		{ ?> loading_select_box_education_level("serach_btn_click()"); <?php } ?>
				loading_select_box_job_type("serach_btn_click()");
				serach_btn_click();
			}); 
			<?php
		} else {
			?> get_ajax("ajax/searchjob_ajax.php?mode=list","opportunities_list","loading_paging()"); <?php
		}
	?>
	
	function changepage(page){
		document.getElementById("searchjob_page").value = page;		
		$.post( "ajax/searchjob_ajax.php", { post_data: $("#searchjob_form").serialize() }).done(function( data ) { searching_result(data); }); 
	}
	
	function changeorder(order){
		document.getElementById("searchjob_order").value = order;
		$.post( "ajax/searchjob_ajax.php", { post_data: $("#searchjob_form").serialize() }).done(function( data ) { searching_result(data);changepage(1) }); 
	}
	
	function serach_btn_click() {
		document.getElementById("searchjob_page").value = 1;
		document.getElementById("searchjob_order").value = "posted_at DESC,updated_at DESC";
		document.getElementById("sort_by").value = "posted_at DESC,updated_at DESC";
		popup_message("<img src='icons/loading.gif' width='100'><br><div style='width:100px;height:5px;background-color:white;position:relative;top:-5px;left:100px;'></div>");
		$.post( "ajax/searchjob_ajax.php", { post_data: $("#searchjob_form").serialize() }).done(function( data ) { searching_result(data); }); 
	}
	
	function searching_result(data){
		try{ $.fancybox.close(); } catch(e){} 
		document.getElementById("opportunities_list").innerHTML = data;
		$('html, body').animate({scrollTop : 0},800);
		loading_search_criteria();
		loading_paging();
	}
	
	function activate_pagenum(){
		var maxrow = document.getElementById("opportunities_maxrow").innerHTML;
		var page = document.getElementById("opportunities_page").innerHTML;
		var list = document.getElementsByClassName("paging")[0];
		for(var i = 0 ; i < maxrow ; i++){ try{ list.getElementsByTagName("a")[i].id = ""; }catch(e){} }
		list.getElementsByTagName("a")[page - 1].id = "a_active";
	}
	
	function loading_paging(){
		var maxrow = document.getElementById("opportunities_maxrow").innerHTML;
		get_ajax("ajax/searchjob_ajax.php?mode=loading_paging&maxrow="+maxrow,"paging_area","activate_pagenum()"); 
	}
	
	function loading_search_criteria(){
		if(document.getElementById("opportunities_search_criteria").innerHTML != "NULL")
			document.getElementById("search_criteria").innerHTML = document.getElementById("opportunities_search_criteria").innerHTML;
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
			$("#savebtn1").removeClass('jobtools_btn').addClass('jobtools_btn_disabled');
			$("#savebtn2").removeClass('jobtools_btn').addClass('jobtools_btn_disabled');
		} else {
			$("#savebtn1").removeClass('jobtools_btn_disabled').addClass('jobtools_btn');
			$("#savebtn2").removeClass('jobtools_btn_disabled').addClass('jobtools_btn');
		}
	}
	
	function applying_on_company_page(respondval,opportunity_id) {
		if (respondval > 0){
			setTimeout(function() {
				$.fancybox.open("<div style='overflow:auto;'>" + applying_on_company_form(opportunity_id) + "</div>");
			}, 1000);
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
				parent.show_login_form(opportunity_id);
			<?php } else if($__company_id) { ?>
				apply_on_company_page(opportunity_id,'<?=$__company_id;?>');
			<?php } else { ?>
				apply_action(opportunity_id);
			<?php } ?>
		}
	}
	
	function save(opportunity_id){
		var savebtn1 = document.getElementById("savebtn1");
		var savebtn2 = document.getElementById("savebtn2");
		if(savebtn1.className == "jobtools_btn" && savebtn2.className == "jobtools_btn"){
			<?php if (!$__isloggedin) { ?>
				popup_message("<?=$v->w("login_first");?>");
			<?php } else { ?>
				save_action(opportunity_id);
			<?php } ?>
		}
	}
	
	function resend_confirmation(){
		popup_message("<?=$v->w("sending_confirmation");?>");
		window.location = "resend_confirmation.php";
	}
	
	function success_applied(valrespond){
		setTimeout(function() {
			if(valrespond == "1"){
				update_applybtn_class(valrespond);
				popup_message("<?=$v->words("apply_success");?>");
			} else if (valrespond.substr(0,10) == "need_email"){
				alert("error:1024");
			} else if (valrespond == "need_confirmation"){
				var message = "<div style='widht:500px;'><?=$v->w("need_confirmation");?><br><br><?=$v->w("click_resend_confirmation");?><div>";
				message += "<div class='language_notactive' onclick='resend_confirmation();'>[<?=$v->w("resend");?>]</div>";
				popup_message(message,"error_message");
			} else if (valrespond == "error:user_not_exist"){
				popup_message("<?=$v->w("user_not_exist");?>","error_message");
			} else if (valrespond == "error:already_applied"){
				popup_message("<?=$v->w("already_applied");?>","error_message");
			} else {
				alert(valrespond);
			}
		}, 500);
	}
	
	function success_saved(valrespond){
		if(valrespond == "1"){
			update_savebtn_class(valrespond);
			popup_message("<?=$v->words("save_success");?>");
		} else if (valrespond.substr(0,5) == "error"){
			alert("error : " + valrespond);
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
		retval += "			<?=str_replace(array(chr(10),chr(13),'"'),array("","","'"),$t->row(array($v->words("email"),":",$f->input("username","",'tabindex="11" maxlength="75" autocomplete="on"',"txt_login")),array("id='td1'")));?>";
		retval += "			<?=str_replace(array(chr(10),chr(13),'"'),array("","","'"),$t->row(array($v->words("password"),":",$f->input("password","",'type="password" tabindex="12" maxlength="75" autocomplete="on"',"txt_login")),array("id='td1'")));?>";
		retval += "			<?=str_replace(array(chr(10),chr(13),'"'),array("","","'"),$t->row(array("","",$f->input("signin",$v->words("signin"),'type="submit" tabindex="13"',"btn_sign")),array("align='right'")));?>";
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
		retval += "		<?=str_replace(array(chr(10),chr(13),'"'),array("","","'"),$t->row(array($v->words("email"),":",$f->input("email","",'tabindex="11" maxlength="75" autocomplete="on"',"txt_login")),array("id='td1'")));?>";
		retval += "		<?=str_replace(array(chr(10),chr(13),'"'),array("","","'"),$t->row(array("","",$f->input("signin",$v->words("send"),'type="button" tabindex="12" onclick="apply_action(opportunity_id.value,email.value);"',"btn_sign")),array("align='right'")));?>";
		retval += "	<?=str_replace(array(chr(10),chr(13)),"",$t->end());?>";
		retval += "</div>";//login_form_area
		
		return retval;
	}
	
	function open_detail_opportunity(url){
		$.fancybox.open({ href: url, type: 'iframe',width:'1050px' });
	}
	
	function load_detail_opportunity(opportunity_id){
		get_ajax("ajax/searchjob_ajax.php?mode=generate_token&opportunity_id="+opportunity_id,"return_generate_token","open_detail_opportunity('opportunity_detail.php?id="+opportunity_id+"&token='+global_respon['return_generate_token']);",false);
	}
</script>