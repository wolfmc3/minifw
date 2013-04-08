<?php
namespace framework\html\form;
use framework\html\element;
use framework\html\anchor;
use framework\app;
class paging extends element {
	function __construct($object,$action,$page,$pages,$block) {
		parent::__construct("div");
		$this->addAttr("class", "paging");
		$basepath = app::root();
		$this->add("Pagine:");
		if ($pages == 0) $pages = 1;
		for ($i = 0;$i < $pages;$i++) {
			if ($i == $page) {
				$this->add(new element("span",null,$page+1));
			} else {
				$this->add(new anchor("$basepath$object/$action/$i/$block", $i+1));
			}
		}
		$blocks = array(10=>"10",25=>"25",50=>"50",100=>"100",0=>"Tutti");
		$this->add("Record per pagina:");
		foreach ($blocks as $key => $value) {
			if ($key == $block) {
				$this->add(new element("span",null,$value));
			} else {
				$this->add(new anchor("$basepath$object/$action/0/$key", $value));
			}
		}
	}
}

