function showStatusMessage() {
	$("#controller_messages").animate({"opacity":0.8},800).delay(5000).animate({"padding-top":0,"padding-right":0,"opacity":0},500, function() { $(this).remove();});
	$("#controller_messages").hover(function() {
		$(this).stop(true, true).show().css("opacity","1");	
	}
	,function() {
		$(this).animate({"padding-top":0,"padding-right":0,"opacity":0},500, function() { $(this).remove();});
	});
};
$(window).load(function() {
	showStatusMessage();
});