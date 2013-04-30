<?php
/**
 *
 * hidden.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\html\form;
	use framework\html\element;
	/**
	 * hidden
	 *
	 * Genera un campo input nascosto
	 *
	 * @author Marco Camplese <info@wolfmc3.com>
	 * @package minifw/html
	 *
	 *
	 */

	class hidden extends element {
		/**
		 * Costruttore
		 *
		 * @param string $key Nome campo (attributo name)
		 * @param string $text Valore (attributo value)
		 * @param string[] $options Attributi opzionali
		 */
		function __construct($key, $text, $options = array()) {
			parent::__construct("input",$options);
			$this
				->addAttr("type", "hidden")
				->addAttr("value", $text)
				->addAttr("name", $key)
			;
		}
	}

