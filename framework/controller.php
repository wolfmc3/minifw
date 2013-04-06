<?php
namespace framework;

class controller {
	private $page;
	
	function __construct() {
		$req = str_replace(app::root(), "", $_SERVER['REQUEST_URI']);
		//echo $req;
		if ($req == "" || $req == "index.php") $req = "index";
		$req = explode("/", $req);
		$obj = $req[0];
		$library = __DIR__."/../views/$obj.php";
		if (file_exists($library)) {
			require $library;
			//echo "\n***\n".$library."\n***\n";
			$class = "\\views\\$obj";
			$this->page = new $class($req, $this);
		} else {
			header("HTTP/1.0 404 Not Found");
			exit;
		}
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



