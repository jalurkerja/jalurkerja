<?php include_once "searchjob_header.php"; ?>
<?php include_once "searchjob_detail.php"; ?>
<?php include_once "scripts/searchjob_js.php"; ?>
<div style="height:80px;"></div>
<table width="100%"><tr><td align="center">
	<?php
		$leftarea = "<b class='viewing_search_results'>".$v->words("viewing_search_results")."</b><br>";
		$leftarea .= "<div style='height:10px;'></div>";
		$leftarea .= "<div class='sort_by'>".$v->words("sort_by")."</div>";
		$sort_bys["posting_date"] = $v->words("posting_date");
		$sort_bys["company_name_asc"] = $v->words("company_name")." (A-Z)";
		$sort_bys["company_name_desc"] = $v->words("company_name")." (Z-A)";
		$sort_bys["salary_asc"] = $v->words("salary_asc");
		$sort_bys["salary_desc"] = $v->words("salary_desc");
		$leftarea .= "<div class='sort_by_select'>".$f->select("sort_by",$sort_bys,@$_POST["sort_by"])."</div><br>";
		$leftarea .= "<div class='opportunities_viewing' id='opportunities_viewing'></div><br>";
		$leftarea .= "<div style='height:20px;'></div>";
		$leftarea .= "<div class='opportunities_list' id='opportunities_list'></div>";
		
		$db->addtable("job_functions"); 
		$db->addfield("id");$db->addfield("name_".$__locale); 
		$db->where("id",0,"i",">");$db->order("name_".$__locale);
		foreach ($db->fetch_data() as $key => $arrtemp){ $arrjob_functions[$arrtemp[0]] = $arrtemp[1]; }
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
		$sb_work_location = $f->select_box("work_location",$v->words("work_location"),$arrlocations,array(),220,200,999,5,26,12,"grey");
		
		$db->addtable("job_level"); 
		$db->addfield("id");$db->addfield("name_".$__locale); 
		$db->where("id",0,"i",">");$db->order("name_".$__locale);
		foreach ($db->fetch_data() as $key => $arrtemp){ $arrjob_level[$arrtemp[0]] = $arrtemp[1]; }
		$sb_job_level = $f->select_box("job_level",$v->words("job_level"),$arrjob_level,array(),220,200,999,5,26,12,"grey");
		
		$db->addtable("industries"); 
		$db->addfield("id");$db->addfield("name_".$__locale); 
		$db->where("id",0,"i",">");$db->order("name_".$__locale);
		foreach ($db->fetch_data() as $key => $arrtemp){ $arrindustries[$arrtemp[0]] = $arrtemp[1]; }
		$sb_industry = $f->select_box("industries",$v->words("industry"),$arrindustries,array(),220,200,998,5,26,12,"grey");
		
		$db->addtable("degree"); 
		$db->addfield("id");$db->addfield("name_".$__locale); 
		$db->where("id",0,"i",">");$db->order("name_".$__locale);
		foreach ($db->fetch_data() as $key => $arrtemp){ $arrdegree[$arrtemp[0]] = $arrtemp[1]; }
		$sb_degree = $f->select_box("education_level",$v->words("education_level"),$arrdegree,array(),220,80,998,5,26,12,"grey");
		
		for($xx = 0;$xx <= 30;$xx++){
			if($xx == 0) $arrexperience_level[$xx] = "0.5 ".$v->words("years"); else $arrexperience_level[$xx] = $xx." ".$v->words("years");
		}
		$sb_experience = $f->select_box("work_experience",$v->words("work_experience"),$arrexperience_level,array(),220,200,998,5,26,12,"grey");
		
		$rightarea = $t->start();
		$rightarea .= $t->row(array($sb_job_function,"<div style='width:5px;'></div>",$sb_work_location,"<div style='width:5px;'></div>",$sb_job_level));
		$rightarea .= $t->row(array(""),array("style='height:25px;'"));
		$rightarea .= $t->row(array($sb_industry,"<div style='width:5px;'></div>",$sb_degree,"<div style='width:5px;'></div>",$sb_experience));
		$rightarea .= $t->row(array(""),array("style='height:25px;'"));
		$rightarea .= $t->end();
		$rightarea .= "<div style='display:none' id='opportunity_temp'></div>";
		$rightarea .= "<div class='opportunity_detail' id='opportunity_detail_empty'><div class='empty_result'>".$v->words("empty_result")."</div></div>";
		$rightarea .= "<table><tr><td class='opportunity_detail' id='opportunity_detail'>";
		$rightarea .= $searchjob_detail;
		$rightarea .= "</td></tr></table>";
	?>
	<?=$t->start("style='width:1000px;' cellpadding='0' cellspacing='0'");?>
		<?=$t->row(array($leftarea,"<div style='width:5px;'></div>",$rightarea),array("valign='top' style='width:250px'","","valign='top' style='width:745px'"));?>
	<?=$t->end();?>
</td></tr></table>
<?php if($_SESSION["errormessage"] != "") { javascript("popup_message('".$_SESSION["errormessage"]."');"); $_SESSION["errormessage"] = ""; } ?>
<?php include_once "searchjob_footer.php"; ?>