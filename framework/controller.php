<?php
namespace framework;

use framework\views\HTTP404;
class controller {
	private $page;
	
	function __construct() {
		$req = str_replace(app::root(), "", $_SERVER['REQUEST_URI']);
		if ($req == "" || $req == "index.php") $req = "index";
		if (substr($req, -1) == "/") $req = substr($req, 0,-1);
		$req = explode("/", $req);
		$obj = $req[0];
		//echo $req;
		//echo PHP_EOL.__DIR__."/../views/$obj.php".PHP_EOL;
		$class = "\\views\\$obj";
		if (class_exists($class,true)) {
			//require $library;
			//echo "\n***\n".$library."\n***\n";
			$this->page = new $class($req, $this);
		} else {
			//header("HTTP/1.0 404 Not Found");
			//$class = "\\framework\\views\\HTTP404";
			$this->page = new HTTP404($req, $this);
			//exit;
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



