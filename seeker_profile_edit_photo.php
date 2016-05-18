<?php include_once "common.php"; ?>
<?php include_once "func.crop_image.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type="text/javascript" src="scripts/jquery-1.10.1.min.js"></script>
	<script type="text/javascript" src="scripts/jquery-pack.js"></script>
	<script type="text/javascript" src="scripts/jquery.imgareaselect.min.js"></script>
</head>
<body>
<center>
<?php 
	if(!$__user_id) javascript("window.close();");
	
	if (isset($_POST["upload_thumbnail"])) {
		$x1 = $_POST["x1"];
		$y1 = $_POST["y1"];
		$x2 = $_POST["x2"];
		$y2 = $_POST["y2"];
		$w = $_POST["w"];
		$h = $_POST["h"];
		$seeker_photo = $_POST["seeker_photo"];
		$seeker_photo_cropped = str_replace("temp_","",$seeker_photo);
		$photo_filename = str_replace("seekers_photo/temp_","",$seeker_photo);
		$scale = $thumb_width/$w;
		resizeThumbnailImage($seeker_photo_cropped, $seeker_photo,$w,$h,$x1,$y1,$scale);
		unlink($seeker_photo);
		$db->addtable("seeker_profiles");$db->where("user_id",$__user_id);
		$db->addfield("photo");$db->addvalue($photo_filename);
		$db->update();
		?> <script> parent.popup_message("<?=$v->w("image_saved");?>"); </script> <?php
	}
	
	if(isset($_POST["upload"])){
		$_type = $_FILES["file_photo"]["type"];
		$_size = $_FILES["file_photo"]["size"];
		$_error = $_FILES["file_photo"]["error"];
		$_filename = basename($_FILES['file_photo']['name']);
		$_file_ext = strtolower(substr($_filename, strrpos($_filename, '.') + 1));
		
		$error = "";
		foreach ($allowed_image_types as $mime_type => $ext) {
			if($_file_ext == $ext && $_type == $mime_type){
				$error = "";
				break;
			}else{
				$error = "Only <strong>".$image_ext."</strong> images accepted for upload<br />";
			}
		}
		if($_error != 0) { $error = $v->w("error_upload_image"); }
		if($_size > ($max_file*1048576)) { $error = str_replace("{max_file}",$max_file,$v->w("image_to_big")); }
		
		if($error == ""){
			$_ext = strtolower(pathinfo($_FILES['file_photo']['name'],PATHINFO_EXTENSION));
			move_uploaded_file($_FILES['file_photo']['tmp_name'], "seekers_photo/temp_".$__user_id.".".$_ext);
			$seeker_photo = "seekers_photo/temp_".$__user_id.".".$_ext;
			$width = getWidth($seeker_photo);
			$height = getHeight($seeker_photo);
			if ($width > $max_width){
				$scale = $max_width/$width;
				$uploaded = resizeImage($seeker_photo,$width,$height,$scale);
			}else{
				$scale = 1;
				$uploaded = resizeImage($seeker_photo,$width,$height,$scale);
			}
		} else {
			$_POST["upload"] = null;
			echo "<span style='color:red;'>".$error."</span>";
		}
	}
	
	if(!isset($_POST["upload"])){
		$db->addtable("seeker_profiles"); $db->where("user_id",$__user_id); $db->limit(1); $arr_seeker_profile = $db->fetch_data();
		if(!isset($arr_seeker_profile["photo"]) || $arr_seeker_profile["photo"] == "") $arr_seeker_profile["photo"] = "seekers_photo/nophoto.png";
		echo $f->start("","POST","","enctype='multipart/form-data'");
			echo $t->start("width='100%'");
				echo $t->row(array($f->input("file_photo","","type='file'")),array("align='center'"));
				echo $t->row(array($f->input("upload",$v->w("upload"),'type="submit" tabindex="17"',"btn_sign")),array("align='center'"));
			echo $t->end();
		echo $f->end();
		echo "<br>";
		echo $t->start("width='100%'");
			echo $t->row(array('<img id="photo" src="seekers_photo/'.$arr_seeker_profile["photo"].'" style="height:150px;">'),array("align='center'"));
		echo $t->end();
	} else {
		$current_large_image_width = getWidth($seeker_photo);
		$current_large_image_height = getHeight($seeker_photo);?>
		<script type="text/javascript">
			function preview(img, selection) {
				var scaleX = <?php echo $thumb_width;?> / selection.width; 
				var scaleY = <?php echo $thumb_height;?> / selection.height; 
				
				$('#thumbnail + div > img').css({ 
					width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px', 
					height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
					marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
					marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
				});
				$('#x1').val(selection.x1);
				$('#y1').val(selection.y1);
				$('#x2').val(selection.x2);
				$('#y2').val(selection.y2);
				$('#w').val(selection.width);
				$('#h').val(selection.height);
			}

			$(document).ready(function () {
				$('#save_thumb').click(function() {
					var x1 = $('#x1').val();
					var y1 = $('#y1').val();
					var x2 = $('#x2').val();
					var y2 = $('#y2').val();
					var w = $('#w').val();
					var h = $('#h').val();
					if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
						alert("You must make a selection first");
						return false;
					}else{
						return true;
					}
				});
			});

			$(window).load(function () {
				$('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview }); 
			});
		</script>
		<table>
			<tr>
				<td align="center">
					<img src="<?=$seeker_photo;?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
					<div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;">
						<img src="<?=$seeker_photo;?>" style="position: relative;" alt="Thumbnail Preview" />
					</div>
					<br style="clear:both;"/>
					<form name="thumbnail" action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
						<input type="hidden" name="seeker_photo" value="<?=$seeker_photo;?>" id="seeker_photo" />
						<input type="hidden" name="x1" value="" id="x1" />
						<input type="hidden" name="y1" value="" id="y1" />
						<input type="hidden" name="x2" value="" id="x2" />
						<input type="hidden" name="y2" value="" id="y2" />
						<input type="hidden" name="w" value="" id="w" />
						<input type="hidden" name="h" value="" id="h" />
						<input type="submit" id="upload_thumbnail" name="upload_thumbnail" value="<?=$v->w("save");?>" id="save_thumb" />
					</form>
				</td>
			</tr>
		</table>
	<?php
	}
	
?>
</center>
</body>
</html>