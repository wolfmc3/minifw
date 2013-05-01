<?php
/**
 *
 * source.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\html;
use framework\app;
/**
 *
 * Classe source
 *
 * Estrae il codice sorgente della vista specificata
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/html
 *
 */
class source extends element {
	/**
	 * Costruttore
	 *
	 * @param string $view Oggetto view
	 */
	function __construct($view) {
		app::Controller()->getPage()->addJavascript("source.js");
		$pre = new element("pre");
		$cont = file_get_contents("views/$view.php");
		$cont = preg_replace("%/\*(?:(?!\*/).)*\*/%s", "", $cont);
		$pre->add($cont);

		parent::__construct("div",array("class"=>"source"),$pre);
	}
}