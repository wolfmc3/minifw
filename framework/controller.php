<?php
namespace framework;
use framework\html\element;
use framework\html\responsive\div;
use framework\views\HTTP404;
use framework\html\img;
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
		$def = [app::conf()->system->defaultobj,app::conf()->system->defaultaction,""];
		for ($i = count($url); $i < count($def); $i++) {
			$url[$i] = $def[$i];
		}
		$querystring = $querystring?explode("&", str_replace("=", ",", $querystring)):[];
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
	 */
	function addMessage($msg,$link1 = NULL,$link2 = NULL,$title=NULL) {
		$this->page->addJavascript("sysmsg.js");
		$this->page->addJqueryUi();

		if (!isset($_SESSION["ctrl_messages"])) $_SESSION["ctrl_messages"] = [];
		$message = htmlspecialchars($msg);
		if ($link1){
			$link1->addAttr("class","btn btn-mini");
			$message .= " ".$link1;
		}
		if ($link2) {
			$link2->addAttr("class","btn btn-mini");
			$message .= " ".$link2;
		}
		if ($title) $message = (new element("strong",[],$title))." ".$message;
		$_SESSION["ctrl_messages"][] = $message;
	}

	/**
	 * Messages()
	 *
	 * Utilizzato nel template HTML per reperire i messaggi destinati all'utente (conferme, notifiche, ecc)<br>
	 * Genera un TAG DIV con id="controller_messages"<br>
	 * $_SESSION["ctrl_messages"] viene azzerata automaticamente<br>
	 * per aggiungere messaggi utilizzare il metodo <code>addMessage(...)</code>
	 *
	 * @return string|\framework\html\element
	 */
	function messages() {
		if (!isset($_SESSION["ctrl_messages"])) return "";
		$messages = $_SESSION["ctrl_messages"];
		unset($_SESSION["ctrl_messages"]);
		$msgcont = new element("div",["id"=>"controller_messages","style"=>"background-color: rgba(125,125,125,0.1); border-radius: 10px;display:block;position:absolute;text-align:right;margin-right:15px;"]);
		$div = new div("icon-star", "",["style"=>"height: 12px;"]);
		$div->add(" ");
		$msgcont->add($div);
		foreach ($messages as $line) {
			$msgcont->add(new element("div",["class"=>"alert alert-info"],$line,TRUE));
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
