<?php
namespace framework;

use framework\views\HTTP404;
use framework\html\element;
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
	 * @var \framework\page $page riferimento all'view richiesta dall'utente
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
		$url = urldecode(preg_replace($qsregex, "", $url));
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
	
	//TODO: DA COMPLETARE
	function addMessage($msg,$link1 = NULL,$link2 = NULL) {
		$this->page->addJavascript("sysmsg.js");
		$this->page->addJqueryUi();
		
		if (!isset($_SESSION["ctrl_messages"])) $_SESSION["ctrl_messages"] = []; 
		$message = htmlspecialchars($msg);
		if ($link1) $message .= " ".$link1;
		if ($link2) $message .= " ".$link2;
		$_SESSION["ctrl_messages"][] = $message;
	}
	
	function messages() {
		if (!isset($_SESSION["ctrl_messages"])) return;
		$messages = $_SESSION["ctrl_messages"];
		unset($_SESSION["ctrl_messages"]);
		$msgcont = new element("div",["id"=>"controller_messages"]);
		foreach ($messages as $line) {
			$msgcont->add(new element("div",[],$line,TRUE));
		} 
		return $msgcont;
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
		//var_dump(app::Security()->getPermission($obj));
		$perm = app::Security()->getPermission($obj);
		if (!$perm->L && $obj != "login") {
			if (app::Security()->user()->isok) { //Loggato ma non autorizzato
				$obj = "HTTP401";
			} else {
				header("location:".app::root()."login?redirect=".urlencode(app::root().$this->uri));
				exit();
			}
		}
		if (class_exists($class,true)) {
			$this->page = new $class($this);
			$this->page->setPermissions($perm->R, $perm->W, $perm->L, $perm->A);
		} else {
			$class = "\\framework\\views\\$obj";
			if (class_exists($class,true)) {
				$this->page = new $class($this);
			} else {
				$this->page = new HTTP404($this);
			}
		}
		if (isset($_SESSION["ctrl_messages"])) {
			$this->page->addJavascript("sysmsg.js");
			$this->page->addJqueryUi();
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
	 * @return \framework\page
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
	 * @return \framework\page
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
	 * @see \framework\page
	 */
	
	function render() {
		$this->page->render();
	}
}



