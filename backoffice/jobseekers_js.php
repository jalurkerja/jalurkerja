<script>
	function seeker_experiences(){
		popup_message("<iframe scrolling='no' id='frame_content' src=\"jobseekers_experiences.php?user_id=<?=$_GET["user_id"];?>\"></iframe>");
	}
	function seeker_certifications(){
		popup_message("<iframe scrolling='no' id='frame_content' src=\"jobseekers_certifications.php?user_id=<?=$_GET["user_id"];?>\"></iframe>");
	}
	function seeker_educations(){
		popup_message("<iframe scrolling='no' id='frame_content' src=\"jobseekers_educations.php?user_id=<?=$_GET["user_id"];?>\"></iframe>");
	}
	function seeker_languages(){
		popup_message("<iframe scrolling='no' id='frame_content' src=\"jobseekers_languages.php?user_id=<?=$_GET["user_id"];?>\"></iframe>");
	}
	function seeker_skills(){
		popup_message("<iframe scrolling='no' id='frame_content' src=\"jobseekers_skills.php?user_id=<?=$_GET["user_id"];?>\"></iframe>");
	}
	function seeker_summary(){
		popup_message("<iframe scrolling='no' id='frame_content' src=\"jobseekers_summary.php?user_id=<?=$_GET["user_id"];?>\"></iframe>");
	}
	function seeker_desires(){
		popup_message("<iframe scrolling='no' id='frame_content' src=\"jobseekers_desires.php?user_id=<?=$_GET["user_id"];?>\"></iframe>");
	}
	function general_settings(){
		popup_message("<iframe scrolling='no' id='frame_content' src=\"jobseekers_settings.php?user_id=<?=$_GET["user_id"];?>\"></iframe>");
	}
	function memberships(){
		popup_message("<iframe scrolling='no' id='frame_content' src=\"jobseekers_memberships.php?user_id=<?=$_GET["user_id"];?>\"></iframe>");
	}
	function saved_search(){
		popup_message("<iframe scrolling='no' id='frame_content' src=\"jobseekers_saved_search.php?user_id=<?=$_GET["user_id"];?>\"></iframe>");
	}
	function saved_opportunities(){
		popup_message("<iframe scrolling='no' id='frame_content' src=\"jobseekers_saved_opportunities.php?user_id=<?=$_GET["user_id"];?>\"></iframe>");
	}
	function applied_opportunities(){
		popup_message("<iframe scrolling='no' id='frame_content' src=\"jobseekers_applied_opportunities.php?user_id=<?=$_GET["user_id"];?>\"></iframe>");
	}
</script>