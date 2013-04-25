<?php
namespace framework\html; 
	use framework\app;
	/**
	 * anchor 
	 *
	 * Genera un collegamento ipertestuale con class button
	 * Richiede in jquery, jqueryui, button.js
	 *
	 * @author Marco Camplese <info@wolfmc3.com>
	 * @package minifw/html
	 * 
	 *
	 * @see element
	 *
	 */
	class anchorbutton extends element {
	/**
	 * Costruttore 
	 *  
	 * @param string $url
	 * @param string $text
	 * @param string[] $options
	 */
		function __construct($url, $text, $options = array()) {
			parent::__construct("div",array("class"=>"btn-group"));
			$this->add(new anchor($url, $text,array("class"=>"btn")));
		}
	}	

