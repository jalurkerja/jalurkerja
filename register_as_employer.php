<?php include_once "head.php"; ?>
<body width="100%" height="100%">
	<table width="600" height="450">
		<tr><td class="common_title" align="center">Register As Employer</td></tr>
		<tr><td valign="top" align="center">
			<br>
			Pasang Iklan Lowongan Anda di JalurKerja.com. Dapatkan Free Exclusive Membership<br>
			Plan 3 Bulan selama masa soft launching kami.
			<br><br>
		</td></tr>
		<tr>
			<td valign="top" align="center">
				<form method="POST">
					<table>
						<tr><td>Email</td><td>:</td><td> <?=$f->input("email","","","search_area_input");?></td></tr>
						<tr><td>Nama Perusahaan</td><td>:</td><td> <?=$f->input("nama","","","search_area_input");?></td></tr>
						<tr><td>Alamat Perusahaan</td><td>:</td><td> <?=$f->textarea("alamat","","style='height:50px;'","search_area_input");?></td></tr>
						<tr><td>PIC</td><td>:</td><td> <?=$f->input("pic","","","search_area_input");?></td></tr>
						<tr><td>No Handphone</td><td>:</td><td> <?=$f->input("handphone","","","search_area_input");?></td></tr>
						<tr><td>No Telepon</td><td>:</td><td> <?=$f->input("telp","","","search_area_input");?></td></tr>
						<tr><td>No Fax</td><td>:</td><td> <?=$f->input("fax","","","search_area_input");?></td></tr>
						<tr><td>Deskripsi Perusahaan</td><td>:</td><td> <?=$f->textarea("deskripsi","","style='height:50px;'","search_area_input");?></td></tr>
						<tr><td>Industri</td><td>:</td><td> <?=$f->input("industri","","","search_area_input");?></td></tr>
						<tr><td>Website</td><td>:</td><td> <?=$f->input("website","","","search_area_input");?></td></tr>
						<tr><td colspan="3" align="center">
							<?=$f->input("register_as_employer","Daftar",'type="submit" tabindex="2"',"btn_sign");?>
						</td></tr>
					</table>
				</form>
			</td>
		</tr>
	</table>
</body>
