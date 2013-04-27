<?php 
namespace framework\views;

use framework\page;
use framework\html\responsive\textblock;
use framework\app;
use framework\html\anchorbutton;
class HTTP401 extends page {
	protected $title = "Non sei autorizzato";
	
	function action_def() {
		return $this->action_other();
	}
	
	function action_other() {
		app::Controller()->resetModule("menu");
		$resp = new textblock("Errore HTTP 401");
		$resp->append("Non sei autorizzato a visualizzare questa pagina");
		$url = isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:app::root();
		$resp->append(new anchorbutton($url, "Torna indietro"));
		return $resp;		
	}
	
}