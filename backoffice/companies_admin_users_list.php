<?php 
	include_once "../common.php";
	if(isset($_GET["deluser"])){
		$db->addtable("users");$db->where("email",$_GET["deluser"]);
		$db->addfield("company_profiles_id");$db->addvalue("");
		$db->update();
	}
	if(isset($_GET["adduser"])){
		?>Email : <input onkeyup="if(event.keyCode == '13'){ window.location='?addinguser='+this.value+'&company_id=<?=$_GET["company_id"];?>'; }"><?php
	}
	if(isset($_GET["addinguser"])){
		$db->addtable("users");$db->where("email",$_GET["addinguser"]);
		$db->addfield("company_profiles_id");$db->addvalue($_GET["company_id"]);
		$updating = $db->update();
		if($updating["affected_rows"] <= 0){
			?> User Email <?=$_GET["addinguser"];?> Tidak ada! <?php
		}
	}
?>
<h3><b>Users Admin</b></h3>
<input type="button" value="+" onclick="window.location='?adduser=1&company_id=<?=$_GET["company_id"];?>';">
<table>
<?php
	$db->addtable("users");$db->where("company_profiles_id",$_GET["company_id"]);$users = $db->fetch_data(true);
	$no=0;
	foreach($users as $user){
		$no++;
		?>
		<tr>
			<td><?=$no;?>.</td>
			<td><?=$user["email"];?></td>
			<td>
				<input type="button" value="-" onclick="window.location='?deluser=<?=$user["email"];?>&company_id=<?=$_GET["company_id"];?>';">
			</td>
		</tr>
		<?php
	}
?>
</table>