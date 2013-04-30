<?php 
/**
 * Modulo applink 
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package modules
 *
 */
namespace modules;
use framework\html\module;
use framework\html\anchor;
use framework\app;
/**
 *
 * Genera un link HTML che punta alla home dell'applicazione
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package modules
 *
 */
class applink extends module {
	/**
	 * Genera il tag thml che punta alla home dell'applicazione
	 * @see \framework\html\module::render()
	 */
	function render() {
		$this->append(new anchor(app::root().app::conf()->system->defaultobj, app::conf()->system->appname,array("class"=>"brand","id"=>"homelink")));
	}
}