<?php 
namespace framework\views;

use framework\page;
class HTTP404 extends page {
	protected $title = "Pagina non trovata";
	protected $template = "error";
	function def() {
		$this->render();
	}
	
}