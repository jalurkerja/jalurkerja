<?php include_once "../common.php";?>
<div class="card">
	<div id="content">
		<b>Atur filter pelamar yang Anda inginkan :</b>
		<?php
			$opportunity_id = $_GET["opportunity_id"];
			$db->addtable("opportunity_filter_categories");$db->where("opportunity_id",$opportunity_id);$db->limit(1);$filter = $db->fetch_data();
			$location 			= ($filter["location"] == 1) ? "checked" : "";
			$job_level 			= ($filter["job_level"] == 1) ? "checked" : "";
			$job_function 		= ($filter["job_function"] == 1) ? "checked" : "";
			$degree				= ($filter["degree"] == 1) ? "checked" : "";
			$salary 			= ($filter["salary"] == 1) ? "checked" : "";
			$major 				= ($filter["major"] == 1) ? "checked" : "";
			$experience_years 	= ($filter["experience_years"] == 1) ? "checked" : "";
			$gender 			= ($filter["gender"] == 1) ? "checked" : "";
			$industry 			= ($filter["industry"] == 1) ? "checked" : "";
			$age 				= ($filter["age"] == 1) ? "checked" : "";
			
			echo $f->start("change_filter_category_form","POST");
				echo $t->start("","","content_data");
					echo $t->row(array(
									$f->input("location","1","type='checkbox' ".$location)." Lokasi<div style='width:350px;'></div>",
									$f->input("job_level","1","type='checkbox' ".$job_level)." Level Kerja"
								));
					echo $t->row(array(
									$f->input("job_function","1","type='checkbox' ".$job_function)." Fungsi Kerja",
									$f->input("degree","1","type='checkbox' ".$degree)." Pendidikan"
								));
					echo $t->row(array(
									$f->input("salary","1","type='checkbox' ".$salary)." Rentang Gaji",
									$f->input("major","1","type='checkbox' ".$major)." Jurusan"
								));
					echo $t->row(array(
									$f->input("experience_years","1","type='checkbox' ".$experience_years)." Pengalaman Kerja",
									$f->input("gender","1","type='checkbox' ".$gender)." Jenis Kelamin"
								));
					echo $t->row(array(
									$f->input("industry","1","type='checkbox' ".$industry)." Industri",
									$f->input("age","1","type='checkbox' ".$age)." Umur"
								));
					echo $t->row(array(
									$f->input("back","Kembali","class='btn_sign' style='background-color: #FF6808;width:200px;' type='button' onclick=\"window.location = window.location;\"")." ".
									$f->input("save","Simpan","class='btn_sign' style='background-color: #FF6808;width:200px;' type='button' onclick=\"changing_filter_category();\""),
								),array("colspan='2' align='center'"));
				echo $t->end();
				echo $f->input("saving_add_advertising2","1","type='hidden'");
				echo $f->input("opportunity_id",$opportunity_id,"type='hidden'");
			echo $f->end();
		?>
	</div>
</div>
<div style="height:20px;"></div>