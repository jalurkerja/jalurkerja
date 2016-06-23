<script> 	
	function load_profile()							{ get_ajax("ajax/seeker_profile_ajax.php?mode=load_profile",						"profile","remove_footer('profile');"); }
	function load_setting_desires()					{ get_ajax("ajax/seeker_profile_ajax.php?mode=load_setting_desires",				"setting_desires","remove_footer('setting_desires');"); }
	function load_setting_general()					{ get_ajax("ajax/seeker_profile_ajax.php?mode=load_setting_general",				"setting_general","remove_footer('setting_general');"); }
	function load_setting_membership()				{ get_ajax("ajax/seeker_profile_ajax.php?mode=load_setting_membership",				"setting_membership","remove_footer('setting_membership');"); }
	function load_documents_saved_search()			{ get_ajax("ajax/seeker_profile_ajax.php?mode=load_documents_saved_search",			"documents_saved_search","remove_footer('documents_saved_search');"); }
	function load_documents_saved_opporunities()	{ get_ajax("ajax/seeker_profile_ajax.php?mode=load_documents_saved_opporunities",	"documents_saved_opportunities","remove_footer('documents_saved_opportunities');"); }
	function load_documents_applied_opporunities()	{ get_ajax("ajax/seeker_profile_ajax.php?mode=load_documents_applied_opporunities",	"documents_applied_opportunities","remove_footer('documents_applied_opportunities');"); }
	/*START PERSONAL DATA =======================================================================================================*/
	function edit_photo(){ 
		$.fancybox.open({ href: "seeker_profile_edit_photo.php", type: 'iframe' });
	}
	function edit_personal_data()			{ get_ajax("ajax/seeker_profile_ajax.php?mode=edit_personal_data",			"profile","remove_footer('profile');"); }
	function save_personal_data() 			{ $.post( "ajax/seeker_profile_ajax.php", { post_data: $("#personal_data_form").serialize() }).done(function( data ) { after_save_personal_data(data); }); }
	function after_save_personal_data(data)	{ 
		if(data >= 0){
			popup_message("<?=$v->words("your_profile_successfully_saved");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_profile_fails_to_be_saved");?>","error_message","load_profile()");
		}
	}
	function print_view(){ var win_edit_photo = window.open("seeker_profile_print_view.php","seeker_profile_print_view","width=1100,height=800,scrollbars=yes"); }
	/*END PERSONAL DATA =======================================================================================================*/
	/*START WORK EXPERIENCE=======================================================================================================*/
	function add_work_experience()			{ get_ajax("ajax/seeker_profile_ajax.php?mode=add_work_experience",			"profile","remove_footer('profile');"); }
	function save_add_work_experience() 	{ $.post( "ajax/seeker_profile_ajax.php", { post_data: $("#add_work_experience_form").serialize() }).done(function( data ) { after_save_add_work_experience(data); }); }
	function after_save_add_work_experience(data)	{ 
		if(data > 0){
			popup_message("<?=$v->words("your_data_successfully_added");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_added");?>","error_message","load_profile()");
		}
	}
	
	function edit_work_experience(id)		{ get_ajax("ajax/seeker_profile_ajax.php?mode=edit_work_experience&id="+id,	"profile","remove_footer('profile');"); }
	function save_edit_work_experience() 	{ $.post( "ajax/seeker_profile_ajax.php", { post_data: $("#edit_work_experience_form").serialize() }).done(function( data ) { after_save_edit_work_experience(data); }); }
	function after_save_edit_work_experience(data)	{ 
		if(data >= 0){
			popup_message("<?=$v->words("your_data_successfully_saved");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_saved");?>","error_message","load_profile()");
		}
	}
	
	function delete_work_experience(id)		{ popup_message("<?=$v->words("are_you_sure_to_delete_this_data");?>?<br><br><input type='button' value='Ok' class='btn_post' onclick=\"deleting_work_experience('"+id+"');\">","error_message"); }	
	function deleting_work_experience(id)	{ get_ajax("ajax/seeker_profile_ajax.php?mode=deleting_work_experience&id_seeker_experiences="+id,	"we_delete_result","after_delete_work_experience(global_respon['we_delete_result'])"); }
	function after_delete_work_experience(data)	{ 
		if(data > 0){
			popup_message("<?=$v->words("your_data_successfully_deleted");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_deleted");?>","error_message","load_profile()");
		}
	}
	/*END WORK EXPERIENCE=======================================================================================================*/
	/*START CERTIFICATION =======================================================================================================*/
	function add_certification()		{ get_ajax("ajax/seeker_profile_ajax.php?mode=add_certification",			"profile","remove_footer('profile');"); }
	function save_add_certification() 	{ $.post( "ajax/seeker_profile_ajax.php", { post_data: $("#add_certification_form").serialize() }).done(function( data ) { after_save_add_certification(data); }); }
	function after_save_add_certification(data)	{ 
		if(data > 0){
			popup_message("<?=$v->words("your_data_successfully_added");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_added");?>","error_message","load_profile()");
		}
	}
	
	function edit_certification(id)		{ get_ajax("ajax/seeker_profile_ajax.php?mode=edit_certification&id="+id,	"profile","remove_footer('profile');"); }
	function save_edit_certification() 	{ $.post( "ajax/seeker_profile_ajax.php", { post_data: $("#edit_certification_form").serialize() }).done(function( data ) { after_save_edit_certification(data); }); }
	function after_save_edit_certification(data)	{ 
		if(data >= 0){
			popup_message("<?=$v->words("your_data_successfully_saved");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_saved");?>","error_message","load_profile()");
		}
	}
	
	function delete_certification(id)	{ popup_message("<?=$v->words("are_you_sure_to_delete_this_data");?>?<br><br><input type='button' value='Ok' class='btn_post' onclick=\"deleting_certification('"+id+"');\">","error_message"); }	
	function deleting_certification(id)	{ get_ajax("ajax/seeker_profile_ajax.php?mode=deleting_certification&id_seeker_certifications="+id,	"we_delete_result","after_delete_certification(global_respon['we_delete_result'])"); }
	function after_delete_certification(data)	{ 
		if(data > 0){
			popup_message("<?=$v->words("your_data_successfully_deleted");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_deleted");?>","error_message","load_profile()");
		}
	}
	/*END CERTIFICATION =======================================================================================================*/
	/*START WORK EDUCATION=======================================================================================================*/
	function loadSelectSchools(name,keycode){
		if(keycode==27){
		  div_select_school.style.display="none";
		}else{
		  if(name != ""){
			try{ school_id.value=""; } catch (e){}
			get_ajax("ajax/seeker_profile_ajax.php?mode=loadSelectSchool&name="+name,	"SelectSchoolsList","loadingSelectSchools();",false);
		  }else{
			div_select_school.style.display="none";
		  }
		}
	}
	
	function loadingSelectSchools(){
		var returnvalue = global_respon['SelectSchoolsList'];
		if(returnvalue != ""){
		  div_select_school.style.display="block";
		  select_school.innerHTML=returnvalue;
		}else{
		  div_select_school.style.display="none";
		}
	}
	
	function pickSelectSchoolList(school_id,school_name){
		try{ document.getElementById("school_id").value = school_id; } catch (e){}
		try{ document.getElementById("school_name").value = school_name; } catch (e){}
		div_select_school.style.display="none";
	}
	
	function add_education()		{ get_ajax("ajax/seeker_profile_ajax.php?mode=add_education",			"profile","remove_footer('profile');"); }
	function save_add_education() 	{ $.post( "ajax/seeker_profile_ajax.php", { post_data: $("#add_education_form").serialize() }).done(function( data ) { after_save_add_education(data); }); }
	function after_save_add_education(data)	{ 
		if(data > 0){
			popup_message("<?=$v->words("your_data_successfully_added");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_added");?>","error_message","load_profile()");
		}
	}
	
	function edit_education(id)		{ get_ajax("ajax/seeker_profile_ajax.php?mode=edit_education&id="+id,	"profile","remove_footer('profile');"); }
	function save_edit_education() 	{ $.post( "ajax/seeker_profile_ajax.php", { post_data: $("#edit_education_form").serialize() }).done(function( data ) { after_save_edit_education(data); }); }
	function after_save_edit_education(data)	{ 
		if(data >= 0){
			popup_message("<?=$v->words("your_data_successfully_saved");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_saved");?>","error_message","load_profile()");
		}
	}
	
	function delete_education(id)		{ popup_message("<?=$v->words("are_you_sure_to_delete_this_data");?>?<br><br><input type='button' value='Ok' class='btn_post' onclick=\"deleting_education('"+id+"');\">","error_message"); }	
	function deleting_education(id)	{ get_ajax("ajax/seeker_profile_ajax.php?mode=deleting_education&id_seeker_educations="+id,	"we_delete_result","after_delete_education(global_respon['we_delete_result'])"); }
	function after_delete_education(data)	{ 
		if(data > 0){
			popup_message("<?=$v->words("your_data_successfully_deleted");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_deleted");?>","error_message","load_profile()");
		}
	}
	/*END WORK EDUCATION=======================================================================================================*/
	/*START WORK LANGUAGE=======================================================================================================*/
	function loadSelectLanguages(name,keycode){
		if(keycode==27){
		  div_select_language.style.display="none";
		}else{
		  if(name != ""){
			try{ language_id.value=""; } catch (e){}
			get_ajax("ajax/seeker_profile_ajax.php?mode=loadSelectLanguages&name="+name,	"SelectLanguagesList","loadingSelectLanguages();",false);
		  }else{
			div_select_language.style.display="none";
		  }
		}
	}
	
	function loadingSelectLanguages(){
		var returnvalue = global_respon['SelectLanguagesList'];
		if(returnvalue != ""){
		  div_select_language.style.display="block";
		  select_language.innerHTML=returnvalue;
		}else{
		  div_select_language.style.display="none";
		}
	}
	
	function pickSelectLanguageList(language_id,language_name){
		try{ document.getElementById("language_id").value = language_id; } catch (e){}
		try{ document.getElementById("language_name").value = language_name; } catch (e){}
		div_select_language.style.display="none";
	}
	
	function add_language()		{ get_ajax("ajax/seeker_profile_ajax.php?mode=add_language",			"profile","remove_footer('profile');"); }
	function save_add_language() 	{ $.post( "ajax/seeker_profile_ajax.php", { post_data: $("#add_language_form").serialize() }).done(function( data ) { after_save_add_language(data); }); }
	function after_save_add_language(data)	{ 
		if(data > 0){
			popup_message("<?=$v->words("your_data_successfully_added");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_added");?>","error_message","load_profile()");
		}
	}
	
	function edit_language(id)		{ get_ajax("ajax/seeker_profile_ajax.php?mode=edit_language&id="+id,	"profile","remove_footer('profile');"); }
	function save_edit_language() 	{ $.post( "ajax/seeker_profile_ajax.php", { post_data: $("#edit_language_form").serialize() }).done(function( data ) { after_save_edit_language(data); }); }
	function after_save_edit_language(data)	{ 
		if(data >= 0){
			popup_message("<?=$v->words("your_data_successfully_saved");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_saved");?>","error_message","load_profile()");
		}
	}
	
	function delete_language(id)		{ popup_message("<?=$v->words("are_you_sure_to_delete_this_data");?>?<br><br><input type='button' value='Ok' class='btn_post' onclick=\"deleting_language('"+id+"');\">","error_message"); }	
	function deleting_language(id)	{ get_ajax("ajax/seeker_profile_ajax.php?mode=deleting_language&id_seeker_languages="+id,	"we_delete_result","after_delete_language(global_respon['we_delete_result'])"); }
	function after_delete_language(data)	{ 
		if(data > 0){
			popup_message("<?=$v->words("your_data_successfully_deleted");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_deleted");?>","error_message","load_profile()");
		}
	}
	/*END WORK LANGUAGE=======================================================================================================*/
	/*START WORK SKILL=======================================================================================================*/	
	function add_skill()		{ get_ajax("ajax/seeker_profile_ajax.php?mode=add_skill",			"profile","remove_footer('profile');"); }
	function save_add_skill() 	{ $.post( "ajax/seeker_profile_ajax.php", { post_data: $("#add_skill_form").serialize() }).done(function( data ) { after_save_add_skill(data); }); }
	function after_save_add_skill(data)	{ 
		if(data > 0){
			popup_message("<?=$v->words("your_data_successfully_added");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_added");?>","error_message","load_profile()");
		}
	}
	
	function edit_skill(id)		{ get_ajax("ajax/seeker_profile_ajax.php?mode=edit_skill&id="+id,	"profile","remove_footer('profile');"); }
	function save_edit_skill() 	{ $.post( "ajax/seeker_profile_ajax.php", { post_data: $("#edit_skill_form").serialize() }).done(function( data ) { after_save_edit_skill(data); }); }
	function after_save_edit_skill(data)	{ 
		if(data >= 0){
			popup_message("<?=$v->words("your_data_successfully_saved");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_saved");?>","error_message","load_profile()");
		}
	}
	
	function delete_skill(id)		{ popup_message("<?=$v->words("are_you_sure_to_delete_this_data");?>?<br><br><input type='button' value='Ok' class='btn_post' onclick=\"deleting_skill('"+id+"');\">","error_message"); }	
	function deleting_skill(id)	{ get_ajax("ajax/seeker_profile_ajax.php?mode=deleting_skill&id_seeker_skills="+id,	"we_delete_result","after_delete_skill(global_respon['we_delete_result'])"); }
	function after_delete_skill(data)	{ 
		if(data > 0){
			popup_message("<?=$v->words("your_data_successfully_deleted");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_deleted");?>","error_message","load_profile()");
		}
	}
	/*END WORK SKILL=======================================================================================================*/
	/*START ORGANIZATION=======================================================================================================*/
	function add_organization()			{ get_ajax("ajax/seeker_profile_ajax.php?mode=add_organization",			"profile","remove_footer('profile');"); }
	function save_add_organization() 	{ $.post( "ajax/seeker_profile_ajax.php", { post_data: $("#add_organization_form").serialize() }).done(function( data ) { after_save_add_organization(data); }); }
	function after_save_add_organization(data)	{ 
		if(data > 0){
			popup_message("<?=$v->words("your_data_successfully_added");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_added");?>","error_message","load_profile()");
		}
	}
	
	function edit_organization(id)		{ get_ajax("ajax/seeker_profile_ajax.php?mode=edit_organization&id="+id,	"profile","remove_footer('profile');"); }
	function save_edit_organization() 	{ $.post( "ajax/seeker_profile_ajax.php", { post_data: $("#edit_organization_form").serialize() }).done(function( data ) { after_save_edit_organization(data); }); }
	function after_save_edit_organization(data)	{ 
		if(data >= 0){
			popup_message("<?=$v->words("your_data_successfully_saved");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_saved");?>","error_message","load_profile()");
		}
	}
	
	function delete_organization(id)		{ popup_message("<?=$v->words("are_you_sure_to_delete_this_data");?>?<br><br><input type='button' value='Ok' class='btn_post' onclick=\"deleting_organization('"+id+"');\">","error_message"); }	
	function deleting_organization(id)	{ get_ajax("ajax/seeker_profile_ajax.php?mode=deleting_organization&id_seeker_organizations="+id,	"we_delete_result","after_delete_organization(global_respon['we_delete_result'])"); }
	function after_delete_organization(data)	{ 
		if(data > 0){
			popup_message("<?=$v->words("your_data_successfully_deleted");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_deleted");?>","error_message","load_profile()");
		}
	}
	/*END WORK ORGANIZATION=======================================================================================================*/
	/*START WORK SUMMARY=======================================================================================================*/	
	function edit_summary(id)		{ get_ajax("ajax/seeker_profile_ajax.php?mode=edit_summary&id="+id,	"profile","remove_footer('profile');"); }
	function save_edit_summary() 	{ $.post( "ajax/seeker_profile_ajax.php", { post_data: $("#edit_summary_form").serialize() }).done(function( data ) { after_save_edit_summary(data); }); }
	function after_save_edit_summary(data)	{ 
		if(data >= 0){
			popup_message("<?=$v->words("your_data_successfully_saved");?>","","load_profile();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_saved");?>","error_message","load_profile()");
		}
	}
	/*END WORK SUMMARY=======================================================================================================*/
	
	
	function remove_footer(area){
		var current_height = document.getElementById(area).offsetHeight * 1;
		footer_area.style.top = (current_height + 250) + "px";
	}
	
	function chk_still_work_here(elm){
		if (elm.checked == true){
			end_date_work_experience.style.visibility = "hidden";
			enddate.value="0000-00-00";
		} else {
			end_date_work_experience.style.visibility= "visible";
		}
	}
		
	function chk_still_here(elm){
		if (elm.checked == true){
			endyear_organization.style.visibility = "hidden";
			endyear.value="0000";
		} else {
			endyear_organization.style.visibility= "visible";
		}
	}
	
	function chk_still_school_here(elm){
		if (elm.checked == true){
			school_graduated_year.style.visibility = "hidden";
			graduated_year.value="0";
		} else {
			school_graduated_year.style.visibility= "visible";
		}
	}
	
	
	
</script>