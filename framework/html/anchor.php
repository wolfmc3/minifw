<?php
namespace framework\html; 
	class anchor extends element {
		function __construct($url, $text, $options = array()) {
			$this->tag = "a";
			$this->attr = array_merge(array("href" => $url),$options);
			$this->inner = $text;
		}
	}	

