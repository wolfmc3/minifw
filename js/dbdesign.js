$(document).ready(function() {
	$(".button,input[type='submit']").button();
	$("select").css("min-width", "380px");
	$('#id option').attr("selected",1);
	$('#names option:first').attr("selected",1);
	$(".includefield").click(function() {
		$('#cols option:selected').remove().appendTo('#fields');
		updateFields();
		return false;
	});
	$(".excludefield").click(function() {
		$('#fields option:selected').remove().appendTo('#cols');
		updateFields();
		return false;
	});
	$(".addspecial").click(function() {
		$("<div></div>").attr("title", $(this).text()).load($(this).attr("href"), function() {
			$(this).dialog({
				height : 450,
				width : 850,
				resizable : false,
				modal : true,
				open : function() {
					$(this).find(".fieldlist_add").css({
						"font-size":"50%",
						"padding":"2px",
						"display":"inline-block",
						"border":"1px solid gray",
						"border-radius": "3px",
						"width":"100px",
						"overflow":"hidden"
					}).click(function() {
						var field = "{"+$(this).attr("href")+"}";
						$("#expr").val($("#expr").val()+field);
						return false;	
					});
					$(this).find("div").css({
						"margin-bottom" : "3px",
						"line-height" : "32px"
					});
					$(this).find("select, textarea").css({"float": "right","width": "80%"});
					$("#addtype").change(function() {
						$(lastSelector).hide().find("select,textarea").attr("disabled", "1");
						lastSelector = FormSelectorClass[$(this).val()];
						$(lastSelector).show().find("select,textarea").removeAttr("disabled");
						if (lastSelector == ".showtable")
							$("#selectviews").change();
					});
					$("#selectviews").change(function() {
						var dest = $("#target");
						var view = $(this).val();
						var url = document.location.href.replace("design", "viewinfo")
						$.getJSON(url, function(data) {
							var v = data[view];
							$(dest).addOptions(v.fields);
						});
					})
					$("#addtype").change();
				},
				buttons : {
					"Aggiungi" : function() {
						var vals = "";
						$.each($(this).find("form").serializeArray(), function(i, l) {
							if (l.value) vals += l.value + (vals == "" ? "" : "/");
						});
						if (vals.length == 1) return false;
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
	$("#tocopy").select();
})
var formtypes = {
	"text" : "Testo",
	"readonly" : "Visualizza",
	"longtext" : "Testo multiriga",
	"numeric" : "Numero",
	"currency" : "Valuta",
	"date" : "Data",
	"datetime" : "Data e ora",
	"time" : "Orario",
	"bool" : "Si/no"
};

jQuery.fn.addOptions = function(options) {
	var element = this;
	$(element).html("");
	$.each(options, function(key, value) {
		if (value == "§") value = "";
		$(element).append($("<option>").attr("value", key).text(value));
	});
}
var FormSelectorClass = {
	"/" : ".showtable",
	"+" : ".showtable",
	"?" : ".viewrecord",
	"!" : ".viewrecord",
	"=" : ".calcfield"
}
var lastSelector = ".showtable, .viewrecord, .calcfield";

function addTd(cont, el, text) {
	td = $("<td>").append(el)
	if (text)
		td.append(text);
	$(cont).append(td);
}

function updateFields() {
		$("#settings tbody").html("");
		$("#fields").find("option").each(function() {
			var value = $(this).val();
			var tr = $("<tr>");
			// div.css({"border":"1px
			// solid
			// #252525","padding":"3px","margin":"3px"});
			addTd(tr, "<b><small>" + value + "</small></b>")

			var input = $("<input>");
			input.attr({
				"name" : "settings[" + value + "][name]"
			}).val(value);
			addTd(tr, input);

			var input = $("<input>");
			input.attr({
				"type" : "checkbox",
				"checked" : "1",
				"name" : "settings[" + value + "][ontable]"
			}).val("1");
			addTd(tr, input);

			if (colsrawdata[value]) {

				var input = $("<select>");
				input.attr({
					"name" : "settings[" + value + "][inputtype]"
				})
				input.addOptions(formtypes);
				addTd(tr, input);

				var input = $("<select>");
				input.attr({
					"name" : "settings[" + value + "][relation]"
				})
				input.addOptions(listviews);
				addTd(tr, input);

				var input = $("<input>");
				input.attr({
					"type" : "checkbox",
					"name" : "settings[" + value + "][required]"
				}).val(1);
				if (colsrawdata[value]['Null'] == "NO") {
					input.attr({
						"onclick":"alert('Richiesto obbligatorio dal database');return false;",
						"checked":"1"
					});
				}
				addTd(tr, input);

				var input = $("<input>");
				input.attr({
					"name" : "settings[" + value + "][regexpr]"
				}).val("");
				addTd(tr, input);

				var input = $("<input>");
				input.attr({
					"readonly" : "1",
					"type" : "hidden",
					"name" : "settings[" + value + "][datatype]"
				}).val(colsrawdata[value]['datatype']);

				addTd(tr, input, input.val());

				var input = $("<input>");
				input.attr({
					"readonly" : "1",
					"type" : "hidden",
					"name" : "settings[" + value + "][len]"
				}).val(colsrawdata[value]['len']);
				addTd(tr, input, input.val());

				var input = $("<input>");
				input.attr({
					"readonly" : "1",
					"type" : "hidden",
					"name" : "settings[" + value + "][null]"
				}).val(colsrawdata[value]['Null'] == "NO" ? "0" : "1");
				addTd(tr, input, input.val());
			} else {
				addTd(tr, "-");
				addTd(tr, "-");
				addTd(tr, "-");
				addTd(tr, "-");
				addTd(tr, "-");
				addTd(tr, "-");
			}

			$("#settings tbody").append(tr);
		})
}
