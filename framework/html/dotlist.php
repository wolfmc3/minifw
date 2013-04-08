<?php 
namespace framework\html; 
class dotlist extends element {
	function __construct($ulclass) {
		parent::__construct("ul");
	}
	
	function add($el, $attr = array()) {
		$ul = new element("li",$attr);
		$ul->add($el);
		parent::add($ul);
	}
} 