<?php 
namespace framework;

/**
 * interfaccia contentBase
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

class contentBase {
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
		$this->addJavascript(app::root()."js/jquery-1.9.1.min.js");
		if (isset($_POST["resp_ajax"])) $this->type = self::TYPE_AJAX;
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
		echo "NO CONTENTS";
	}

	/**
	 * Aggiunta javascript esterno
	 * 
	 * <code>$this->addCss("/percorso/tuostile.js)</code>
	 * 
	 * @todo supporto javascript in base al percorso (http:// | /sdfhk/script) 
	 * 
	 * @param string $script
	 * @return void
	 */
	function addJavascript($script) {
		$this->javascripts[] = $script;
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
		$this->css[] = $css;
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
		if (!$action) $action .= "/";
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
			echo "<script src='$script'></script>";
		}
		foreach ($this->css as $script ) {
			echo "<link rel='stylesheet' type='text/css' href='$script'>";
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
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		switch ($this->type) {
			case self::TYPE_HTML:
				header('Content-type: text/html');
				require __DIR__."/../templates/".$this->template.".php";
				break;
			case self::TYPE_AJAX:
				header('Content-type: text/html');
				echo $this->action();
				break;
			case self::TYPE_CUSTOM:
				$this->action();
				break;
			case self::TYPE_JSON:
				header('Content-type: application/json');
				echo json_encode($this->action());
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
			require __DIR__."/../templates/".$this->menu.".php";
		}
	}

	function setMenu($menuModel) {
		$this->menu = $menuModel;
	}

	function action() {
		if ($this->action == "") {
			return $this->action_def();
		} else {
			if (method_exists($this, "action_".$this->action)) {
				return call_user_func(array($this,"action_".$this->action));
			} else {
				return "ERRORE NELLA RICHIESTA: <b>".$this->action."</b>";
			}
		}
	}
}
