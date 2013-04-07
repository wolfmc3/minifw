<?php
namespace framework\html; 
	class select extends element {
		function __construct($name, $data, $cur, $options = array()) {
			parent::__construct("select", array_merge(array("name" => $name),$options));
			foreach ($array_expression as $key => $value) {
				$el = new element("option",array(
						"selected"=> ($cur == $key)?1:0,
						"value" => $key
				));
				$el->addElement($value);
				$this->addElement($el);
			}
			
		}
	}	

