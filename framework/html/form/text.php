<?php
namespace framework\html\form; 
	use framework\html\element;
	class text extends element {
		function __construct($key, $text) {
			parent::__construct("input",array("type" => "text","value"=> $text,"name" => $key));
		}
	}	

