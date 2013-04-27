<?php
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
		 */
		function __construct($text,$attr = array()) {
			parent::__construct("input",$attr);
			$this->addAttr("class", "btn");
			$this->addAttr("type", "submit");
			$this->addAttr("value", $text);
			$this->addAttr("name", "SAVE");
		}
	}	

