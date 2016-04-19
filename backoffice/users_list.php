<?php include_once "head.php";?>
<div class="bo_title">Users</div>
<div id="bo_expand" onclick="toogle_bo_filter();">[+] View Filter</div>
<div id="bo_filter">
	<div id="bo_filter_container">
		<?=$f->start("filter","GET");?>
			<?=$t->start();?>
			<?php
				$txt_email = $f->input("txt_email",@$_GET["txt_email"]);
				$txt_company_profiles_id = $f->input("txt_company_profiles_id",@$_GET["txt_company_profiles_id"]);
				$sel_locale = $f->select("sel_locale",array("" => "","id" => "Indonesian","en" => "English"),@$_GET["sel_locale"],"style='height:20px;'");
			?>
			<?=$t->row(array("Email",$txt_email));?>
			<?=$t->row(array("Company Profile ID",$txt_company_profiles_id));?>
			<?=$t->row(array("Locale",$sel_locale));?>
			<?=$t->end();?>
			<?=$f->input("page","1","type='hidden'");?>
			<?=$f->input("sort",@$_GET["sort"],"type='hidden'");?>
			<?=$f->input("do_filter","Load","type='submit'");?>
			<?=$f->input("reset","Reset","type='button' onclick=\"window.location='?';\"");?>
		<?=$f->end();?>
	</div>
</div>

<?php
	$whereclause = "";
	if(@$_GET["txt_email"]!="") $whereclause .= "email LIKE '"."%".str_replace(" ","%",$_GET["txt_email"])."%"."' AND ";
	if(@$_GET["txt_company_profiles_id"]!="") $whereclause .= "company_profiles_id = '".$_GET["txt_company_profiles_id"]."' AND ";
	if(@$_GET["sel_locale"]!="") $whereclause .= "locale = '".$_GET["sel_locale"]."' AND ";
	
	$db->addtable("users");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($_max_counting);
	$maxrow = count($db->fetch_data(true));
	$start = getStartRow(@$_GET["page"],$_rowperpage);
	$paging = paging($_rowperpage,$maxrow,@$_GET["page"],"paging");
	
	$db->addtable("users");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($start.",".$_rowperpage);
	if(@$_GET["sort"] != "") $db->order($_GET["sort"]);
	$users = $db->fetch_data(true);
?>
	<?=$f->input("add","Add","type='button' onclick=\"window.location='users_add.php';\"");?>
	<?=$paging;?>
	<?=$t->start("","data_content");?>
	<?=$t->header(array("No",
						"<div onclick=\"sorting('email');\">Email</div>",
						"<div onclick=\"sorting('company_profiles_id');\">Company Name</div>",
						"<div onclick=\"sorting('locale');\">Locale</div>",
						"Is CSO",
						""));?>
	<?php foreach($users as $no => $user){ ?>
		<?php
			$company_name = $db->fetch_single_data("company_profiles","name",array("id" => $user["company_profiles_id"]));
			$locale = ($user["locale"] == "en") ? "English" : "Indonesian";
			$is_cso = ($db->fetch_single_data("cso_profiles","id",array("user_id" => $user["id"])) > 0) ? "Yes" : "No";
			$actions = "<a href=\"users_edit.php?id=".$user["id"]."\">Edit</a>";
		?>
		<?=$t->row(
					array($no+$start+1,"<a href=\"users_view.php?id=".$user["id"]."\">".$user["email"]."</a>",$company_name,$locale,$is_cso,$actions),
					array("align='right' valign='top'","")
				);?>
	<?php } ?>
	<?=$t->end();?>
	<?=$paging;?>
	
<?php include_once "footer.php";?>