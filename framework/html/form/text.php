<?php
/**
 *
 * text.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\html\form;
	use framework\html\element;
/**
 * text
 *
 * Genera un blocco html input per il testo
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/html
 *
 */
	class text extends element {
		/**
		 * Costruttore
		 *
		 * @param string $key Nome del campo input (attributo name)
		 * @param string $text Valore del campo (attributo value)
		 */
		function __construct($key, $text) {
			parent::__construct("input",array("type" => "text","value"=> $text,"name" => $key));
		}
	}

