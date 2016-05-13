<?php include_once "head.php"; ?>
<?php if(!$__is_seeker) { javascript('popup_message("'.$v->words("please_login_as_job_seeker").'","error_message","window.location=\'index.php\';"); '); exit();} ?>
<?php
	$setting_clicked = $db->fetch_single_data("users","setting_clicked",array("id" => $__user_id)) * 1;
	if($setting_clicked < 3) $setting_clicked++;
	$db->addtable("users");$db->where("id",$__user_id);$db->addfield("setting_clicked");$db->addvalue($setting_clicked);$db->update();
?>
<?php include_once "classes/tabular.php"; ?>
<?php include_once "homepage_header.php"; ?>
<?php include_once "scripts/seeker_profile_js.php"; ?>
<?php include_once "scripts/seeker_general_setting_js.php"; ?>
<?php include_once "scripts/seeker_setting_desires_js.php"; ?>
<script> $("body").css({"background-color":"white"});</script>
<div style="height:100px;"></div>
	<table width="100%" height="100%"><tr><td align="center" nowrap>
	<table width="1000"><tr><td class="page_title"><?=$v->words("job_seeker_setting");?></td></tr></table>
	<?php
		$tab = new Tabular("profile");
		$tab->set_border_width(2);
		$tab->set_area_width(1000);
		$tab->set_area_height(800);
		$tab->setnoborder();
		$tab->add_tab_title($v->words("profile"),"load_profile();");
		$tab->add_tab_title($v->words("settings"),"load_setting_desires();");
		$tab->add_tab_title($v->words("documents"),"load_documents_saved_search();");
		
		/**PROFILE**/
		$tab->add_tab_container("<div id='profile'></div>");
		/**END PROFILE**/
		/**SETTING**/
			$tab_settings = new Tabular("settings");
			$tab_settings->setnoborder();
			$tab_settings->setautorunscript(false);
			$tab_settings->set_tab_width(190);
			$tab_settings->set_area_width(970);
			$tab_settings->set_area_height(730);
			$tab_settings->add_tab_title($v->words("job_desires"),"load_setting_desires()");
			$tab_settings->add_tab_title($v->words("general"),"load_setting_general()");
			$tab_settings->add_tab_title($v->words("membership"),"load_setting_membership()");
			$tab_settings->add_tab_container("<div id='setting_desires'></div>");
			$tab_settings->add_tab_container("<div id='setting_general'></div>");
			$tab_settings->add_tab_container("<div id='setting_membership'></div>");
			$settings_tab = $tab_settings->draw();
		$tab->add_tab_container($settings_tab);
		/**END SETTING**/
		/**DOCUMENTS**/
			$tab_documents = new Tabular("documents");
			$tab_documents->setnoborder();
			$tab_documents->setautorunscript(false);
			$tab_documents->set_tab_width(170);
			$tab_documents->set_area_width(970);
			$tab_documents->set_area_height(730);
			$tab_documents->add_tab_title($v->words("saved_search"),"load_documents_saved_search()");
			$tab_documents->add_tab_title($v->words("saved_opporutnities"),"load_documents_saved_opporunities()");
			$tab_documents->add_tab_title($v->words("applied_opporunities"),"load_documents_applied_opporunities()");
			$tab_documents->add_tab_container("<div id='documents_saved_search'></div>");
			$tab_documents->add_tab_container("<div id='documents_saved_opportunities'></div>");
			$tab_documents->add_tab_container("<div id='documents_applied_opportunities'></div>");
			$documents_tab = $tab_documents->draw();
		$tab->add_tab_container($documents_tab);
		/**END DOCUMENTS**/
		$tab->set_bordercolor("#0CB31D");
		echo $tab->draw();
	?>
	</td></tr></table>
<?php include_once "footer.php"; ?>