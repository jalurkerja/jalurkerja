<script>
	/*START CHANGE PASSWORD =======================================================================================================*/
	function save_edit_change_password() 	{ $.post( "ajax/seeker_setting_ajax.php", { post_data: $("#edit_change_password").serialize() }).done(function( data ) { after_edit_change_password(data); }); }
	function after_edit_change_password(data)	{
		if(data > 0){
			popup_message("<?=$v->words("your_data_successfully_saved");?>","","load_setting_general();");
		} else if(data == "error:wrong_new_password"){
			popup_message("<?=$v->words("wrong_new_password");?>","error_message","load_setting_general()");
		} else if(data == "error:wrong_password"){
			popup_message("<?=$v->words("wrong_password");?>","error_message","load_setting_general()");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_saved");?>","error_message","load_setting_general()");
		}
	}
	/*END CHANGE PASSWORD =======================================================================================================*/
	/*START APPLICATION =======================================================================================================*/
	function save_edit_application() 	{ $.post( "ajax/seeker_setting_ajax.php", { post_data: $("#edit_application").serialize() }).done(function( data ) { after_edit_application(data); }); }
	function after_edit_application(data)	{
		if(data >= 0){
			popup_message("<?=$v->words("your_data_successfully_saved");?>","","load_setting_general();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_saved");?>","error_message","load_setting_general()");
		}
	}
	/*END APPLICATION =======================================================================================================*/
	/*START SETTING =======================================================================================================*/
	function save_edit_setting() 	{ $.post( "ajax/seeker_setting_ajax.php", { post_data: $("#edit_setting").serialize() }).done(function( data ) { after_edit_setting(data); }); }
	function after_edit_setting(data)	{
		if(data >= 0){
			popup_message("<?=$v->words("your_data_successfully_saved");?>","","load_setting_general();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_saved");?>","error_message","load_setting_general()");
		}
	}
	/*END SETTING =======================================================================================================*/
</script>