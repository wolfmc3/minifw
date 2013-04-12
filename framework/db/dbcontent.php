<?php 
/*
 * Formato variabile [dbcontents]$columns
 * Array associativo
 * [Nome campo db] = array(
 * 		name: Descrizione Campo 
 * 		ontable: 1= Visualizza nella tabella     
 * 		inputtype: tipo di campo
 * 			valori possibili: 
 * 				text : Testo semplice,
 *				readonly : Solo visualizzazione (indicato per campi ID)
 *				longtext : Testo di dimensioni oltre 40 caratteri (indicativo)
 *				numeric : Numero
 *				currency : Valuta
 *				date : Data
 *				datetime : Data e ora
 *				time : Orario
 *				bool : Si/no
 *
 * 		relation: indica a quale vista può essere associato questo valore (tramite campo id),    
 * 		required: se impostato a 1 nella modalità edit non può essere vuoto      
 * 		regexpr: espressione regolare per verificare la correttezza del campo    
 * 		datatype: legato al tipo di dato usato nel database    
 * 		len: lunghezza campo (per i campi di testo incide sulla quantità di caratteri inseribili nella input    
 * 		null: se a 1 indica che nel database il campo può essere null (requred a 1 se il campo non può essere null)
 * 
 *  
 * */
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
		protected $columns = array();
		protected $addRecord = TRUE;
		protected $editRecord = TRUE;
		protected $deleteRecord = TRUE;
		protected $viewRecord = TRUE;
		protected $defaultBlock = 25;
		protected $DescriptionKeys = "";
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
		}

		function action_table() {
			$db = new database();
			$where = NULL;
			$whereArgs = array();
			//echo "fileds:";print_r($this->fields);
			foreach ($this->columns as $key => $value) {
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
			$columns = $this->columns;
			if ($this->deleteRecord) {
				$columns = array_merge($columns,array(":DELETE:"=>["name"=>"Cancella","ontable"=>1]));
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
			$table = new edittable($row,$this->columns,$options);
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
			//TODO: Controlli di sicurazza lato server
			//TODO: Indicazione in caso di errore 
			foreach ($this->columns as $key => $value) {
				if (isset($_POST[$key])) {
					$data[":".$key] = $_POST[$key];
					$realcolumns[$key] = $value;
				}
			}
			print_r($data);
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
			return new anchor($this->uri($id,"edit") , $this->label($id));
		}
		
		function label($id) {
			if (!$id) return "-";
			if (!$this->DescriptionKeys) {
				$this->DescriptionKeys = $this->idkey;
			}
			
			$db = new database();
			$row = $db->row($this->table, $id, $this->idkey);
			//print_r($row);
			$label = "";
			$keys = explode(",", $this->DescriptionKeys);
			foreach ($keys as $key) {
				$label .= $row[$key]." ";
			}
			return trim($label);
		}
		
		function fields() {
			$cols = [];
			$db = new database();
			$dbcol = $db->columnInfo($this->table);
			foreach ($dbcol as $vals) {
				$col = $vals['Field'];
				if (ctype_alpha(substr($col, 0,1))) {
					$cols[$col] = "(".$this->obj.") ".(array_key_exists($col, $this->columns)?$this->columns[$col]['name']:$col);
				}
			}
			return $cols;
		}

		function action_def() {
			return $this->action_table();
		}
		
		function columnInfo($column,$key) {
			
		}
	}

}