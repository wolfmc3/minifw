<?php 
namespace plugins\tinymce;
use framework\html\element;
use framework\app;
use framework\html\template;
class tmcetextarea extends element {
	private $textarea;
	function __construct($name, $id = "" ,$class = "",$options = array()) {
		app::Controller()->getPage()->addJavascript("tinymce/tinymce.min.js");
		parent::__construct();
		$textarea = $this->append(new element("textarea",$options));
		$textarea->addAttr("name", $name)->addAttr("style", "width:100%; height:550px;")->addAttr("class", "tmce")->addAttr("class", $class)->addAttr("id", $id)->add("");
		$this->textarea = $textarea;
		$this->add(new template("initscript", array("id"=>$id),"plugins/tinymce/"));
	}
	
	function setContents($html) {
		$this->textarea->html( $html );
	}
}