<?php
/**
 * Modulo footer
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package modules
 *
 */

namespace modules;
use framework\html\module;
use framework\html\element;
use framework\html\responsive\div;
use framework\html\anchor;
use framework\app;
/**
 *
 * Genera un DIV html con il contenuto del footer
 *
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package modules
 *
 */
class footer extends module {
/**
 * Genera il contenuto del footer include anche il modulo themeswitch
 * @see \framework\html\module::render()
 * @see \modules\footer
 */
	function render() {
		$this->add(element::hr());
		$this->append(new div("navbar text-center"))->append(new element("p",array("class"=>"text-center")))->add(array(
			"Builded with mini_fw",
			" v.".app::conf()->core->version,
			new anchor("https://github.com/wolfmc3/minifw", "Info"),
			app::Controller()->Module("themeswitch")
		));
	}
}