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
			return;
		}
	}
	/**
	 * Ritorna tutta la configurazione in formato human-readable
	 * @return string
	 */
	function __toString() {
		return print_r($this->config,TRUE);
	}
}
