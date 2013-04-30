<?php
/**
 *
 * jsscript.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\html;
/**
 *
 * Elemento jsscript
 *
 * Genera un tag script con relativo contenuto
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/html
 *
 */
class jsscript extends html {
	/**
	 * Costruttore
	 *
	 * @param string $script Script da inserire (testo)
	 * @param string $ready Se TRUE aggiunge il codice javascript per eseguire appena la pagina solo quando è pronta
	 */
	function __construct($script,$ready = TRUE) {
		if ($ready) $script = '$(document).ready(function(){'.PHP_EOL.$script.PHP_EOL.'});';
		$script = "<script>$script</script>";
		$this->inner = $script;
	}
}