<?php 
namespace framework;
/**
 * Config 
 *
 * Gestisce il reperimento della configurazione 
 * Combina le impostazioni di default (/framework/config) e quelle specifiche dell'applicazione (/config)
 * La classe config e normalmente inizializzata e gestita dalla classe app
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw
 *
 *
 */
class config {
	/**
	 * Contenitore delle classi config
	 * 
	 * @var stdClass $config 
	 */
	private $config = array();
	
	/**
	 * Construttore
	 * 
	 * Recupera e combina le impostazioni di default e le impostazioni specificate nel file $file
	 * 
	 * @param string $file percorso assoluto del file di configurazione
	 */
	function __construct($file) {
		$config = parse_ini_file($file, true );
		$defauts = parse_ini_file(__DIR__."/config/defaults.ini", true );
		$config = $this->compile($config);
		$defauts = $this->compile($defauts);
		foreach ($defauts as $module => $section) {
			if (array_key_exists($module, $config)) {
				foreach ($section as $key => $value) {
					if (!array_key_exists($key, $config[$module])) {
						$config[$module][$key] = $value;
					}
				}
			} else {
				$config[$module] = $section;
			}
		}
		foreach ($config as $module => $section) {
			$this->config[$module] = $this->createClass($section);
		}
	}
	private function compile($config) {
		$parsedconfig = array();
		foreach ($config as $module => $section) {
			if (is_array($section)) {
				list($module,$parent) = explode(":", $module.":");
				if ($parent) $section = array_merge($config[$parent],$section);
				$parsedconfig[$module] = $section;
			}
		}
		return $parsedconfig;
	}
	private function createClass($section) {
		$sectionobj = new \stdClass();
		foreach ($section as $key => $value) {
			$sectionobj->$key = $value;
		}
		return $sectionobj;
	}
	/**
	 * ->[section]
	 * 
	 * Ritorna un oggetto stdClass con le impostazioni della sezione richiesta
	 * 
	 * @param string $section
	 * @return stdClass
	 */
	function __get($section) {
		//echo "Requested: $section";
		if (array_key_exists($section, $this->config)) {
			return $this->config[$section];
		} else {
			return FALSE;
		}
	}
	/**
	 * Ritorna tutta la configurazione in formato human-readable
	 * @return string
	 */
	function __toString() {
		$return = "";
		foreach ($this->config as $module => $object) {
			$return .= "[$module]".PHP_EOL;
			foreach ($object as $key => $value) {
				$return .= $key ."=".$value.PHP_EOL;
			}
			$return .= PHP_EOL;
		}
		return $return;
	}
}
