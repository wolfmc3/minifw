<?php
namespace framework\html; 
	class select extends element {
		function __construct($name, $data, $cur, $options = array()) {
			parent::__construct("select", array_merge(array("name" => $name),$options));
			foreach ($data as $key => $value) {
				$options = array("value" => $key);
				if ($cur == $key) $options["selected"] = "1";
				$el = new element("option",$options);
				$el->add($value);
				$this->add($el);
			}
			
		}
	}	

