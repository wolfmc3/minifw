<?php
namespace framework\html; 
	use framework\app;
	class icon extends element {
		function __construct($icon,$controller) {
			$this->tag = "img";
			$this->attr = array("src" => app::root()."img/icons/$icon.png");
		}
	}	

