<?php 
namespace framework\html;

class jsscript extends html {
	function __construct($script,$ready = TRUE) {
		if ($ready) $script = '$(document).ready(function(){'.PHP_EOL.$script.PHP_EOL.'});';
		$script = "<script>$script</script>";
		$this->inner = $script;
	}
}