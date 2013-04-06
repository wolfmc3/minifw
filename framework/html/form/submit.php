<?php
namespace framework\html\form; 
	use framework\html\element;
	class submit extends element {
		function __construct($text) {
			parent::__construct("input",array("type" => "submit","value"=> $text,"name" => "SAVE"));
		}
	}	

