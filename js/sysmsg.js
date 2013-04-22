function showStatusMessage() {
	$("#controller_messages").position({
        my: 'right top',
        at: 'right bottom',
        of: '#logincontrol',
        "offset": "25 55",
        collision:"flip flip"
       });
    $("#controller_messages").delay(1500).animate({"opacity":0},1500);

};
$(window).load(function() {
	showStatusMessage();
});