$(document).ready(function() {
	$(".button").button();
	$(".addspecial").click(function() {
		$("<div></div>").attr("title", $(this).text()).load($(this).attr("href"), function() {
			$(this).find("#addtype").change(function(){
				if ($(this).val() == "/") {
					$("#viewcont").show();
					$("#viewcont").find("selaction").attr("disabled","1");
				} else {
					$("#viewcont").hide();
					$("#viewcont").find("selaction").attr("disabled","0");
				}
			});
			$(this).dialog({
				height : 300,
				width : 480,
				resizable : false,
				modal : true,
				buttons : {
					"Aggiungi" : function() {
						var vals = "";
						$.each($(this).find("form").serializeArray(), function(i, l) {
							vals += l.value + (vals == "" ? "" : "/");
						});
						$("#cols").append($("<option></option>").attr("value", vals).attr("selected", "1").text(vals));
						alert(vals);
						$(this).dialog("close");
						$(this).dialog('destroy').remove()
					},
					"Annulla" : function() {
						$(this).dialog("close");
						$(this).dialog('destroy').remove()
					}
				}
			});
		});
		return false;
	});
	$("#cols").change(function() {
		$("#settings tbody").html("");
		$.each($(this).val(), function() {
			var tr = $("<tr>");
			// div.css({"border":"1px
			// solid
			// #252525","padding":"3px","margin":"3px"});
			addTd(tr, "<b>" + this + "</b>")

			var input = $("<input>");
			input.attr({
				"name" : "settings[" + this + "][name]"
			}).val("Colonna " + this);
			addTd(tr, input);

			if (cols[this]) {
				var input = $("<input>");
				input.attr({
					"type" : "checkbox",
					"checked" : "1",
					"name" : "settings[" + this + "][ontable]"
				}).val("true");
				addTd(tr, input);

				var input = $("<input>");
				input.attr({
					"readonly" : "1",
					"name" : "settings[" + this + "][datatype]"
				}).val(cols[this]['datatype']);
				addTd(tr, input);

				var input = $("<input>");
				input.attr({
					"readonly" : "1",
					"name" : "settings[" + this + "][len]"
				}).val(cols[this]['len']);
				addTd(tr, input);

				var input = $("<input>");
				input.attr({
					"readonly" : "1",
					"name" : "settings[" + this + "][null]"
				}).val(cols[this]['Null'] == "NO" ? "false" : "true");
				addTd(tr, input);
			} else {
				addTd(tr, "-");
				addTd(tr, "-");
				addTd(tr, "-");
				addTd(tr, "-");
			}

			$("#settings tbody").append(tr);
		})
	})
	$("#tocopy").select();
})
function addTd(cont, el) {
	$(cont).append($("<td>").append(el));
}