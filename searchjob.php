<?php include_once "searchjob_header.php"; ?>
<?php include_once "searchjob_detail.php"; ?>
<?php include_once "scripts/searchjob_js.php"; ?>
<div style="height:80px;"></div>
<table width="100%"><tr><td align="center">
	<?php
		$arr_sort_by = array("posted_at DESC" => $v->w("posting_date"),
							 "name" => $v->w("company_name")." (A-Z)",
							 "name DESC" => $v->w("company_name")." (Z-A)",
							 "salary_min" => $v->w("salary_asc"),
							 "salary_max DESC" => $v->w("salary_desc"));
		$rightarea  = "<div class='whitecard' style='text-align:right'>";
		$rightarea .= $v->w("sort_by")." ".$f->select("sort_by",$arr_sort_by,"","onchange='changeorder(this.value);'");
		$rightarea .= "</div><br>";
		$rightarea .= "<div class='whitecard' style='min-height:340px;'>";
		$rightarea .= "<div class='opportunities_list' id='opportunities_list'></div>";
		$rightarea .= "</div><br>";
		$rightarea .= "<div id='paging_area'>";
		$rightarea .= "</div>";
		
		$keyword_placeholder = $v->words("keyword")." (".$v->words("job_level").", ".$v->words("company_name").", ".$v->words("etc").")";
		$txt_keyword = $f->input("keyword",$_GET["keyword"],"placeholder='".$keyword_placeholder."'  onkeyup=\"if(event.keyCode == 13){ serach_btn_click(); }\" style='width:217px;'","search_area_input");
		
		$f->add_config_selectbox("table","job_functions");$f->add_config_selectbox("id","id");$f->add_config_selectbox("caption","name_".$__locale);
		$f->add_config_selectbox("where",array("id" => "0:>"));$f->add_config_selectbox("order",array("name_".$__locale));
		$sb_job_function = $f->select_box_ajax("job_function",$v->words("job_function"),array_swap($_GET["job_function"]),220,200,999,5,26,12,"grey");
		
		
		$db->addtable("locations"); 
		$db->addfield("province_id");$db->addfield("location_id");$db->addfield("name_".$__locale);
		$db->where("id",1,"i",">");$db->order("seqno");
		foreach ($db->fetch_data() as $key => $arrlocation){
			if($arrlocation[1]>0){
				$arrlocations[$arrlocation[0].":".$arrlocation[1]] = "&nbsp;&nbsp;".$arrlocation[2];
			} else {
				$arrlocations[$arrlocation[0].":".$arrlocation[1]] = "<b>".$arrlocation[2]."</b>";
			}
		}
		$sb_work_location = $f->select_box("work_location",$v->words("work_location"),$arrlocations,array_swap($_GET["work_location"]),220,200,998,5,26,12,"grey");
		
		$f->add_config_selectbox("table","job_level");$f->add_config_selectbox("id","id");$f->add_config_selectbox("caption","name_".$__locale);$f->add_config_selectbox("where",array("id" => "0:>"));
		$sb_job_level = $f->select_box_ajax("job_level",$v->words("job_level"),array_swap($_GET["job_level"]),220,200,997,5,26,12,"grey");
		
		$f->add_config_selectbox("table","industries");$f->add_config_selectbox("id","id");$f->add_config_selectbox("caption","name_".$__locale);$f->add_config_selectbox("where",array("id" => "0:>"));$f->add_config_selectbox("order",array("name_".$__locale));
		$sb_industry = $f->select_box_ajax("industries",$v->words("industry"),array_swap($_GET["industries"]),220,200,996,5,26,12,"grey");
		
		$f->add_config_selectbox("table","degree");$f->add_config_selectbox("id","id");$f->add_config_selectbox("caption","name_".$__locale);$f->add_config_selectbox("where",array("id" => "0:>"));
		$sb_degree = $f->select_box_ajax("education_level",$v->words("education_level"),array_swap($_GET["education_level"]),220,200,995,5,26,12,"grey");
		
		for($xx = 0;$xx <= 30;$xx++){
			if($xx == 0) $arrexperience_level[$xx] = "0.5 ".$v->words("years"); else $arrexperience_level[$xx] = $xx." ".$v->words("years");
		}
		$sb_experience = $f->select_box("work_experience",$v->words("work_experience"),$arrexperience_level,array_swap($_GET["work_experience"]),220,200,994,5,26,12,"grey");
		
		$f->add_config_selectbox("table","job_type");$f->add_config_selectbox("id","id");$f->add_config_selectbox("caption","name_".$__locale);$f->add_config_selectbox("where",array("id" => "0:>"));
		$sb_job_type = $f->select_box_ajax("job_type",$v->words("job_type"),array_swap($_GET["job_type"]),220,200,993,5,26,12,"grey");
		
		$db->addtable("salaries"); 
		$db->addfield("id");$db->addfield("salary"); $db->order("id");
		$arrsalariesfrom[0] = $v->words("salary")." ".$v->words("from");
		$arrsalariesto[0] = $v->words("salary")." ".$v->words("to");
		foreach ($db->fetch_data() as $key => $arrsalary){
			$arrsalariesfrom[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
			$arrsalariesto[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
		}
		
		$sel_salaries  = $f->select("salary_from",$arrsalariesfrom,$_GET["salary_from"],"","search_area_select");
		$sel_salaries .= " - ".$f->select("salary_to",$arrsalariesto,$_GET["salary_to"],"","search_area_select");
		
		$checked = ($_GET["chk_syariah"] == 1) ? "checked" : "";
		$box_syariah = $v->w("show_only_syariah_opportunities")." ".$f->input("chk_syariah","1","type='checkbox' $checked");
		$checked = ($_GET["chk_fresh_graduate"] == 1) ? "checked" : "";
		$box_fresh_graduate = $v->w("show_fresh_graduate_opportunities")." ".$f->input("chk_fresh_graduate","1","type='checkbox' $checked");
		$btn_search = $f->input("search",$v->w("search"),'type="button" onclick="serach_btn_click();"',"btn_sign");
		
		$leftarea  = "<div style='position:fixed;'>";
		$leftarea .= 	"<div class='whitecard' style='position:relative;left:-35px;'>";
		$leftarea .= 		$f->start("searchjob_form","","","onsubmit='return false;'");
		$leftarea .= 			$f->input("searchjobpage_searching","1","type='hidden'");
		$leftarea .= 			$f->input("searchjob_page","1","type='hidden'");
		$leftarea .= 			$f->input("searchjob_order","","type='hidden'");
		$leftarea .= 			$t->start();
		$leftarea .= 			$t->row(array($v->w("ultimate_search")."<br>"),array("class='common_title'",""));
		$leftarea .= 			$t->row(array($txt_keyword));
		$leftarea .= 			$t->row(array($sb_job_function."<div style='height:23px;'></div>"));
		$leftarea .= 			$t->row(array($sb_work_location."<div style='height:23px;'></div>"));
		$leftarea .= 			$t->row(array($sb_job_level."<div style='height:23px;'></div>"));
		$leftarea .= 			$t->row(array($sb_industry."<div style='height:23px;'></div>"));
		$leftarea .= 			$t->row(array($sb_degree."<div style='height:23px;'></div>"));
		$leftarea .= 			$t->row(array($sb_experience."<div style='height:23px;'></div>"));
		$leftarea .= 			$t->row(array($sb_job_type."<div style='height:23px;'></div>"));
		$leftarea .= 			$t->row(array($sel_salaries."<br>"));
		$leftarea .= 			$t->row(array($box_syariah."<br>"),array("align='right'"));
		$leftarea .= 			$t->row(array($box_fresh_graduate."<br>"),array("align='right'"));
		$leftarea .= 			$t->row(array($btn_search."<br>"),array("align='right'"));
		$leftarea .= 			$t->end();
		$leftarea .= 		$f->end();
		$leftarea .= 	"</div>";
		$leftarea .= "</div>";
		
		$search_criteria  = "<div style='position:relative;' id='search_criteria'>";
		$search_criteria .= "</div>";
	?>
	<?=$t->start("style='width:1000px;' cellpadding='0' cellspacing='0'");?>
		<?=$t->row(array($leftarea,"<div style='width:15px;'></div>",$rightarea,"<div style='width:15px;'></div>",$search_criteria),array("valign='top' style='width:250px'","","valign='top' style='width:500px'","","valign='top' style='width:200px'"));?>
	<?=$t->end();?>
</td></tr></table>
<?php if(isset($_SESSION["errormessage"]) && $_SESSION["errormessage"] != "") { javascript("popup_message('".$_SESSION["errormessage"]."');"); $_SESSION["errormessage"] = ""; } ?>
<?php include_once "searchjob_footer.php"; ?>