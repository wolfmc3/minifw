$(document).ready(
		function() {
			$("tr[data-id]").hover(function() {
				$(this).find("td").addClass("highlight");
			}, function() {
				$(this).find("td").removeClass("highlight");
			});
			$("tr[data-id]").css("cursor", "pointer").click(
					function() {
						var baseurl = $(this).parents("table").data("editurl");
						if (baseurl) window.location = baseurl + $(this).data("id");
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
			$(".inlinedetail").click(function(event){
				var tr = $(this).closest("tr");
				var next = tr.next("tr"); 
				if (next && !next.hasClass("refline")) {
					var cols = tr.children("td").length;
					var newtr = $("<tr>").append("<td>Dettagli</td><td colspan="+(cols-1)+">"+tr.data("id")+"</td>");
					newtr.addClass("refline");
					tr.after(newtr);
					newtr.children("td:last").addClass("border").load($(this).attr("href")+" table");
					$(this).addClass("rotateDown");
				} else {
					$(this).removeClass("rotateDown");
					next.remove();
				}
				event.preventDefault();
				event.stopPropagation();
			});
		})
