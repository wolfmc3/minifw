<?php
namespace framework\html; 
	use framework\app;
	/**
	 * table
	 *
	 * Genera una tabella HTML completa<br>
	 * NOTA: questo oggetto table è utilizzato dall'oggetto dbcontents
	 *
	 * @author Marco Camplese <info@wolfmc3.com>
	 * @package minifw/html
	 *
	 * @see element
	 * @see \framework\db\dbcontent
	 *
	 */
	class table extends element {
		/**
		 * Costruttore 
		 * 
		 * @param string[] $cols Array associativo contenente le chiavi e i nomi di colonna
		 * @param string[] $rows Array associativo contenente le righe
		 * @param string $useidkey Riservato per l'utilizzo come tabella associata a dati
		 * @param string[] $options attributi del tag table
		 */
		function __construct($cols,$rows,$useidkey = FALSE,$options = array()) {
			parent::__construct("table",$options,array());
			$this->addAttr("style", "width: 100%;");

			$head = new element("tr",array(),array());

			foreach ($cols as $colname => $setting) {
				if (!array_key_exists("ontable",$setting)) {
					$cols[$colname]['ontable'] = 0;
				}
			}
			foreach ($cols as $colname => $setting) {
				if ($setting['ontable']) {
					$head->add(new element("th",NULL,$setting['name']));
				} 
					
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
				foreach ($cols as $colname => $setting) {
					if (!$setting['ontable']) continue;
					if ($colname == ":DELETE:") {
						if ($useidkey !== FALSE) {
							$tr->add(new element("td",array(),
									new anchor("#remove", new icon("Trash"))
							));
						}
					} elseif (substr($colname,0,1) == "/") { //OPEN LIST
						list($null,$obj,$action,$item,$idtarget) = explode("/", $colname);
						$id = $row[$item]; 
						$callkey = $idtarget; 
						if ($id) $tr->add(new element("td",array("style"=>"text-align:center;"),
							new anchor(app::root()."$obj/$action/0/0/$callkey,$id", new icon("Search"))
						)); else $tr->add(new element("td",array("style"=>"text-align:center;"),"-"));
					} elseif (substr($colname,0,1) == "+") { //OPEN LIST INLINE
						$colname = str_replace("+", "/", $colname);
						list($null,$obj,$action,$item,$idtarget) = explode("/", $colname);
						$id = $row[$item];
						$callkey = $idtarget; 
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
					} elseif (substr($colname,0,1) == "=") { //Calculated view
						$colname = str_replace("=", "", $colname);
						$colname = substr($colname, 0,-1);
						$item_pattern = "/{(\w+)}/e";
						$colname = preg_replace($item_pattern, "\$row['\\1']", $colname);
						//echo $colname;
						$colname = eval("return $colname;");
						$tr->add(new element("td",array(),
							new element("b",NULL,$colname)		
						));
					} else {
						$tr->add(new element("td",array(),$row[$colname]));						
					}

				}
				$this->add($tr);
			}
		}
	}	

