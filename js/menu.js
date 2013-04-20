$(document).ready(function() {
	$("#mainmenu .menu").children("li").each(function() {
		var child = $(this).children('.submenu');

		if (child.length == 1) {
			if (child.children("ul").children("li").length == 0) {
				child.remove();
			} else {
				$("body").append(child);
				child.hide();
				var submenuname = "#submenu_" + $(this).children("a").attr("id");
				$(submenuname).hover(function() {
					$(this).stop(true, true).show();
				}, function() {
					$(this).hide();
				});

				var link = $(this).children("a");
				link.hover(function() {
					var submenuname = "#submenu_" + $(this).attr("id");
					pos = $(this).offset();
					$(submenuname).css("left", pos.left + "px");
					$(submenuname).show();
				}, function() {
					var submenuname = "#submenu_" + $(this).attr("id");
					$(submenuname).hide();
				});
				
			}
		}

	});	
});
