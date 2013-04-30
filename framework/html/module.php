<?php
/**
 *
 * module.php
 *
 *
 * @author Marco Camplese <info@wolfmc3.com>
 */
namespace framework\html;
/**
 *
 * Classe module
 *
 * Classe per creare moduli, le classi derivate di questa classe devono essere salvate nella cartella /modules
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package framework\html
 */
class module extends element {
/**
 * Questo metodo deve essere ridefinito
 * @param boolean $force Impostata dal controller, la prima volta che il controller richiama questo metodo è FALSE nelle successive TRUE
 * @return boolean Indica al controller che l'inizializzazione è avvenuta con successo
 */
	function render($force) {
		return true;
	}
	/**
	 * Costruttore impostato su final per non essere ridefinito nella classe derivata
	 */
	final function __construct() {
		parent::__construct();

	}
}