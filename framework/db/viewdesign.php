<?php 
namespace framework\db;
use framework\html\element;
class viewdesign extends dbcontent {

	function action_export() {
		$db = new database();
		
		$cols = $db->columnInfo($this->table, $this->item);
		$show = new element("pre");
		$coldefs = array();
		$colsetting = array();
		
		$colids = PHP_EOL.'protected $idkey = "';
		$colshort = PHP_EOL.'protected $shortFields = "';
		foreach ($cols as $col) {
			if ($col['Key'] == "PRI") {
				$colids .= $col['Field'];
				$colshort .= $col['Field'];
			}
			$coldefs[$col['Field']] = "Colonna ".$col['Field'];
			$datatype = ""; $len = "";
			if (strpos($col['Type'], "(") === FALSE ) $col['Type'] .= "(0)";
			list($datatype,$len) = explode("(", $col['Type']);
			$len = substr($len, 0,-1);
			$setting =  array(
					"datatype" => $datatype,
					"len" => $len,
					"null" => $col['Null'] == "YES",
					"ontable" => true);
			$colsetting[$col['Field']] = $setting;
		}
		
		$coldefs = 'protected $columnnames = '.var_export($coldefs,TRUE).";".PHP_EOL.PHP_EOL;
		$colsetting = '/** OPTIONAL **/'.PHP_EOL.'protected $columnsettings = '.var_export($colsetting,TRUE).";".PHP_EOL.PHP_EOL;
		$colids .= '";'.PHP_EOL.PHP_EOL;
		$colshort .= '";'.PHP_EOL.PHP_EOL;
		$show->addElement(array($coldefs,$colids,$colsetting));
		return $show;
		
	}
	
	function action_design() {
		$db = new database();

		$cols = $db->columnInfo($this->table, $this->item);
		$show = new element("form");
		$coldefs = array();
		$colsetting = array();
	
		$colids = PHP_EOL.'protected $idkey = "';
		$colshort = PHP_EOL.'protected $shortFields = "';
		foreach ($cols as $col) {
			if ($col['Key'] == "PRI") {
				$colids .= $col['Field'];
				$colshort .= $col['Field'];
			}
			$coldefs[$col['Field']] = "Colonna ".$col['Field'];
			$datatype = ""; $len = "";
			if (strpos($col['Type'], "(") === FALSE ) $col['Type'] .= "(0)";
			list($datatype,$len) = explode("(", $col['Type']);
			$len = substr($len, 0,-1);
			$setting =  array(
					"datatype" => $datatype,
					"len" => $len,
					"null" => $col['Null'] == "YES",
					"ontable" => true);
			$colsetting[$col['Field']] = $setting;
		}
	
		$coldefs = 'protected $columnnames = '.var_export($coldefs,TRUE).";".PHP_EOL.PHP_EOL;
		$colsetting = '/** OPTIONAL **/'.PHP_EOL.'protected $columnsettings = '.var_export($colsetting,TRUE).";".PHP_EOL.PHP_EOL;
		$colids .= '";'.PHP_EOL.PHP_EOL;
		$colshort .= '";'.PHP_EOL.PHP_EOL;
		$show->addElement(array($coldefs,$colids,$colsetting));
		return $show;
	}
	
}
