<?php 
namespace framework;

class contentBase {
	protected $obj = "";
	protected $action = "";
	protected $item = 0;
	protected $extra = array();
	protected $javascripts = array();
	protected $css = array();
	protected $template = "html";
	const TYPE_HTML = 0;
	const TYPE_AJAX = 1;
	const TYPE_JSON = 2;
	const TYPE_CUSTOM = 3;
	protected $type = self::TYPE_HTML; //json, ajax, html
	protected $controller;
	protected $menu = FALSE;
	protected $title = "";

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
			$this->init();
		}
	}

	function typeByAction($action,$type) {
		if ($action == $this->action) {
			$this->type = $type;
		}
	}

	function init() {
		$this->addJavascript(app::root()."js/jquery-1.9.1.min.js");
		if (isset($_POST["resp_ajax"])) $this->type = self::TYPE_AJAX;
	}

	function title() {
		return $this->title;
	}

	function action_def() {
		echo "NO CONTENTS";
	}

	function addJavascript($script) {
		$this->javascripts[] = $script;
	}

	function addCss($css) {
		$this->css[] = $css;
	}

	function url($action = "") {
		if (!$action) $action .= "/";
		return app::root().$this->obj."/".$action;
	}

	function scripts() {
		foreach ($this->javascripts as $script ) {
			echo "<script src='$script'></script>";
		}
		foreach ($this->css as $script ) {
			echo "<link rel='stylesheet' type='text/css' href='$script'>";
		}
	}

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
				echo $this->action();
				break;
			case self::TYPE_JSON:
				header('Content-type: application/json');
				echo json_encode($this->action());
				break;
		}

	}

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
