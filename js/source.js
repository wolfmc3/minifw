$(document).ready(function(){
	$(".source > pre").css({
		"font-size":"15%",
		"line-height":"3px",
		"width":"15%"
	}).hover(function(){
		$(this).animate({
			"font-size":"100%",
			"line-height":"20px",
			"width":"100%"
		},200);
	},function(){
		$(this).animate({
			"font-size":"15%",
			"line-height":"3px",
			"width":"15%"
		},200);

	}).click(function(){
		$(this).removeClass("source");
		$(this).css({
			"font-size":"100%",
			"line-height":"20px",
			"width":"100%"
		});
		$(this).hover(null,null);
	});
});