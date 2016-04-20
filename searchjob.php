<?php include_once "searchjob_header.php"; ?>
<?php include_once "searchjob_detail.php"; ?>
<?php include_once "scripts/searchjob_js.php"; ?>
<div style="height:80px;"></div>
<table width="100%"><tr><td align="center">
	<?php
		$rightarea  = "<div class='opportunities_viewing' id='opportunities_viewing'></div><br>";
		$rightarea .= "<div style='height:20px;'></div>";
		$rightarea .= "<div class='opportunities_list' id='opportunities_list'></div>";
		
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
		$sb_work_location = $f->select_box("work_location",$v->words("work_location"),$arrlocations,array(),220,200,998,5,26,12,"grey");
		
		$db->addtable("job_level"); 
		$db->addfield("id");$db->addfield("name_".$__locale); 
		$db->where("id",0,"i",">");$db->order("name_".$__locale);
		foreach ($db->fetch_data() as $key => $arrtemp){ $arrjob_level[$arrtemp[0]] = $arrtemp[1]; }
		$sb_job_level = $f->select_box("job_level",$v->words("job_level"),$arrjob_level,array(),220,200,997,5,26,12,"grey");
		
		$db->addtable("industries"); 
		$db->addfield("id");$db->addfield("name_".$__locale); 
		$db->where("id",0,"i",">");$db->order("name_".$__locale);
		foreach ($db->fetch_data() as $key => $arrtemp){ $arrindustries[$arrtemp[0]] = $arrtemp[1]; }
		$sb_industry = $f->select_box("industries",$v->words("industry"),$arrindustries,array(),220,200,996,5,26,12,"grey");
		
		$db->addtable("degree"); 
		$db->addfield("id");$db->addfield("name_".$__locale); 
		$db->where("id",0,"i",">");$db->order("name_".$__locale);
		foreach ($db->fetch_data() as $key => $arrtemp){ $arrdegree[$arrtemp[0]] = $arrtemp[1]; }
		$sb_degree = $f->select_box("education_level",$v->words("education_level"),$arrdegree,array(),220,80,995,5,26,12,"grey");
		
		for($xx = 0;$xx <= 30;$xx++){
			if($xx == 0) $arrexperience_level[$xx] = "0.5 ".$v->words("years"); else $arrexperience_level[$xx] = $xx." ".$v->words("years");
		}
		$sb_experience = $f->select_box("work_experience",$v->words("work_experience"),$arrexperience_level,array(),220,200,994,5,26,12,"grey");
		
		$leftarea = $t->start();
		$leftarea .= $t->row(array("<br><br>"));
		$leftarea .= $t->row(array($sb_job_function."<br><br>"));
		$leftarea .= $t->row(array($sb_work_location."<br><br>"));
		$leftarea .= $t->row(array($sb_job_level."<br><br>"));
		$leftarea .= $t->row(array($sb_industry."<br><br>"));
		$leftarea .= $t->row(array($sb_degree."<br><br>"));
		$leftarea .= $t->row(array($sb_experience."<br><br>"));
		$leftarea .= $t->end();
	?>
	<?=$t->start("style='width:1000px;' cellpadding='0' cellspacing='0'");?>
		<?=$t->row(array($leftarea,"<div style='width:5px;'></div>",$rightarea),array("valign='top' style='width:250px'","","valign='top' style='width:745px'"));?>
	<?=$t->end();?>
</td></tr></table>
<?php if(isset($_SESSION["errormessage"]) && $_SESSION["errormessage"] != "") { javascript("popup_message('".$_SESSION["errormessage"]."');"); $_SESSION["errormessage"] = ""; } ?>
<?php include_once "searchjob_footer.php"; ?>