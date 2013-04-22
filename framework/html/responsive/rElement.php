<?php 
namespace framework\html\responsive;
use framework\html\element;
class rElement extends element {
	function __construct($tag,$class="",$id="",$options = []) {
		parent::__construct($tag,$options);
		if ($class) $this->addAttr("class", $class);		
		if ($id) $this->addAttr("id", $class);
	} 
}