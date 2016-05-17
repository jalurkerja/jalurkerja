<?php include_once "../common.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta property="og:image" content="../images/logo_transparent.png">
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<meta http-equiv="X-UA-Compatible" content="IE=8;" />
		<link rel="Shortcut Icon" href="../favicon.ico">
		<title id="titleid">JalurKerja.com - BackOffice</title>
		
		<script src="../scripts/jquery-1.10.1.min.js"></script>
		<script type="text/javascript" src="../scripts/jquery.fancybox.js"></script>
		<script type="text/javascript" src="../calendar/calendar.js"></script>
		<script type="text/javascript" src="../calendar/lang/calendar-en.js"></script>
		<script type="text/javascript" src="../calendar/calendar-setup.js"></script>

		<link rel="stylesheet" type="text/css" href="../styles/style.css">
		<link rel="stylesheet" type="text/css" href="backoffice.css">
		<link rel="stylesheet" type="text/css" href="../calendar/calendar-win2k-cold-1.css">
		<link rel="stylesheet" type="text/css" href="../styles/jquery.fancybox.css" media="screen" />
		<link rel="stylesheet" href="../font/font.css">
	</head>
	<body id="bodyid" style="margin:0px;">
		<?=$t->start("","data_content");?>
		<?=$t->header(array("No","User Id","Email","Name","Gender","Degree"));?>
		<?php
			$db->addtable("applied_opportunities");$db->addfield("user_id");$db->where("opportunity_id",$_GET["opportunity_id"]);$users = $db->fetch_data(true);
			$no = 0;
			foreach($users as $_user){
				$no++;
				$user_id = $_user["user_id"];
				$db->addtable("seeker_profiles");$db->where("user_id",$user_id);$db->limit(1);$user = $db->fetch_data();
				$email = $db->fetch_single_data("users","email",array("id" => $user_id));
				$gender = $db->fetch_single_data("gender","name_en",array("id" => $user["gender_id"]));
				$degree_id = $db->fetch_single_data("seeker_educations","degree_id",array("user_id" => $user_id),array("start_year DESC"));
				$degree = $db->fetch_single_data("degree","name_en",array("id" => $degree_id));
				echo $t->row(array($no,$user_id,$email,$user["first_name"]." ".$user["middle_name"]." ".$user["last_name"],$gender,$degree));
		?>
		<?php
			}
		?>
		<?=$t->end();?>
	</body>
</html>