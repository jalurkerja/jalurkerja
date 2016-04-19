<script>
	/*START SETTING DESIRES =======================================================================================================*/
	function save_edit_desires() 	{ $.post( "ajax/seeker_setting_desires_ajax.php", { post_data: $("#edit_desires").serialize() }).done(function( data ) { after_edit_desires(data); }); }
	function after_edit_desires(data)	{
		if(data > 0){
			popup_message("<?=$v->words("your_data_successfully_saved");?>","","load_setting_desires();");
		} else {
			popup_message("<?=$v->words("your_data_fails_to_be_saved");?>","error_message","load_setting_desires()");
		}
	}
	/*END SETTING DESIRES =======================================================================================================*/
</script>