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

	if($_mode == "reposting"){
		$opportunity_ids = explode(",",$_GET["opportunity_ids"]);
		$posting_date = $_GET["posting_date"];
		$error_message = "";
		foreach($opportunity_ids as $opportunity_id){
			$opportunity_id = str_replace("chk_","",$opportunity_id);
			$closing_date = $db->fetch_single_data("opportunities","closing_date",array("id" => $opportunity_id));
			if($closing_date > $posting_date){
				$db->addtable("opportunities");$db->where("id",$opportunity_id);
				$db->addfield("posted_at");$db->addvalue($posting_date);
				$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
				$db->addfield("updated_by");$db->addvalue($__username);
				$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
				$updating = $db->update();
				if($updating["affected_rows"]<0){
					$error_message .= "Opportunity Id ".$opportunity_id." tidak berhasil di reposting<br>";
				}
			}else{
				$error_message .= "Opportunity Id ".$opportunity_id." tanggal posting tidak boleh lebih dari ".$closing_date."<br>";
			}
		}
		if($error_message == ""){
			echo "<font color='green'>Repost berhasil</font>";
		}else{
			echo "<font color='red'>".$error_message."</font>";
		}
	}
?>
