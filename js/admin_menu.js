$(document).ready(function(){
	$(".rtable").sortable({
		items: "tr",
		stop: function(event, ui) {
			var id = ui.item.data("id"); 
			var pos = ui.item.index();
			var url = $(this).data("moveurl");
			document.location.href = url+id+"/"+pos; 
		}
	});
});