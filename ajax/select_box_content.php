<?php 
	include_once "../common.php"; 
	
	if(isset($_GET["mode"])){ $_mode = $_GET["mode"]; } else { $_mode = ""; }
	
	$data = unserialize(base64_decode($_GET["data"]));
	
	$values = $db->fetch_select_data($data["table"],$data["id"],$data["caption"],$data["where"],$data["order"],$data["limit"]);
	$selecteds = $data["selecteds"];
	$name = $data["name"];
	$maxselects = $data["maxselects"];
	
	$arr_elms = "";
	foreach($values as $id => $caption){ $arr_elms .= "'$id',"; }
	$arr_elms = substr($arr_elms,0,-1);
	
	$return = "";
	foreach($values as $id => $caption){
		$checked = (@in_array($id,$selecteds)) ? "checked" : "";
		$return .='
			<div>
			<input type="checkbox" id="'.$name.'['.$id.']" name="'.$name.'['.$id.']" value="1" '.$checked.' class="'.$class.'" onclick="return select_box_check_'.$name.'(this);"> <font color="'.$contains_color.'">'.$caption.'</font>
			</div>
		';
	}
	
	$return .='
	<script>
		function select_box_json_'.$name.'(){
			var elms_'.$name.' = new Array('.$arr_elms.');
			var arrchecked = new Array();
			x = 0;
			for(xx = 0;xx < elms_'.$name.'.length;xx++){
				arr_i = elms_'.$name.'[xx];
				if(document.getElementById("'.$name.'["+arr_i+"]").checked == true) { 
					arrchecked[x] = arr_i;
					x++;
				}
			}
			var retval = JSON.stringify(arrchecked);
			retval = retval.replace(/\"/g,"\'");
			document.getElementById("chr_'.$name.'").value = retval;
			document.getElementById("int_'.$name.'").value = retval.replace(/\'/g,"");
		}

		function select_box_check_'.$name.'(elm){
			var elms_'.$name.' = new Array('.$arr_elms.');
			var retval = true;
			if (elm.checked == true){
				var checkednum = 0;
				var arrchecked = new Array();
				for(xx = 0;xx < elms_'.$name.'.length;xx++){
					arr_i = elms_'.$name.'[xx];
					if(document.getElementById("'.$name.'[" + arr_i + "]").checked == true) {
						if(checkednum + 1 > '.$maxselects.') {
							retval = false;
							document.getElementById("'.$name.'["+arr_i+"]").checked = false;
						}
						checkednum++;
					}
				}
			}
			select_box_json_'.$name.'();
			return retval;
		}
	</script>';

echo $return;
?>