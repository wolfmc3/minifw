<?php 
namespace framework\html; 
class dotlist extends element {
	function __construct($ulclass = NULL) {
		parent::__construct("ul");
		if ($ulclass) $this->addAttr("class", $ulclass);
	}
	
	function addItem($el, $attr = array()) {
		$ul = new element("li",$attr);
		$ul->add($el);
		parent::add($ul);
	}
	
	function add($el, $attr = array()) {
		if (is_array($el)) {
			foreach ($el as $key => $value) {
				$this->addItem($value);
			}
		} else {
			$ul = new element("li",$attr);
			$ul->add($el);
			parent::add($ul);
		}
	}
} 