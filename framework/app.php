<?php 
namespace framework;

final class app {
	private static $controller;
	private static $root;
	private static $config;
	
	public static function init() {
		self::$root = str_replace("index.php", "", $_SERVER['SCRIPT_NAME']);
		self::$controller = new controller();
		self::$config = new config(__DIR__."/../config/config.ini");
		setlocale(LC_ALL, self::conf()->format->locale);
		date_default_timezone_set(self::conf()->locale->timezone);
		//print_r(self::$config);
	}
	
	public static function root() {
		return self::$root;
	}
	
	public static function &conf() {
		return self::$config;
	}
	
	public static function setController(controller $controller) {
		self::$controller = $controller;
	}
	
	public static function &Controller() {
		if (!self::$controller) throw new \Exception("Controller non found!!!");
		return self::$controller;
	}
	
	public static function getViews() {
		$views = array();
		chdir("views");
		$list = glob('*.php',GLOB_BRACE);
		chdir("..");
		$list = explode("/", str_replace(".php", "", implode("/", $list))); 
		return $list;
	}
	
}