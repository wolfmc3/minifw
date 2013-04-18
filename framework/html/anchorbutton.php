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
	class anchorbutton extends anchor {
	/**
	 * Costruttore 
	 *  
	 * @param string $url
	 * @param string $text
	 * @param string[] $options
	 */
		function __construct($url, $text, $options = array()) {
			app::Controller()->getPage()->addJavascript(app::conf()->jquery->core);
			app::Controller()->getPage()->addJavascript(app::conf()->jquery->ui);
			app::Controller()->getPage()->addCss(app::conf()->jquery->theme);
			app::Controller()->getPage()->addJavascript("button.js");
			parent::__construct($url, $text, $options);
			$this->addAttr("class","anchorbutton");
		}
	}	

