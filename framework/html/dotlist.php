<?php 
namespace framework\html; 
class dotlist extends element {
	function __construct($ulclass) {
		parent::__construct("ul");
	}
	
	function addElement($el, $attr = array()) {
		$ul = new element("li",$attr);
		$ul->addElement($el);
		parent::addElement($ul);
	}
} 