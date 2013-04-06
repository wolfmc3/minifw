<?php 
namespace framework\db {
	use framework\contentBase;
	use framework\html\table;
	use framework\html\form\edittable;
	use framework\html\element;
	use framework\html\form\submit;
	use framework\html\anchor;
	use framework\html\icon;
	use framework\html\form\paging;
use framework\app;
		class dbcontent extends contentBase {
		protected $table;
		protected $fields;
		protected $idkey = "id";
		protected $columnnames = array();
		protected $columnsettings = array();
		protected $addRecord = TRUE;
		protected $editRecord = TRUE;
		protected $deleteRecord = TRUE;
		protected $viewRecord = TRUE;
		protected $defaultBlock = 25;

		function init() {
			parent::init();
			$this->addJavascript(app::root()."js/dbcontents.js");
			if (isset($this->extra[0])) {
				$this->defaultBlock = $this->extra[0];
			}
		}

		function table() {
			$db = new database();
			$ret = $db->read($this->table,$this->item*$this->defaultBlock,$this->defaultBlock);
			$rows = $ret->rows;
			$options = array(
					"data-openurl" => app::root().$this->obj."/edit/",
					"data-delurl" => app::root().$this->obj."/remove/",
					"id" => $this->table,
					"class" => "datatable"
			);
			$container = new element("");
			$columns = $this->columnnames;
			foreach ($this->columnsettings as $key => $value) {
				if (!$value['ontable']) {
					unset($columns[$key]);
				}
			}
			if ($this->deleteRecord) {
				$columns = array_merge($columns,array(":DELETE:"=>"Cancella"));
			}
			$table = new table($columns, $rows, $this->idkey,$options);
			$container->addElement($table);
				
			$container->addElement(new paging($this->obj, "table", $ret->page(), $ret->pages(), $ret->block));
			$container->addElement(new element("hr"));
			if ($this->addRecord) $container->addElement(new anchor(app::root().$this->obj."/add", array(new icon("Plus")," Nuovo"),array("class"=>"button")) );
			return $container;
		}

		function edit() {
			$db = new database();
			$row = $db->row($this->table, $this->item,$this->idkey);
			$options = array(
					"action" => app::root().$this->obj."/save/".$this->item,
					"method" => "POST"
			);
			$table = new edittable($row,$this->columnnames,$options);
			$form = new element("form",$options);
			$form->addElement($table);
			return $form;
		}

		function add() {
			$db = new database();
			//$row = $db->row($this->table, $this->item);
			$row = array_fill_keys(array_keys($this->columnnames), '');
			$options = array(
					"action" => app::root().$this->obj."/save",
					"method" => "POST"
			);
			$table = new edittable($row,$this->columnnames, $this->idkey,$options);
			$form = new element("form",$options);
			$form->addElement($table);
			return $form;
		}

		function remove() {
			$db = new database();
			$row = $db->delete($this->table, $this->item,$this->idkey);
			header("location: ". $_SERVER['HTTP_REFERER']);
		}

		function save() {
			$data = array();
			foreach ($this->columnnames as $key => $value) {
				$data[":".$key] = $_POST[$key];
			}
			if ($this->item) $data[":".$this->idkey] = $this->item;
			$db = new database();
			$db->write($this->table, $data, $this->columnnames,$this->idkey);
			header("location: ". app::root().$this->obj."/");
			exit();
		}

		function showColumnInfo() {
			if ($this->columnnames) return "Only for init";
			$db = new database();
			$cols = $db->columnInfo($this->table, $this->item);
			$show = new element("pre");
			$coldefs = array();
			$colsetting = array();
				
			$colids = PHP_EOL.'protected $idkey = "';
			foreach ($cols as $col) {
				if ($col['Key'] == "PRI") {
					$colids .= $col['Field'];
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
			$show->addElement(array($coldefs,$colids,$colsetting));
			return $show;
		}

		function def() {
			if (!$this->columnnames) {
				return $this->showColumnInfo();
			} else {
				return $this->table();
			}
		}
	}

}