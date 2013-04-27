$(window).load(function() {
	$(".menu").children("li").each(function() {
		var submenu = $(this).children('.submenu');
		
		if (submenu.length == 1) {
				submenu.attr("id","submenu_"+$(this).attr("id"));
				submenu.addClass("dropdown-menu");
				submenu.hide();
				$(submenu).hover(function() {
					$(this).stop(true, true).show();
				}, function() {
					$(this).hide(200);
				});

				var link = $(this).children("a");
				link.hover(function() {
					var submenuname = "#submenu_" + $(this).parent().attr("id");
					pos = $(this).position();
					$(submenuname).css("left", pos.left + "px");
					$(submenuname).show(200);
				}, function() {
					var submenuname = "#submenu_" + $(this).parent().attr("id");
					$(submenuname).hide(200);
				});
		}

	});	
});
