<?php 
namespace framework\html;
class template extends element {
	private $data;
	private $loadedtemplate=[];
	private $template;	
	protected $html = TRUE;
	
	function __construct($file,$data, $folder = "") {
		parent::__construct("");
		if ($folder == "") $folder = __DIR__."/../../templates/";
		if (!file_exists("$folder$file.tmpl.htm")) $this->html = "TEMPLATE $folder$file.htm NOT FOUND!!";
		$this->template = file_get_contents("$folder$file.tmpl.htm");
		$this->data = $data;
	}
	
	function __toString() {
		return  $this->renderPart($this->template, $this->data);
	}

	private function renderPart($html, $data) {
		$group_pattern = "/{(\w+):(.*?):}/sm";
		$item_pattern = "/{(\w+)}/";
		$callbackblock = function( $match ) use ( $data ) {
			$ret = "";
			$item_pattern = "/{(\w+)}/";
			if (isset($data[$match[1]])) {
				foreach ($data[$match[1]] as $subvalues) {
					$callbackitem = function( $match ) use ( $subvalues ) {
						if (array_key_exists($match[1], $subvalues)) {
							return $subvalues[$match[1]];
						} else {
							return "";
						}
			    	}; 
					$ret .= preg_replace_callback($item_pattern, $callbackitem, $match[2]);
				}
			} else {
				$ret = "";
			}
			return $ret;
    	}; 
		$callbackitem = function( $match ) use ( $data ) {
			//print_r($match);
			if (isset($data[$match[1]])) {
				return $data[$match[1]];
			} else {
				return "";
			}
    	}; 
		$html = preg_replace_callback($group_pattern, $callbackblock, $html);
		$html = preg_replace_callback($item_pattern, $callbackitem, $html);
		return $html;
	}
}
