<?php
/**
 * Classe per aggiungere un controllo textarea con il supporto tinymce
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package plugins\tinymce4
 *
 */
namespace plugins\tinymce;
use framework\html\element;
use framework\app;
use framework\html\template;
/**
 *
 * tmcetextarea
 *
 * Textarea con sopporto completo TinyMCE v4
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/plugins/tinymce4
 *
 */
class tmcetextarea extends element {
	/**
	 * @var \framework\html\element Controllo textarea da associare a tinymce
	 */
	private $textarea;
	/**
	 * Costruttore
	 *
	 * @param string $name Nome nel form HTML
	 * @param string $id ID elemento html
	 * @param string $class Classe elemento HTML
	 * @param string[] $options array contenente gli attributi del tag html
	 */
	function __construct($name, $id = "" ,$class = "",$options = array()) {
		app::Controller()->getPage()->addJavascript("tinymce/tinymce.min.js");
		parent::__construct();
		$textarea = $this->append(new element("textarea",$options));
		$textarea->addAttr("name", $name)->addAttr("style", "width:100%; height:550px;")->addAttr("class", "tmce")->addAttr("class", $class)->addAttr("id", $id)->add("");
		$this->textarea = $textarea;
		$this->add(new template("initscript", array("id"=>$id),"plugins/tinymce/"));
	}
	/**
	 * setContents
	 *
	 * Imposta il contenuto della textarea
	 *
	 * @param mixed $html
	 */
	function setContents($html) {
		$this->textarea->html( $html );
	}
}