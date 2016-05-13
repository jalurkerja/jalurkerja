<?php include_once "head.php"; ?>
<?php if(!$__company_id) { javascript('popup_message("'.$v->words("please_login_as_company").'","error_message","window.location=\'index.php\';"); '); exit();} ?>
<?php
	$setting_clicked = $db->fetch_single_data("users","setting_clicked",array("id" => $__user_id)) * 1;
	if($setting_clicked < 3) $setting_clicked++;
	$db->addtable("users");$db->where("id",$__user_id);$db->addfield("setting_clicked");$db->addvalue($setting_clicked);$db->update();
?>
<?php include_once "classes/tabular.php"; ?>
<?php include_once "homepage_header.php"; ?>
<?php include_once "scripts/company_profile_js.php"; ?>
<script> $("body").css({"background-color":"white"});</script>
<div style="height:100px;"></div>
	<table width="100%" height="100%"><tr><td align="center" nowrap>
	<table width="1000"><tr><td class="page_title"><?=$v->words("employer_pages");?></td></tr></table>
	<?php
		$tab = new Tabular("employer_pages");
		$tab->set_border_width(2);
		$tab->set_tab_width(158);
		$tab->set_area_width(1000);
		$tab->set_area_height(800);
		$tab->setnoborder();
		$tab->add_tab_title($v->w("company_profile"),"load_profile();");
		$tab->add_tab_title($v->w("applicant_management"),"load_applicant_management();");
		$tab->add_tab_title($v->w("advertising"),"load_advertising();");
		$tab->add_tab_title($v->w("candidate_search"),"load_candidate_search();");
		$tab->add_tab_title($v->w("report"),"load_report();");
		$tab->add_tab_title($v->w("setting"),"load_setting();");
		
		$tab->add_tab_container("<div id='profile'></div>");
		$tab->add_tab_container("<div id='applicant_management'></div>");
		$tab->add_tab_container("<div id='advertising'></div>");
		$tab->add_tab_container("<div id='candidate_search'></div>");
		$tab->add_tab_container("<div id='report'></div>");
		$tab->add_tab_container("<div id='setting'></div>");
		$tab->set_bordercolor("#0CB31D");
		echo $tab->draw();
	?>
	</td></tr></table>
	
<?php 
	if($_GET["mode"] == "load_applicant_management"){ 
	?> <script> 
		tab_toggle_employer_pages('1'); 
		load_applicant_management("<?=$_GET["tabid"];?>","<?=$_GET["keyword"];?>","<?=$_GET["sort"];?>","<?=$_GET["page"];?>","<?=$_GET["key_id"];?>");
	</script> <?php 
	} 
	if($_GET["mode"] == "load_advertising"){ ?> <script> tab_toggle_employer_pages('2'); load_advertising("<?=str_replace("mode=load_advertising","",$_SERVER["QUERY_STRING"]);?>"); </script> <?php  } 
?>
<?php include_once "footer.php"; ?>