<?php 
namespace framework; 

class contentBase {
	protected $obj;
	protected $action = "";
	protected $item = 0;
	protected $extra = null;
	protected $javascripts = array();
	protected $css = array();
	protected $template = "html";
	protected $controller;
	protected $menu = FALSE;
	protected $title = "";
	
	function __construct($args = array(), $controller = null) {
		//var_dump($args);
		if (!$controller) $controller = app::Controller();  
		$this->obj = $args[0];
		if (count($args) > 1) {
			$this->action = $args[1];
			if (count($args) > 2) {
				$this->item = $args[2];	
				if (count($args) > 3) {
					$this->extra = array_slice($args, 3);
				} 			
			}
		}
		$this->controller = $controller;
		$this->init();
	}
	
	function init() {
		$this->addJavascript(app::root()."js/jquery-1.9.1.min.js");
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
	
	function scripts() {
		foreach ($this->javascripts as $script ) {
			echo "<script src='$script'></script>";
		}
		foreach ($this->css as $script ) {
			echo "<link rel='stylesheet' type='text/css' href='$script'>";
		}
	}
	
	function render() {
		require __DIR__."/../models/".$this->template.".php";
	}
	
	function menu() {
		if ($this->menu) {
			require __DIR__."/../models/".$this->menu.".php";			
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
