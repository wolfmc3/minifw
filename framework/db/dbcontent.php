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
		protected $shortFields = "";

		function init() {
			parent::init();
			$this->addJavascript(app::root()."js/dbcontents.js");
			if (isset($this->extra[0])) {
				$this->defaultBlock = $this->extra[0];
			}
		}

		function action_table() {
			$db = new database();
			$where = NULL;
			$whereArgs = array();
			//echo print_r($this->extra);
			if (count($this->extra) == 3) {
				$where = $this->extra[1]." = ?";
				$whereArgs[] = $this->extra[2]; 
			}
			$ret = $db->read($this->table,$this->item*$this->defaultBlock,$this->defaultBlock,$where,$whereArgs);
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
			$container->add($table);
				
			$container->add(new paging($this->obj, "table", $ret->page(), $ret->pages(), $ret->block));
			$container->add(new element("hr"));
			if ($this->addRecord) $container->add(new anchor(app::root().$this->obj."/add", array(new icon("Plus")," Nuovo"),array("class"=>"button")) );
			return $container;
		}

		function action_edit() {
			$db = new database();
			$row = $db->row($this->table, $this->item,$this->idkey);
			$options = array(
					"action" => app::root().$this->obj."/save/".$this->item,
					"method" => "POST"
			);
			$table = new edittable($row,$this->columnnames,$options);
			$form = new element("form",$options);
			$form->add($table);
			return $form;
		}

		function action_add() {
			$db = new database();
			//$row = $db->row($this->table, $this->item);
			$row = array_fill_keys(array_keys($this->columnnames), '');
			$options = array(
					"action" => app::root().$this->obj."/save",
					"method" => "POST"
			);
			$table = new edittable($row,$this->columnnames, $this->idkey,$options);
			$form = new element("form",$options);
			$form->add($table);
			return $form;
		}

		function action_remove() {
			$db = new database();
			$row = $db->delete($this->table, $this->item,$this->idkey);
			header("location: ". $_SERVER['HTTP_REFERER']);
		}

		function action_save() {
			print_r($_POST);
			$data = array();
			$realcolumns = array();
			foreach ($this->columnnames as $key => $value) {
				if (isset($_POST[$key])) {
					$data[":".$key] = $_POST[$key];
					$realcolumns[$key] = $value;
				}
			}
			if ($this->item) $data[":".$this->idkey] = $this->item;
			$db = new database();
			$db->write($this->table, $data, $realcolumns,$this->idkey);
			header("location: ". app::root().$this->obj."/");
			exit();
		}
		
		function link($id) {
			if (!$id) return "-";
			return new anchor(app::root().$this->obj."/edit/$id", $this->label($id));
		}
		
		function label($id) {
			if (!$id) return "-";
			if (!$this->shortFields) {
				$this->shortFields = $this->idkey;
			}
			$db = new database();
			$row = $db->row($this->table, $id, $this->idkey);
			//print_r($row);
			return $row[$this->shortFields];
		}
		

		function action_def() {
			return $this->action_table();
		}
	}

}