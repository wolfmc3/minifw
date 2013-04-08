<?php
namespace framework\html\form;
use framework\html\element;
class edittable extends element {
	function __construct($row, $labels, $options = array()) {
		parent::__construct("table",$options,array());
		foreach ($labels as $colname => $value) {
			if (isset($row[$colname])) {
				$tr = new element("tr");
				$tr->add(new element("th",array(),$value)); //LABEL
				$input = new text($colname, $row[$colname]);
				$tr->add(new element("td",array(),$input)); //INPUT
				$this->add($tr);
			}
		}
		$tr = new element("tr");
		$td = new element("td",array("colspan"=>"2"),new submit("Salva"));
		$td->addAttr("style", "text-align: center;");
		$tr->add($td); 
		$this->add($tr);
		
		
	}
}

