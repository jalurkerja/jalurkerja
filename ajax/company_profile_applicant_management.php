<?php
$_key_id = $_GET["key_id"];
$_tabid = $_GET["tabid"];
$_keyword = $_GET["keyword"];
$_sort = $_GET["sort"];
$_page = $_GET["page"];
?>
<script> function changepage(page){ load_applicant_management("<?=$_tabid;?>","<?=$_keyword;?>","<?=$_sort;?>",page,"<?=$_key_id;?>"); } </script>
<?php if($_tabid == ""){ ?>
	<div class="card">
		<div id="title">
			<?=$v->w("search_your_ads");?> : 
			<?=$f->input("keyword",$_keyword,"onkeyup=\"if(event.keyCode == 13){ load_applicant_management('',this.value,'posted_at DESC','1'); }\"","search_area_input");?>
			<?php $arrsortby = array("posted_at DESC" => $v->w("posted_date")." (Z - A)",
									 "posted_at" => $v->w("posted_date")." (A - Z)",
									 "closing_date DESC" => $v->w("closing_date")." (Z - A)",
									 "closing_date" => $v->w("closing_date")." (A - Z)",
									 "created_at DESC" => $v->w("created_at")." (Z - A)",
									 "created_at" => $v->w("created_at")." (A - Z)"
									);?>
			<div style="position:relative;float:right;"><?=$v->w("sort_by");?> : <?=$f->select("orderby",$arrsortby,$_sort,"onchange=\"load_applicant_management('',keyword.value,this.value,'1');\"");?>&nbsp;&nbsp;&nbsp;</div>
		</div>
		<div id="content">
			<table><tr>
				<td><div style="width:20px;"></div></td>
				<td valign="top" style="width:700px;">
					<?php
						$whereclause = "company_id = '".$__company_id."'";
						if($_keyword != "") $whereclause .= " AND (title_id LIKE '%$_keyword%' OR title_en LIKE '%$_keyword%' OR requirement LIKE '%$_keyword%' OR description LIKE '%$_keyword%')";
						//counting//
						$db->addtable("opportunities"); if($whereclause != "") $db->awhere($whereclause); $db->limit(300);//di kasih limit biar ga kepanjangan pagingnya
						$maxrow = count($db->fetch_data(true)) * 1;
						if(isset($_page)) $_page = $_page * 1;if($_page == 0) $_page = 1;
						//end counting//
					
						if($maxrow > 0){
							//loading//
							$db->addtable("opportunities"); if($whereclause != "") $db->awhere($whereclause);
							$start = getStartRow($_page,$db->searchjob_limit); $db->limit($start.",".$db->searchjob_limit);
							if($_sort == "" || !isset($_sort)) $_sort = "posted_at DESC"; $db->order($_sort);
							$opportunities = $db->fetch_data(true);
							//end loading//
							
							foreach($opportunities as $key => $opportunity){ ?>
								<?php		
									$daydiff_toclosing = date_diff(date_create(date("Y-m-d H:i:s")),date_create($opportunity["closing_date"]),true);
									$num_applicant = $db->fetch_single_data("applied_opportunities","count(*)",array("opportunity_id" => $opportunity["id"]));
								?>
								<div class="seeker_profile_sp_detail greencard_hover" style="width:700px;" onclick="load_applicant_management('all_applicant','','','1','<?=$opportunity["id"];?>');">
									<table><tr><td width="600" valign="top">
										<b style="font-size:14px;"><?=$opportunity["title_".$__locale];?></b><br>
										<?=$db->fetch_single_data("locations","name_".$__locale,array("province_id" => $opportunity["province_id"], "location_id" => $opportunity["location_id"]));?><br>
										<?=format_tanggal($opportunity["posted_at"],"dMY");?> - <?=format_tanggal($opportunity["closing_date"],"dMY");?> <br>
										<?=$daydiff_toclosing->days;?> <?=$v->w("days_before_closing");?>
									</td><td width="100" valign="top" align="center">
										<?php if($opportunity["is_syariah"]){ ?> <div style="position:absolute;left:550px;"><img src="icons/syariah_stamp.png" width="50"></div> <?php } ?>
										<b><?=$v->w("total_applicant");?></b><br><br> <b style="font-size:14px;"><?=$num_applicant;?></b>
									</td></tr></table>
								</div>
								<div style="height:10px;"></div>
							<?php } ?>
							
							<div style="height:10px;"></div>
							<div class="whitecard" style="width:700px;text-align:center;"><?=paging($db->searchjob_limit,$maxrow,$_page,"paging"); ?></div>
					<?php
						}
					?>
				</td>
				<td><div style="width:10px;"></div></td>
				<td valign="top" style="width:220px;">
					<?php 
						$logo = $db->fetch_single_data("company_profiles","logo",array("id" => $__company_id));
						$logo = ($logo != "" && file_exists("../company_logo/".$logo) > 0) ? $logo  : "no_logo.png";
						$logo = "company_logo/".$logo;
						$expired_post_at = $db->fetch_single_data("company_profiles","expired_post_at",array("id" => $__company_id));
						$expired_search_at = $db->fetch_single_data("company_profiles","expired_search_at",array("id" => $__company_id));
						$created_at = $db->fetch_single_data("company_profiles","created_at",array("id" => $__company_id));
						$now = date("Y-m-d H:i:s");
						if($expired_post_at < $now && $expired_search_at < $now) { $member_status="Not Active"; } else { $member_status="Active"; }
						if($expired_post_at < $expired_search_at) { $end_date = $expired_search_at; } else { $end_date = $expired_post_at; }
						$member_package="No Member";
						$active_date = format_tanggal($created_at,"dMY");
						$end_date = format_tanggal($end_date,"dMY");
						$opportunity_quota = "Unlimited";
						$used_quota = $db->fetch_single_data("opportunities","count(*)",array("company_id" => $__company_id));
					?>
					<div class="whitecard"><br><center><img width="150" src="<?=$logo;?>"></center><br></div>
					<div style="height:10px;"></div>
					<div class="seeker_profile_sp_detail" style="text-align:right;width:200px;">
						<?=$v->w("member_status");?> 	:<br><b><?=$member_status;?></b><br><br>
						<?=$v->w("member_package");?> 	:<br><b><?=$member_package;?></b><br><br>
						<?=$v->w("active_date");?> 		:<br><b><?=$active_date;?></b><br><br>
						<?=$v->w("end_date");?> 		:<br><b><?=$end_date;?></b><br><br>
						<?=$v->w("opportunity_quota");?> :<br><b><?=$opportunity_quota;?></b><br><br>
						<?=$v->w("used_quota");?> 		:<br><b><?=$used_quota;?></b><br>
					</div>
				</td>
			</tr></table>
		</div>
	</div>
	<div style="height:20px;"></div>
<?php } ?>
<?php if($_tabid == "all_applicant"){ ?>
<?php
	$db->addtable("opportunities");$db->where("id",$_key_id);$db->limit(1); $opportunity = $db->fetch_data();
	$daydiff_toclosing = date_diff(date_create(date("Y-m-d H:i:s")),date_create($opportunity["closing_date"]),true);
	$num_applicant = $db->fetch_single_data("applied_opportunities","count(*)",array("opportunity_id" => $opportunity["id"]));
	?>
	<div class="card">
		<div id="content">
			<table><tr><td width="600" valign="top">
				<b style="font-size:14px;"><?=$opportunity["title_".$__locale];?></b><br>
				<?=$db->fetch_single_data("locations","name_".$__locale,array("province_id" => $opportunity["province_id"], "location_id" => $opportunity["location_id"]));?><br>
				<?=format_tanggal($opportunity["posted_at"],"dMY");?> - <?=format_tanggal($opportunity["closing_date"],"dMY");?> <br>
				<?=$daydiff_toclosing->days;?> <?=$v->w("days_before_closing");?>
			</td><td width="100" valign="top" align="center">
				<?php if($opportunity["is_syariah"]){ ?> <div style="position:absolute;left:550px;"><img src="icons/syariah_stamp.png" width="50"></div> <?php } ?>
				<b><?=$v->w("total_applicant");?></b><br><br> <b style="font-size:14px;"><?=$num_applicant;?></b>
			</td></tr></table>
		</div>
	</div>
<?php } ?>