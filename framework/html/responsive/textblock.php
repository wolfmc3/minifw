<?php 
namespace framework\html\responsive;

use framework\html\element;
class textblock extends div {
	function __construct($title, $span=0, $offset=0 , $class="", $id="", $attr = array()) {
		parent::__construct( $class, $id, $attr);
		if ($span) $this->addAttr("class", "span$span");
		if ($offset) $this->addAttr("class", "offset$offset");
		$titleel = new element("h3");
		$titleel->add($title);
		parent::append($titleel);	
	}
	
	function &append($el) {
		$cont = element::p();
		$cont->add($el);
		parent::add($cont);
		return $this;
	}
}