<?php 
namespace framework\html;
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
	 * @param string $file Nome del template presente nella cartella /templates/*.tmpl.htm
	 * @param string[] $data Array associativo contenente chiavi e valori da sostituire nel template
	 * @param string $folder
	 */
	function __construct($file,$data, $folder = "") {
		parent::__construct("");
		if ($folder == "") $folder = __DIR__."/../../templates/";
		if (!file_exists("$folder$file.tmpl.htm")) $this->html = "TEMPLATE $folder$file.htm NOT FOUND!!";
		$this->template = file_get_contents("$folder$file.tmpl.htm");
		$this->data = $data;
	}
	
	/**
	 * @see \framework\html\element::__toString()
	 */
	function __toString() {
		return  $this->renderPart($this->template, $this->data);
	}
	/**
	 * @internal
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
