<?php
namespace framework\html; 
	use framework\app;
	class table extends element {
		function __construct($cols,$rows,$useidkey = FALSE,$options = array()) {
			parent::__construct("table",$options,array());
			$this->addAttr("style", "width: 100%;");

			$head = new element("tr",array(),array());
			//print_r($cols);
			foreach ($cols as $colname => $label) {
				$head->add(new element("th",NULL,$label));
			}
			$this->add($head);
			foreach ($rows as $row) {
				
				$tr = new element("tr");
				if ($useidkey !== FALSE) {
					$useidkey = str_replace(",", "~", $useidkey);
					$id = preg_replace("/([\w]+)/e", "\$row['\\1']", $useidkey);
					//$id = implode("-", array_map(function($val){$row[$val];}, explode(",", $useidkey)));
					$tr->addAttr("data-id", $id);
				}
				foreach ($cols as $colname => $label) {
					if ($colname == ":DELETE:") {
						if ($useidkey !== FALSE) {
							$tr->add(new element("td",array(),
									new anchor("#remove", new icon("Trash"))
							));
								
						}
					} elseif (substr($colname,0,1) == "/") { //OPEN LIST
						list($null,$obj,$action,$item) = explode("/", $colname);
						$id = $row[$item]; 
						$callkey = app::Controller()->$obj->key(); 
						if ($id) $tr->add(new element("td",array("style"=>"text-align:center;"),
							new anchor(app::root()."$obj/$action/0/0/$callkey,$id", new icon("Search"))
						)); else $tr->add(new element("td",array("style"=>"text-align:center;"),"-"));
					} elseif (substr($colname,0,1) == "+") { //OPEN LIST INLINE
						$colname = str_replace("+", "/", $colname);
						list($null,$obj,$action,$item) = explode("/", $colname);
						$id = $row[$item];
						$callkey = app::Controller()->$obj->key(); 
						if ($id) $tr->add(new element("td",array("style"=>"text-align:center;"),
							new anchor(app::root()."$obj/$action/0/0/$callkey,$id", new icon("Arrow2-Down"),array("class"=>"inlinedetail rotate"))
						)); else $tr->add(new element("td",array("style"=>"text-align:center;"),"-"));
							
					} elseif (substr($colname,0,1) == "?") { //EDIT SINGLE
						$colname = str_replace("?", "", $colname);
						list($obj,$linkid) = explode("/", $colname);
						$id = $row[$linkid];
						$tr->add(new element("td",array(),
							app::Controller()->$obj->link($id)		
						));
					} elseif (substr($colname,0,1) == "!") { //Label OTHER VIEW
						$colname = str_replace("!", "", $colname);
						list($obj,$linkid) = explode("/", $colname) ;
						$id = $row[$linkid];
						$tr->add(new element("td",array(),
							new element("b",NULL,app::Controller()->$obj->label($id))		
						));
					} else {
						$tr->add(new element("td",array(),$row[$colname]));						
					}

				}
				$this->add($tr);
			}
		}
	}	

