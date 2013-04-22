$(document).ready(
		function() {
			$("tr[data-id]").css("cursor", "pointer").click(
					function() {
						var baseurl = $(this).parents("table").data("editurl");
						if (baseurl) window.location = baseurl + $(this).data("id");
			});
			$("tr[data-id]").find('a[href*="#remove"]').each(function() {
				$(this).parent().css("text-align","center");
				$(this).click(
						function(ev) {
							ev.stopPropagation();
							ev.preventDefault();
							if (confirm("Vuoi cancellare?")) window.location = $(this).parents("table").data("delurl") + $(this).parents("tr[data-id]").data("id");
				});
				
			});
			$(".inlinedetail").click(function(event){
				var tr = $(this).closest("tr");
				var next = tr.next("tr"); 
				if (next && !next.hasClass("refline")) {
					var cols = tr.children("td").length;
					var newtr = $("<tr>").append("<th>Dettagli</th><td class='alert alert-info' colspan="+(cols-1)+">"+tr.data("id")+"</td>");
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

			$(".fwpaging").delay(1000).animate({"opacity":0.4},1200).hover(function () {
				$(this).animate({'opacity':1}, 250);
			}, function (){
				$(this).animate({'opacity':0.4}, 350);
			});
		});
