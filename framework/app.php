<?php 
namespace framework;
	/**
	 * Application (classe statica)
	 *
	 * Inzializza il controller e la classe config 
	 *
	 * @author Marco Camplese <info@wolfmc3.com>
	 * @package minifw
	 *
	 * 
	 */
final class app {
	/**
	 * @var \framework\controller $controller Classe controller instanziata tramite init
	 */
	private static $controller;
	/**
	 * @var string $root Url base 
	 */
	private static $root;
	/**
	 * @var \framework\config $config Riferimento alla configurazione 
	 */
	private static $config;
	
	/**
	 * Init
	 * 
	 * Inizializzato dal front controller /index.php
	 * 
	 */
	public static function init() {
		self::$root = str_replace("index.php", "", $_SERVER['SCRIPT_NAME']);
		self::$controller = new controller();
		self::$config = new config(__DIR__."/../config/config.ini");
		setlocale(LC_ALL, self::conf()->format->locale);
		date_default_timezone_set(self::conf()->locale->timezone);
		//print_r(self::$config);
	}
	
	/**
	 * Url base
	 * 
	 * Ritorna l'url base dell'applicazione (dove risiede index.php). 
	 * Normalmente ritorna / o /[subdir]/ se installata in subdirectory del sito
	 * 
	 * @return string
	 */
	public static function root() {
		return self::$root;
	}
	
	/**
	 * Conf[ig]
	 * 
	 * Ritorna un riferimento all'oggetto che si occupa di caricare la configurazione di sistema.
	 * Utilizzo:
	 * <code>app::conf()->base->version</code>
	 * <code>app::conf()->database->host</code>
	 *  
	 * @return \framework\config
	 */
	
	public static function &conf() {
		return self::$config;
	}
	
	/**
	 * @ignore
	 * @param controller $controller
	 */
	public static function setController(controller $controller) {
		self::$controller = $controller;
	}
	
	/**
	 * Controller()
	 * 
	 * Ritorna un riferimento al controller istanziato nel metodo init()
	 * 
	 * @throws \Exception Se il controller non è stato inizializzato
	 * @return \framework\controller
	 */
	public static function &Controller() {
		if (!self::$controller) throw new \Exception("Controller non found!!!");
		return self::$controller;
	}
	
	/**
	 * Ritorna la lista dei nomi degli oggetti presenti nella cartella /views
	 * 
	 * @return string[]
	 */
	public static function getViews() {
		$views = array();
		chdir("views");
		$list = glob('*.php',GLOB_BRACE);
		chdir("..");
		$list = explode("/", str_replace(".php", "", implode("/", $list))); 
		return $list;
	}
	
}