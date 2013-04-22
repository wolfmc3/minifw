<?php
namespace framework\html; 
	use framework\app;
	/**
	 * anchor 
	 *
	 * Genera un collegamento ipertestuale
	 *
	 * @author Marco Camplese <info@wolfmc3.com>
	 * @package minifw/html
	 *
	 * @see element
	 *
	 */
	class anchor extends element {
	/**
	 * Costruttore 
	 *  
	 * @param string $url
	 * @param string $text
	 * @param string[] $options
	 */
		function __construct($url, $text, $options = array()) {
			$this->tag = "a";
			$this->attr = array_merge(array("href" => $url),$options);
			$this->add($text);
		}
	}	

