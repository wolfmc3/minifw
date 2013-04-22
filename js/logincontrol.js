var logincontrolw = 0;
$(window).load(function() {
	if ($("#logincontrol").find(".username").length != 1) return;
	var logincontrolw = $("#logincontrol").find(".username").delay(1000).width(); 
	$("#logincontrol").find(".username").animate({"opacity":0,"width": "0px"},1000,"easeOutBounce");
	$("#logincontrol").hover(
			function(){ //HOVER IN
				$(this).find(".username").animate({"opacity":1, "width": logincontrolw+"px"},700,"easeOutBounce");
			},
			function(){ //HOVER OUT
				$(this).find(".username").delay(1000).animate({"opacity":0,"width": "0px"},700,"easeOutBounce");
			}
	);
});