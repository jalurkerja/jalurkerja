<?php include_once "head.php";?>
<?php include_once "opportunities_js.php";?>
<?php include_once "../searchjob_detail.php";?>
<div style="display:none" id="opportunity_temp"></div>
<?=$t->start();?>
<?=$t->row(array($searchjob_detail),array("class=\"opportunity_detail\""));?>
<?=$t->end();?>
<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_view","_list",$_SERVER["PHP_SELF"])."';\"");?>
<script> get_ajax("../ajax/searchjob_ajax.php?mode=detail&opportunity_id=<?=$_GET["id"];?>","opportunity_temp","opportunity_detail_parsing();"); </script>
<?php include_once "footer.php";?>