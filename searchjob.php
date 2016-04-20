<?php include_once "searchjob_header.php"; ?>
<?php include_once "searchjob_detail.php"; ?>
<?php include_once "scripts/searchjob_js.php"; ?>
<div style="height:80px;"></div>
<table width="100%"><tr><td align="center">
	<?php
		$arr_sort_by = array("posting_date" => $v->w("posting_date"),
							 "company_name_asc" => $v->w("company_name")." (A-Z)",
							 "company_name_desc" => $v->w("company_name")." (Z-A)",
							 "salary_asc" => $v->w("salary_asc"),
							 "salary_desc" => $v->w("salary_desc"));
		$rightarea  = "<div class='whitecard' style='text-align:right'>";
		$rightarea .= $v->w("sort_by")." ".$f->select("sort_by",$arr_sort_by,@$_GET["sort_by"]);
		$rightarea .= "</div><br>";
		$rightarea .= "<div class='whitecard'>";
		$rightarea .= "<div class='opportunities_viewing' id='opportunities_viewing'></div><br>";
		$rightarea .= "<div class='opportunities_list' id='opportunities_list'></div>";
		$rightarea .= "</div>";
		
		$keyword_placeholder = $v->words("keyword")." (".$v->words("job_level").", ".$v->words("company_name").", ".$v->words("etc");
		$txt_keyword = $f->input("keyword","","placeholder='".$keyword_placeholder.")' style='width:217px;'","search_area_input");
		
		$arrjob_functions = $db->fetch_select_data("job_functions","id","name_".$__locale,array("id" => "0:>"));
		$sb_job_function = $f->select_box("job_function",$v->words("job_function"),$arrjob_functions,array(),220,200,999,5,26,12,"grey");
		
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
		$sb_work_location = $f->select_box("work_location",$v->words("work_location"),$arrlocations,array(),220,200,998,5,26,12,"grey");
		
		$arrjob_level = $db->fetch_select_data("job_level","id","name_".$__locale,array("id" => "0:>"));
		$sb_job_level = $f->select_box("job_level",$v->words("job_level"),$arrjob_level,array(),220,200,997,5,26,12,"grey");
		
		$arrindustries = $db->fetch_select_data("industries","id","name_".$__locale,array("id" => "0:>"));
		$sb_industry = $f->select_box("industries",$v->words("industry"),$arrindustries,array(),220,200,996,5,26,12,"grey");
		
		$arrdegree = $db->fetch_select_data("degree","id","name_".$__locale,array("id" => "0:>"));
		$sb_degree = $f->select_box("education_level",$v->words("education_level"),$arrdegree,array(),220,80,995,5,26,12,"grey");
		
		for($xx = 0;$xx <= 30;$xx++){
			if($xx == 0) $arrexperience_level[$xx] = "0.5 ".$v->words("years"); else $arrexperience_level[$xx] = $xx." ".$v->words("years");
		}
		$sb_experience = $f->select_box("work_experience",$v->words("work_experience"),$arrexperience_level,array(),220,200,994,5,26,12,"grey");
		
		$arrjob_type= $db->fetch_select_data("job_type","id","name_".$__locale);
		$sb_job_type = $f->select_box("job_type",$v->words("job_type"),$arrjob_type,array(),220,80,995,5,26,12,"grey");
		
		$db->addtable("salaries"); 
		$db->addfield("id");$db->addfield("salary"); $db->order("id");
		$arrsalariesfrom[0] = $v->words("salary")." ".$v->words("from");
		$arrsalariesto[0] = $v->words("salary")." ".$v->words("to");
		foreach ($db->fetch_data() as $key => $arrsalary){
			$arrsalariesfrom[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
			$arrsalariesto[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
		}
		
		$sel_salaries  = $f->select("salary_from",$arrsalariesfrom,"","","search_area_select");
		$sel_salaries .= " - ".$f->select("salary_to",$arrsalariesto,"","","search_area_select");
		
		$box_syariah = $v->w("show_only_syariah_opportunities")." ".$f->input("chk_syariah","1","type='checkbox'");
		$box_fresh_graduate = $v->w("show_fresh_graduate_opportunities")." ".$f->input("chk_fresh_graduate","1","type='checkbox'");
		$btn_search = $f->input("",$v->words("search"),'type="button"',"btn_sign");
		
		$leftarea  = "<div style='position: fixed;'>";
		$leftarea .= 	"<div class='whitecard'>";
		$leftarea .= 		$t->start();
		$leftarea .= 		$t->row(array($v->w("ultimate_search")."<br>"),array("class='common_title'",""));
		$leftarea .= 		$t->row(array($txt_keyword."<div style='height:7px;'></div>"));
		$leftarea .= 		$t->row(array($sb_job_function."<br><br>"));
		$leftarea .= 		$t->row(array($sb_work_location."<br><br>"));
		$leftarea .= 		$t->row(array($sb_job_level."<br><br>"));
		$leftarea .= 		$t->row(array($sb_industry."<br><br>"));
		$leftarea .= 		$t->row(array($sb_degree."<br><br>"));
		$leftarea .= 		$t->row(array($sb_experience."<br><br>"));
		$leftarea .= 		$t->row(array($sb_job_type."<br><br>"));
		$leftarea .= 		$t->row(array($sel_salaries."<br>"));
		$leftarea .= 		$t->row(array($box_syariah."<br>"),array("align='right'"));
		$leftarea .= 		$t->row(array($box_fresh_graduate."<br><br>"),array("align='right'"));
		$leftarea .= 		$t->row(array($btn_search."<br>"),array("align='right'"));
		$leftarea .= 		$t->end();
		$leftarea .= 	"</div>";
		$leftarea .= "</div>";
	?>
	<?=$t->start("style='width:1000px;' cellpadding='0' cellspacing='0'");?>
		<?=$t->row(array($leftarea,"<div style='width:15px;'></div>",$rightarea,""),array("valign='top' style='width:250px'","","valign='top' style='width:500px'","valign='top' style='width:200px'"));?>
	<?=$t->end();?>
</td></tr></table>
<?php if(isset($_SESSION["errormessage"]) && $_SESSION["errormessage"] != "") { javascript("popup_message('".$_SESSION["errormessage"]."');"); $_SESSION["errormessage"] = ""; } ?>
<?php include_once "searchjob_footer.php"; ?>