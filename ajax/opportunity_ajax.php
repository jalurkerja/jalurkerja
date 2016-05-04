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
	
	if($_mode == "loadDetailCompany"){
		$db->addtable("company_profiles");$db->where("id",$_GET["company_id"]);$db->limit(1);$cp = $db->fetch_data();
		echo $cp["industry_id"]."|||".$cp["web"]."|||".$cp["description"]."|||".$cp["province_id"].":".$cp["location_id"]."|||".$cp["email"]."|||".$cp["first_name"]." ".$cp["middle_name"]." ".$cp["last_name"];
	}
?>
