<?php
/**
 *
 * HTTP401.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\views;

use framework\page;
use framework\html\responsive\textblock;
use framework\app;
use framework\html\anchorbutton;
/**
 *
 * Visualizzazione non autorizzata
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw
 *
 */

class HTTP401 extends page {
	/**
	 *
	 * @var string Titolo della pagina
	 */
	protected $title = "Non sei autorizzato";

	/**
	 * Azione di default
	 * @see \framework\page::action_def()
	 */
	function action_def() {
		return $this->action_other();
	}
	/**
	 * Risposta predefinita per altre azioni inesistenti
	 * @return \framework\html\element
	 */

	function action_other() {
		app::Controller()->resetModule("menu");
		$resp = new textblock("Errore HTTP 401");
		$resp->append("Non sei autorizzato a visualizzare questa pagina");
		$url = isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:app::root();
		$resp->append(new anchorbutton($url, "Torna indietro"));
		return $resp;
	}

}