function showStatusMessage() {
	$("#controller_messages").position({
        my: 'right top',
        at: 'right bottom',
        of: '#logincontrol',
        offset: "0 55"
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