<?php 
	include_once "../common.php";
	$user_id = $_GET["user_id"]; $opportunity_id = $_GET["opportunity_id"];
	if($__company_id == "" || $user_id == "" || $opportunity_id == ""){ exit(); }
	$db->addtable("applied_opportunities");$db->where("user_id",$user_id);$db->where("opportunity_id",$opportunity_id);$db->limit(1);
	$applied_opportunities = $db->fetch_data();
	if($applied_opportunities["user_id"] != $user_id || $applied_opportunities["opportunity_id"] != $opportunity_id){ exit(); }
?>
<div class="card">
	<div style="height:20px;" id="title"></div>
	<div style="padding:10px;">
		<h2><b>Process History</b></h2>
		<?php
			echo $t->start("style='width:950px;cursor:pointer;'","","content_data");
			echo $t->header(
						array(
								"no",
								"Transition Status",
								"notes",
								"Updated At",
								"Updated By"
						)
					);
			$db->addtable("applicant_process_history"); $db->where("user_id",$user_id); $db->where("opportunity_id",$opportunity_id);
			$aph_s = $db->fetch_data(true);
			$no=0;
			foreach($aph_s as $aph){
				$no++;
				$transition_status = pipetoarray($aph["status_trans"]);
				$transition_status = $db->fetch_single_data("applicant_status","name",array("id" => $transition_status[0]));
				$transition_status .= " => ".$db->fetch_single_data("applicant_status","name",array("id" => $aph["applicant_status_id"]));
				$updatedby = $db->fetch_single_data("users","email",array("id" => $aph["created_by"]));
				echo $t->row(
					array(
						$no,
						$transition_status,
						$aph["notes"],
						format_tanggal($aph["created_at"],"dMY",true,true),
						$updatedby
					),
					array("style='width:1px;'","style='width:200px;'","style='width:500px;'")
				);
			}
			echo $t->end();
		?>
		<div style="height:20px;"></div>
		<div style="height:20px;" id="title">Change Title</div>
		<div style="height:20px;"></div>
		<div class="seeker_profile_sp_detail">
			<?php
				$last_applicant_status_id = $db->fetch_single_data("applicant_process_history","applicant_status_id",array("user_id" => $user_id,"opportunity_id" => $opportunity_id),array("id DESC"));
				if($last_applicant_status_id == 1){ $arr_change_status = array("0" => "Unviewed","2" => "Qualified","3" => "Denied");}
				if($last_applicant_status_id == 2){ $arr_change_status = array("1" => "Viewed","4" => "Interviewed","5" => "Not Present");}
				if($last_applicant_status_id == 3){ $arr_change_status = array("1" => "Viewed");}
				if($last_applicant_status_id == 4){ $arr_change_status = array("2" => "Qualified","6" => "Hired");}
				if($last_applicant_status_id == 5){ $arr_change_status = array("2" => "Qualified");}
				if($last_applicant_status_id == 6){ $arr_change_status = array("4" => "Interviewed");}
				echo $f->start();
				echo 	$t->start("","","content_data");
				echo 		$t->row(array("Change to"," : ",$f->select("change_status",$arr_change_status)));
				echo 		$t->row(array("Notes"," : ",$f->input("notes")));
				echo 	$t->end();
				echo 	$f->input("save_process_history","Save","type='submit'");
				echo $f->end();
			?>
		</div>
	</div>
</div>