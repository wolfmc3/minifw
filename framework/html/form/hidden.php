<?php
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
		 * @param string $key Nome campo (attributo name)
		 * @param string $text Valore (attributo value)
		 */
		function __construct($key, $text) {
			parent::__construct("input",array("type" => "hidden", "value"=> $text, "name" => $key));
		}
	}	

