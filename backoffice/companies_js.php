<script>
	function change_status(id,value){
		get_ajax("../ajax/bo_companies_ajax.php?mode=change_status&id="+id+"&value="+value);
	}
	
	function call_histories(){
		popup_message("<iframe scrolling='no' id='frame_content' src=\"companies_call_histories.php?id=<?=@$_GET["id"];?>\"></iframe>");
	}
	
	function open_admin_users(company_id){
		popup_message("<iframe scrolling='no' id='frame_content' src=\"companies_admin_users_list.php?company_id="+company_id+"\"></iframe>");
	}
	
</script>