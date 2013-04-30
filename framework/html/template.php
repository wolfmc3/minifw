<?php
/**
 *
 * template.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\html;
use framework\io\file;
use framework\app;
/**
 * template
 *
 * Genera codice HTML partendo da un template<br>
 * NOTA: questo oggetto table è utilizzato dall'oggetto dbpages
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/html
 *
 * @see element
 *
 */

class template extends element {
	/**
	 * @var string[] array associativo contenete i dati
	 */
	private $data;
	/**
	 * @ignore
	 * @var unknown
	 */
	private $loadedtemplate=array();
	/**
	 * @var string Template corrente
	 */
	private $template;
	/**
	 * @var boolean Indica che il tag utilizza codice html
	 */
	protected $html = TRUE;
	/**
	 *
	 * @var boolean Indica che il file di template è valido e verrà usato
	 */
	protected $valid = FALSE;
	/**
	 * Costruttore
	 *
	 * Esempio di template:<br>
	 * <code>
	 * &lt;h1&gt;{titolo}&lt;/h1&gt;
	 * {paragrafi:
	 * &lt;p&gt;{testo}&lt;/p&gt;
	 * :}
	 * </code>
	 *
	 * Esempio dati<br>
	 * <code>
	 * $data = array(
	 * "titolo"=>"questo è il titolo",
	 * 		"paragrafi"=> array(
	 * 			["testo"=>"Paragrafo 1, ciao"],
	 * 			["testo"=>"Paragrafo 2, ciao"],
	 * 			["testo"=>"Paragrafo 3, ciao"],
	 * 		)
	 * );
	 * </code>
	 *
	 * Risultato<br>
	 * <code>
	 * <b>questo è il titolo</b>
	 * <p>Paragrafo 1, ciao</p>
	 * <p>Paragrafo 2, ciao</p>
	 * <p>Paragrafo 3, ciao</p>
	 * </code>
	 *
	 * @param string $filename Nome del template presente nella cartella /templates/*.tmpl.htm
	 * @param string[] $data Array associativo contenente chiavi e valori da sostituire nel template
	 * @param string $folder
	 */
	function __construct($filename,$data, $folder = "") {
		parent::__construct("");

		if ($folder == "") $folder = "templates/";
		$file = new file("$filename.tmpl.htm",TRUE,$folder);
		if (!$file->exist()) {

			$this->template = "TEMPLATE $folder$filename.tmpl.htm NOT FOUND!!";
			return;
		}
		$this->valid = TRUE;
		$this->template = $file->read();
		$this->data = $data;
		app::Controller()->Modules($this->data);
		//var_dump($this."");
	}
	/**
	 * isValid()
	 * Indica se il template specificato esiste ed è valido
	 *
	 * @return boolean TRUE Valido FALSE File non trovato o non leggibile
	 */
	function isValid() {
		return $this->valid;
	}
	/**
	 * toString()
	 *
	 * Ritorna il blocco compilato del template
	 *
	 * @see \framework\html\element::__toString()
	 */
	function __toString() {
		return  $this->renderPart($this->template, $this->data);
	}
	/**
	 * renderPart()
	 *
	 * genera in parte il blocco html in maniera ricorsiva
	 *
	 * @param string $html
	 * @param string[] $data
	 * @return string
	 */
	private function renderPart($html, $data) {
		$group_pattern = "/{(\w+):(.*?):}/sm";
		$item_pattern = "/{(\w+)}/";
		$callbackblock = function( $match ) use ( $data ) {
			$ret = "";
			$item_pattern = "/{(\w+)}/";
			if (isset($data[$match[1]])) {
				foreach ($data[$match[1]] as $subvalues) {
					$callbackitem = function( $match ) use ( $subvalues ) {
						if (array_key_exists($match[1], $subvalues)) {
							return $subvalues[$match[1]];
						} else {
							return "";
						}
			    	};
					$ret .= preg_replace_callback($item_pattern, $callbackitem, $match[2]);
				}
			} else {
				$ret = "";
			}
			return $ret;
    	};
		$callbackitem = function( $match ) use ( $data ) {
			//print_r($match);
			if (isset($data[$match[1]])) {
				return $data[$match[1]];
			} else {
				return "";
			}
    	};
		$html = preg_replace_callback($group_pattern, $callbackblock, $html);
		$html = preg_replace_callback($item_pattern, $callbackitem, $html);
		return $html;
	}
}
