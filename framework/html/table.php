<?php
namespace framework\html; 
	class table extends element {
		function __construct($cols,$rows, $controller ,$useidkey = FALSE,$options = array()) {
			parent::__construct("table",$options,array());

			$head = new element("tr",array(),array());
			//print_r($cols);
			foreach ($cols as $colname => $label) {
				$head->addElement(new element("th",NULL,$label));
			}
			$this->addElement($head);
			foreach ($rows as $row) {
				
				$tr = new element("tr");
				if ($useidkey !== FALSE) {
					$tr->addAttr("data-id", $row[$useidkey]);
				}
				
				foreach ($cols as $colname => $label) {
					if ($colname != ":DELETE:") {
						$tr->addElement(new element("td",array(),$row[$colname]));						
					} else {
						if ($useidkey !== FALSE) {
							$tr->addElement(new element("td",array(),
									new anchor("#remove", new icon("Trash", $controller))
							));
								
						}
					}

				}
				$this->addElement($tr);
			}
		}
	}	

