<?php 
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
	protected $title = "Configurazione";
	protected $template = "html";
	protected $title = "Configurazione";
	function action_def() {
		return "<pre>".str_replace("=", "=<b>", str_replace("\n", "</b>\n", app::conf()))."</pre>";
	}
	
}