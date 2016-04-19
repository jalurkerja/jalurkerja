<?php 
	include_once "../common.php"; 
	
	if(isset($_GET["mode"])){ $_mode = $_GET["mode"]; } else { $_mode = ""; }
	
	if(isset($_POST["post_data"])){ parse_str($_POST["post_data"],$_POST); }
	
	if($_mode == "loadSelectCompany"){
		$_name = "%".str_replace(" ","%",$_GET["name"])."%";
		$companies = $db->fetch_select_data("company_profiles","id","name",array("name" => "$_name:LIKE"),array(),10);
		foreach($companies as $id_company => $name_company){ 
			$return .= "<div onclick=\"pickSelectCompanyList('".$id_company."','".$name_company."');\">".$name_company." [".$id_company."]</div>";
		}
		echo $return;
	}
?>
