<?php
namespace framework\html\form; 
	use framework\html\element;
	class hidden extends element {
		function __construct($key, $text) {
			parent::__construct("input",array("type" => "hidden", "value"=> $text, "name" => $key));
		}
	}	

