<?php
include_once "company_profile_func.php";
?>
<script> 
	function load_applicant_management_detail(opportunity_id,userid){
		get_ajax("ajax/company_profile_ajax.php?mode=generate_token&id_key="+userid,"return_generate_token","openwindow('applicant_management_detail.php?opportunity_id="+opportunity_id+"&user_id="+userid+"&token='+global_respon['return_generate_token']);");
	}
</script>
<div class="card">
	<div id="title">
		<?=$v->w("post_your_opportunity_ad");?>
	</div>
	<div id="content">
		<?php if(@$_GET["add_advertising"] == 2){ include_once "company_profile_advertising_add2.php"; } ?>
		<?php 
		$remain_opportunity = $db->fetch_single_data("company_profiles","remain_opportunity",array("id" => $__company_id)) * 1;
		$_remain_opportunity = ($remain_opportunity < 0) ? $v->w("unlimited") : $remain_opportunity;
		echo $v->w("you_still_have_a_quota_of_ads")." : <b>".$_remain_opportunity."</b>";
		include_once "company_profile_advertising_list.php";
		?>
	</div>
</div>
<div style="height:20px;"></div>