<?php include_once "homepage_header.php"; ?>
<?php include_once "classes/tabular.php"; ?>
<?php include_once "classes/banner.php"; ?>
<?php include_once "scripts/homepage_js.php"; ?>
	<!--MAIN IMAGE-->
	<table width="100%" class="mainImage">
		<tr><td style="height:60px;"></td></tr>
		<tr>
			<td align="right" valign="middle">
				<?php if(!$__isloggedin) { ?>
					<?=$t->start("","","frontRegisterArea");?>
						<?=$t->row(array(""),array("style='height:20px'"));?>
						<?=$t->row(array("",$v->words("starts_here")),array("style='width:35px'","class='starts_here'"));?>
						<?=$t->row(array("",$f->input("namalengkap","","placeholder='".$v->words("fullname")."' autocomplete='off'","starts_here_input")));?>
						<?=$t->row(array("",$f->input("email","","placeholder='".$v->words("email_address")."' autocomplete='off'","starts_here_input")));?>
						<?=$t->row(array("",$f->input("x_password","","type='password' placeholder='".$v->w("password")." (".$v->w("minimum_6_characters").")' autocomplete='off'","starts_here_input")));?>
						<?=$t->row(array("",$f->input("repassword","","type='password' placeholder='".$v->words("repassword")."' autocomplete='off'","starts_here_input")));?>
						<?=$t->row(array("",$f->input("signup",$v->words("signup"),"type='button' onclick='signup(namalengkap.value,email.value,x_password.value,repassword.value);'","btn_sign"),""),array("","align='right' valign='top'","style='width:40px;'"));?>
					<?=$t->end();?>
				<?php } ?>
			</td>
			<td style="width:100px;"></td>
		</tr>
	</table>
	<!--END MAIN IMAGE-->
	<!--SEARCH AREA -->
	<table width="100%" style="height:70px;box-shadow: 0px 1px 3px #000;background-color: rgba(255, 255, 255, 0.80);"><tr><td height="70" align="center" nowrap>
		<?=$f->start();?>
			<?=$t->start();?>
				<?php $keyword_placeholder = $v->words("keyword")." (".$v->words("job_level").", ".$v->words("company_name").", ".$v->words("etc"); ?>
				<?php $arrfields[] = $f->input("keyword","","placeholder='".$keyword_placeholder.")'","search_area_input");?>
				<?php $arrfields[] = "&nbsp;"; ?>
				<?php 
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
				?>
				<?php $arrfields[] = $f->select_box("location",$v->words("choose")." ".$v->words("work_location"),$arrlocations,array(),200,300,999,5,26,12,"grey");?>
				<?php $arrfields[] = "&nbsp;"; ?>
				<?php 
					$db->addtable("salaries"); 
					$db->addfield("id");$db->addfield("salary"); $db->order("id");
					$arrsalariesfrom[0] = $v->words("salary")." ".$v->words("from");
					$arrsalariesto[0] = $v->words("salary")." ".$v->words("to");
					foreach ($db->fetch_data() as $key => $arrsalary){
						$arrsalariesfrom[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
						$arrsalariesto[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
					}
				?>
				<?php $arrfields[] = $f->select("salary_from",$arrsalariesfrom,"","","search_area_select"); ?>
				<?php $arrfields[] = $v->words("to"); ?>
				<?php $arrfields[] = $f->select("salary_to",$arrsalariesto,"","","search_area_select"); ?>
				<?php 
					$arr_attr[] = "";$arr_attr[] = "";$arr_attr[] = "";$arr_attr[] = "";$arr_attr[] = "";
					$arr_attr[] = "style='vertical-align:middle;'";
				?>
				<?php $arrfields[] = "&nbsp;"; ?>
				<?php $arrfields[] = $f->input("",$v->words("search"),'type="button"',"btn_sign"); ?>
				<?=$t->row($arrfields,$arr_attr);?>
			<?=$t->end();?>
		<?=$f->end();?>
	</td></tr></table>
	<!--END SEARCH AREA -->
	<br>
	<!--CATEGORY SEARCH-->
	<table width="100%"><tr><td align="center" nowrap>
		<table width="700" class="whitecard"><tr><td align="center" nowrap><br>
	<?php
		$tab = new Tabular("index");
		$tab->set_tab_width(120);
		$tab->set_area_width(650);
		$tab->set_area_height(500);
		$tab->add_tab_title($v->words("job_category"));
		$tab->add_tab_title($v->words("job_level"));
		$tab->add_tab_title($v->words("work_location"));
		
		/**JOB CATEGORIES**/
		$db->addtable("job_categories");
		$db->addfield("id");
		$db->addfield("name_".$__locale);
		$db->where("parent_id",0);
		$db->order("name_".$__locale);
		$categories = $db->fetch_data();
		$maxrows = round(count($categories)/2);
		$arrcontainer = array();
		$cols=1;
		$arrcontainer[0] = "&nbsp;&nbsp;&nbsp;";
		foreach($categories as $key => $category){
			if($key >= $maxrows) $cols = 2;
			if(!isset($arrcontainer[$cols])) $arrcontainer[$cols] = "";
			$arrcontainer[$cols] .= "<div class='category_search_link'><a href='searchjob.php?category_id=".$category["id"]."'>".$category["name_".$__locale]."</a></div><br>";
		}
		$containers = $t->start() . $t->row($arrcontainer) . $t->end();
		$tab->add_tab_container($containers);
		/**END JOB CATEGORIES**/
		
		/**JOB JOB LEVEL**/
		$db->addtable("job_level");
		$db->addfield("id");
		$db->addfield("name_".$__locale);
		$db->where("id",0,"i",">");
		$db->order("name_".$__locale);
		$joblevels = $db->fetch_data();
		$maxrows = round(count($joblevels)/2);
		$arrcontainer = array();
		$cols=1;
		$arrcontainer[0] = "&nbsp;&nbsp;&nbsp;";
		foreach($joblevels as $key => $joblevel){
			if($key >= $maxrows) $cols = 2;
			if(!isset($arrcontainer[$cols])) $arrcontainer[$cols] = "";
			$arrcontainer[$cols] .= "<div class='category_search_link'><a href='searchjob.php?job_level_id=".$joblevel["id"]."'>".$joblevel["name_".$__locale]."</a></div><br>";
		}
		$containers = $t->start() . $t->row($arrcontainer) . $t->end();
		$tab->add_tab_container($containers);
		/**END JOB LEVEL**/
		
		/**JOB LOCATION**/
		$db->addtable("locations");
		$db->addfield("id");
		$db->addfield("name_".$__locale);
		$db->where("province_id",0,"i",">");
		$db->where("location_id",0,"i");
		$db->order("seqno");
		$locations = $db->fetch_data();
		$maxrows = round(count($locations)/2);
		$arrcontainer = array();
		$cols=1;
		$arrcontainer[0] = "&nbsp;&nbsp;&nbsp;";
		foreach($locations as $key => $location){
			if($key >= $maxrows) $cols = 2;
			if(!isset($arrcontainer[$cols])) $arrcontainer[$cols] = "";
			$arrcontainer[$cols] .= "<div class='category_search_link'><a href='searchjob.php?location_id=".$location["id"]."'>".$location["name_".$__locale]."</a></div><br>";
		}
		$containers = $t->start() . $t->row($arrcontainer) . $t->end();
		$tab->add_tab_container($containers);
		/**END LOCATION**/
		$tab->set_bordercolor("#0CB31D");
		echo $tab->draw();
	?>
		<br></td></tr></table>
	</td></tr></table>
	<!--END CATEGORY SEARCH-->
	<br>
	<!--FHE-->
	<table width="100%"><tr><td align="center" nowrap>
		<table width="700" class = "whitecard"><tr><td align="center" nowrap><br>
	<?php
		$db->addtable("fhe");
		$db->addfield("slot");
		$db->addfield("seqno");
		$db->addfield("logo");
		$db->addfield("url");
		$db->where("startdate","NOW()","i","<=");
		$db->where("enddate","NOW()","i",">=");
		$db->order("slot");
		$db->order("seqno");
		$fhe_s = $db->fetch_data();
		foreach($fhe_s as $key => $banner){
			$slot = $banner["slot"];
			$seqno = $banner["seqno"];
			$images[$slot][$seqno] = "fhe/".$banner["logo"];
			$urls[$slot][$seqno] = $banner["url"];
		}
	
		$fhe = new Banner();
		$slot=0;
		for($row = 0;$row < 2;$row++){
			for($col = 0;$col < 5; $col++){
				$banners[$row][] = $fhe->draw($slot,$images[$slot],$urls[$slot]);
				$banners[$row][] = "&nbsp;&nbsp;";
				$slot++;
			}
		}
	?>
		<?=$t->start();?>
			<?=$t->row(array("<div class='fhe_title'>".$v->words("featured_hiring_employers")."</div>"),array("colspan='9'"));?>
			<?=$t->row($banners[0]);?>
			<?=$t->row(array("&nbsp;"));?>
			<?=$t->row($banners[1]);?>
		<?=$t->end();?>
		<br></td></tr></table>
	</td></tr></table>
	<!--END FHE-->
<?php if(isset($_SESSION["errormessage"]) && $_SESSION["errormessage"] != "") { javascript("popup_message('".$_SESSION["errormessage"]."');"); $_SESSION["errormessage"] = ""; } ?>
<?php include_once "footer.php"; ?>