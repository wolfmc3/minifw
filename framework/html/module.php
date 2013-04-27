<?php 
namespace framework\html;
class module extends element {
	private $renderok;
	
	function render($force) {
		return true;
	}
	
	final function __construct() {
		parent::__construct();
		
	}
}