<?php
/**
 *
 * anchorbutton.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
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
			$btn = new anchor($url, $text,$options);
			$btn->addAttr("class", "btn");
			$this->add($btn);
		}
	}

