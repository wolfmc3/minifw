var logincontrolw = 0;
$(window).load(function() {
	if (notlogged) return;
	var logincontrolw = $("#logincontrol").delay(1000).width(); 
	$("#logincontrol").delay(1000).animate({"width": "0px"},1000).hover(
			function(){ //HOVER IN
				$(this).animate({"width": logincontrolw+"px"},300);
			},
			function(){ //HOVER OUT
				$(this).delay(500).animate({"width": "0px"},500)
			}
	);
});