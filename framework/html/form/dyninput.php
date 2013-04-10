<?php
namespace framework\html\form; 
	use framework\html\element;
	class dyninput extends element {
		function __construct($key, $text, $setting = array()) {
			if (count($setting) && array_key_exists("inputtype", $setting)) {
				$dt = $setting['inputtype'];
				$len = $setting['len'];
				if ($dt == "readonly") {
					parent::__construct("");
					$this->add($text);
				} elseif ($dt == "currency" || $dt == "numeric") {
					parent::__construct("input",array("type" => "text","class"=>"$dt","value"=> $text,"name" => $key));
				} elseif ($dt == "text") {
					parent::__construct("input",array("type" => "text","value"=> $text,"name" => $key));
					if (is_numeric($len) && $len > 0) {
						$this->addAttr("size", $len);
						$this->addAttr("maxlength", $len);
					}
				} else {
					parent::__construct("input",array("type" => "text","value"=> $text,"name" => $key));
				}
				if ($this->tag) {
					$this->addAttr("class", "ui-widget ui-widget-content ui-corner-all");
					if ($setting['regexpr']) {
						$this->addAttr("data-validate", $setting['regexpr']);
					} elseif ($setting['null'] != 'true') {
						$this->addAttr("data-validate", '^\s*\S.*$');
					}
					
				}
			} else {
				parent::__construct("input",array("type" => "text","value"=> $text,"name" => $key));
			}
		}
		
	}	

