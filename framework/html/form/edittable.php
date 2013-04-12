<?php
namespace framework\html\form;
use framework\html\element;
class edittable extends element {

	function __construct($row, $cols, $options = array()) {
		parent::__construct("table",$options,array());
		$this->addAttr("style", "width: 100%;");
		foreach ($cols as $colname => $settings) {
			if (ctype_alpha(substr($colname, 0,1))) {
				$tr = new element("tr");
				$tr->add(new element("th",array(),$settings['name'])); //LABEL
				$input = new dyninput($colname, $row[$colname],$settings);
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

