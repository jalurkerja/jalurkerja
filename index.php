<?php include_once "homepage_header.php"; ?>
<?php include_once "classes/tabular.php"; ?>
<?php include_once "classes/banner.php"; ?>
<?php include_once "scripts/homepage_js.php"; ?>
	<!--MAIN IMAGE-->
	<?php 
		if($__is_seeker && $db->fetch_single_data("users","setting_clicked",array("id" => $__user_id)) < 2){ 
			$mainImageClass = "callout";$mainImageStyle = "style=\"background-image: url('images/main_image_callout.jpg') !important;\""; 
		} else if($__company_id != "" && $db->fetch_single_data("users","setting_clicked",array("id" => $__user_id)) < 2){
			$mainImageClass = "employer";$mainImageStyle = "style=\"background-image: url('images/main_image_employer.jpg') !important;\""; 
		} else { 
			$mainImageClass = "";$mainImageStyle = "";
		}
	?>
	<table width="100%" class="mainImage <?=$mainImageClass;?>" <?=$mainImageStyle;?>>
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
		<?=$f->start("","GET","searchjob.php");?>
			<?=$f->input("get_search","1","type='hidden'");?>
			<?=$t->start();?>
				<?php 
					$keyword_placeholder = $v->words("keyword")." (".$v->words("job_level").", ".$v->words("company_name").", ".$v->words("etc");
					$arrfields[0][0] = $f->input("keyword","","placeholder='".$keyword_placeholder.")'","search_area_input");
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
					$arrfields[0][1] = $f->select_box("work_location",$v->words("choose")." ".$v->words("work_location"),$arrlocations,array(),200,200,999,5,26,12,"grey");
					$f->add_config_selectbox("table","job_level");$f->add_config_selectbox("id","id");$f->add_config_selectbox("caption","name_".$__locale);$f->add_config_selectbox("where",array("id" => "0:>"));
					$arrfields[0][2] = $f->select_box_ajax("job_level",$v->words("job_level"),array(),212,200,999,5,26,12,"grey");
					
					$f->add_config_selectbox("table","degree");$f->add_config_selectbox("id","id");$f->add_config_selectbox("caption","name_".$__locale);$f->add_config_selectbox("where",array("id" => "0:>"));
					$arrfields[1][0] = $f->select_box_ajax("education_level",$v->words("education_level"),array_swap($_GET["education_level"]),305,100,998,5,26,12,"grey");
					
					$f->add_config_selectbox("table","industries");$f->add_config_selectbox("id","id");$f->add_config_selectbox("caption","name_".$__locale);$f->add_config_selectbox("where",array("id" => "0:>"));$f->add_config_selectbox("order",array("name_".$__locale));
					$arrfields[1][1] = $f->select_box_ajax("industries",$v->words("industry"),array_swap($_GET["industries"]),200,200,998,5,26,12,"grey");
					
					$db->addtable("salaries"); 
					$db->addfield("id");$db->addfield("salary"); $db->order("id");
					$arrsalariesfrom[0] = $v->words("salary")." ".$v->words("from");
					$arrsalariesto[0] = $v->words("salary")." ".$v->words("to");
					foreach ($db->fetch_data() as $key => $arrsalary){
						$arrsalariesfrom[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
						$arrsalariesto[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
					}
					
					$arrfields[1][2]  = $f->select("salary_from",$arrsalariesfrom,"","","search_area_select");
					$arrfields[1][2] .= " - ".$f->select("salary_to",$arrsalariesto,"","","search_area_select");
					
					$arrfields[2][0] = $v->w("show_only_syariah_opportunities")." ".$f->input("chk_syariah","1","type='checkbox'");
					$arrfields[2][0] .= "&nbsp;&nbsp;";
					$arrfields[2][0] .= $v->w("show_fresh_graduate_opportunities")." ".$f->input("chk_fresh_graduate","1","type='checkbox'");
					
				?>
				<?php $arr_attr[] = "";$arr_attr[] = "";$arr_attr[] = "";$arr_attr[] = "style='vertical-align:middle;'";?>
				<?php $arrfields[0][3] = $f->input("search_btn",$v->words("search"),'type="submit"',"btn_sign"); ?>
				<?=$t->row($arrfields[0],$arr_attr);?>
				<?=$t->row($arrfields[1],$arr_attr);?>
				<?=$t->row($arrfields[2],array("nowrap align='right' colspan='3'"));?>
			<?=$t->end();?>
		<?=$f->end();?>
	</td></tr></table>
	<!--END SEARCH AREA -->
	<br>
	<!--CATEGORY SEARCH-->
	<table width="100%"><tr><td align="center" nowrap>
		<table><tr><td valign="top">
			<table width="700" class="whitecard"><tr><td align="center" nowrap>
			<br>
		<?php
			$tab = new Tabular("index");
			$tab->set_tab_width(120);
			$tab->set_area_width(650);
			$tab->set_area_height(500);
			$tab->add_tab_title($v->words("job_function"));
			$tab->add_tab_title($v->words("job_level"));
			$tab->add_tab_title($v->words("work_location"));
			$tab->add_tab_title("<div onclick=\"document.getElementById('chk_syariah').checked = true; search_btn.click(); \"'>Syariah</div>");
			
			/**JOB FUNCTIONS**/
			$db->addtable("job_functions");
			$db->addfield("id");
			$db->addfield("name_".$__locale);
			$db->where("id",0,"i",">");
			$db->order("name_".$__locale);
			$job_functions = $db->fetch_data();
			$maxrows = round(count($job_functions)/2);
			$arrcontainer = array();
			$cols=1;
			$arrcontainer[0] = "&nbsp;&nbsp;&nbsp;";
			foreach($job_functions as $key => $job_function){
				if($key >= $maxrows) $cols = 2;
				if(!isset($arrcontainer[$cols])) $arrcontainer[$cols] = "";
				$arrcontainer[$cols] .= "<div class='category_search_link'><a href='searchjob.php?get_search=1&job_function[".$job_function["id"]."]=1'>".$job_function["name_".$__locale]."</a></div><br>";
			}
			$containers = $t->start() . $t->row($arrcontainer) . $t->end();
			$tab->add_tab_container($containers);
			/**END JOB FUNCTIONS**/
			
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
				$arrcontainer[$cols] .= "<div class='category_search_link'><a href='searchjob.php?get_search=1&job_level[".$joblevel["id"]."]=1'>".$joblevel["name_".$__locale]."</a></div><br>";
			}
			$containers = $t->start() . $t->row($arrcontainer) . $t->end();
			$tab->add_tab_container($containers);
			/**END JOB LEVEL**/
			
			/**JOB LOCATION**/
			$db->addtable("locations");
			$db->addfield("province_id");
			$db->addfield("location_id");
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
				$arrcontainer[$cols] .= "<div class='category_search_link'><a href='searchjob.php?get_search=1&work_location[".$location["province_id"].":".$location["location_id"]."]=1'>".$location["name_".$__locale]."</a></div><br>";
			}
			$containers = $t->start() . $t->row($arrcontainer) . $t->end();
			$tab->add_tab_container($containers);
			/**END LOCATION**/
			$tab->set_bordercolor("#0CB31D");
			echo $tab->draw();
		?>
			<br></td></tr></table>
		</td><td valign="top">
			<!--BANNER SIDE-->
			<table><tr><td align="center" nowrap>
			<?php
				$banner1 = new Banner();
				$sidebanners[0] = "banners/00.jpg";
				$sidebanners[1] = "banners/01.jpg";
				$sidebanners[2] = "banners/02.jpg";
				$sideurls[0] = "";
				$sideurls[1] = "";
				$sideurls[2] = "";
				echo $banner1->draw("banner1",$sidebanners,$sideurls,250,168,5000);
			?>
			<br>
			<?php
				$banner2 = new Banner();
				$sidebanners2[0] = "banners/10.jpg";
				$sidebanners2[1] = "banners/11.jpg";
				$sidebanners2[2] = "banners/12.jpg";
				$sideurls2[0] = "#";
				$sideurls2[1] = "javascript:load_register_as_employer();";
				$sideurls2[2] = "http://www.jalurkerja.com/searchjob.php?get_search=1&searchjobpage_searching=1&searchjob_page=1&searchjob_order=posted_at+DESC%2Cupdated_at+DESC&keyword=&int_job_function=&chr_job_function=&int_work_location=%5B%5D&chr_work_location=%5B%5D&int_job_level=&chr_job_level=&int_industries=&chr_industries=&int_education_level=&chr_education_level=&int_work_experience=%5B%5D&chr_work_experience=%5B%5D&int_job_type=&chr_job_type=&salary_from=0&salary_to=0&chk_syariah=1";
				echo $banner2->draw("banner2",$sidebanners2,$sideurls2,250,168,5000,"","","");
			?>
			<br>
			<?php
				$banner3 = new Banner();
				$sidebanners3[0] = "banners/20.jpg";
				$sidebanners3[1] = "banners/21.jpg";
				$sideurls3[0] = "http://www.corphr.com";
				$sideurls3[1] = "http://www.jepege.co.id";
				echo $banner3->draw("banner3",$sidebanners3,$sideurls3,250,168,5000);
			?>
			</td></tr></table>
			<!--END BANNER SIDE-->
		</td></tr></table>
	</td>
	</tr></table>
	<!--END CATEGORY SEARCH-->
	<br>
	<!--SLIDE BANNER-->
	<!--
	<script>
		jQuery(document).ready(function ($) {
			$( document ).ready(function() { setInterval(function () { moveRight(); }, 5000); });
			var slideCount = $('#slider ul li').length;
			var slideWidth = $('#slider ul li').width();
			var slideHeight = $('#slider ul li').height();
			var sliderUlWidth = slideCount * slideWidth;
			$('#slider').css({ width: slideWidth, height: slideHeight });
			$('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
			$('#slider ul li:last-child').prependTo('#slider ul');
			function moveRight() {
				$('#slider ul').animate({
					left: - slideWidth
				}, 200, function () {
					$('#slider ul li:first-child').appendTo('#slider ul');
					$('#slider ul').css('left', '');
				});
			};
		});    
	</script>
	<style>
		#slider {
			position: relative;
			overflow: hidden;
			margin: 20px auto 0 auto;
			border-radius: 4px;
		}

		#slider ul {
			position: relative;
			margin: 0;
			padding: 0;
			height: 200px;
			list-style: none;
		}

		#slider ul li {
			position: relative;
			display: block;
			float: left;
			margin: 0;
			padding: 0;
			width: 968px;
			height: 126px;
			background: #ccc;
			text-align: center;
			line-height: 300px;
		}

		#slider li div{
			position:absolute;
			top:152px;
			width:150px;
			height:20px;
			cursor:pointer;
		}

		#slider img{
			cursor:pointer;
		}
	</style>
	<div id="slider">
	  <ul>
		<li> <img src=""> </li>
		<li> <img src=""> </li>
	  </ul>  
	</div>
	<br>
	-->
	<!--END SLIDE BANNER-->
	<br>
	<!--FHE-->
	<table width="100%"><tr><td align="center" nowrap>
		<table width="920" class = "whitecard"><tr><td align="center" nowrap><br>
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
				$banners[$row][] = $fhe->draw($slot,$images[$slot],$urls[$slot],120,90,100000);
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