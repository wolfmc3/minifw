<?php 
namespace framework\views;

use framework\app;
use framework\contentBase;
class config extends contentBase {
	protected $title = "Configurazione";
	protected $template = "html";
	function action_def() {
		return "<code>".str_replace("=", "=<b>", str_replace("\n", "</b>\n<br>", app::conf()))."</code>";
	}
	
}