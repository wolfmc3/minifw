<?php
namespace framework\html\form;
use framework\html\element;
class edittable extends element {
	function __construct($row, $labels, $options = array()) {
		parent::__construct("table",$options,array());
		foreach ($labels as $colname => $value) {
			$tr = new element("tr");
			$tr->addElement(new element("th",array(),$value)); //LABEL
			$input = new text($colname, $row[$colname]);
			$tr->addElement(new element("td",array(),$input)); //INPUT
			$this->addElement($tr);
		}
		$tr = new element("tr");
		$td = new element("td",array("colspan"=>"2"),new submit("Salva"));
		$td->addAttr("style", "text-align: center;");
		$tr->addElement($td); 
		$this->addElement($tr);
		
		
	}
}

