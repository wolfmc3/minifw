<?php
namespace framework;

class controller {
	private $page;
	private $approot;
	
	function __construct() {
		$this->approot = str_replace("index.php", "", $_SERVER['SCRIPT_NAME']);
		$req = str_replace($this->approot, "", $_SERVER['REQUEST_URI']);
		//echo $req;
		if ($req == "" || $req == "index.php") $req = "index";
		$req = explode("/", $req);
		$obj = $req[0];
		$library = __DIR__."/../views/$obj.php";
		if (file_exists($library)) {
			require $library;
			//echo "\n***\n".$library."\n***\n";
			$this->page = new \content($req, $this);
		} else {
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		system::setController($this);
	}
	
	function getPage() {
		return $this->page;
	}
	
	function getAppRoot() {
		return $this->approot;
	}
	
	function render() {
		$this->page->render();
	}
}

final class system {
	private static $controller;
	public static function setController(controller $controller) {
		self::$controller = $controller;
	}
	public static function getController() {
		return self::$controller;
	}
}

