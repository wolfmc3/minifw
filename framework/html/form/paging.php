<?php
namespace framework\html\form;
use framework\html\element;
use framework\html\anchor;
use framework\system;
class paging extends element {
	function __construct($object,$action,$page,$pages,$block) {
		parent::__construct("div");
		$this->addAttr("class", "paging");
		$basepath = system::getController()->getAppRoot();
		$this->addElement("Pagine:");
		if ($pages == 0) $pages = 1;
		for ($i = 0;$i < $pages;$i++) {
			if ($i == $page) {
				$this->addElement(new element("span",null,$page+1));
			} else {
				$this->addElement(new anchor("$basepath$object/$action/$i/$block", $i+1));
			}
		}
		$blocks = array(10=>"10",25=>"25",50=>"50",100=>"100",0=>"Tutti");
		$this->addElement("Record per pagina:");
		foreach ($blocks as $key => $value) {
			if ($key == $block) {
				$this->addElement(new element("span",null,$value));
			} else {
				$this->addElement(new anchor("$basepath$object/$action/0/$key", $value));
			}
		}
	}
}

