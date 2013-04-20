$(document).ready(
		function() {
			$("tr[data-id]").hover(function() {
				$(this).find("td").addClass("highlight");
			}, function() {
				$(this).find("td").removeClass("highlight");
			});
			$("tr[data-id]").css("cursor", "pointer").click(openEdit);
			$(".addperm").click(openEdit);
			$("tr[data-id]").find('a[href*="#remove"]').each(
					function() {
						$(this).parent().css("text-align", "center");
						$(this).click(
								function(ev) {
									ev.stopPropagation();
									ev.preventDefault();
									if (confirm("Vuoi cancellare?"))
										window.location = $(this).parents(
												"table").data("delurl")
												+ $(this)
														.parents("tr[data-id]")
														.data("id");
								});

					});
		});
function openEdit() {
	var url = ($(this).prop("tagName")=="A")?$(this).attr("href"):$(this).parents("table").data("openurl") + $(this).data("id");
	$("<div title='Modifica permessi'></div>").load(url, function() {
		$(this).find(".checkboxes").buttonset();
		$(this).dialog({
			modal : true,
			width : 550,
			height : 350,
			show : "fade",
			buttons : {
				"Salva" : function() {
					$(this).find("form").submit();
					$(this).dialog("close").dialog("destroy").remove();
				}
			}
		});
	});
	return false;
}