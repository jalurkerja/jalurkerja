<?php    
    class JobSeeker extends Database {
		
        public function is_applied($user_id,$opportunity_id){
			$this->addtable("applied_opportunities");
			$this->addfield("user_id");
			$this->where("user_id",$user_id);
			$this->where("opportunity_id",$opportunity_id);
			$this->limit(1);
			return count($this->fetch_data());
		}
		
		public function email_notification($user_id,$opportunity_id){
			$locale = $_COOKIE["locale"];
			$company_id = $this->fetch_single_data("opportunities","company_id",array("id" => $opportunity_id));
			$title = $this->fetch_single_data("opportunities","title_".$locale,array("id" => $opportunity_id));
			$email = array();
			$email[] = $this->fetch_single_data("company_profiles","email",array("id" => $company_id));
			$this->addtable("users");$this->addfield("email");$this->where("company_profiles_id",$company_id);
			$emails = $this->fetch_data(true);
			foreach($emails as $_email){ $email[] = $_email[0]; }
			if($locale == "id"){ $subject = "JalurKerja.com - Pelamar Kerja ".$title; }else{ $subject = "JalurKerja.com - Job Applicant ".$title; }			
			$filename = "../html/notification_applicant_".$locale.".html";
			$handle = fopen($filename, "r");
			$body = fread($handle, filesize($filename));
			fclose($handle);
			$this->addtable("seeker_profiles");$this->where("user_id",$user_id);$this->limit(1);$sp = $this->fetch_data();
			$gender = $this->fetch_single_data("gender","name_".$locale,array("id" => $sp["gender_id"]));
			$marital_status = $this->fetch_single_data("marital_status","name_".$locale,array("id" => $sp["marital_status_id"]));
			$seeker_email = $this->fetch_single_data("users","email",array("id" => $user_id));
			$birthplace = $this->fetch_single_data("locations","name_".$locale,array("id" => $sp["birthplace"]));
			$birthdate = $sp["birthdate"]; $birthdate = substr($birthdate,8,2)."-".substr($birthdate,5,2)."-".substr($birthdate,0,4);
			$arr1 = array(	"{title}","{opportunity_id}","{name}","{email}","{phone}","{cellphone}","{gender}",
							"{address}","{birth_place}","{birth_date}","{nationality}","{marital_status}" );
			$arr2 = array(  $title,$opportunity_id,$sp["first_name"]." ".$sp["middle_name"]." ".$sp["last_name"],$seeker_email,$sp["phone"],$sp["cellphone"],$gender,
							$sp["address"],$birthplace,$birthdate,$sp["nationality"],$marital_status );
			$body = str_replace($arr1,$arr2,$body);
			include "../func.sendingmail.php";
			foreach($email as $_email){ sendingmail($subject,$_email,$body); }
		}
		
        public function apply_opportunity($user_id,$opportunity_id){
			if($this->is_applied($user_id,$opportunity_id) <= 0){
				if($user_id > 0){
					$this->addtable("applied_opportunities");
					$this->addfield("user_id");			$this->addvalue($user_id);
					$this->addfield("opportunity_id");	$this->addvalue($opportunity_id);
					$this->addfield("created_at");		$this->addvalue(date("Y-m-d H:i:s"));
					$this->addfield("created_by");		$this->addvalue($_SESSION["username"]);
					$this->addfield("created_ip");		$this->addvalue($_SERVER["REMOTE_ADDR"]);
					$inserting = $this->insert();
					//if($inserting["affected_rows"] > 0) $this->email_notification($user_id,$opportunity_id);
					return $inserting["affected_rows"];
				}else{
					return "error:user_not_exist";
				}
			}else{
				return "error:already_applied";
			}
		}
		
		public function is_saved($user_id,$opportunity_id){
			$this->addtable("saved_opportunities");
			$this->addfield("user_id");
			$this->where("user_id",$user_id);
			$this->where("opportunity_id",$opportunity_id);
			$this->limit(1);
			return count($this->fetch_data());
		}
		
		public function save_opportunity($user_id,$opportunity_id){
			if($this->is_saved($user_id,$opportunity_id) <= 0){
				$this->addtable("saved_opportunities");
				$this->addfield("user_id");			$this->addvalue($user_id);
				$this->addfield("opportunity_id");	$this->addvalue($opportunity_id);
				$this->addfield("created_at");		$this->addvalue(date("Y-m-d H:i:s"));
				$this->addfield("created_by");		$this->addvalue($_SESSION["username"]);
				$this->addfield("created_ip");		$this->addvalue($_SERVER["REMOTE_ADDR"]);
				$inserting = $this->insert();
				return $inserting["affected_rows"];
			}else{
				return "error:already_saved";
			}
		}
		
		public function opportunity_belongs_to_company($opportunity_id,$company_id) {
			$this->addtable("opportunities"); $this->addfield("id");
			$this->where("id",$opportunity_id); $this->where("company_id",$company_id); $this->limit(1);
			return count($this->fetch_data());
		}

		public function signup($namalengkap,$email,$password,$repassword) {
			if($password == $repassword && strlen($password) > 5) {
				$this->addtable("users");$this->addfield("id");$this->where("email",$email,null,"LIKE");
				$arr = $this->fetch_data();
				if(count($arr) > 0){
					return "error:email_already_used";
				} else {
					$this->addtable("users");
					$this->addfield("email");		$this->addvalue($email);
					$this->addfield("password");	$this->addvalue(base64_encode($password));
					$this->addfield("locale");		$this->addvalue($_COOKIE["locale"]);
					$this->addfield("created_at");	$this->addvalue(date("Y-m-d H:i:s"));
					$this->addfield("created_by");	$this->addvalue($email);
					$this->addfield("created_ip");	$this->addvalue($_SERVER["REMOTE_ADDR"]);
					$this->addfield("updated_at");	$this->addvalue(date("Y-m-d H:i:s"));
					$this->addfield("updated_by");	$this->addvalue($email);
					$this->addfield("updated_ip");	$this->addvalue($_SERVER["REMOTE_ADDR"]);
					$arrreturn = $this->insert();
					if($arrreturn["affected_rows"] > 0){
						$user_id = $arrreturn["insert_id"];
						$arrnama = explode(" ",$namalengkap);
						$first_name = $arrnama[0];
						$middle_name = isset($arrnama[1]) ? $arrnama[1] : "";
						$last_name = isset($arrnama[2]) ? $arrnama[2] : "";
						$this->addtable("seeker_profiles");$this->addfield("user_id");$this->addfield("first_name");$this->addfield("middle_name");$this->addfield("last_name");
						$this->addvalue($user_id);$this->addvalue($first_name);$this->addvalue($middle_name);$this->addvalue($last_name);
						$arrreturn = $this->insert();
						return $arrreturn["affected_rows"];
					} else {
						return "error:failed_insert_users";
					}
				}
			} else {
				return "error:password_error";
			}
		}
    }
?>
