<?php	
	if(@$_GET["edit_advertising"] == 1) {
		$opportunity_id = $_GET["add_opportunity_id"];
		$db->addtable("opportunities");$db->where("id",$opportunity_id);$db->limit(1);$opp = $db->fetch_data();
	}
	$ket_select_multiple = "<br><br><div class='whitecard' style='font-size:11px;width:230px;'>Sambil tekan tombol \"Ctrl\"<br>untuk memilih lebih dari satu pilihan</div>";
	$ket_salary = "<br><br><div class='whitecard' style='font-size:11px;width:230px;'>Kami menggunakan sistem pencocokan<br>gaji otomatis. Mohon masukkan rentang gaji<br>yang ditawarkan. Informasi ini tidak akan<br>tampil pada iklan Anda.</div>";
	
	$checked = ($opp["is_syariah"] == 1) ? "checked" : "";
	$chk_syariah				= $f->input("is_syariah","1","type='checkbox' ".$checked)." Klik untuk lowongan Syariah";
	$txt_title 					= $f->input("title",$opp["title_id"])."<br>".$chk_syariah;
	$sel_job_type 				= $f->select("job_type_id",$db->fetch_select_data("job_type","id","name_id"),$opp["job_type_id"]);
	$sel_industry				= $f->select("industry_id",$db->fetch_select_data("industries","id","name_id"),$opp["industry_id"]);
	$sel_location 				= $f->select("location",$db->fetch_select_data("locations","concat(province_id,':',location_id) as location_id","name_id"),$opp["province_id"].":".$opp["location_id"]);
	$sm_job_levels 				= $f->select_multiple("job_level_ids",$db->fetch_select_data("job_level","id","name_id"),pipetoarray($opp["job_level_ids"])).$ket_select_multiple;
	$sel_function				= $f->select("job_function_id",$db->fetch_select_data("job_functions","id","name_id"),$opp["job_function_id"]);
	$sel_degree					= $f->select("degree_id",$db->fetch_select_data("degree","id","name_id",array("id" => "0:>")),$opp["degree_id"]);
	$majors = $db->fetch_select_data("majors","id","name_id"); asort($majors);
	$sm_majors	 				= $f->select_multiple("major_ids",$majors,pipetoarray($opp["major_ids"])).$ket_select_multiple;
	$checked = ($opp["is_freshgraduate"] == 1) ? "checked" : "";
	$chk_freshgraduate			= $f->input("is_freshgraduate","1","type='checkbox' ".$checked)." Klik bila fresh graduate / non pengalaman boleh melamar";
	$txt_experience				= $f->input("experience_years",$opp["experience_years"])." Tahun <br>".$chk_freshgraduate;
	
	$arrgender[1] = "Male";$arrgender[2] = "Female";
	$sm_gender 					= $f->select_multiple("gender",$arrgender,pipetoarray($opp["gender"]),"style='height:50px;'").$ket_select_multiple;
	
	for($xx = 14 ; $xx < 75 ; $xx++) { $arrage[$xx] = $xx; }
	$sel_ages 					= $f->select("age_min",$arrage,$opp["age_min"])." - ".$f->select("age_max",$arrage,$opp["age_max"]);
	
	$txt_email					= $f->input("email",$opp["email"]);
	
	$db->addtable("salaries"); $db->addfield("id");$db->addfield("salary"); $db->order("id");
	foreach ($db->fetch_data() as $key => $arrsalary){
		$salaries[$arrsalary[1]] = number_format($arrsalary[1],0,",",".");
	}
	$salary_range 				= $f->select("salary_min",$salaries,$opp["salary_min"]) ." - ". 
								  $f->select("salary_max",$salaries,$opp["salary_max"]).$ket_salary;
	
	$txt_requirement			= $f->textarea("requirement",$opp["requirement"]);
	$txt_contact_person			= $f->input("contact_person",$opp["contact_person"]);
	$txt_description			= $f->textarea("description",$opp["description"]);
	$date_closing_date			= $f->input_tanggal("closing_date",$opp["closing_date"],"","","","desc");
	if($opp["posted_at"] == "" || substr($opp["posted_at"],0,10) == "0000-00-00") $opp["posted_at"] = date("Y-m-d");
	$date_posted_at				= $f->input_tanggal("posted_at",$opp["posted_at"],"","","closing_date.innerHTML = change_close_date(document.getElementById('x_posted_at[tgl]').value,document.getElementById('x_posted_at[bln]').value,document.getElementById('x_posted_at[thn]').value);","desc");
	if($opp["closing_date"] == "" || substr($opp["closing_date"],0,10) == "0000-00-00"){ 
		$closing_date = date("d-m-Y",mktime(0,0,0,date("m")+3));
	} else {
		$closing_date = format_tanggal($opp["closing_date"]);
	}
?>
<?=$f->start("add_advertising_form","POST");?>
	<?=$t->start("","","content_data");?>
		<?=$t->row(array("Posisi",$txt_title));?>
		<?=$t->row(array("Tipe Pekerjaan",$sel_job_type));?>
		<?=$t->row(array("Lokasi",$sel_location));?>
		<?=$t->row(array("Fungsi Kerja",$sel_function));?>
		<?=$t->row(array("Jenjang Karir",$sm_job_levels));?>
		<?=$t->row(array("Jenjang Pendidikan",$sel_degree));?>
		<?=$t->row(array("Jurusan",$sm_majors));?>
		<?=$t->row(array("Rentang Gaji",$salary_range));?>
		<?=$t->row(array("Pengalaman Kerja",$txt_experience));?>
		<?=$t->row(array("Industri",$sel_industry));?>
		<?=$t->row(array("Jenis Kelamin",$sm_gender));?>
		<?=$t->row(array("Umur",$sel_ages));?>
		<?=$t->row(array("Kualifikasi",$txt_requirement));?>
		<?=$t->row(array("Tanggung Jawab",$txt_description));?>
		<?=$t->row(array("Email",$txt_email));?>
		<?=$t->row(array("Syariah",$chk_syariah));?>
		<?=$t->row(array("Posted At",$date_posted_at));?>
		<?=$t->row(array("Closing Date","<span id='closing_date'>".$closing_date."</span>"));?>
	<?=$t->end();?>
	<?php
		if(@$_GET["edit_advertising"] == 1) {
			echo $f->input("saving_edit_advertising","1","type='hidden'");
			echo $f->input("opportunity_id",$opportunity_id,"type='hidden'");
		} else {
			echo $f->input("saving_add_advertising","1","type='hidden'");
		}
	?>
	<?=$f->input("save","Save","type='button' onclick=\"adding_advertising();\"");?> <?=$f->input("cancel","Cancel","type='button' onclick=\"cancel_add_advertising();\"");?>
<?=$f->end();?>
<br><br>