<?php include_once "common.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta property="og:image" content="images/logo_transparent.png">
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<meta http-equiv="X-UA-Compatible" content="IE=8;" />
		<meta name="keywords" content="lowongan, lowongan kerja, lowongan pekerjaan, lowongan kerja terbaru, lowongan kerja pt, lowongan kerja bank, job fair, bursa kerja"/>
		<meta name="description" content="jalurkerja.com adalah salah satu situs rekrutmen tenaga kerja online yang terbesar dengan informasi 	lowongan kerja terbaru setiap hari dari berbagai perusahaan di Indonesia. . karir indonesia"/>
		<meta name="title" content="situs informasi lowongan kerja terbaru dan karir di Indonesia | jalurkerja.com"/>
		<meta name="language" content="id"/>
		<meta name="country" content="indonesia"/>
		<meta name="source" content="http://www.jalurkerja.com/"/>
		<meta name="subject" content="human resources"/>
		<meta name="revisit-after" content="7 days"/>
		<meta name="robots" content="index, follow"/>
		<link rel="Shortcut Icon" href="favicon.ico">
		<title id="titleid">JalurKerja.com [BETA]</title>
		
		<script src="scripts/jquery-1.10.1.min.js"></script>
		<script type="text/javascript" src="scripts/jquery.fancybox.js"></script>
		<script type="text/javascript" src="calendar/calendar.js"></script>
		<script type="text/javascript" src="calendar/lang/calendar-en.js"></script>
		<script type="text/javascript" src="calendar/calendar-setup.js"></script>

		<link rel="stylesheet" type="text/css" href="styles/style.css">
		<link rel="stylesheet" type="text/css" href="calendar/calendar-win2k-cold-1.css">
		<link rel="stylesheet" type="text/css" href="styles/jquery.fancybox.css" media="screen" />
		<link rel="stylesheet" href="font/font.css">
		<script>
			var global_respon = new Array();
			var select_box_active_id = "";
			
			function toogle_bo_filter(){
				var bo_filter_container = document.getElementById('bo_filter_container'),
				style = window.getComputedStyle(bo_filter_container),
				bo_filter_container_display = style.getPropertyValue('display');
				if(bo_filter_container_display == "none") {
					bo_filter_container.style.display="block";
					bo_expand.innerHTML="[-] Hide Filter";
				}
				if(bo_filter_container_display == "block") {
					bo_filter_container.style.display="none";
					bo_expand.innerHTML="[+] View Filter";
				}
			}
			
			function hiding_select_box(current_id){
				if(select_box_active_id != "" && current_id != select_box_active_id){
					$("#"+select_box_active_id).fadeOut(500);
					select_box_active_id = "";
				}
			}
			
			function get_ajax(x_url,target_elm,done_function,withloading = true){
				$( document ).ready(function() {
					if(withloading) popup_message("<img src='icons/loading.gif' width='100'><br><div style='width:100px;height:5px;background-color:white;position:relative;top:-5px;left:100px;'></div>");
					$.ajax({url: x_url, success: function(result){
						try{ $("#"+target_elm).html(result); } catch(e){}
						try{ $("#"+target_elm).val(result); } catch(e){}
						try{ global_respon[target_elm] = result; } catch(e){}
						try{ eval(done_function || ""); } catch(e){}
						if(withloading) { try{ $.fancybox.close(); } catch(e){} }
					}});
				});
			}
			
			function popup_message(message,mode,actionAfterClose){
				mode = mode || "";
				actionAfterClose = actionAfterClose || "";
				$.fancybox.open({
					content:"<div style='overflow:auto;'><table class='popup_message "+mode+"'><tr><td>"+message+"</td></tr></table></div>",
					afterClose: function(){ try{ eval(actionAfterClose); } catch(e){} }
				});
			}
			
			function validateEmail(email) {
				var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				return re.test(email);
			}
			
			function openwindow(url){ 
				var n = window.open(url,""," scrollbars=yes,width=1100,height=800"); 
				if(n==null) { alert("Izinkan browser Anda untuk membuka popup window!"); }
			}
		</script>
	</head>
	<body id="bodyid" style="margin:0px;">