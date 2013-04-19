var logincontrolw = 0;
$(window).load(function() {
	if (notlogged) return;
	var logincontrolw = $("#logincontrol").delay(1000).width(); 
	$("#logincontrol").animate({"width": "0px"},1000,"easeOutBounce").hover(
			function(){ //HOVER IN
				$(this).animate({"width": logincontrolw+"px"},700,"easeOutBounce");
			},
			function(){ //HOVER OUT
				$(this).delay(1000).animate({"width": "0px"},700,"easeOutBounce")
			}
	);
});