<?php 
namespace framework\views;

use framework\page;
use framework\html\responsive\textblock;
use framework\app;
use framework\html\anchorbutton;
class HTTP404 extends page {
	protected $title = "Pagina non trovata";
	function action_def() {
		return $this->action_other();
	}
	function action_other() {
		app::Controller()->resetModule("menu");
		$resp = new textblock("Errore HTTP 404");
		$resp->append("La pagina richiesta non esiste");
		$url = isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:app::root();
		$resp->append(new anchorbutton($url, "Torna indietro"));
		return $resp;		
	}
		
}