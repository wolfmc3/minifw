<?php
/**
 *
 * controller.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework;
use framework\html\element;
use framework\html\responsive\div;
use framework\views\HTTP404;
use framework\html\img;
use framework\html\module;
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
	 *
	 * @var \framework\html\module[] Moduli caricati
	*/
	private $modules = array();

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
		$class = "\\views\\$obj";
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
		$this->addModule("sysmsg", "\\modules\\sysmsg");

	}


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
		$req = strip_tags($req);
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
		$querystring = trim($urlparts[1]);
		$url = $url?explode("/", $url):array();
		$def = array(app::conf()->system->defaultobj,app::conf()->system->defaultaction,"");
		for ($i = count($url); $i < count($def); $i++) {
			$url[$i] = $def[$i];
		}
		$querystring = $querystring?explode("&", str_replace("=", ",", $querystring)):array();
		//print_r(array_merge($url,$querystring,$uriqs));
		$uri = implode("/", array_merge($url,$querystring,$uriqs));
		return $uri;
	}

	/**
	 * addMessage
	 *
	 * Inserisce un messaggio nello stack dei messaggi per l'utente<br>
	 * I messaggi sono inseriti nella variabile di sessione <code>$_SESSION["ctrl_messages"]</code><br>
	 * I messaggi visualizzati dal metodo messages() sono rimossi automaticamente<br>
	 *
	 * @param string $msg Messaggio sotto forma di testo (tag HTML saranno convertiti)
	 * @param \framework\html\anchor $link1 optional Link 1 da visualizzare nel messaggio
	 * @param \framework\html\anchor $link2 optional Link 2 da visualizzare nel messaggio
	 * @param string $title Titolo del messaggio
	 *
	 */
	function addMessage($msg,$link1 = NULL,$link2 = NULL,$title=NULL) {
		if (isset($_SESSION["ctrl_messages"]) && array_search($msg, $_SESSION["ctrl_messages"]) !== FALSE) return;
		$this->page->addJavascript("sysmsg.js");
		$this->page->addJqueryUi();

		if (!isset($_SESSION["ctrl_messages"])) $_SESSION["ctrl_messages"] = array();
		$message = htmlspecialchars($msg);
		if ($link1){
			$link1->addAttr("class","btn btn-mini");
			$message .= " ".$link1;
		}
		if ($link2) {
			$link2->addAttr("class","btn btn-mini");
			$message .= " ".$link2;
		}
		if ($title) $message = (new element("strong",array(),$title))." ".$message;
		$_SESSION["ctrl_messages"][] = $message;
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
	 * addModule()
	 * @param string $module nome del modulo
	 * @param string $class classe del modulo
	 * @return boolean TRUE se inizializzato correttamente
	 */
	function addModule($module, $class) {
		$moduleobj = new $class();
		if (is_a($moduleobj, "framework\\module")) {
			$this->modules[$module] = "Module $module not found";
			return FALSE;
		}
		$this->modules[$module] = $moduleobj;
		return TRUE;
	}
	/**
	 * Module()
	 *
	 * Ritorna il modulo richiesto
	 *
	 * @param string $module
	 * @return \framework\html\module
	 */
	function &Module($module) {
		if (!array_key_exists($module, $this->modules)) {
			$res = "Module $module not found";
			return $res;
		}
		return $this->modules[$module];
	}
	/**
	 * Modules(&$array)
	 *
	 * Ritorna tramite $array un riferimento all'array dei moduli
	 *
	 * @param \framework\html\module $array
	 */
	function Modules(&$array = array()) {
		foreach ($this->modules as $module => $obj) {
			$array[$module] = &$this->modules[$module];
		}
	}
	/**
	 *  renderModules()
	 *  Invia il comendo di render a tutti i moduli
	 */
	function renderModules() {
		foreach ($this->modules as $name => $obj) {
			$obj->render(FALSE);
		}
	}

	/**
	 * resetModule()
	 *
	 * Cancella un modulo e lo sostituisce con uno vuoto (= "")
	 * @param string $module
	 * @return boolean Risultato dell'operazione
	 */

	function resetModule($module) {
		if (!array_key_exists($module, $this->modules)) return FALSE;
		$this->modules[$module] = new module();
		return TRUE;
	}
	/**
	 * Richiama il rendering della pagina
	 *
	 * Avvia il rendering della pagina<br>Utilizzato da /index.php (Front Controller)
	 *
	 * @see \framework\page
	 */

	function render() {
		$this->page->action();
		$this->renderModules();
		$this->page->render();
	}
}
