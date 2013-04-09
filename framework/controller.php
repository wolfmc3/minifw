<?php
namespace framework;

use framework\views\HTTP404;
class controller {
	private $page;
	public $uri = "";
	public $parseduri = array();
	private $viewscalled = array();
	
	static function resolveUrl($req) {
		$req = str_replace(app::root(), "", $req);
		$req = str_replace("//", "/", $req);
		if (strpos($req,"?") === FALSE) $req .= "?";
		$urlparts = explode("?", $req);
		$url = trim($urlparts[0]);
		$url = preg_replace("/(\/)+$/", "", $url); //REMOVE / OR // at end url
		$qsregex = '/\/*([\w]+\,[\w]+)\/*/';
		//echo "$url\n";
		preg_match_all($qsregex, $url,$uriqs);
		$uriqs = $uriqs[1];
		//print_r($uriqs);
		$url = preg_replace($qsregex, "", $url);
		//echo "$url\n";
		$querystring = trim($urlparts[1]);
		$url = $url?explode("/", $url):[];
		$def = ["index","def","*"];
		for ($i = count($url); $i < count($def); $i++) {
			$url[$i] = $def[$i];
		}
		$querystring = $querystring?explode("&", str_replace("=", ",", $querystring)):[];
		//print_r(array_merge($url,$querystring,$uriqs));
		$uri = implode("/", array_merge($url,$querystring,$uriqs));
		return $uri;
	}
	
	function __construct() {
		$uri = self::resolveUrl($_SERVER['REQUEST_URI']);
		$this->uri = $uri;
		$uri = explode("/", $uri);
		$this->parseduri = $uri;
		//print_r($uri);
		$obj = $uri[0];

		$class = "\\views\\$obj";
		if (class_exists($class,true)) {
			$this->page = new $class($this);
		} else {
			$class = "\\framework\\views\\$obj";
			if (class_exists($class,true)) {
				$this->page = new $class($this);
			} else {
				$this->page = new HTTP404($this);
			}
		}
	}
	
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



