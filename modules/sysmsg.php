<?php 
namespace modules;
use framework\html\module;
use framework\html\element;
use framework\html\responsive\div;
/**
 * Messages()
 *
 * Utilizzato nel template HTML per reperire i messaggi destinati all'utente (conferme, notifiche, ecc)<br>
 * Genera un TAG DIV con id="controller_messages"<br>
 * $_SESSION["ctrl_messages"] viene azzerata automaticamente<br>
 * per aggiungere messaggi utilizzare il metodo <code>addMessage(...)</code>
 *
 */
class sysmsg extends module {
	function render() {
		if (!isset($_SESSION["ctrl_messages"])) return;
		$messages = $_SESSION["ctrl_messages"];
		$msgcont = new element("div",array(
				"id"=>"controller_messages",
				"style"=>"display:block;position:absolute;text-align:right;margin-right:15px;"
		));
		//$div = new div("icon-star", "",array("style"=>"height: 12px;"));
		//$div->add(" ");
		//$msgcont->add($div);
		foreach ($messages as $line) {
			$msgcont->add(new element("div",array("class"=>"sysmsg alert alert-error"),$line,TRUE));
		}
		$this->add($msgcont);
	}
	
	function __toString() {
		if (isset($_SESSION["ctrl_messages"])) unset($_SESSION["ctrl_messages"]);
		return parent::__toString();
	}
}