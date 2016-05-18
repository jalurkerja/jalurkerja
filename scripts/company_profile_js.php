<script> 	
	function load_profile()					{ get_ajax("ajax/company_profile_ajax.php?mode=load_profile",				"profile","remove_footer('profile');"); }
	function load_applicant_management(tabid,keyword,sort,page,key_id)	{
		key_id = key_id || ""; tabid = tabid || ""; keyword = keyword || ""; sort = sort || ""; page = page || "";
		var url_string = "?mode=load_applicant_management&key_id="+key_id+"&tabid="+tabid+"&keyword="+keyword+"&sort="+sort+"&page="+page;
		window.history.pushState("","",url_string);
		get_ajax("ajax/company_profile_ajax.php"+url_string,"applicant_management","remove_footer('applicant_management');"); 
	}
	function load_advertising(gets)				{ 
		var url_string = "?mode=load_advertising&"+gets;
		get_ajax("ajax/company_profile_ajax.php"+url_string,"advertising","remove_footer('advertising');");
		window.history.pushState("","",url_string);
		$('html, body').animate({scrollTop : 0},800);
	}
	function search_advertising() { load_advertising($("#search_advertising_form").serialize()); }
	function adding_advertising() { $.post( "ajax/company_profile_ajax.php", { post_data: $("#add_advertising_form").serialize() }).done(function( data ) { after_save_adding_advertising(data); }); }
	function after_save_adding_advertising(data){
		if(data >= 0){
			document.getElementById('add_advertising').value = 2; 
			document.getElementById('add_opportunity_id').value = data; 
			search_advertising();
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_saved");?>","error_message","document.getElementById('add_advertising').value = 0; load_advertising()");
		}
	}
	function adding_advertising2() { $.post( "ajax/company_profile_ajax.php", { post_data: $("#add_advertising_form2").serialize() }).done(function( data ) { after_save_adding_advertising2(data); }); }
	function after_save_adding_advertising2(data){
		if(data > 0){
			popup_message("<?=$v->words("your_data_successfully_saved");?>","","document.getElementById('add_advertising').value = 0; load_advertising()");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_saved");?>","error_message","document.getElementById('add_advertising').value = 0; load_advertising()");
		}
	}
	
	function load_candidate_search()		{ get_ajax("ajax/company_profile_ajax.php?mode=load_candidate_search",		"candidate_search","remove_footer('candidate_search');"); }
	function load_report()					{ get_ajax("ajax/company_profile_ajax.php?mode=load_report",				"report","remove_footer('report');"); }
	function load_setting()					{ get_ajax("ajax/company_profile_ajax.php?mode=load_setting",				"setting","remove_footer('setting');"); }
	/*START PERSONAL DATA =======================================================================================================*/
	function edit_header_image()				{ var win_edit_header_image = window.open("company_profile_edit_images.php?mode=header_image","company_profile_edit_images","width=800 height=300"); }
	function edit_logo()						{ var win_edit_logo = window.open("company_profile_edit_images.php?mode=logo","company_profile_edit_images","width=300 height=300"); }
	function edit_company_profile()				{ get_ajax("ajax/company_profile_ajax.php?mode=edit_company_profile",			"profile","remove_footer('profile');"); }
	function save_company_profile() 			{ $.post( "ajax/company_profile_ajax.php", { post_data: $("#company_profile_form").serialize() }).done(function( data ) { after_save_company_profile(data); }); }
	function after_save_company_profile(data)	{ 
		if(data >= 0){
			popup_message("<?=$v->words("your_profile_successfully_saved");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_profile_fails_to_be_saved");?>","error_message","load_profile()");
		}
	}
	/*END PERSONAL DATA =======================================================================================================*/
	/*START COMPANY DESCRIPTION=======================================================================================================*/	
	function edit_company_description()	{ get_ajax("ajax/company_profile_ajax.php?mode=edit_company_description","profile","remove_footer('profile');"); }
	function save_company_description()	{ $.post( "ajax/company_profile_ajax.php", { post_data: $("#company_description_form").serialize() }).done(function( data ) { after_save_company_description(data); }); }
	function after_save_company_description(data) {
		if(data >= 0){
			popup_message("<?=$v->words("your_data_successfully_saved");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_saved");?>","error_message","load_profile()");
		}
	}
	/*END COMPANY DESCRIPTION=======================================================================================================*/
	/*START JOIN REASON=======================================================================================================*/	
	function edit_company_join_reason()	{ get_ajax("ajax/company_profile_ajax.php?mode=edit_company_join_reason","profile","remove_footer('profile');"); }
	function save_company_join_reason()	{ $.post( "ajax/company_profile_ajax.php", { post_data: $("#company_join_reason_form").serialize() }).done(function( data ) { after_save_company_join_reason(data); }); }
	function after_save_company_join_reason(data) {
		if(data >= 0){
			popup_message("<?=$v->words("your_data_successfully_saved");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_saved");?>","error_message","load_profile()");
		}
	}
	/*END JOIN REASON=======================================================================================================*/
	
	function remove_footer(area){
		var current_height = document.getElementById(area).offsetHeight * 1;
		if(current_height > 0) footer_area.style.top = (current_height + 250) + "px";
	}	
	
	function change_close_date(tgl,bln,thn) {
		bln = bln*1 + 3;
		if(bln > 12) {
			bln = bln - 12;
			thn = thn*1 + 1;
		}
		return tgl+"-"+bln+"-"+thn;
	}
	
	/*START CHANGE PASSWORD =======================================================================================================*/
	function save_edit_change_password() 	{ $.post( "ajax/company_profile_ajax.php", { post_data: $("#edit_change_password").serialize() }).done(function( data ) { after_edit_change_password(data); }); }
	function after_edit_change_password(data)	{
		if(data > 0){
			popup_message("<?=$v->words("your_data_successfully_saved");?>","","load_setting();");
		} else if(data == "error:wrong_new_password"){
			popup_message("<?=$v->words("wrong_new_password");?>","error_message","load_setting()");
		} else if(data == "error:wrong_password"){
			popup_message("<?=$v->words("wrong_password");?>","error_message","load_setting()");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_saved");?>","error_message","load_setting()");
		}
	}
	/*END CHANGE PASSWORD =======================================================================================================*/
	
	// function load_detail_opportunity(opportunity_id){
		// get_ajax("ajax/searchjob_ajax.php?mode=generate_token&opportunity_id="+opportunity_id,"return_generate_token","openwindow('opportunity_detail.php?id="+opportunity_id+"&token='+global_respon['return_generate_token']);");
	// }
</script>