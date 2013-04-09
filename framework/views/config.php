<?php 
namespace framework\views;

use framework\app;
use framework\contentBase;
class config extends contentBase {
	protected $title = "Configurazione";
	protected $template = "html";
	function action_def() {
		$results = str_replace("\n", "<br>\n", print_r(app::conf(),TRUE)) ;
		//print_r(get_declared_classes());
		echo $results;
	}
	
}