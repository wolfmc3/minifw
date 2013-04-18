$(document).ready(
		function() {
			$("#contents").find("a").button();
			$("#sec_modules").change(function(){
				$("#secinfo").load($(this).data("info")+$(this).val());
			})
			$("#sec_modules").change();
});