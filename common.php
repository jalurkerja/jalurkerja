<?php
	ini_set("session.cookie_lifetime", 60 * 60 * 24 * 100);
	ini_set("session.gc_maxlifetime", 60 * 60 * 24 * 100);
	set_time_limit(0);
	session_start();
	
	$__isloggedin				= @$_SESSION["isloggedin"];
	$__username					= @$_SESSION["username"];
	$__user_id					= @$_SESSION["user_id"];
	$__is_seeker				= @$_SESSION["is_seeker"];
	$__cso_id					= @$_SESSION["cso_id"];
	$__company_profiles_id		= @$_SESSION["company_profiles_id"];
	$__company_id				= $__company_profiles_id;
	$__first_name				= @$_SESSION["first_name"];
	$__cso_name					= @$_SESSION["cso_name"];
	$__company_first_name		= @$_SESSION["company_first_name"];
	$__company_name				= @$_SESSION["company_name"];
	$__errormessage				= @$_SESSION["errormessage"];
	
	if(isset($_GET["locale"])) { setcookie("locale",$_GET["locale"]);$_COOKIE["locale"]=$_GET["locale"]; }
	if(!isset($_COOKIE["locale"])) { setcookie("locale","id");$_COOKIE["locale"]="id"; }
	$__locale = $_COOKIE["locale"];
	
	include_once "classes/database.php";
	include_once "classes/jobseeker.php";
    include_once "classes/form_elements.php";
    include_once "classes/tables.php";
    include_once "classes/helper.php";
	include_once "classes/vocabulary.php";
	
	$v = new Vocabulary($__locale);
	$db = new Database();
	$js = new JobSeeker();
	$f = new FormElements();
	$t = new Tables();
	$h = new Helper();
	
	function chr13tobr($string) { return str_replace(chr(13).chr(10),"<br>",$string); }
	
	function javascript($script){  ?> <script> $( document ).ready(function() { <?=$script;?> }); </script> <?php }
	
	function salary_min_max($min,$max){
		global $__locale,$v;
		$_max = $max;
		if($__locale == "en") {
			$min = number_format($min);
			$max = number_format($max);
		} else {
			$min = number_format($min,0,",",".");
			$max = number_format($max,0,",",".");
		}
		if($_max > 0){return "Rp.".$min." - Rp.".$max;} else {return "Rp.".$min." - ".$v->w("infinite");}
	}
	
	function format_tanggal ($tanggal,$mode="dmY",$withtime=false) {
		if(substr($tanggal,0,10) != "0000-00-00" && $tanggal != ""){
			$arr = explode(" ",$tanggal);
			$time = @$arr[1];
			$tanggal = $arr[0];
			$arr = explode("-",$tanggal);
			$Y=$arr[0];
			$m=$arr[1];
			$d=$arr[2];
			if($mode == "dmY"){ $tanggal = $d."-".$m."-".$Y; }
			if($mode == "dMY"){ $tanggal = $d." ".date("F",mktime(0,0,0,$m))." ".$Y; }
			if($withtime && isset($time)) $tanggal .= " ".$time;
			return $tanggal;
		}
	}
	
	function format_range_tanggal($tanggal1,$tanggal2){
		global $v;
		if($tanggal1 == "" || substr($tanggal1,0,10) == "0000-00-00") $tanggal1 = "0000-00-00";
		if($tanggal2 == "" || substr($tanggal2,0,10) == "0000-00-00") $tanggal2 = "0000-00-00";
		$return = "";
		if($tanggal1 != "0000-00-00") $return .= format_tanggal($tanggal1,"dMY"); else  $return .= $v->words("now");
		$return .= " - ";
		if($tanggal2 != "0000-00-00") $return .= format_tanggal($tanggal2,"dMY"); else  $return .= $v->words("now");
		return $return;
	}
	
	function fetch_locations(){
		global $db,$__locale;
		$db->addtable("locations"); 
		$db->addfield("province_id,location_id,name_".$__locale);
		$db->where("id",1,"i",">");$db->order("seqno");
		foreach ($db->fetch_data() as $key => $arrlocation){
			if($arrlocation[1]>0){
				$arrlocations[$arrlocation[0].":".$arrlocation[1]] = "&nbsp;&nbsp;".$arrlocation[2];
			} else {
				$arrlocations[$arrlocation[0].":".$arrlocation[1]] = "<b>".$arrlocation[2]."</b>";
			}
		}
		return $arrlocations;
	}
	
	function province_location_format_id($id){
		global $db;
		$db->addtable("locations"); $db->addfield("province_id,location_id");$db->where("id",$id);
		$temp = $db->fetch_data();
		if(isset($temp[0]) && isset($temp[1])) return $temp[0].":".$temp[1];				
	}
	
	function pipetoarray($data){
		if(!isset($data) || $data == "") return array();
		$arr = explode("|",$data);
		foreach($arr as $data){ 
			$data = str_replace("|","",$data);
			if ($data !="") $return[] = $data; 
		}
		return $return;
	}
	
	function sb_to_pipe($data){
		ksort($data);
		$return = "";
		foreach($data as $datum => $val){ $return .= "|".$datum."|"; }
		return $return;
	}
	
	function array_swap($data){
		$return = array();
		if(is_array($data)){ foreach($data as $key => $value) { $return[] = $key; } }
		return $return;
	}
	
	function sel_to_pipe($data){
		if(!is_array($data)) return "";
		sort($data);
		$return = "";
		foreach($data as $datum => $val){ $return .= "|".$val."|"; }
		return $return;
	}
	
	function getStartRow($page,$rowperpage){
		$page = ($page > 0) ? $page:1;
		return ($page - 1) * $rowperpage;
	}
	
	function paging($rowperpage,$maxrow,$activepage,$class = ""){
		$numpage = ceil($maxrow/$rowperpage);
		$activepage = ($activepage == 0) ? 1:$activepage;
		$return = "<div class='".$class."'>";
		for($i = 1 ; $i <= $numpage ; $i++){
			if($activepage == $i ) $return .= "<a id=\"a_active\" href=\"javascript:changepage('".$i."');\">".$i."</a>";
			else  $return .= "<a href=\"javascript:changepage('".$i."');\">".$i."</a>";
		}
		$return .= "</div>";
		return $return;
	}
	
	function validate_domain_email($email){
        $exp = "^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$";
        if(eregi($exp,$email)){
            if(checkdnsrr(array_pop(explode("@",$email)),"MX")){
                return "1";
            }else{
                return "0";
            }
        }else{
            return "0";
        }
    }
?>
<?php include_once "log_action.php"; ?>
