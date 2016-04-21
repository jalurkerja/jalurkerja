<script> 
	get_ajax("ajax/searchjob_ajax.php?mode=list","opportunities_list","loading_paging()"); 
	
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
		document.getElementById("searchjob_order").value = "posted_at DESC";
		document.getElementById("sort_by").value = "posted_at DESC";
		popup_message("<img src='icons/loading.gif' width='100'><br><div style='width:100px;height:5px;background-color:white;position:relative;top:-5px;left:100px;'></div>");
		$.post( "ajax/searchjob_ajax.php", { post_data: $("#searchjob_form").serialize() }).done(function( data ) { searching_result(data); }); 
	}
	
	function searching_result(data){
		try{ $.fancybox.close(); } catch(e){} 
		document.getElementById("opportunities_list").innerHTML = data;
		$('html, body').animate({scrollTop : 0},800);
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