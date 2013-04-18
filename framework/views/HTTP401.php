<?php 
namespace framework\views;

use framework\page;
class HTTP401 extends page {
	protected $title = "Non sei autorizzato";
	protected $template = "error";
	function def() {
		$this->render();
	}
	
}