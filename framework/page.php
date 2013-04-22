<?php 
namespace framework;

/**
 * interfaccia page
 *
 * Questa classe è l'interfaccia per la costruzione di oggetti view<br>
 * <code>
 * <h1>Gli oggetti view risiedono nella cartella:</h1>
 * /views
 * </code>
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw
 *
 */

class page {
	/**
	 * @var string Nome classe
	 */
	protected $obj = "";

	/**
	 * @var string Azione
	 */
	protected $action = "";

	/**
	 * @var string|int ID elemento da visualizzare (da URL)
	 */
	protected $item = 0;
	/**
	 * @var mixed variabile contenente il risultato dell'operazione action_*
	 */
	protected $results = NULL;

	/**
	 *
	 * @var string[] Parametri extra passati nell'url
	 */
	protected $extra = array();

	/**
	 * @var array[] Lista dei script Javascript da includere nella pagina
	*/
	protected $javascripts = array();

	/**
	 * @var array[] Lista dei fogli di stile da includere nella pagina
	*/
	protected $css = array();

	/**
	 * @var string Template predefinito
	*/
	protected $template = "html";

	/**
	 * Risposta HTML
	 *
	 * Il risultato sarà una pagina HTML con template
	 *
	 * @const TYPE_HTML
	 */
	const TYPE_HTML = 0;

	/**
	 * Risposta AJAX
	 *
	 * Il risultato sarà un blocco html (risultato di action_*) senza template
	 *
	 * @const TYPE_AJAX
	 */
	const TYPE_AJAX = 1;

	/**
	 * Risposta JSON
	 *
	 * Il risultato sarà di tipo application/json (risultato di action_* convertito tramite json_encode())
	 *
	 * @const TYPE_JSON
	 */
	const TYPE_JSON = 2;

	/**
	 * Risposta personalizzata
	 *
	 * Il risultato sarà controllato direttamente dall'action
	 *
	 * @const TYPE_CUSTOM
	 */
	const TYPE_CUSTOM = 3;
	/**
	 * Risposta reindirizzata
	 *
	 * Il valore ritornato verrà utilizzato come url per reindirizzare la navigazione
	 *
	 * @const TYPE_REDIRECT
	 */
	const TYPE_REDIRECT = 4;
	/**
	 * Tipo risposta
	 *
	 * Risposta predefinita
	 *
	 * @var $type
	 */
	protected $type = self::TYPE_HTML; //json, ajax, html

	/**
	 *
	 * @var $controller Controller assegnato alla view
	 *
	 * @see \framework\controller
	 *
	 */

	protected $controller;

	/**
	 * Template menu
	 *
	 * I template si trovano nella cartella /templates
	 *
	 * @var $menu
	 */
	protected $menu = FALSE;

	/**
	 * Titolo view
	 *
	 * @var $title
	 */
	protected $title = "";

	/**
	 * Costruttore
	 *
	 * @param void|\framework\controller $controller opzionale. Se non fornito verrà usato il controller dell'applicazione
	 */
	function __construct(&$controller = FALSE) {
		$this->obj = preg_replace('/(.*)\\\\(.*)/', "\\2", get_called_class()) ;

		if ($controller === FALSE) {
			$this->controller = app::Controller();
		} else {
			$this->controller = $controller;
		}
		$args = $this->controller->parseduri;

		if ($args[0] == $this->obj) {
			$this->action = $args[1];
			$this->item = $args[2];
			if (count($args) > 3) {
				$rawextra = array_slice($args, 3);
				foreach ($rawextra as $key => $value) {
					if (strpos($value,",") !== FALSE) {
						list($key,$value) = explode(",", $value);
					}
					$value = urldecode($value);
					$this->extra[$key] = $value;
				}
				//print_r($this->extra);
			}
		}
		$this->init();
	}
	/**
	 * Applica in base ad $action il $type necessario
	 *
	 * Ha effetto solo se utilizzato nel metodo init()
	 *
	 * @param string $action Azione
	 * @param int $type Tipo di risposta della pagina, vedi le costanti TYPE_*
	 *
	 */
	function typeByAction($action,$type) {
		if ($action == $this->action) {
			$this->type = $type;
		}
	}

	/**
	 * Inizializza
	 *
	 * Viene richiamato alla fine della creazione della classe, nella classe derivata permette di eseguire inizializzazioni senza modificare il costruttore.
	 * Il metodo può essere ridefinito e chiamato il metodo della classe genitore:
	 * <code> parent::init();</code>
	 *
	 * @return void
	 */
	function init() {
		$this->addJavascript(app::conf()->jquery->core);
		$this->addJavascript(app::conf()->jquery->core);
		if (isset($_POST["resp_ajax"])) $this->type = self::TYPE_AJAX;
	}
	/**
	 * setPermissions()
	 *
	 * Utilizzato dal controller per impostare i permessi che l'utente ha sull'oggetto<br>
	 * Autorizzato == 1<br>
	 * Non autorizzato = 0<br>
	 * Indifferente = NULL <br>
	 *
	 * @param number $read Permesso di lettura dei dati
	 * @param number $write Permesso di scrittura
	 * @param number $list Permesso di visualizzare l'oggetto
	 * @param number $add Permesso di aggiungere dati
	 */
	function setPermissions($read, $write, $list, $add) {
		/*$this->addRecord = ($add==1);
		 $this->deleteRecord = ($write==1);
		$this->editRecord = ($write==1);
		$this->viewRecord = ($read==1);*/
	}

	/**
	 * Titolo
	 *
	 * Ritorna il titolo impostato nella variabile $title della classe
	 * Viene utilizzato nei template
	 *
	 * @return $this->title
	 */
	function title() {
		return $this->title;
	}

	/**
	 * Azione di default
	 *
	 * Viene richiamata dal controller quando l'url non comprende l'azione
	 *
	 *
	 */
	function action_def() {
		return "NO CONTENTS";
	}

	/**
	 * Aggiunta javascript esterno
	 *
	 * <code>$this->addCss("/percorso/tuoscript.js)</code>
	 *
	 * @todo supporto javascript in base al percorso (http:// | /sdfhk/script)
	 *
	 * @param string $script
	 * @return void
	 */
	function addJavascript($script) {
		$jslist = explode(",", $script);
		foreach ($jslist as $curjs) {
			$curjs = $this->resolveUrl($curjs,"js/");
			if (array_search($curjs, $this->javascripts) === FALSE) {
				$this->javascripts[] = $curjs;
			}
				
		}
	}

	/**
	 * addJqueryUi()
	 *
	 * Aggiunge automaticamente i riferimenti css e javascript per utilizzare jquery con jqueryui<br>
	 * Questo metodo chiama automaticamente addJquery()
	 *
	 */
	function addJqueryUi() {
		$this->addJquery();
		$this->addJavascript(app::conf()->jquery->ui);
		$this->addCss(app::conf()->jquery->theme);
	}

	/**
	 * addJquery()
	 *
	 * Aggiunge automaticamente i riferimenti javascript per utilizzare jquery
	 *
	 */
	function addJquery() {
		$this->addJavascript(app::conf()->jquery->core);
	}

	/**
	 * Aggiunta foglio di stile al template
	 *
	 * <code>$this->addCss("/percorso/tuostile.css)</code>
	 *
	 * @todo supporto javascript esterni
	 *
	 * @param string $css
	 * @return void
	 */
	function addCss($css) {
		$csslist = explode(",", $css);
		foreach ($csslist as $curcss) {
			$curcss = $this->resolveUrl($curcss,"css/");
			if (array_search($curcss, $this->css) === FALSE) {
				$this->css[] = $curcss;
			}
		}
	}
	/**
	 * Risolve l'url del file specificato
	 *
	 * @param string $file file
	 * @param string $basedir directory di base
	 * @return string Url Completo
	 */
	private function resolveUrl($file, $basedir="/") {
		$fullpath = "";
		if (substr($file, 0,1) == "/") { //root app
			$fullpath = app::root().substr($file, 1);
		} elseif (substr($file, 0,7) == "http://") { //external
			$fullpath = $file;
		} else { //relative to $basedir
			if (substr($basedir, -1) != "/") $basedir .= "/";
			if (substr($basedir, 0,1) == "/") $basedir = substr($basedir, 1);
			$fullpath = app::root().$basedir.$file;
		}
		return $fullpath;
	}
	/**
	 * Indirizzo esterno
	 *
	 * ritorna l'indirizzo esterno della view
	 *
	 * @param string $action
	 * @return string url completo (http://[host]/[view]/[$action]
	 *
	 */
	function url($action = "") {
		if ($action) $action .= "/";
		return app::root().$this->obj."/".$action;
	}
	/**
	 * Generatore script (javascript e css)
	 *
	 * Ritorna tramite echo il codice HTML per generare i riferimenti a file css e javascript
	 *
	 * @see addJavascript($script)
	 * @see addCss($css)
	 *
	 */
	function scripts() {
		foreach ($this->javascripts as $script ) {
			echo "<script src='$script'></script>".PHP_EOL;
		}
		foreach ($this->css as $script ) {
			echo "<link rel='stylesheet' type='text/css' href='$script' media='screen'>".PHP_EOL;
		}
	}

	/**
	 * Render
	 *
	 * In base alle impostazioni genera il risultato
	 *
	 * Il metodo è richiamato dal controller.
	 * Non utilizzare questo metodo per evitare chiamate circolari alle funzioni
	 *
	 */
	function render() {
		$this->action();
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		switch ($this->type) {
			case self::TYPE_HTML:
				header('Content-type: text/html');
				require __DIR__."/../templates/".$this->template.".php";
				break;
			case self::TYPE_AJAX:
				header('Content-type: text/html');
				echo $this->results;
				break;
			case self::TYPE_CUSTOM:
				$this->action();
				break;
			case self::TYPE_REDIRECT:
				$url = $this->results;
				//TODO: Controllo solo url locali
				if ($url) header("location: $url");
				break;
			case self::TYPE_JSON:
				header('Content-type: application/json');
				echo json_encode($this->results);
				break;
		}

	}

	/**
	 * Generazione menu
	 *
	 * Viene richiamato dal template per generare il menu
	 *
	 * @see $menu
	 *
	 */
	function menu() {
		if ($this->menu) {
			return $this->menu ;
		}
	}
	/**
	 * setMenu()
	 *
	 * Imposta il menu
	 *
	 * @param string $menuModel
	 */
	function setMenu($menuModel) {
		$this->menu = "".$menuModel;
	}

	/**
	 * action()
	 *
	 * Richiama l'azione richesta in base al valore di $this->action o l'azione predefinita
	 *
	 */
	function action() {
		if ($this->action == "") {
			$this->results = $this->action_def();
		} else {
			if (method_exists($this, "action_".$this->action)) {
				$this->results = call_user_func(array($this,"action_".$this->action));
			} else {
				$this->results = "ERRORE NELLA RICHIESTA: <b>".$this->action."</b>";
			}
		}
	}

	/**
	 * Ritorna la classe della pagina
	 */

	function name() {
		return $this->obj;
	}
}
