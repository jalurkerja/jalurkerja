
<?php
    include "head.php";
	
	$f->add_config_selectbox("table","job_functions");
	$f->add_config_selectbox("id","id");
	$f->add_config_selectbox("caption","name_en");
	$f->add_config_selectbox("where",array("id" => "0:>"));
	echo $f->select_box_ajax("job_function",$v->words("job_function"),array(),220,200,999,5,26,12,"grey");
?>