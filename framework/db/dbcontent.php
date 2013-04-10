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
			$this->addJavascript(app::root()."js/jquery-ui.js");
			$this->addCss(app::root()."css/black-tie/jquery-ui.css");
			$this->addJavascript(app::root()."js/dyninput.js");
			if (isset($this->extra[0])) {
				$this->defaultBlock = $this->extra[0];
			}
			//print_r(array_keys($this->columnnames));
			$this->fields = array_unique(array_merge(explode(",", $this->idkey), array_keys($this->columnnames)));
		}

		function action_table() {
			$db = new database();
			$where = NULL;
			$whereArgs = array();
			//echo "fileds:";print_r($this->fields);
			foreach ($this->fields as $key) {
				//echo " $key \n";
				if (array_key_exists($key, $this->extra)) {
					$where = ($where?" AND ":"").$key." = ?";
					$whereArgs[] = $this->extra[$key];
				}
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
				if (isset($value['ontable']) && $value['ontable'] == 'true') {
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
			$table = new edittable($row,$this->columnnames,$this->columnsettings,$options);
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
			//print_r($_POST);
			$data = array();
			$realcolumns = array();
			foreach ($this->columnnames as $key => $value) {
				if (isset($_POST[$key])) {
					$data[":".$key] = $_POST[$key];
					$realcolumns[$key] = $value;
				}
			}
			$db = new database();
			$db->write($this->table, $data, $realcolumns,$this->item,$this->idkey);
			header("location: ". app::root().$this->obj."/");
			exit();
		}
		
		function uri($id, $action= "table",$extra = array()) {
			$uri = app::root().$this->obj;
			if ($action) $uri .= "/$action"; 			
			if ($action && $id) $uri .= "/$id"; 
			return app::root().$this->obj."/$action/$id";
		}
		
		function key() {
			return str_replace(",", "|", $this->idkey);
		}
		
		function link($id,$action = "table") {
			if (!$id) return "-";
			return new anchor($this->uri($id,$action) , $this->label($id));
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
		
		function fields() {
			$cols = [];
			$db = new database();
			$dbcol = $db->columnInfo($this->table);
			foreach ($dbcol as $vals) {
				$col = $vals['Field'];
				if (ctype_alpha(substr($col, 0,1))) {
					$cols[$col] = array_key_exists($col, $this->columnnames)?$this->columnnames[$col]:$col;
				}
			}
			return $cols;
		}

		function action_def() {
			return $this->action_table();
		}
	}

}