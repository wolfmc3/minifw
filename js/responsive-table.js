
$(window).resize(checkResizeTable);
$(window).load(checkResizeTable);

function checkResizeTable() {
	var small = $(this).width() <  700;
	$(".rtable").delay(500).each(function(){
		if ($(this).data("small") != small) {
			$(this).data("small",small);
			if (small) {
				
				$(this).find("thead").hide();
				var ths = $(this).find("thead").find("th");
				$(this).find("tbody").find("td").css("display","block");
				$(this).find("tbody").find("tr").each(function() {
					$(this).find("td").each(function(index){
						
						$(this).prepend($("<b class='table-title span1' style='display: inline-block; min-width: 30%;width: auto;'>"+(index==0?"<br>":"")+$(ths[index]).text()+"</b>"));
						
					});
				});
			} else {
				$(this).find("thead").show();
				$(this).find("tbody").find("td").css("display","");
				$(this).find(".table-title").remove();
			};
		};
	});
	
};