<?php
$edit_company_profile = ($_mode == "edit_company_profile") ? true : false;
$edit_company_description = ($_mode == "edit_company_description") ? true : false;
$edit_company_join_reason = ($_mode == "edit_company_join_reason") ? true : false;
		
$db->addtable("company_profiles"); $db->where("id",$__company_id); $db->limit(1); $arr_company_profiles = $db->fetch_data();
?>
<div class="card">
	<div id="title">
		<?=$v->w("company_header_image");?>
		<div style="float:right"><?=$f->input("edit",$v->w("edit"),"type='button' onclick='edit_header_image();'","btn_post");?></div>
	</div>
	<div id="content">
		<?php
			$header_image = $arr_company_profiles["header_image"];
			$header_image = ($header_image != "" && file_exists("../company_header/".$header_image) > 0) ? $header_image  : "nocompanyheader.png";
			$header_image = "company_header/".$header_image;
		?>
		<center><img src="<?=$header_image;?>" height="150"></center>
	</div>
</div>
<div style="height:20px;"></div>

<div class="card">
	<div id="title"><?=$v->w("company_profile");?></div>
	<div id="content">
		<?php
			$db->addtable("locations"); $db->addfield("name_".$__locale); 
			$db->where("province_id",@$arr_company_profiles["province_id"]); $db->where("location_id",@$arr_company_profiles["location_id"]);$db->limit(1);
			$location = $db->fetch_data(false,0);
			
			$rows = array();
			if(!$edit_company_profile){
				$rows[] = array($v->w("company_name"),@$arr_company_profiles["name"]);
				$rows[] = array($v->w("company_address"),chr13tobr(@$arr_company_profiles["address"]));
				$rows[] = array($v->w("location"),$location);
				$rows[] = array($v->w("zipcode"),@$arr_company_profiles["zipcode"]);
				$rows[] = array($v->w("industry"),$db->fetch_single_data("industries","name_".$__locale,array("id" => @$arr_company_profiles["industry_id"])));
				$rows[] = array($v->w("phone"),@$arr_company_profiles["phone"]);
				$rows[] = array($v->w("fax"),@$arr_company_profiles["fax"]);
				$rows[] = array($v->w("email"),@$arr_company_profiles["email"]);
				$rows[] = array($v->w("web"),@$arr_company_profiles["web"]);
				$rows[] = array($v->w("company_pic"),$v->capitalize(@$arr_company_profiles["first_name"]." ".@$arr_company_profiles["middle_name"]." ".@$arr_company_profiles["last_name"]));
			} else {				
				$arrlocations 		= fetch_locations();				
				$rows[] = array($v->w("company_name"),$f->input("name",@$arr_company_profiles["name"]));
				$rows[] = array($v->w("company_address"),$f->textarea("address",@$arr_company_profiles["address"]));
				$rows[] = array($v->w("location"),$f->select("location",$arrlocations,@$arr_company_profiles["province_id"].":".@$arr_company_profiles["location_id"]));
				$rows[] = array($v->w("zipcode"),$f->input("zipcode",@$arr_company_profiles["zipcode"]));
				$rows[] = array($v->w("industry"),$f->select("industry_id",$db->fetch_select_data("industries","id","name_".$__locale),@$arr_company_profiles["industry_id"]));
				$rows[] = array($v->w("phone"),$f->input("phone",@$arr_company_profiles["phone"]));
				$rows[] = array($v->w("fax"),$f->input("fax",@$arr_company_profiles["fax"]));
				$rows[] = array($v->w("email"),$f->input("email",@$arr_company_profiles["email"]));
				$rows[] = array($v->w("web"),$f->input("web",@$arr_company_profiles["web"]));
				$rows[] = array("PIC ".$v->w("first_name"),$f->input("first_name",@$arr_company_profiles["first_name"]));
				$rows[] = array("PIC ".$v->w("middle_name"),$f->input("middle_name",@$arr_company_profiles["middle_name"]));
				$rows[] = array("PIC ".$v->w("last_name"),$f->input("last_name",@$arr_company_profiles["last_name"]));
			}
			$btn_edit_company_profile = $t->row(array($f->input("edit",$v->w("edit"),"type='button' onclick=\"edit_company_profile();\"","btn_post")),array("align='right'"));
			$btn_save_cancel_company_profile = $t->row(
												array(
													$f->input("save",$v->w("save"),"type='button' onclick=\"save_company_profile();\"","btn_post")." ".
													$f->input("cancel",$v->w("cancel"),"type='button' onclick=\"load_profile();\"","btn_post")
												),
												array("align='right'")
											);
			
			$nav_company_profile = (!$edit_company_profile) ? $btn_edit_company_profile : $btn_save_cancel_company_profile;
			$nav_company_profile = $t->start("","","navigation") . $nav_company_profile . $t->end();
		?>		
		<table width="100%"><tr><td align="center">
			<?=(!$edit_company_profile) ? $nav_company_profile : "";?>
			<?=$f->start("company_profile_form");?>
				<?=$f->input("saving_company_profile_form","1","type='hidden'");?>
				<?=$t->start("","","content_data");?>
				<?php foreach($rows as $row) { echo $t->row($row); } ?>
				<?=$t->end();?>
			<?=$f->end();?>
			<?=($edit_company_profile) ? $nav_company_profile : "";?>
		</td></tr></table>
	</div>
</div>
<div style="height:20px;"></div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div class="card">
	<div id="title"><?=$v->w("company_description");?></div>
	<div id="content">
		<?php			
			$rows = array();
			if(!$edit_company_description){
				$rows[] = array(chr13tobr(@$arr_company_profiles["description"]));
			} else {
				$rows[] = array($f->textarea("description",@$arr_company_profiles["description"],"style='width:680px;height:200px;'"));
			}
			$btn_edit_company_description = $t->row(array($f->input("edit",$v->w("edit"),"type='button' onclick=\"edit_company_description();\"","btn_post")),array("align='right'"));
			$btn_save_cancel_company_description = $t->row(
												array(
													$f->input("save",$v->w("save"),"type='button' onclick=\"save_company_description();\"","btn_post")." ".
													$f->input("cancel",$v->w("cancel"),"type='button' onclick=\"load_profile();\"","btn_post")
												),
												array("align='right'")
											);
			
			$nav_company_description = (!$edit_company_description) ? $btn_edit_company_description : $btn_save_cancel_company_description;
			$nav_company_description = $t->start("","","navigation") . $nav_company_description . $t->end();
		?>		
		<table width="100%"><tr><td align="center">
			<?=(!$edit_company_description) ? $nav_company_description : "";?>
			<?=$f->start("company_description_form");?>
				<?=$f->input("saving_company_description_form","1","type='hidden'");?>
				<?=$t->start("","","content_data");?>
				<?php foreach($rows as $row) { echo $t->row($row); } ?>
				<?=$t->end();?>
			<?=$f->end();?>
			<?=($edit_company_description) ? $nav_company_description : "";?>
		</td></tr></table>
	</div>
</div>
<div style="height:20px;"></div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div class="card">
	<div id="title"><?=$v->w("company_join_reason");?></div>
	<div id="content">
		<?php			
			$rows = array();
			if(!$edit_company_join_reason){
				$rows[] = array(chr13tobr(@$arr_company_profiles["join_reason"]));
			} else {
				$rows[] = array($f->textarea("join_reason",@$arr_company_profiles["join_reason"],"style='width:680px;height:200px;'"));
			}
			$btn_edit_company_join_reason = $t->row(array($f->input("edit",$v->w("edit"),"type='button' onclick=\"edit_company_join_reason();\"","btn_post")),array("align='right'"));
			$btn_save_cancel_company_join_reason = $t->row(
												array(
													$f->input("save",$v->w("save"),"type='button' onclick=\"save_company_join_reason();\"","btn_post")." ".
													$f->input("cancel",$v->w("cancel"),"type='button' onclick=\"load_profile();\"","btn_post")
												),
												array("align='right'")
											);
			
			$nav_company_join_reason = (!$edit_company_join_reason) ? $btn_edit_company_join_reason : $btn_save_cancel_company_join_reason;
			$nav_company_join_reason = $t->start("","","navigation") . $nav_company_join_reason . $t->end();
		?>		
		<table width="100%"><tr><td align="center">
			<?=(!$edit_company_join_reason) ? $nav_company_join_reason : "";?>
			<?=$f->start("company_join_reason_form");?>
				<?=$f->input("saving_company_join_reason_form","1","type='hidden'");?>
				<?=$t->start("","","content_data");?>
				<?php foreach($rows as $row) { echo $t->row($row); } ?>
				<?=$t->end();?>
			<?=$f->end();?>
			<?=($edit_company_join_reason) ? $nav_company_join_reason : "";?>
		</td></tr></table>
	</div>
</div>
<div style="height:20px;"></div>

<div class="card">
	<div id="title">
		<?=$v->w("company_logo");?>
		<div style="float:right"><?=$f->input("edit",$v->w("edit"),"type='button' onclick='edit_logo();'","btn_post");?></div>
	</div>
	<div id="content">
		<?php
			$logo = $arr_company_profiles["logo"];
			$logo = ($logo != "" && file_exists("../company_logo/".$logo) > 0) ? $logo  : "no_logo.png";
			$logo = "company_logo/".$logo;
		?>
		<center><img src="<?=$logo;?>" height="100"></center>
	</div>
</div>
<div style="height:20px;"></div>