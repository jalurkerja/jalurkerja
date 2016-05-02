
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
							<a href='#none' onclick='load_registrasi();'>".$v->words("register")."</a><br>
							<div class='v_spacer'></div>
							<a href='#none' onclick='load_advice_center();'>".$v->words("advice_center")."</a><br>
							<div class='v_spacer'></div>
							<a href='#none' onclick='load_advanced_search();'>".$v->words("advanced_search")."</a>
						";
						$arrfooters[] = "<div style='width:1px;height:100px;border-left:1px solid white;'></div>";
						$arrfooters[] = "
							<b>".$v->words("employer")."</b><br>
							<div class='v_spacer'></div>
							<div class='v_spacer'></div>
							<a href='#none' onclick='load_register_as_employer();'>".$v->words("register_as_employer")."</a><br>
							<div class='v_spacer'></div>
							<a href='#none' onclick='load_search_all_candidates();'>".$v->words("search_all_candidates")."</a><br>
							<div class='v_spacer'></div>
							<a href='#none' onclick='load_products_and_prices();'>".$v->words("products_and_prices")."</a>
						";
						$arrfooters[] = "<div style='width:1px;height:100px;border-left:1px solid white;'></div>";
						$arrfooters[] = "
							<b>".$v->words("aboutus")."</b><br>
							<div class='v_spacer'></div>
							<div class='v_spacer'></div>
							<a href='#none' onclick='load_terms_and_conditions();'>".$v->words("terms_and_conditions")."</a><br>
							<div class='v_spacer'></div>
							<a href='#none' onclick='load_privacy_policy();'>".$v->words("privacy_policy")."</a><br>
							<div class='v_spacer'></div>
							<a href='#none' onclick='load_contactus();'>".$v->words("contactus")."</a>
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
		<script>
			<?php if(isset($_POST["register_as_employer"])) { ?> 
				popup_message("<table width='500'><tr><td>Data Anda telah terkirim ke Customer Service Kami,<br>dan akan segera menghubungi Anda. Terima Kasih</td></tr></table>"); 
			<?php } ?>
			function load_registrasi(){
				<?php if($__isloggedin) { ?>
					popup_message("<?=$v->w("you_already_registered");?>");
				<?php } else { ?>
					$('html, body').animate({scrollTop : 0},800);
				<?php }  ?>
			}

			function load_advice_center(){ popup_message("<?=$v->w("coming_soon");?>"); }
			function load_advanced_search(){ popup_message("<?=$v->w("coming_soon");?>"); }
			function load_register_as_employer(){ get_ajax("register_as_employer.php","register_as_employer","setTimeout(function(){ $.fancybox.open(global_respon['register_as_employer']); }, 10);"); }
			function load_search_all_candidates(){ popup_message("<?=$v->w("coming_soon");?>"); }
			function load_products_and_prices(){ get_ajax("contactus.php","contactus","setTimeout(function(){ popup_message(global_respon['contactus']); }, 10);"); }
			function load_terms_and_conditions(){ popup_message("<?=$v->w("coming_soon");?>"); }
			function load_privacy_policy(){ popup_message("<?=$v->w("coming_soon");?>"); }
			function load_contactus(){ get_ajax("contactus.php","contactus","setTimeout(function(){ popup_message(global_respon['contactus']); }, 10);"); }
		</script>
	</body>
</html>