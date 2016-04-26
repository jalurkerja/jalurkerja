<?php include_once "common.php"; ?>
<script src="scripts/jquery-1.10.1.min.js"></script>
<?php 
	if(!$__company_id) javascript("window.close();");
	
	if($_GET["mode"] == "header_image"){		
		if(isset($_POST["save"])){
			move_uploaded_file($_FILES['file_header_image']['tmp_name'], "company_header/".$__company_id.".".pathinfo($_FILES['file_header_image']['name'],PATHINFO_EXTENSION));
			$db->addtable("company_profiles");$db->where("id",$__company_id);
			$db->addfield("header_image");$db->addvalue($__company_id.".".pathinfo($_FILES['file_header_image']['name'],PATHINFO_EXTENSION));
			$db->update();
			javascript("window.close();");
		}
		
		$header_image = $db->fetch_single_data("company_profiles","header_image",array("id" => $__company_id));
		$header_image = ($header_image != "" && file_exists("company_header/".$header_image) > 0) ? $header_image  : "nocompanyheader.png";
		$header_image = "company_header/".$header_image;
		echo $f->start("","POST","","enctype='multipart/form-data'");
			echo $t->start("width='100%'");
				echo $t->row(array('<img id="photo" src="'.$header_image.'" style="height:150px;">'),array("align='center'"));
				echo $t->row(array($f->input("file_header_image","","type='file'")),array("align='center'"));
				echo $t->row(array($f->input("save",$v->w("save"),'type="submit" tabindex="17"',"btn_sign")),array("align='center'"));
			echo $t->end();
		echo $f->end();
	}
	
	if($_GET["mode"] == "logo"){		
		if(isset($_POST["save"])){
			move_uploaded_file($_FILES['file_logo']['tmp_name'], "company_logo/".$__company_id.".".pathinfo($_FILES['file_logo']['name'],PATHINFO_EXTENSION));
			$db->addtable("company_profiles");$db->where("id",$__company_id);
			$db->addfield("logo");$db->addvalue($__company_id.".".pathinfo($_FILES['file_logo']['name'],PATHINFO_EXTENSION));
			$db->update();
			javascript("window.close();");
		}
		
		$logo = $db->fetch_single_data("company_profiles","logo",array("id" => $__company_id));
		$logo = ($logo != "" && file_exists("company_logo/".$logo) > 0) ? $logo  : "no_logo.png";
		$logo = "company_logo/".$logo;
		echo $f->start("","POST","","enctype='multipart/form-data'");
			echo $t->start("width='100%'");
				echo $t->row(array('<img id="photo" src="'.$logo.'" style="height:150px;">'),array("align='center'"));
				echo $t->row(array($f->input("file_logo","","type='file'")),array("align='center'"));
				echo $t->row(array($f->input("save",$v->w("save"),'type="submit" tabindex="17"',"btn_sign")),array("align='center'"));
			echo $t->end();
		echo $f->end();
	}
?>