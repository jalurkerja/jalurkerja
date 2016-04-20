<?php
class Vocabulary{
	protected $locale;
	public function __construct($locale){
		$this->locale = $locale;
	}
	
	public function capitalize($words){
		$words = strtolower($words);
		$arr = explode(" ",$words);
		$return = "";
		foreach($arr as $word){ $return .= strtoupper(substr($word,0,1)).substr($word,1)." "; }
		return $return;
	}
	
	public function w($index){ return $this->words($index); }
	
	public function words($index){
		$l = "en";
		$arr[$l]["hello"] 									= "Hello";
		$arr[$l]["username"] 								= "Username";
		$arr[$l]["signin"] 									= "Sign In";
		$arr[$l]["signout"] 								= "Sign Out";
		$arr[$l]["signup"] 									= "Sign Up";
		$arr[$l]["starts_here"] 							= "Your Journey Starts Here";
		$arr[$l]["fullname"]	 							= "Full Name";
		$arr[$l]["email"]	 								= "E-mail";
		$arr[$l]["address"]									= "Address";
		$arr[$l]["email_address"]							= "E-mail Address";
		$arr[$l]["password"]								= "Password";
		$arr[$l]["repassword"]								= "Retype Password";
		$arr[$l]["minimum_6_characters"]					= "Minimum 6 characters";
		$arr[$l]["password_error"]							= "Password Error";
		$arr[$l]["range_characters"]						= "6-8 characters";
		$arr[$l]["by_signing_up_i_agree_to"]				= "By Signing Up, I agree to karir's";
		$arr[$l]["terms_and_conditions"]					= "Terms and Conditions";
		$arr[$l]["and"]										= "and";
		$arr[$l]["or"]										= "or";
		$arr[$l]["privacy_policy"]							= "Privacy Policy";
		$arr[$l]["keyword"]									= "Keyword";
		$arr[$l]["company"]									= "Company";
		$arr[$l]["company_name"]							= "Company Name";
		$arr[$l]["etc"]										= "etc";
		$arr[$l]["salary"]									= "Salary";
		$arr[$l]["expected_salary"]							= "Expected Salary";
		$arr[$l]["from"]									= "From";
		$arr[$l]["to"]										= "To";
		$arr[$l]["choose"]									= "Choose";
		$arr[$l]["job_category"]							= "Job Category";
		$arr[$l]["function"]								= "Function";
		$arr[$l]["location"]								= "Location";
		$arr[$l]["job_level"]								= "Job Level";
		$arr[$l]["search"]									= "Search";
		$arr[$l]["featured_hiring_employers"]				= "Featured Hiring Employers";
		$arr[$l]["advertising_info"]						= "Advertising Info";
		$arr[$l]["office_day"]								= "Mon - Fri";
		$arr[$l]["office_hour"]								= "8:00am - 5:00pm";
		$arr[$l]["job_seeker"]								= "Job Seeker";
		$arr[$l]["employer"]								= "Employer";
		$arr[$l]["aboutus"]									= "About Us";
		$arr[$l]["register"]								= "Register";
		$arr[$l]["advice_center"]							= "Advice Center";
		$arr[$l]["advanced_search"]							= "Advanced Search";
		$arr[$l]["register_as_employer"]					= "Register As Employer";
		$arr[$l]["search_all_candidates"]					= "Search All Candidates";
		$arr[$l]["products_and_prices"]						= "Product and Prices";
		$arr[$l]["contactus"]								= "Contact Us";
		$arr[$l]["please_click_update_button"]				= "Please click Update button for refine result";
		$arr[$l]["update_result"]							= "UPDATE RESULT";
		$arr[$l]["viewing_search_results"]					= "Viewing Search Result";
		$arr[$l]["sort_by"]									= "Sort By";
		$arr[$l]["posting_date"]							= "Posting Date";
		$arr[$l]["salary_asc"]								= "Salary (Lowest - Highest)";
		$arr[$l]["salary_desc"]								= "Salary (Highest - Lowest)";
		$arr[$l]["viewing"]									= "Viewing";
		$arr[$l]["out_of"]									= "out of";
		$arr[$l]["go_to_page"]								= "Go To Page";
		$arr[$l]["previous"]								= "Previous";
		$arr[$l]["next"]									= "Next";
		$arr[$l]["job_function"]							= "Job Function";
		$arr[$l]["work_location"]							= "Work Location";
		$arr[$l]["industry"]								= "Industry";
		$arr[$l]["education_level"]							= "Education Level";
		$arr[$l]["experience_level"]						= "Experience Level";
		$arr[$l]["contact_person"]							= "Contact Person";
		$arr[$l]["description"]								= "Description";
		$arr[$l]["work_descriptions"]						= "Work Descriptions";
		$arr[$l]["job_description"]							= "Job Description";
		$arr[$l]["requirements"]							= "Requirements";
		$arr[$l]["apply"]									= "Apply";
		$arr[$l]["applied"]									= "Applied";
		$arr[$l]["save"]									= "Save";
		$arr[$l]["saved"]									= "Saved";
		$arr[$l]["print"]									= "Print";
		$arr[$l]["share"]									= "Share";
		$arr[$l]["major"]									= "Major";
		$arr[$l]["work_experience"]							= "Work Experience";
		$arr[$l]["years"]									= "Year(s)";
		$arr[$l]["salary_offer"]							= "Salary Offer";
		$arr[$l]["posted_date"]								= "Posted Date";
		$arr[$l]["closing_date"]							= "Closing Date";
		$arr[$l]["empty_result"]							= "Your search produced no result. Please select a new set of criteria and search again.";
		$arr[$l]["web"]										= "Web";
		$arr[$l]["empty_description"]						= "No Description";
		$arr[$l]["empty_requirement"]						= "No Requirement";
		$arr[$l]["error_wrong_username_password"]			= "Username and/or Password was wrong";
		$arr[$l]["apply_success"]							= "Your application has been applied";
		$arr[$l]["save_success"]							= "Your application has been saved";
		$arr[$l]["error_company_cannot_apply"]				= "Sorry, You cannot apply to this opprotunity, Pleas login as a job seeker!";
		$arr[$l]["send"]									= "Send";
		$arr[$l]["email_already_used"]						= "Your email address is already used!";
		$arr[$l]["failed_insert_users"]						= "Ups! Failed to add user";
		$arr[$l]["failed_insert_seeker_profiles"]			= "Ups! Failed to add seeker profiles";
		$arr[$l]["youre_almost_there"]						= "You're almost there";
		$arr[$l]["please_complete_signup_form"]				= "Please complete the signup form";
		$arr[$l]["first_name"]								= "First Name";
		$arr[$l]["middle_name"]								= "Middle Name";
		$arr[$l]["last_name"]								= "Last Name";
		$arr[$l]["zipcode"]									= "Zip Code";
		$arr[$l]["phone"]									= "Phone";
		$arr[$l]["cellphone"]								= "Cellphone";
		$arr[$l]["fax"]										= "Fax";
		$arr[$l]["birthdate"]								= "Birth Date";
		$arr[$l]["birthplace"]								= "Birth Place";
		$arr[$l]["nationality"]								= "Nationality";
		$arr[$l]["gender"]									= "Gender";
		$arr[$l]["marital_status"]							= "Marital Status";
		$arr[$l]["photo"]									= "Photo";
		$arr[$l]["job_seeker_setting"]						= "Job Seeker's Profile Setting";
		$arr[$l]["your_profile_successfully_saved"]			= "Your profile successfully saved";
		$arr[$l]["your_profile_fails_to_be_saved"]			= "Your profile fails to be saved!";
		$arr[$l]["please_login_as_job_seeker"]				= "Please login as job seeker";
		$arr[$l]["personal_data"]							= "Personal Data";
		$arr[$l]["certification"]							= "Certification";
		$arr[$l]["education"]								= "Education";
		$arr[$l]["language"]								= "Language";
		$arr[$l]["skill"]									= "Skill";
		$arr[$l]["summary"]									= "Summary";
		$arr[$l]["profile"]									= "Profile";
		$arr[$l]["settings"]								= "Settings";
		$arr[$l]["documents"]								= "Documents";
		$arr[$l]["general"]									= "General";
		$arr[$l]["job_desires"]								= "Job Desires";
		$arr[$l]["membership"]								= "Membership";
		$arr[$l]["saved_search"]							= "Saved Search";
		$arr[$l]["saved_opporutnities"]						= "Saved Opportunities";
		$arr[$l]["applied_opporunities"]					= "Applied Opportunitites";
		$arr[$l]["personal_data"]							= "Personal Data";
		$arr[$l]["edit"]									= "Edit";
		$arr[$l]["cancel"]									= "Cancel";
		$arr[$l]["add"]										= "Add";
		$arr[$l]["delete"]									= "Delete";
		$arr[$l]["position"]								= "Position";
		$arr[$l]["job_type"]								= "Job Type";
		$arr[$l]["your_data_successfully_added"]			= "Your data successfully added";
		$arr[$l]["your_data_fails_to_be_added"]				= "Your data fails to be added";
		$arr[$l]["your_data_successfully_saved"]			= "Your data successfully saved";
		$arr[$l]["your_data_fails_to_be_saved"]				= "Your data fails to be saved";
		$arr[$l]["your_data_successfully_deleted"]			= "Your data successfully deleted";
		$arr[$l]["your_data_fails_to_be_deleted"]			= "Your data fails to be deleted";
		$arr[$l]["work_periode"]							= "Work Periode";
		$arr[$l]["at"]										= " at ";
		$arr[$l]["now"]										= "now";
		$arr[$l]["still_work_here"]							= "still work here";
		$arr[$l]["are_you_sure_to_delete_this_data"]		= "Are You sure to delete this data";
		$arr[$l]["certification"]							= "Certification";
		$arr[$l]["name"]									= "Name";
		$arr[$l]["issued_at"]								= "Issued At";
		$arr[$l]["issued_by"]								= "Issued By";
		$arr[$l]["university_school"]						= "University / School";
		$arr[$l]["graduated_year"]							= "Graduated year";
		$arr[$l]["degree"]									= "Degree";
		$arr[$l]["gpa"]										= "GPA";
		$arr[$l]["honors"]									= "Honors";
		$arr[$l]["school_periode"]							= "School Period";
		$arr[$l]["still_school_here"]						= "Still school here";
		$arr[$l]["languages"]								= "Languages";
		$arr[$l]["speaking_level"]							= "Speaking level";
		$arr[$l]["writing_level"]							= "Writing level";
		$arr[$l]["skills"]									= "Skills";
		$arr[$l]["skill_level"]								= "Skill Level";
		$arr[$l]["print_view"]								= "Print View";
		$arr[$l]["change_password"]							= "Change Password";
		$arr[$l]["current_password"]						= "Current Password";
		$arr[$l]["new_password"]							= "New Password";
		$arr[$l]["confirm_password"]						= "Confirm Password";
		$arr[$l]["wrong_password"]							= "Wrong password";
		$arr[$l]["wrong_new_password"]						= "Wrong new password";
		$arr[$l]["available_date"]							= "Availability Date";
		$arr[$l]["availability"]							= "Availability";
		$arr[$l]["cover_letter"]							= "Cover Letter";
		$arr[$l]["application"]								= "Application";
		$arr[$l]["others"]									= "Others";
		$arr[$l]["get_job_alert"]							= "Receive Job Alert";
		$arr[$l]["get_newsletter"]							= "Receive Newsletter";
		$arr[$l]["ultimate_search"]							= "Ultimate Search";
		$arr[$l]["login_for_find_out_salary"]				= "Login to find out salary";
		$arr[$l]["below_expectation"]						= "Below Expectation";
		$arr[$l]["meet_expectation"]						= "Meet Expectation";
		$arr[$l]["above_expectation"]						= "Above Expectation";
		$arr[$l]["please_update_your_salary_expectation"] 	= "Please update your salary expectation on profile setting menu";
		$arr[$l]["show_only_syariah_opportunities"] 		= "Show only syariah opportunities";
		$arr[$l]["show_fresh_graduate_opportunities"] 		= "Show fresh graduate opportunities";
		/*==================================================================================================================================*/
		/*==================================================================================================================================*/
		$l = "id";
		$arr[$l]["hello"] 									= "Halo";
		$arr[$l]["username"] 								= "Username";
		$arr[$l]["signin"] 									= "Masuk";
		$arr[$l]["signout"] 								= "Keluar";
		$arr[$l]["signup"] 									= "Daftar";
		$arr[$l]["starts_here"] 							= "Perjalanan Anda dimulai disini";
		$arr[$l]["fullname"]	 							= "Nama Lengkap";
		$arr[$l]["email"]	 								= "E-mail";
		$arr[$l]["address"]									= "Alamat";
		$arr[$l]["email_address"]							= "Alamat Email";
		$arr[$l]["password"]								= "Kata Sandi";
		$arr[$l]["repassword"]								= "Ketik Ulang Password";
		$arr[$l]["minimum_6_characters"]					= "Minimal 6 karakter";
		$arr[$l]["password_error"]							= "Kesalahan pada Kata Sandi";
		$arr[$l]["range_characters"]						= "6-8 Karakter";
		$arr[$l]["by_signing_up_i_agree_to"]				= "Dengan mendaftar berarti Saya telah menyetujui";
		$arr[$l]["terms_and_conditions"]					= "Syarat dan Ketentuan";
		$arr[$l]["and"]										= "dan";
		$arr[$l]["or"]										= "atau";
		$arr[$l]["privacy_policy"]							= "Polis kerahasiaan";
		$arr[$l]["keyword"]									= "Kata Kunci";
		$arr[$l]["company"]									= "Perusahaan";
		$arr[$l]["company_name"]							= "Nama Perusahaan";
		$arr[$l]["etc"]										= "dll";
		$arr[$l]["salary"]									= "Gaji";
		$arr[$l]["expected_salary"]							= "Gaji yang diharapkan";
		$arr[$l]["from"]									= "Dari";
		$arr[$l]["to"]										= "Sampai";
		$arr[$l]["choose"]									= "Pilih";
		$arr[$l]["job_category"]							= "Kategori Kerja";
		$arr[$l]["function"]								= "Fungsi Kerja";
		$arr[$l]["location"]								= "Lokasi";
		$arr[$l]["job_level"]								= "Jenjang Karir";
		$arr[$l]["search"]									= "Cari";
		$arr[$l]["featured_hiring_employers"]				= "Fitur Minggu Ini";
		$arr[$l]["advertising_info"]						= "Info Iklan";
		$arr[$l]["office_day"]								= "Senin - Jumat";
		$arr[$l]["office_hour"]								= "8:00 - 17:00";
		$arr[$l]["job_seeker"]								= "Pencari Kerja";
		$arr[$l]["employer"]								= "Perusahaan";
		$arr[$l]["aboutus"]									= "Tentang Kami";
		$arr[$l]["register"]								= "Daftar";
		$arr[$l]["advice_center"]							= "Pusat Saran";
		$arr[$l]["advanced_search"]							= "Pencarian Lebih Detail";
		$arr[$l]["register_as_employer"]					= "Daftar Sebagai Perusahaan";
		$arr[$l]["search_all_candidates"]					= "Cari Semua Kandidat";
		$arr[$l]["products_and_prices"]						= "Produk dan Harga";
		$arr[$l]["contactus"]								= "Hubungi Kami";
		$arr[$l]["please_click_update_button"]				= "Harap klik tombol Update untuk perbaharui hasil pencarian";
		$arr[$l]["update_result"]							= "Perbaharui Hasil";
		$arr[$l]["viewing_search_results"]					= "Menampilkan hasil pencarian";
		$arr[$l]["sort_by"]									= "Urut Berdasarkan";
		$arr[$l]["posting_date"]							= "Tanggal Pasang";
		$arr[$l]["salary_asc"]								= "Gaji (Rendah - Tinggi)";
		$arr[$l]["salary_desc"]								= "Gaji (Tinggi - Rendah)";
		$arr[$l]["viewing"]									= "Menampilkan";
		$arr[$l]["out_of"]									= "dari";
		$arr[$l]["go_to_page"]								= "Ke Halaman";
		$arr[$l]["previous"]								= "Sebelumnya";
		$arr[$l]["next"]									= "Berikutnya";
		$arr[$l]["job_function"]							= "Fungsi Kerja";
		$arr[$l]["work_location"]							= "Lokasi Kerja";
		$arr[$l]["industry"]								= "Industri";
		$arr[$l]["education_level"]							= "Jenjang Pendidikan";
		$arr[$l]["experience_level"]						= "Pengalaman Kerja";
		$arr[$l]["contact_person"]							= "Nama Kontak";
		$arr[$l]["description"]								= "Deskripsi";
		$arr[$l]["work_descriptions"]						= "Deskripsi Pekerjaan";
		$arr[$l]["job_description"]							= "Deskripsi Pekerjaan";
		$arr[$l]["requirements"]							= "Persyaratan";
		$arr[$l]["apply"]									= "Lamar";
		$arr[$l]["applied"]									= "Sudah Dilamar";
		$arr[$l]["save"]									= "Simpan";
		$arr[$l]["saved"]									= "Tersimpan";
		$arr[$l]["print"]									= "Cetak";
		$arr[$l]["share"]									= "Bagikan";
		$arr[$l]["major"]									= "Jurusan";
		$arr[$l]["work_experience"]							= "Pengalaman Kerja";
		$arr[$l]["years"]									= "Tahun";
		$arr[$l]["salary_offer"]							= "Penawaran Gaji";
		$arr[$l]["posted_date"]								= "Tanggal Pasang";
		$arr[$l]["closing_date"]							= "Tanggal Tutup";
		$arr[$l]["empty_result"]							= "Pencarian Anda tidak ada hasil. Silahkan pilih kriteria baru dan cari lagi.";
		$arr[$l]["web"]										= "Situs";
		$arr[$l]["empty_description"]						= "Tidak ada deskripsi";
		$arr[$l]["empty_requirement"]						= "Tidak ada persyaratan";
		$arr[$l]["error_wrong_username_password"]			= "Username dan/atau Kata Sandi Salah!";
		$arr[$l]["apply_success"]							= "Lamaran Anda telah berhasil terkirim.";
		$arr[$l]["save_success"]							= "Lamaran Anda telah berhasil disimpan.";
		$arr[$l]["error_company_cannot_apply"]				= "Maaf, Anda tidak dapat mengirimkan lamaran ini, Silakan masuk sebagai Pencari Kerja!";
		$arr[$l]["send"]									= "Kirim";
		$arr[$l]["email_already_used"]						= "Your email address is already used!";
		$arr[$l]["failed_insert_users"]						= "Ups! Gagal untuk menambahkan data pengguna";
		$arr[$l]["failed_insert_seeker_profiles"]			= "Ups! Gagal untuk menambahkan profil Penjari Kerja";
		$arr[$l]["youre_almost_there"]						= "Anda hampir sampai";
		$arr[$l]["please_complete_signup_form"]				= "Silakan lengkapi formulir pendaftaran";
		$arr[$l]["first_name"]								= "Nama Depan";
		$arr[$l]["middle_name"]								= "Nama Tengah";
		$arr[$l]["last_name"]								= "Nama Akhir";
		$arr[$l]["zipcode"]									= "Kode Pos";
		$arr[$l]["phone"]									= "Telpon";
		$arr[$l]["cellphone"]								= "Handphone";
		$arr[$l]["fax"]										= "Fax";
		$arr[$l]["birthdate"]								= "Tanggal Lahir";
		$arr[$l]["birthplace"]								= "Tempat Lahir";
		$arr[$l]["nationality"]								= "Kebangsaan";
		$arr[$l]["gender"]									= "Jenis Kelamin";
		$arr[$l]["marital_status"]							= "Status Pernikahan";
		$arr[$l]["photo"]									= "Foto";
		$arr[$l]["job_seeker_setting"]						= "Pengaturan Profil Pencari Kerja";
		$arr[$l]["your_profile_successfully_saved"]			= "Profil Anda berhasil disimpan";
		$arr[$l]["your_profile_fails_to_be_saved"]			= "Profil Anda gagal untuk disimpan!";
		$arr[$l]["please_login_as_job_seeker"]				= "Silakan login sebagai pencari kerja";
		$arr[$l]["personal_data"]							= "Data Pribadi";
		$arr[$l]["certification"]							= "Sertifikasi";
		$arr[$l]["education"]								= "Pendidikan";
		$arr[$l]["language"]								= "Bahasa";
		$arr[$l]["skill"]									= "Ketrampilan";
		$arr[$l]["summary"]									= "Rangkuman";
		$arr[$l]["profile"]									= "Profil";
		$arr[$l]["settings"]								= "Pengaturan";
		$arr[$l]["documents"]								= "Dokumen";
		$arr[$l]["general"]									= "Umum";
		$arr[$l]["job_desires"]								= "Pekerjaan yang diinginkan";
		$arr[$l]["membership"]								= "Berlangganan";
		$arr[$l]["saved_search"]							= "Pencarian Tersimpan";
		$arr[$l]["saved_opporutnities"]						= "Lowongan Tersimpan";
		$arr[$l]["applied_opporunities"]					= "Yang sudah di lamar";
		$arr[$l]["personal_data"]							= "Data Pribadi";
		$arr[$l]["edit"]									= "Ubah";
		$arr[$l]["cancel"]									= "Batal";
		$arr[$l]["add"]										= "Tambah";
		$arr[$l]["delete"]									= "Hapus";
		$arr[$l]["position"]								= "Posisi";
		$arr[$l]["job_type"]								= "Tipe Pekerjaan";
		$arr[$l]["your_data_successfully_added"]			= "Data Anda berhasil di tambahkan";
		$arr[$l]["your_data_fails_to_be_added"]				= "Data Anda gagal di tambahkan";
		$arr[$l]["your_data_successfully_saved"]			= "Data Anda berhasil disimpan";
		$arr[$l]["your_data_fails_to_be_saved"]				= "Data Anda gagal disimpan";
		$arr[$l]["your_data_successfully_deleted"]			= "Data Anda berhasil dihapus";
		$arr[$l]["your_data_fails_to_be_deleted"]			= "Data Anda gagal dihapus";
		$arr[$l]["work_periode"]							= "Periode Kerja";
		$arr[$l]["at"]										= " di ";
		$arr[$l]["now"]										= "sekarang";
		$arr[$l]["still_work_here"]							= "masih bekerja disini";
		$arr[$l]["are_you_sure_to_delete_this_data"]		= "Anda yakin ingin menghapus data ini";
		$arr[$l]["certification"]							= "Sertifikasi";
		$arr[$l]["name"]									= "Name";
		$arr[$l]["issued_at"]								= "Dikeluarkan pada";
		$arr[$l]["issued_by"]								= "Dikeluarkan oleh";
		$arr[$l]["university_school"]						= "Universitas / Sekolah";
		$arr[$l]["graduated_year"]							= "Tahun Lulus";
		$arr[$l]["degree"]									= "Gelar";
		$arr[$l]["gpa"]										= "IPK";
		$arr[$l]["honors"]									= "Penghargaan";
		$arr[$l]["school_periode"]							= "Periode Sekolah";
		$arr[$l]["still_school_here"]						= "Masih sekolah disini";
		$arr[$l]["languages"]								= "Bahasa";
		$arr[$l]["speaking_level"]							= "Tingkat lisan";
		$arr[$l]["writing_level"]							= "Tingkat tulisan";
		$arr[$l]["skills"]									= "Ketrampilan";
		$arr[$l]["skill_level"]								= "Tingkat Ketrampilan";
		$arr[$l]["print_view"]								= "Tampilan Cetak";
		$arr[$l]["change_password"]							= "Ganti Password";
		$arr[$l]["current_password"]						= "Kata sandi saat ini";
		$arr[$l]["new_password"]							= "Kata sandi baru";
		$arr[$l]["confirm_password"]						= "Konfirmasi kata sandi";
		$arr[$l]["wrong_password"]							= "Kata sandi salah";
		$arr[$l]["wrong_new_password"]						= "Ada kesalahan pada kata sandi baru";
		$arr[$l]["available_date"]							= "Tanggal bersedia gabung";
		$arr[$l]["availability"]							= "Tempo bersedia gabung";
		$arr[$l]["cover_letter"]							= "Surat pengantar lamaran";
		$arr[$l]["application"]								= "Lamaran";
		$arr[$l]["others"]									= "Lainnya";
		$arr[$l]["get_job_alert"]							= "Menerima email lowongan";
		$arr[$l]["get_newsletter"]							= "Menerima email berita";
		$arr[$l]["ultimate_search"]							= "Pencarian Utama";
		$arr[$l]["login_for_find_out_salary"]				= "Login untuk mengetahui gaji";
		$arr[$l]["below_expectation"]						= "Dibawah Harapan";
		$arr[$l]["meet_expectation"]						= "Sesuai Harapan";
		$arr[$l]["above_expectation"]						= "Melebihi Harapan";
		$arr[$l]["please_update_your_salary_expectation"] 	= "Harap update data gaji yang di harapkan di menu Pengaturan Profil";
		$arr[$l]["show_only_syariah_opportunities"] 		= "Tampilkan hanya lowongan syariah";
		$arr[$l]["show_fresh_graduate_opportunities"] 		= "Tampilkan lowongan Fresh Graduate";
		
		return $arr[$this->locale][$index];
	}
}
?>