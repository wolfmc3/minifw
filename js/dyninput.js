$(document).ready(function() {
	$(".numeric").spinner();
	$(".currency").spinner({
	      step: 25,
	      numberFormat: "C"
	});
	$("form").submit(function(){
		$(".valerror").remove();
		var correct = true;
		$.each($(this).serializeArray(), function(i, field) {
			var input = $("[name='"+field.name+"']");
			if (regex = input.data("validate")) {
				var pattern = new RegExp(regex);
				var res = field.value.match(regex);
				if (!res) { //NOT MATCH
					correct = false;
					input.closest("td").append($("<span>").addClass("valerror").append("Dato non valido"));
				} 
			}
		});
		return correct;
	})
	
});