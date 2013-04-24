<?php 
namespace framework\html;
use framework\app;
class source extends element {
	
	function __construct($file) {
		$cont = file_get_contents("views/$file.php");
		parent::__construct("pre",[],$cont);
	}
}