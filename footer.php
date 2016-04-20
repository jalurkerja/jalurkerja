
		<br>
		<div class="footer_area" id="footer_area">
			<div>
				<br>
				<?=$t->start("width='900'");?>
					<?php
						$arrfooters[] = "
							<b>".$v->words("advertising_info")."</b><br>
							<div class='v_spacer'></div>
							<div class='v_spacer'></div>
							Telp : +62 21 29941058<br>
							<div class='v_spacer'></div>
							Fax : +62 21 29941058<br>
							<div class='v_spacer'></div>
							Email: cs@jalurkerja.com<br>
							<div class='v_spacer'></div>
							<font color='white'>(".$v->words("office_day").", ".$v->words("office_hour").")</font>
						";
						$arrfooters[] = "";
						$arrfooters[] = "
							<b>".$v->words("job_seeker")."</b><br>
							<div class='v_spacer'></div>
							<div class='v_spacer'></div>
							<a href='#'>".$v->words("register")."</a><br>
							<div class='v_spacer'></div>
							<a href='#'>".$v->words("advice_center")."</a><br>
							<div class='v_spacer'></div>
							<a href='#'>".$v->words("advanced_search")."</a>
						";
						$arrfooters[] = "<div style='width:1px;height:100px;border-left:1px solid white;'></div>";
						$arrfooters[] = "
							<b>".$v->words("employer")."</b><br>
							<div class='v_spacer'></div>
							<div class='v_spacer'></div>
							<a href='#'>".$v->words("register_as_employer")."</a><br>
							<div class='v_spacer'></div>
							<a href='#'>".$v->words("search_all_candidates")."</a><br>
							<div class='v_spacer'></div>
							<a href='#'>".$v->words("products_and_prices")."</a>
						";
						$arrfooters[] = "<div style='width:1px;height:100px;border-left:1px solid white;'></div>";
						$arrfooters[] = "
							<b>".$v->words("aboutus")."</b><br>
							<div class='v_spacer'></div>
							<div class='v_spacer'></div>
							<a href='#'>".$v->words("terms_and_conditions")."</a><br>
							<div class='v_spacer'></div>
							<a href='#'>".$v->words("privacy_policy")."</a><br>
							<div class='v_spacer'></div>
							<a href='#'>".$v->words("contactus")."</a>
						";
						
						$arrfooters_attr[] = "nowrap valign='top' style='width:200px;font-size:13px;'";
						$arrfooters_attr[] = "style='width:300px;'";
						$arrfooters_attr[] = "nowrap valign='top' style='width:150px;'";
						$arrfooters_attr[] = "style='width:20px;'";
						$arrfooters_attr[] = "nowrap valign='top' style='width:200px;'";
						$arrfooters_attr[] = "style='width:20px;'";
						$arrfooters_attr[] = "nowrap valign='top' style='width:150px;'";
						
					?>
					<?=$t->row($arrfooters,$arrfooters_attr);?>
				<?=$t->end();?>
				<br>
				<?=$t->start("width='900'");?>
					<?=$t->row(array("COPYRIGHT &copy; ".date("Y")." JALURKERJA.COM. ALL RIGHTS RESERVED."),array("align='middle' style='color:#333;'"));?>
				<?=$t->end();?>
				<br>
			</div>
		</div>
	</body>
</html>