$(document).ready(
		function() {
			$("tr[data-id]").hover(function() {
				$(this).find("td").addClass("highlight");
			}, function() {
				$(this).find("td").removeClass("highlight");
			});
			$("tr[data-id]").css("cursor", "pointer").click(
					function() {
						window.location = $(this).parents("table").data("openurl") + $(this).data("id");
			})
			$("tr[data-id]").find('a[href*="#remove"]').each(function() {
				$(this).parent().css("text-align","center")
				$(this).click(
						function(ev) {
							ev.stopPropagation();
							ev.preventDefault();
							if (confirm("Vuoi cancellare?")) window.location = $(this).parents("table").data("delurl") + $(this).parents("tr[data-id]").data("id");
				})
				
			})
		})
