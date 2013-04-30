$(document).ready(function() {
	$(".checkboxes").each(function() {
		$(this).find(".btn").click(function() {
			//$(this).parent().find("button").removeClass("active");
			var control = $(this);
			var hidden = $(control.data("name"));
			if (control.hasClass("active")) {
				control.removeClass("active");
				hidden.val("");
			} else {
				control.addClass("active");
				var val = control.data("value");
				hidden.val(val);
			}
			return false;
		});
	});
});