<script>
	function change_status(id,value){
		get_ajax("../ajax/bo_companies_ajax.php?mode=change_status&id="+id+"&value="+value);
	}
	
	function call_histories(){
		popup_message("<iframe scrolling='no' id='frame_content' src=\"companies_call_histories.php?id=<?=$_GET["id"];?>\"></iframe>");
	}
	
</script>