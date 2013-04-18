<?php 
namespace framework\db {
	use framework\page;
	use framework\html\table;
	use framework\html\form\edittable;
	use framework\html\element;
	use framework\html\form\submit;
	use framework\html\anchor;
	use framework\html\icon;
	use framework\html\form\paging;
	use framework\app;
use framework\html\anchorbutton;
		/**
 * Classe dbpage
 * 
 * Estendere questa classe per ottenere oggetti instaziabili dalla classe controller per generare pagine collegate a database
 *<br><br>
 * <code>
 * Formato variabile [dbpages]$columns
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
 * </code>
 * <br>
 * <br>
 * @see \framework\controller
 * @see \framework\page
 * @see \framework\db\dbpage
 * @package minifw/database
 *
 */
		class dbpage extends page {
			/**
			 * @var string Tabella del database
			 */
		protected $table;
		/**
		 * @deprecated
		 * @var string[] Lista campi
		 */
		protected $fields;
		protected $database = "database";
		/**
		 * @var string Indica la chiave primaria della tabella (se le chiavi sono multiple separare con la virgola)
		 */
		protected $idkey = "id";
		/**
		 * @var mixed[] Vedi descrizione della classe
		 * @see \framework\db\dbpage
		 */
		protected $columns = array();
		/**
		 * @var boolean Indica se la view può aggiungere dati
		 */
		protected $addRecord = TRUE;
		/**
		 * @var boolean Indica se la view può modificare dati
		 */
		protected $editRecord = TRUE;
		/**
		 * @var boolean Indica se la view può cancellare dati
		 */
		protected $deleteRecord = TRUE;
		/**
		 * @var boolean Indica se la view può vedere il dettaglio dati
		 */
		protected $viewRecord = TRUE;
		/**
		 * @var boolean Indica se la view può vedere la lista dei dati
		 */
		protected $listRecord = TRUE;
		/**
		 * @var number numero di record per pagina 
		 */
		protected $defaultBlock = 25;
		/**
		 * @var string campi che offrono un breve descrizione del record (se le colonne sono multiple separare con la virgola)
		 */
		protected $DescriptionKeys = "";

		/**
		 * init()
		 * 
		 * @see \framework\page::init()
		 */
		function init() {
			parent::init();
			$this->addJavascript("dbpages.js");
			$this->addJavascript(app::conf()->jquery->ui);
			$this->addCss(app::conf()->jquery->theme);
			if (isset($this->extra[0])) {
				$this->defaultBlock = $this->extra[0];
			}
		}

		/**
		 * Azione table
		 * 
		 * Visualizza la lista dei record
		 * 
		 * Questo metodo è richiamato direttamente dal controller 
		 * 
		 * @see \framework\controller
		 * @return \framework\html\element 
		 */
		function action_table() {
			if (!$this->listRecord) return "";
			$db = new database($this->database);
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
			if ($this->addRecord) $container->add(new anchorbutton(app::root().$this->obj."/add", array(new icon("Plus")," Nuovo"),array("class"=>"button")) );
			return $container;
		}
		/**
		 * Azione edit
		 * 
		 * apre il form per la modifica dei dati
		 * 
		 * @return \framework\html\element
		 */
		function action_edit() {
			if (!$this->editRecord) return "";
			$db = new database($this->database);
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

		/**
		 * Azione add
		 *
		 * apre il form per l'aggiunta dei dati
		 *
		 * @return \framework\html\element
		 */
		
		function action_add() {
			if (!$this->addRecord) return "";
			$db = new database($this->database);
			//$row = $db->row($this->table, $this->item);
			$row = array_fill_keys(array_keys($this->columns), NULL);
			$options = array(
					"action" => app::root().$this->obj."/save",
					"method" => "POST"
			);
			$table = new edittable($row,$this->columns, $this->idkey,$options);
			$form = new element("form",$options);
			$form->add($table);
			return $form;
		}

		/**
		 * Azione remove
		 *
		 * cancella un record
		 *
		 * @return NULL
		 */
		
		function action_remove() {
			if (!$this->editRecord) return "";
			$db = new database($this->database);
			$row = $db->delete($this->table, $this->item,$this->idkey);
			header("location: ". $_SERVER['HTTP_REFERER']);
		}

		function setPermissions($read, $write, $list, $add) {
			$this->addRecord = ($add==1);
			$this->deleteRecord = ($write==1);
			$this->editRecord = ($write==1);
			$this->viewRecord = ($read==1);
		}
		/**
		 * Azione save
		 * 
		 * salva i dati provenienti dalle azioni add ed edit
		 * 
		 * @see action_edit()
		 * @see action_add()
		 *  
		 */
		function action_save() {
			if (!$this->editRecord) return "";
				
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
			//print_r($data);
			$db = new database($this->database);
			$db->write($this->table, $data, $realcolumns,$this->item,$this->idkey);
			header("location: ". app::root().$this->obj."/");
			exit();
		}
		
		/**
		 * uri()
		 * 
		 * Genera un Uri sulla base dei parametri impostati
		 * 
		 * @param string|number $id id del record
		 * @param string $action azione
		 * @param string[] $extra parametri extra 
		 * @return string Uri completo
		 */
		function uri($id, $action= "table",$extra = array()) {
			$uri = app::root().$this->obj;
			if ($action) $uri .= "/$action"; 			
			if ($action && $id) $uri .= "/$id"; 
			return app::root().$this->obj."/$action/$id";
		}
		
		/**
		 * key()
		 * 
		 * rimuove eventuali virgole dalla chiave primaria
		 * @see \framework\db\dbpage::$idkey
		 * 
		 * @return string
		 */
		function key() {
			return str_replace(",", "|", $this->idkey);
		}
		
		/**
		 * link(...)
		 * 
		 * Ritorna un link alla risorsa richiesta 
		 * 
		 * @param string $id Id record
		 * @param string $action Azione
		 * @return \framework\html\anchor 
		 */
		function link($id,$action = "table") {
			if (!$id) return "-";
			return new anchor($this->uri($id,"edit") , $this->label($id));
		}
		
		
		/**
		 * link(...)
		 *
		 * Ritorna una stringa contenente la descrizione breve
		 *
		 * @param string $id Id record
		 * @return string
		 * @see $DescriptionKeys
		 */
		
		function label($id) {
			if (!$id) return "-";
			if (!$this->DescriptionKeys) {
				$this->DescriptionKeys = $this->idkey;
			}
			
			$db = new database($this->database);
			$row = $db->row($this->table, $id, $this->idkey);
			//print_r($row);
			$label = "";
			
			$keys = explode(",", $this->DescriptionKeys);
			foreach ($keys as $key) {
				$label .= $row[$key]." ";
			}
			return trim($label);
		}
		
		/**
		 * fields()
		 * 
		 * Genera una lista delle colonne della tabella
		 * 
		 * @return string[]
		 */
		function fields() {
			$cols = [];
			$db = new database($this->database);
			$dbcol = $db->columnInfo($this->table);
			foreach ($dbcol as $vals) {
				$col = $vals['Field'];
				if (ctype_alpha(substr($col, 0,1))) {
					$cols[$col] = "(".$this->obj.") ".(array_key_exists($col, $this->columns)?$this->columns[$col]['name']:$col);
				}
			}
			return $cols;
		}

		/**
		 * Azione di default
		 * 
		 * Imposta l'azione di default su table
		 * 
		 * @see \framework\page::action_def()
		 * @see action_table()
		 */
		function action_def() {
			return $this->action_table();
		}
	}

}