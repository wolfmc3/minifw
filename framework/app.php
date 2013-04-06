<?php 
namespace framework;

final class app {
	private static $controller;
	private static $root;
	
	public static function init() {
		self::$root = str_replace("index.php", "", $_SERVER['SCRIPT_NAME']);
		self::$controller = new controller();
	}
	
	public static function root() {
		return self::$root;
	}
	
	public static function setController(controller $controller) {
		self::$controller = $controller;
	}
	
	public static function Controller() {
		return self::$controller;
	}
}