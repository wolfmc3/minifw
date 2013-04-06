<?php
namespace framework\html; 
	use framework\app;
	class img extends element {
		function __construct($icon) {
			parent::__construct("img",array("src" => app::root()."img/$icon"));
		}
	}	

