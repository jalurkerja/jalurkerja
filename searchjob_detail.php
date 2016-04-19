<?php
$searchjob_detail = '
<div class="opportunity_detail_container">
	<div id="head">
		<div id="description">
';

$searchjob_detail .= $t->start();
$searchjob_detail .= $t->row(array($v->words("company_name"),":","<div id='opportunity___name'></div>"),array("id='td1'","id='td2'"));
$searchjob_detail .= $t->row(array($v->words("industry"),":","<div id='opportunity___industry'></div>"),array("id='td1'","id='td2'"));
$searchjob_detail .= $t->row(array($v->words("web"),":","<div id='opportunity___web'></div>"),array("id='td1'","id='td2'"));
$searchjob_detail .= $t->row(array($v->words("contact_person"),":","<div id='opportunity___contact_person'></div>"),array("id='td1'","id='td2'"));
$searchjob_detail .= $t->row(array("<u>".$v->words("description")."</u>","",""),array("id='td1'",""));
$searchjob_detail .= $t->row(array("<div id='opportunity___description'></div>"),array("colspan='3'"));
$searchjob_detail .= $t->end();

$searchjob_detail .= '
		</div>
		<div id="opportunity___logo"></div>
	</div>
	<div id="main_content">
		<div id="opportunity___title"></div>
		<div style="position:relative;height:20px;"></div>
';

$searchjob_detail .= $t->start();
$searchjob_detail .= $t->row(array($v->words("function"),"","<div id='opportunity___job_function'></div>"),array("id='td1'","id='td2'","id='td3'"));
$searchjob_detail .= $t->row(array($v->words("job_level"),"","<div id='opportunity___job_levels'></div>"),array("id='td1'","id='td2'","id='td3'"));
$searchjob_detail .= $t->row(array($v->words("education_level"),"","<div id='opportunity___degree'></div>"),array("id='td1'","id='td2'","id='td3'"));
$searchjob_detail .= $t->row(array($v->words("major"),"","<div id='opportunity___majors'></div>"),array("id='td1'","id='td2'","id='td3'"));
$searchjob_detail .= $t->row(array($v->words("work_experience"),"","<div id='opportunity___work_experience'></div>"),array("id='td1'","id='td2'","id='td3'"));
$searchjob_detail .= $t->row(array($v->words("salary_offer"),"","<div id='opportunity___salary_offer'></div>"),array("id='td1'","id='td2'","id='td3'"));
$searchjob_detail .= $t->row(array($v->words("posted_date"),"","<div id='opportunity___posted_date'></div>"),array("id='td1'","id='td2'","id='td3'"));
$searchjob_detail .= $t->row(array($v->words("closing_date"),"","<div id='opportunity___closing_date'></div>"),array("id='td1'","id='td2'","id='td3'"));
$searchjob_detail .= $t->end();

$searchjob_detail .= '<div class="jobtools_area">';
$searchjob_detail .= '	<div>';
$searchjob_detail .= '		<div id="applybtn1" class="jobtools_btn" onclick="apply(opportunity__id.innerHTML);">Apply</div><br>';
$searchjob_detail .= '		<div id="savebtn" class="jobtools_btn" onclick="save(opportunity__id.innerHTML);">Save</div><br>';
$searchjob_detail .= '		<div id="sharebtn" class="jobtools_btn">Share</div><br>';
$searchjob_detail .= '		<div id="printbtn" class="jobtools_btn">Print</div><br>';
$searchjob_detail .= '	</div>';
$searchjob_detail .= '</div>';//jobtools_area

$searchjob_detail .= '<div id="description_detail">';
$searchjob_detail .= '	<div id="title">'.$v->words("description").'</div>';
$searchjob_detail .= '	<div id="opportunity___descriptions"></div>';
$searchjob_detail .= '	<div id="title">'.$v->words("requirements").'</div>';
$searchjob_detail .= '	<div id="opportunity___requirements"></div>';
$searchjob_detail .= '</div>'; //description_detail

$searchjob_detail .= '<div class="jobtools-bottom"><div><div id="applybtn2" class="jobtools_btn" onclick="apply(opportunity__id.innerHTML);">Apply</div></div></div>';

$searchjob_detail .= '</div>';//main_content
$searchjob_detail .= '</div>';//opportunity_detail_container
?>