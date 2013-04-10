<?php
namespace framework\html\form; 
	use framework\html\element;
	class text extends element {
		function __construct($key, $text, $setting = array()) {
			if (count($setting) && array_key_exists("inputtype", $setting)) {
				$dt = $setting['inputtype'];
				if ($dt == "readonly") {
					parent::__construct("");
					$this->add($text);
				} else {
					parent::__construct("input",array("type" => "text","value"=> $text,"name" => $key));
				}
			} else {
				parent::__construct("input",array("type" => "text","value"=> $text,"name" => $key));
			}
		}
	}	

