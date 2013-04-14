<?php
namespace framework\html\form; 
	use framework\html\element;
	/**
	 * jsondata
	 *
	 * Genera uno script javascript contenente la dichiarazione di una variabile da PHP
	 * Utile per passare variabili PHP lato server al lato client
	 *
	 * @author Marco Camplese <info@wolfmc3.com>
	 * @package minifw/html
	 *
	 *
	 */
	
	class jsondata extends element {
		/**
		 * @internal
		 */
		protected $html = true;
		/**
		 * Costruttore
		 * 
		 * @param string $var Nome variabile javascipt
		 * @param mixed|mixed[] $data valore da assegnare alla variabile   
		 */
		function __construct($var, $data) {
			parent::__construct("script");
			$script = "var $var = ". json_encode($data) .";";
			$this->add($script);
		}
	}	

