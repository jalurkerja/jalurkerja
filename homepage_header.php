<?php include_once "homepage_actions.php"; ?>
<?php include_once "head.php"; ?>
<!--HEADER-->
<header class="fixedHeader">
	<table id="tableHeader" width="100%">
		<tr>
			<td>&nbsp;</td>
			<td align="center" width="1100">
				<table style="background-color: rgba(255, 255, 255, 0.0);height:60px;width:100%;" cellpadding="0" cellspacing="0">
					<tr>
						<td nowrap>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<img src="images/jk_icon.png" style="height:52px;position:relative;top:0px;left:-10px;cursor:pointer;border:0px;" alt="jalurkerja.com" title="jalurkerja.com" onclick="window.location='index.php';">
							&nbsp;&nbsp;
							<img src="images/jk_text.png" style="height:52px;position:relative;top:0px;left:-10px;cursor:pointer;border:0px;" alt="jalurkerja.com" title="jalurkerja.com" onclick="window.location='index.php';">
						</td>
						<td style="width:20px;">&nbsp;</td>
						<td style="width:250px;" align="left" nowrap>
							<!--MENU WHEN LOGGED IN-->
							<!--END MENU WHEN LOGGED IN-->
						</td>
						<td nowrap width="120">
							<?php
								if($__locale == "en") {
									$_link_bahasa = "<span class='language_notactive' onclick=\"window.location='?locale=id';\">Bahasa</span>";
									$_link_english = "<span class='language_active'>English</span>";
								} else {
									$_link_bahasa = "<span class='language_active'>Bahasa</span>";
									$_link_english = "<span class='language_notactive' onclick=\"window.location='?locale=en';\">English</span>";
								}
							?>
							<?=$_link_bahasa;?> <b>|</b> <?=$_link_english;?>
						</td>
						<?php if($__isloggedin) {
							$db->addtable("seeker_profiles"); $db->addfield("photo"); $db->where("user_id",$__user_id); $db->limit(1); $photo = $db->fetch_data(false,0);
						?>
							<td class="homepage_greeting" nowrap valign="middle">
								<?=$v->words("hello");?>, <span id="first_name"><?=ucwords($__first_name);?></span>
							</td>
							<td class="homepage_greeting" nowrap valign="middle">
								<?php if(@filesize("seekers_photo/".$photo)>4096){ ?> <td> <img id="photo" src="seekers_photo/<?=$photo;?>" style="height:60px;"> </td> <?php } ?>
							</td>
							<td class="homepage_greeting" nowrap valign="middle">
								<img title="<?=$v->words("job_seeker_setting");?>" src="icons/settings.png" onclick="window.location='seeker_profile.php';">
								<img title="<?=$v->words("signout");?>" src="icons/logout.png" onclick="window.location='?logout_action=1';">
							</td>
						<?php } ?>
						<td nowrap>&nbsp;&nbsp;&nbsp;</td>
						<td nowrap valign="top">
							<?php if(!$__isloggedin) { ?>
							<table cellpadding="1" cellspacing="1"><tr><td style="height:2px;"></td></tr></table>
							<?=$f->start("homepage_login");?>
								<?=$f->input("login_action","1","type='hidden'");?>
								<table width="430" cellpadding="0" cellspacing="0" style="color:#4A4A4A;">
									<tr>
										<td style="color:#58595A;" align="left"><b><?=$v->words("email");?></b></td>
										<td style="width:20px;"></td>
										<td nowrap style="color:#58595A;" align="left"><b><?=$v->words("password");?></b></td>
									</tr>
									<tr>
										<td><?=$f->input("username","",'tabindex="1" maxlength="75" autocomplete="on"',"txt_login");?></td>
										<td style="width:13px;"></td>
										<td><?=$f->input("password","",'type="password" tabindex="2" maxlength="75" autocomplete="on"',"txt_login");?></td>
										<td style="width:13px;"></td>
										<td><?=$f->input("signin",$v->words("signin"),'type="submit" tabindex="2"',"btn_sign");?></td>
									</tr>
								</table>
							<?=$f->end();?>
							<?php } ?>
						</td>
						<td style="width:20px;">&nbsp;</td>
					</tr>
				</table>
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</header>
<!--END HEADER-->