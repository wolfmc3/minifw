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
		$cont = file_get_contents("views/$view.php");
		parent::__construct("pre",array(),$cont);
	}
}