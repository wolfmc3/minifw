<?php
namespace framework\html; 
	/**
	 * anchor 
	 *
	 * Genera un blocco html
	 *
	 * @author Marco Camplese <info@wolfmc3.com>
	 * @package minifw/html
	 *
	 * @see element
	 *
	 */
	class html extends element {
		/**
		 * @var boolean Definisce che l'oggetto usa html non controllato
		 */
		protected $html = TRUE;
		/**
		 * Costruttore
		 * 
		 * @param mixed $html Blocco HTML da inserire
		 */
		function __construct($html) {
			$this->inner = $html;
		}
		/**
		 * toString() Genera una stringa contenente il codice HTML generato
		 * 
		 * @see \framework\html\element::__toString()
		 */
		function __toString() {
			return $this->inner;
		}
		
	}	

