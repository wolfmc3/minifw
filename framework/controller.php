<?php
namespace framework;

use framework\views\HTTP404;
	/**
	 * Controller
	 *
	 * Crea i rifermenti alla views e gestisce le richieste di dati 
	 *
	 * @author Marco Camplese <info@wolfmc3.com>
	 * @package minifw
	 *
	 * 
	 */
class controller {
	/**
	 * @var \framework\contentBase $page riferimento all'view richiesta dall'utente
	 */
	private $page;
	/**
	 * @var string $uri Url richiesto dall'utente passato per resolveUrl Formato:/[view]/[action]/[item][/[nome,valore]...] 
	 */
	public $uri = "";
	/**
	 * 
	 * @var array[] $parseduri URI in formato array
	 */
	public $parseduri = array();
	/**
	 * @var array[] $viewscalled Cache oggetti Views riutilizzabili già instanziati dal controller
	 */
	private $viewscalled = array();
	
	/**
	 * resolveUrl
	 * 
	 * Rettifica e uniforma un url trasformandolo in uri valido
	 * 
	 * 
	 * @param string $req
	 * @return string
	 */
	static function resolveUrl($req) {
		$req = urldecode($req);
		$req = str_replace(app::root(), "", $req);
		$req = str_replace("//", "/", $req);
		if (strpos($req,"?") === FALSE) $req .= "?";
		$urlparts = explode("?", $req);
		$url = trim($urlparts[0]);
		$url = preg_replace("/(\/)+$/", "", $url); //REMOVE / & // at end url
		$qsregex = '/\/*([\w]+\,[\w]+)\/*/';
		//echo "$url\n";
		preg_match_all($qsregex, $url,$uriqs);
		$uriqs = $uriqs[1];
		//print_r($uriqs);
		$url = preg_replace($qsregex, "", $url);
		//echo "$url\n";
		//TODO: Controllo di sicurezza su oggetto e azione (html injection)
		$querystring = trim($urlparts[1]);
		$url = $url?explode("/", $url):[];
		$def = ["index","def",""];
		for ($i = count($url); $i < count($def); $i++) {
			$url[$i] = $def[$i];
		}
		$querystring = $querystring?explode("&", str_replace("=", ",", $querystring)):[];
		//print_r(array_merge($url,$querystring,$uriqs));
		$uri = implode("/", array_merge($url,$querystring,$uriqs));
		return $uri;
	}
	
	/**
	 * Costruttore
	 * 
	 * Instanziato dalla classe application::init()
	 * Inizializza la classe page
	 * 
	 */
	function __construct() {
		$uri = self::resolveUrl($_SERVER['REQUEST_URI']);
		$this->uri = $uri;
		$uri = explode("/", $uri);
		$this->parseduri = $uri;
		//print_r($uri);
		$obj = $uri[0];

		$class = "\\views\\$obj";
		if (class_exists($class,true)) {
			$this->page = new $class($this);
		} else {
			$class = "\\framework\\views\\$obj";
			if (class_exists($class,true)) {
				$this->page = new $class($this);
			} else {
				$this->page = new HTTP404($this);
			}
		}
	}
	
	/**
	 * [controller]->[view]
	 * 
	 * Cerca e inizializza la classe view richiesta
	 * Se la classe è già stata richiesta verrà ripresa dalla cache
	 * Utilizzata da altri oggetti view (di solito quello della pagina) per recuperare dati da altre view
	 * 
	 * @param string $obj Nome classe view
	 * @return \framework\contentBase
	 */
	
	function __get($obj) {
		$view = "\\views\\$obj";
		if (array_key_exists($obj, $this->viewscalled)) {
			//echo "__cache:".$view;
			return $this->viewscalled[$obj];
		} else {
			//echo "__GET:".$view;
			return  $this->viewscalled[$obj] = new $view(); 
		}
	}
	
	/**
	 * Classe page
	 * 
	 * Ritorna la classe instanziata come page nel controller
	 * 
	 * @return \framework\contentBase
	 */
	function getPage() {
		return $this->page;
	}
	
	/**
	 * Url base
	 * 
	 * Ritorna l'indirizzo base (senza host, protocollo e view) 
	 * 
	 * @return string Root dell'applicazione di solito "/" se installato in sottodirectory ritorna /[nomedir]/
	 */
	function getAppRoot() {
		return $this->approot;
	}
	
	/**
	 * Richiama il rendering della pagina
	 * 
	 * Avvia il rendering della pagina<br>Utilizzato da /index.php (Front Controller)
	 * 
	 * @see \framework\contentBase
	 */
	
	function render() {
		$this->page->render();
	}
}



