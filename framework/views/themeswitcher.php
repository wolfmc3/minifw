<?php
/**
 *
 * themeswitcher.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\views;
use framework\page;
use framework\app;
/**
 *
 * View themeswitcher
 *
 * Memorizza il cambio del tema di default per l'utenete
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/themes
 *
 */
class themeswitcher extends page {
	/**
	 *
	 * @var int Risposta Redirect
	 */
	protected $type = self::TYPE_REDIRECT;
	/**
	 * Azione di default
	 *
	 * Salva in una variabile di sessione il tema da utilizzare
	 * @see \framework\page::action_def()
	 */
	function action_def() {
		$url = isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:app::root();
		$theme = $_POST["newtheme"];
		if (file_exists("themes/$theme")){
			$_SESSION["theme"] =  $theme;
		}
		return $url;
	}
}