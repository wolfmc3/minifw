<?php 
namespace framework;
class config {
	private $config = array();
	function __construct($file) {
		$config = parse_ini_file($file, true );
		$defauts = parse_ini_file(__DIR__."/config/defaults.ini", true );
		$config = array_merge($defauts,$config);
		$parsedconfig = array();
		foreach ($config as $module => $section) {
			if (is_array($section)) {
				list($module,$parent) = explode(":", $module.":");
				if ($parent) $section = array_merge($config[$parent],$section);
				$sectionobj = new \stdClass();
				foreach ($section as $key => $value) {
					$sectionobj->$key = $value;
				}
				$this->config[$module] = $sectionobj;
				
			} 
		}
	}
	function __get($section) {
		//echo "Requested: $section";
		if (array_key_exists($section, $this->config)) {
			return $this->config[$section];
		} else {
			return;
		}
	}
	function __toString() {
		return print_r($this->config,TRUE);
	}
}
