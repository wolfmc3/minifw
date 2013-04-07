<?php 
namespace framework\views;

use framework\contentBase;
class HTTP404 extends contentBase {
	protected $title = "Pagina non trovata";
	protected $template = "404";
	function def() {
		$this->render();
	}
	
}