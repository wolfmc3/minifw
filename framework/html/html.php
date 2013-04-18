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
		protected $html = TRUE;
		
		function __construct($html) {
			$this->inner = $html;
		}
		
		function __toString() {
			return $this->inner;
		}
		
	}	

