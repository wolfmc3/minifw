function showStatusMessage() {
	$("#controller_messages").css({
        right: 12,
        top:47
       });
    $("#controller_messages").delay(2500).animate({"opacity":0},1500, function() { $(this).remove();});
    $("#controller_messages").hover(function() {
		$(this).stop(true, true).show().css("opacity","1");	
	}
	,function() {
		$(this).animate({"opacity":0},500, function() { $(this).remove();});
	});
};
$(window).load(function() {
	showStatusMessage();
});