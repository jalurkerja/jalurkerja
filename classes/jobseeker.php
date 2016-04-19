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
		
        public function apply_opportunity($user_id,$opportunity_id){
			if($this->is_applied($user_id,$opportunity_id) <= 0){
				$this->addtable("applied_opportunities");
				$this->addfield("user_id");			$this->addvalue($user_id);
				$this->addfield("opportunity_id");	$this->addvalue($opportunity_id);
				$this->addfield("created_at");		$this->addvalue(date("Y-m-d H:i:s"));
				$this->addfield("created_by");		$this->addvalue($_SESSION["username"]);
				$this->addfield("created_ip");		$this->addvalue($_SERVER["REMOTE_ADDR"]);
				return $this->insert()["affected_rows"];
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
				return $this->insert()["affected_rows"];
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
