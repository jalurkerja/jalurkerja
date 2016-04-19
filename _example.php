<script src="scripts/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>

<link rel="stylesheet" type="text/css" href="styles/style.css">
<link rel="stylesheet" type="text/css" href="calendar/calendar-win2k-cold-1.css">

<br>
<br>
<br>
<br>
<br>
<?php
    include "classes/database.php";
    include "classes/form_elements.php";
    include "classes/vocabulary.php";
    include "classes/tabular.php";
    include "classes/banner.php";
?>
<?php
	$db = new Database();
	$db->addtable("applicant_status");
	$db->addfield("name");
    $db->addfield("created_at");
	echo "sss<pre>";
    print_r($db->fetch_data());
    echo "</pre>";
    $form = new FormElements();
    // $t = new Tables();
	$v = new Vocabulary("en");
	echo $v->words("LOGIN");
    echo $form->start("form1");
		echo $t->start("border='1'");
			$arrheader[] = "<b>No</b>";
			$arrheader[] = "<b>Textbox</b>";
			$arrheader[] = "<b>Textarea</b>";
			$arrheader[] = "<b>Select</b>";
			$arrheader[] = "<b>Multiple Select</b>";
			$arrheader[] = "<b>Tanggal</b>";
			$arrheader[] = "<b>Calendar</b>";
			$arrheader[] = "<b>Time</b>";
			$arrheader[] = "<b>Periode</b>";
			$arrheader[] = "<b>Select Box</b>";
			echo $t->header($arrheader);
			
			$arrcolumn[] = "1. ";
			$arrcolumn[] = $form->input("txt","ok","onclick='form1.submit();'","");
			$arrcolumn[] = $form->textarea("notes","aaa","","xinput");
			$arrcolumn[] = $form->select("select",array(1,2,3),array("a","b","c"),2,"attr='aaa'","xinput");
			$arrcolumn[] = $form->select_multiple("select",array(1,2,3),array("a","b","c"),array(1,3),"attr='bbb'","xinput");
			$arrcolumn[] = $form->input_tanggal("tanggal","2016-02-12","class='xinput'","","alert(tanggal.value);");
			$arrcolumn[] = $form->calendar("tgl_calendar","01-02-2012","","","alert(tgl_calendar.value);");
			$arrcolumn[] = $form->input_time("jam","08:30","xclass='xinput'","xinput","alert(jam.value);");
			$arrcolumn[] = $form->input_periode("periode",8,2014,"sclass='bbb'","xinput","alert(periode.value);");
			
			$values[1] = "aaa";
			$values[3] = "bbb";
			$values[5] = "ccc";
			$values[7] = "ddd";
			$values[8] = "eee";
			$values[10] = "fff";
			$selecteds = array(1,5,10);
			
			$arrcolumn[] = $form->select_box("box","Job Title",$values,$selecteds,200,100,0);
			echo $t->row($arrcolumn);
			
			$arrcolumn = array();
			$arrcolumn[] = "";
			$arrcolumn[] = $form->input("btn","sss","type='submit'","button");        
			echo $t->row($arrcolumn,"","",array("colspan='5'"));
			
		echo $t->end();
    echo $form->end();

?>
