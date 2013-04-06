<?php
namespace framework\html; 
	class icon extends element {
		function __construct($icon,$controller) {
			$this->tag = "img";
			$this->attr = array("src" => $controller->getAppRoot()."img/icons/$icon.png");
		}
	}	

