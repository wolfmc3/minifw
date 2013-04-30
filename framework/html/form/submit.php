<?php
/**
 *
 * submit.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\html\form;
	use framework\html\element;
	/**
	 * submit
	 *
	 * Genera un pulsante submit submit
	 *
	 * @author Marco Camplese <info@wolfmc3.com>
	 * @package minifw/html
	 *
	 */
	class submit extends element {
		/**
		 * Costruttore
		 * @param string $text Titolo del pulsante
		 * @param string[] $attr Attributi opzionali del bottone
		 */
		function __construct($text,$attr = array()) {
			parent::__construct("input",$attr);
			$this->addAttr("class", "btn");
			$this->addAttr("type", "submit");
			$this->addAttr("value", $text);
			$this->addAttr("name", "SAVE");
		}
	}

