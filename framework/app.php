<?php
/**
 *
 * app.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework;
use framework\security\security;
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
	 * @var \framework\security\security Modulo sicurezza caricato
	 */
	private static $security;

	/**
	 * Init
	 *
	 * Inizializzato dal front controller /index.php
	 *
	 */
	public static function init() {
		self::$root = str_replace("index.php", "", $_SERVER['SCRIPT_NAME']);
		self::$config = new config(__DIR__."/../config/config.ini");
		if (self::conf()->system->usesessiondb)	session_set_save_handler(new pdosessions());
		session_start();
		self::$security = new security();
		self::$controller = new controller();
		setlocale(LC_ALL, self::conf()->format->locale);
		date_default_timezone_set(self::conf()->locale->timezone);
		if (!file_exists(self::conf()->system->imagecache)) {
			if (@mkdir(self::conf()->system->imagecache)) {
				self::Controller()->addMessage("Cartella cache immagini creata con successo");
			} else {
				self::Controller()->addMessage("ERRORE: Impossibile creare cartella cache");
			}
		} elseif (!is_writable(self::conf()->system->imagecache)) {
			self::Controller()->addMessage("Attenzione: La cartella cache non è scrivibile");
		}

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
	 * Security()
	 *
	 * Ottiene l'oggetto security
	 *
	 * @return \framework\security\security
	 */
	public static function &Security() {
		return self::$security;
	}

	/**
	 * Ritorna la lista dei nomi degli oggetti presenti nella cartella /views
	 *
	 * @param boolean $systemviews Specifica se devono essere incluse le viste di sistema (/framework/views/)
	 * @return string[]
	 */
	public static function getViews($systemviews = FALSE) {
		$views = array();
		chdir("views");
		$list = glob('*.php',GLOB_BRACE);
		chdir("..");
		if ($systemviews) {
			chdir("framework/views");
			$list = array_merge($list,glob('*.php',GLOB_BRACE));
			chdir("../..");
		}
		$list = explode("/", str_replace(".php", "", implode("/", $list)));
		return $list;
	}

}