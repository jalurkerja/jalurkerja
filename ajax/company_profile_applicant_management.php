<?php
include_once "company_profile_func.php";
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
<?php if($_tabid != ""){ ?>
<?php
	$db->addtable("opportunities");$db->where("id",$_key_id);$db->limit(1); $opportunity = $db->fetch_data();
	$daydiff_toclosing = date_diff(date_create(date("Y-m-d H:i:s")),date_create($opportunity["closing_date"]),true);
	$num_applicant = $db->fetch_single_data("applied_opportunities","count(*)",array("opportunity_id" => $opportunity["id"]));
	?>
	<div class="card">
		<div id="content">
			<div style="border-bottom:1px solid rgba(12, 179, 29, 0.3);"><table><tr><td width="600" valign="top">
				<b style="font-size:14px;"><?=$opportunity["title_".$__locale];?></b><br>
				<?=$db->fetch_single_data("locations","name_".$__locale,array("province_id" => $opportunity["province_id"], "location_id" => $opportunity["location_id"]));?><br>
				<?=format_tanggal($opportunity["posted_at"],"dMY");?> - <?=format_tanggal($opportunity["closing_date"],"dMY");?> <br>
				<?=$daydiff_toclosing->days;?> <?=$v->w("days_before_closing");?>
			</td><td width="100" valign="top" align="center">
				<?php if($opportunity["is_syariah"]){ ?> <div style="position:absolute;left:550px;"><img src="icons/syariah_stamp.png" width="50"></div> <?php } ?>
				<b><?=$v->w("total_applicant");?></b><br><br> <b style="font-size:14px;"><?=$num_applicant;?></b>
			</td></tr></table></div>
			<div style="position:relative;top:25px;width:100%;text-align:right;">
				<script> function shortcut(thisvalue){ load_applicant_management(thisvalue,'<?=$_keyword;?>','<?=$_sort;?>','<?=$_page;?>','<?=$_key_id;?>'); } </script>
				<?php $arrshortcut = array("" => "","quilified" => $v->w("quilified"),"interviewed" => $v->w("interviewed"),"accepted" => $v->w("accepted"),); ?>
				<?=$v->w("shortcut");?> : <?=$f->select("shortcut",$arrshortcut,"","onchange=\"shortcut(this.value);\"");?>
			</div>
			<?php
				include_once "../classes/tabular.php";
				$tab1 = new Tabular("filter_step_1");
				$tab1->set_border_width(1);
				$tab1->set_tab_width(158);
				$tab1->set_area_width(995);
				$tab1->set_area_height(50);
				$tab1->setnoborder();
				$tab1->add_tab_title($v->w("all_applicant"),"load_applicant_management('all_applicant','".$_keyword."','applied_date','1','".$_key_id."');");
				$tab1->add_tab_title($v->w("viewed"),"load_applicant_management('viewed','".$_keyword."','applied_date','1','".$_key_id."');");
				$tab1->add_tab_title($v->w("unviewed"),"load_applicant_management('unviewed','".$_keyword."','applied_date','1','".$_key_id."');");
				$tab1->add_tab_container("<div id='all_applicant'></div>");
				$tab1->add_tab_container("<div id='viewed'></div>");
				$tab1->add_tab_container("<div id='unviewed'></div>");
				$tab1->set_bordercolor("#0CB31D");
				$tab1->setautorunscript(false);
				echo $tab1->draw();
			?>
			<?php if($_tabid == "all_applicant"){ ?>
				<script> tab_toggle_filter_step_1('0');</script>
				<?=company_profile_applicant_management_list($_key_id,$_tabid,$_keyword,$_sort,$_page);?>
			<?php } ?>
			<?php if($_tabid == "viewed" || $_tabid == "quilified" || $_tabid == "denied" || $_tabid == "quilified" || $_tabid == "interviewed" || $_tabid == "not_present" || $_tabid == "accepted"){ ?>
				<script> tab_toggle_filter_step_1('1'); </script>
				<?php
					$tab2 = new Tabular("filter_step_2");
					$tab2->set_border_width(1);
					$tab2->set_tab_width(158);
					$tab2->set_area_width(995);
					$tab2->set_area_height(50);
					$tab2->setnoborder();
					$tab2->add_tab_title($v->w("viewed"),"load_applicant_management('viewed','".$_keyword."','created_at','1','".$_key_id."');");
					$tab2->add_tab_title($v->w("quilified"),"load_applicant_management('quilified','".$_keyword."','created_at','1','".$_key_id."');");
					$tab2->add_tab_title($v->w("denied"),"load_applicant_management('denied','".$_keyword."','created_at','1','".$_key_id."');");
					$tab2->add_tab_container("<div id='viewed'></div>");
					$tab2->add_tab_container("<div id='quilified'></div>");
					$tab2->add_tab_container("<div id='denied'></div>");
					$tab2->set_bordercolor("#0CB31D");
					$tab2->setautorunscript(false);
					echo $tab2->draw();
				?>
				<?php if($_tabid == "viewed"){ ?>
					<script> tab_toggle_filter_step_2('0');</script>
					<?=company_profile_applicant_management_list($_key_id,$_tabid,$_keyword,$_sort,$_page);?>
				<?php } ?>
				<?php if($_tabid == "quilified" || $_tabid == "interviewed" || $_tabid == "not_present" || $_tabid == "accepted"){ ?>
					<script> tab_toggle_filter_step_2('1');</script>
					<?php
						$tab3 = new Tabular("filter_step_3");
						$tab3->set_border_width(1);
						$tab3->set_tab_width(158);
						$tab3->set_area_width(995);
						$tab3->set_area_height(50);
						$tab3->setnoborder();
						$tab3->add_tab_title($v->w("quilified"),"load_applicant_management('quilified','".$_keyword."','created_at','1','".$_key_id."');");
						$tab3->add_tab_title($v->w("interviewed"),"load_applicant_management('interviewed','".$_keyword."','created_at','1','".$_key_id."');");
						$tab3->add_tab_title($v->w("not_present"),"load_applicant_management('not_present','".$_keyword."','created_at','1','".$_key_id."');");
						$tab3->add_tab_container("<div id='quilified'></div>");
						$tab3->add_tab_container("<div id='interviewed'></div>");
						$tab3->add_tab_container("<div id='not_present'></div>");
						$tab3->set_bordercolor("#0CB31D");
						$tab3->setautorunscript(false);
						echo $tab3->draw();
					?>
					<?php if($_tabid == "quilified"){ ?>
						<script> tab_toggle_filter_step_3('0');</script>
						<?=company_profile_applicant_management_list($_key_id,$_tabid,$_keyword,$_sort,$_page);?>
					<?php } ?>
					<?php if($_tabid == "interviewed" || $_tabid == "accepted"){ ?>
						<script> tab_toggle_filter_step_3('1');</script>
						<?php
							$tab4 = new Tabular("filter_step_4");
							$tab4->set_border_width(1);
							$tab4->set_tab_width(158);
							$tab4->set_area_width(995);
							$tab4->set_area_height(50);
							$tab4->setnoborder();
							$tab4->add_tab_title($v->w("interviewed"),"load_applicant_management('interviewed','".$_keyword."','created_at','1','".$_key_id."');");
							$tab4->add_tab_title($v->w("accepted"),"load_applicant_management('accepted','".$_keyword."','created_at','1','".$_key_id."');");
							$tab4->add_tab_container("<div id='interviewed'></div>");
							$tab4->add_tab_container("<div id='accepted'></div>");
							$tab4->set_bordercolor("#0CB31D");
							$tab4->setautorunscript(false);
							echo $tab4->draw();
						?>
						<?php if($_tabid == "interviewed"){ ?>
							<script> tab_toggle_filter_step_4('0');</script>
							<?=company_profile_applicant_management_list($_key_id,$_tabid,$_keyword,$_sort,$_page);?>
						<?php } ?>
						<?php if($_tabid == "accepted"){ ?>
							<script> tab_toggle_filter_step_4('1');</script>
							<?=company_profile_applicant_management_list($_key_id,$_tabid,$_keyword,$_sort,$_page);?>
						<?php } ?>
					<?php } ?>
					<?php if($_tabid == "not_present"){ ?>
						<script> tab_toggle_filter_step_3('2');</script>
						<?=company_profile_applicant_management_list($_key_id,$_tabid,$_keyword,$_sort,$_page);?>
					<?php } ?>
				<?php } ?>
				<?php if($_tabid == "denied"){ ?>
					<script> tab_toggle_filter_step_2('2');</script>
					<?=company_profile_applicant_management_list($_key_id,$_tabid,$_keyword,$_sort,$_page);?>
				<?php } ?>
			<?php } ?>
			<?php if($_tabid == "unviewed"){ ?>
				<script> tab_toggle_filter_step_1('2'); </script>
				<?=company_profile_applicant_management_list($_key_id,$_tabid,$_keyword,$_sort,$_page);?>
			<?php } ?>
			
		</div>
	</div>
<?php } ?>