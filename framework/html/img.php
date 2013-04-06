<?php
namespace framework\html; 
	class img extends element {
		function __construct($icon,$controller) {
			parent::__construct("img",array("src" => $controller->getAppRoot()."img/$icon"));
		}
	}	

