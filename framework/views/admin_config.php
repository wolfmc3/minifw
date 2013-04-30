<?php
/**
 *
 * admin_config.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\views;

use framework\app;
use framework\page;
/**
 *
 * admin_config
 *
 * Pagina di accesso alla configurazione di sistema
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw
 *
 */
class admin_config extends page {
	/**
	 *
	 * @var string Titolo della pagina
	 */
	protected $title = "Configurazione";
	/**
	 *
	 * @var string Template
	 */
	protected $template = "html";
	/**
	 * Azione di default
	 * @see \framework\page::action_def()
	 */
	function action_def() {
		return "<pre>".str_replace("=", "=<b>", str_replace("\n", "</b>\n", app::conf()))."</pre>";
	}

}