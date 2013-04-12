$(document).ready(function() {
	$(".numeric").spinner();
	$(".bool").buttonset();
	$(".date,.time").change(function() {
		var cur = "";
		$("[data-ref='"+$(this).data("ref") +"']").each(function(){
			cur += $(this).val() + ' ';
		});
		cur = new Date(Date.parse(cur));
		$("#"+$(this).data("ref")).val(cur.toISOString());
	});
	$(".date").datepicker({dateFormat: 'mm/dd/yy',changeMonth: true,
	      changeYear: true});
	
	$(".currency").spinner({
	      step: 25,
	      numberFormat: "C"
	});
	$("form").submit(function(){
		$(".valerror").remove();
		var correct = true;
		$.each($(this).serializeArray(), function(i, field) {
			var input = $("[name='"+field.name+"']");
			if (regex = input.data("validate")) {
				var pattern = new RegExp(regex);
				var res = field.value.match(regex);
				if (!res) { //NOT MATCH
					correct = false;
					input.closest("td").append($("<span>").addClass("valerror").append("Dato non valido"));
				} 
			}
		});
		return correct;
	})
		$(".selectitem").click(function() {
			var itemClicked = $(this);
			$("<div></div>").attr("title", $(this).text()).load($(this).attr("href")+" table", function() {
				$(this).dialog({
					height : 600,
					width : 850,
					resizable : false,
					modal : true,
					open : function() {
						$(this).find("tr[data-id]").hover(function() {
							$(this).find("td").addClass("highlight");
						}, function() {
							$(this).find("td").removeClass("highlight");
						});
						$(this).find("tr[data-id]").css("cursor", "pointer").click(
							function() {
								var container = itemClicked.closest("td");
								var input = container.find("input");
								input.val($(this).data("id"));
								container.find("a").find("span").remove();
								$(this).closest('.ui-dialog-content').dialog('close').dialog('destroy').remove();
						});
						$(this).find('a').replaceWith(function() {
							var label = $(this).text();
							return label;
						});

					},
					buttons : {
						"Annulla" : function() {
							$(this).dialog("close");
							$(this).dialog('destroy').remove()
						}
					}
				});
			});
			return false;
		});

});