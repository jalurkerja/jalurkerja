<script>
	function loadSelectCompanies(name,keycode){
		if(keycode==27){
		  div_select_company.style.display="none";
		}else{
		  if(name != ""){
			try{ company_id.value=""; } catch (e){}
			get_ajax("../ajax/opportunity_ajax.php?mode=loadSelectCompany&name="+name,"SelectCompaniesList","loadingSelectCompanies();");
		  }else{
			div_select_company.style.display="none";
		  }
		}
	}
	
	function loadingSelectCompanies(){
		var returnvalue = global_respon['SelectCompaniesList'];
		if(returnvalue != ""){
		  div_select_company.style.display="block";
		  select_company.innerHTML=returnvalue;
		}else{
		  div_select_company.style.display="none";
		}
	}
	
	function pickSelectCompanyList(company_id,company_name){
		try{ document.getElementById("company_id").value = company_id; } catch (e){}
		try{ document.getElementById("company_name").value = company_name; } catch (e){}
		div_select_company.style.display="none";
		loadDetailCompany(company_id);
	}
	
	function loadDetailCompany(company_id){
		get_ajax("../ajax/opportunity_ajax.php?mode=loadDetailCompany&company_id="+company_id,"DetailCompany","loadingDetailCompany();");
	}
	function loadingDetailCompany(company_id){
		var returnvalue = global_respon['DetailCompany'];
		returnvalues = returnvalue.split("|||");
		document.getElementById("industry_id").value			= returnvalues[0];
		document.getElementById("web").value					= returnvalues[1];
		document.getElementById("company_description").value	= returnvalues[2];
		document.getElementById("location").value				= returnvalues[3];
		document.getElementById("email").value					= returnvalues[4];
		document.getElementById("contact_person").value			= returnvalues[5];
	}

	function opportunity_detail_parsing(){
		var opportunity__id = document.getElementById("opportunity__id").innerHTML || "";
		var returnval = "";
		if(opportunity__id != "NULL"){
			get_ajax("../ajax/searchjob_ajax.php?mode=isapplied&user_id=<?=$__user_id;?>&opportunity_id="+opportunity__id,"isapplied","update_applybtn_class(global_respon['isapplied']);");
			
			if(opportunity__logo.innerHTML != "") {
				opportunity___logo.innerHTML 		= "<img src='../company_logo/" + opportunity__logo.innerHTML + "'>";
			} else {
				opportunity___logo.innerHTML 		= "";
			}
			opportunity___name.innerHTML 			= opportunity__name.innerHTML;
			opportunity___industry.innerHTML 		= opportunity__industry.innerHTML;
			opportunity___web.innerHTML 			= "<a href='" + opportunity__web.innerHTML + "' target='_BLANK'>" + opportunity__web.innerHTML + "</a>";
			opportunity___contact_person.innerHTML 	= opportunity__contact_person.innerHTML;
			opportunity___description.innerHTML 	= opportunity__description.innerHTML;
			opportunity___title.innerHTML 			= document.getElementById("opportunity__title_<?=$__locale;?>").innerHTML;
			opportunity___job_function.innerHTML 	= opportunity__job_function.innerHTML;
			opportunity___job_levels.innerHTML 		= opportunity__job_levels.innerHTML;
			opportunity___degree.innerHTML 			= opportunity__degree.innerHTML;
			opportunity___majors.innerHTML 			= opportunity__majors.innerHTML;
			opportunity___work_experience.innerHTML = opportunity__experience_years.innerHTML + " <?=$v->words("years");?>";
			opportunity___salary_offer.innerHTML 	= opportunity__salary_offer.innerHTML;
			opportunity___posted_date.innerHTML 	= opportunity__posted_date.innerHTML;
			opportunity___closing_date.innerHTML 	= opportunity__closing_date2.innerHTML;
			opportunity___descriptions.innerHTML 	= opportunity__descriptions.innerHTML;
			if(!opportunity__descriptions.innerHTML) opportunity___descriptions.innerHTML 	= "{<?=$v->words("empty_description");?>}";
			opportunity___requirements.innerHTML 	= opportunity__requirements.innerHTML;
		} else {
			document.getElementById("opportunity_detail_empty").style.display = "block";
			document.getElementById("opportunity_detail").style.display = "none";
		}
	}
	
	function load_detail_applicant(opportunity_id){
		$.fancybox.open({ href: "opportunities_applicant.php?opportunity_id="+opportunity_id, type: 'iframe',width:'1050px' });
	}
	
	function reposting(){
		var opportunity_ids = new Array();
		var list_form = document.getElementById("opportunities_list").elements;
		var xx = 0;
		for(var i = 0; i < list_form.length; i++) {
			if(list_form[i].type == "checkbox" && list_form[i].checked == true) {
				opportunity_ids[xx] = list_form[i].id;
				xx++;
			}
		}
		if(opportunity_ids.length > 0){
			var posting_date = prompt("Masukkan tanggal posting:", "<?=date("Y-m-d");?>");
			get_ajax("../ajax/opportunity_ajax.php?mode=reposting&opportunity_ids="+opportunity_ids+"&posting_date="+posting_date,"reposting_span");
		}
		
	}
</script>
<span id="reposting_span"></span>