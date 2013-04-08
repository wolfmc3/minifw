<?php
namespace framework\html\form; 
	use framework\html\element;
	class jsondata extends element {
		protected $html = true;
		function __construct($var, $data) {
			parent::__construct("script");
			$script = "var $var = ". json_encode($data) .";";
			$this->add($script);
		}
	}	

