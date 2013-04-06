<?php
namespace framework\html; 
	use framework\app;
	class table extends element {
		function __construct($cols,$rows,$useidkey = FALSE,$options = array()) {
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
					if ($colname == ":DELETE:") {
						if ($useidkey !== FALSE) {
							$tr->addElement(new element("td",array(),
									new anchor("#remove", new icon("Trash"))
							));
								
						}
					} elseif (substr($colname,0,1) == "/") {
						list($null,$obj,$action,$item) = explode("/", $colname);
						$id = $row[$item]; 
						$tr->addElement(new element("td",array("style"=>"text-align:center;"),
							new anchor(app::root()."$obj/$action/$item/$id", new icon("Search"))
						));
					} else {
						$tr->addElement(new element("td",array(),$row[$colname]));						
					}

				}
				$this->addElement($tr);
			}
		}
	}	

