<?php 
namespace framework\db {
	use framework\app;
	/**
	 * Database
	 *
	 * Gestisce il reperimento delle informazioni dal database impostato nella sezione di configurazione [database]
	 *
	 * @author Marco Camplese <info@wolfmc3.com>
	 * @package minifw/database
	 *
	 *
	 */
	class database {
		//TODO. SEPARARE LA LOGICA DI ESTRAZIONE (interfaccia) DAL MODULO DATABASE
		/**
		 * Database di sistema instanziato da init()
		 * @var \PDO
		 */
		private static $db = array();
		/**
		 * @var string Modulo di configurazione che contiene le impostazioni del database
		 */
		private $module;
		/**
		 * Costruttore
		 * 
		 * @param string $module optional Modulo di configurazione che contiene le impostazioni del database
		 */
		function __construct($module = "database") {
			$this->module = $module;
		}
		/**
		 * init()
		 * 
		 * inizializza, se necessario, la connessione al database di sistema
		 */
		function init() {
			$module = $this->module;
			if (!array_key_exists($module, $this::$db)) {
				try {
					$config = app::conf()->$module;
					if (!$config) throw new \Exception("Error: Not find config section $module");
					$dsn = $config->driver.":";
					$dsn .= "host=".$config->host.";";
					$dsn .= "dbname=".$config->database;
					$this::$db[$module] = new \PDO($dsn, $config->user, $config->password,array(\PDO::ERRMODE_EXCEPTION));
					$this::$db[$module]->exec("set names utf8");
				} catch (\Exception $e) {
					exit("Errore durante l'accesso al database $module: ".$e->getMessage());
				}
			}
		}
		
		/**
		 * compileid
		 * 
		 * Se la stringa $id contiene nomi separati da virgole li combina per richiedere al database un unico dato.
		 * Necessario per tabelle che hanno chiavi primarie multiple.
		 * esempio:
		 * <code>"customerNumber,orderNumber" --> "CONCAT(customerNumber,'~',orderNumber)"</code>
		 * 
		 * @param string $id Campo id (di solito specificato nel campi idkey di dbpages)
		 * @return string
		 */
		function compileid($id) {
			if (strpos($id, ",") === FALSE) {
				return "`$id`";
			} else {
				return "CONCAT(`".str_replace(",", "`, '~' ,`", $id)."`)";
			}
		}
		
		/**
		 * Ritorna le informazioni sulle colonne della tabella specificata ($table)
		 * 
		 * @param string $table Tabella del database
		 * @return array[]
		 */
		function columnInfo($table) {
			$this->init();
			$sql = "SHOW COLUMNS FROM $table";
			$res = array();
			$ret = $this::$db[$this->module]->query($sql);
			while ($row = $ret->fetch(\PDO::FETCH_ASSOC)) {
				$res[] = $row;
			}
			return $res;
		}

		/**
		 * read
		 * 
		 * Legge dal database tutte le righe
		 * 
		 * @param string $table Tabella del database
		 * @param number $start Record iniziale (primo record=0)
		 * @param number $count Blocco di record da leggere (0=tutti)
		 * @param string $filter Filtro WHERE nel formato t-sql. esempio:
		 * <code>"customerNumber > ? AND customerNumber < ?"</code> 
		 * @param string[] $filterargs Array associativo con i dati del filtro
		 * @return \framework\db\resultset
		 */
		function read($table,$start = 0,$count = 0,$filter = NULL,$filterargs = array()) {
			$this->init();
			$where = "";
			if ($filter) {
				$where = " WHERE $filter";
			}
			$sql = "SELECT * FROM `$table` $where";
			$ret = new resultset();
			
			if ($count) {
				$sqlcount = "SELECT count(*) FROM `$table` $where";
				$sth = $this::$db[$this->module]->prepare($sqlcount);
				$sth->execute($filterargs);				
				$row = $sth->fetch(\PDO::FETCH_NUM);
				$ret->count = $row[0]-$start;
				$ret->start = $start;
				$ret->block = $count;
				$sql .= " LIMIT $start,$count"; 
			}
			$res = array();
			$sth = $this::$db[$this->module]->prepare($sql);
			$sth->execute($filterargs);
			//$sth->debugDumpParams();
			while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
				$res[] = $row;	
			}
			$ret->rows = $res;
			return $ret;
		}

		/**
		 * row
		 * 
		 * Ritorna una singola riga di database corrispondente a $idkey=$id
		 * 
		 * @param string $table Tabella del database
		 * @param string $id valore univoco del campo id
		 * @param string $idkey nome del campo id (di solito la chiave primaria) 
		 * @return mixed[]
		 */
		function row($table,$id,$idkey = "id") {
			$this->init();
			$idkey = $this->compileid($idkey);
			//echo "IDKEY:".$idkey." ID:$id";
			$sql = "SELECT * FROM `$table` WHERE $idkey = ?";
			$id = array($id);
			$sth = $this::$db[$this->module]->prepare($sql);
			$sth->execute($id);
			//$sth->debugDumpParams();
			$row = $sth->fetch(\PDO::FETCH_ASSOC);
			//print_r($row);
			return $row;
		}
		
		/**
		 * delete
		 * 
		 * Cancella una singola riga di database corrispondente a $idkey=$id
		 * 
		 * @param string $table Tabella del database
		 * @param string $id valore univoco del campo id
		 * @param string $idkey nome del campo id (di solito la chiave primaria) 
		 * @return boolean TRUE se la cancellazione è avvenuta con successo
		 */
		function delete($table,$id,$idkey = "id") {
			$this->init();
			$idkey = $this->compileid($idkey);
			$sql = "DELETE FROM `$table` WHERE $idkey = ?";
			$id = array($id);
			$sth = $this::$db[$this->module]->prepare($sql);
			return $sth->execute($id);
		}
		/**
		 * execute()
		 * 
		 * @param string $sql Query SQL i valori devono essere inseriti come parametri nominati es: <code>`id` = :id</code>
		 * @param string[] $args Array associativo contenete i dati per i parametri della query le chiavi devono iniziare con ":"
		 * @return boolean TRUE se eseguita correttamente
		 */
		function execute($sql,$args) {
		 	$this->init();
		 	$sth = $this::$db[$this->module]->prepare($sql);
		 	return $sth->execute($args);
		}
		/**
		 * Aggiunge o aggiorna una riga della tabella $table
		 * 
		 * @param string $table Tabella del database
		 * @param mixed[] $data Array associativo che contiene i dati da scrivere nel database. esempio: 
		 * <code>$data[":customerName"] = "Pallino spa"</code>
		 * I nomi di colonna devono essere preceduti da ":" 
		 * @param string[] optional $fields Array associativo che contiene i nomi di colonna (protezione contro la scrittura di dati erreti)
		 * @param string optional $id Valore della chiave primaria se NULL o non specificato la riga verrà aggiunta e non aggiornata
		 * @param string optional $idkey Nome della colonna id. Se non specificato verrà usato "id"
		 * @return boolean TRUE se l'aggiornamento/inserimento è avvenuto con successo
		 */
		function write($table,$data,$fields = NULL,$id = NULL,$idkey = "id") {
			if ($fields === NULL) {
				foreach ($data as $key => $value) {
					$key = substr($key, 1);
					$fields[$key] = $key;
				}
			}
			if ($id) { //aggiornamento
				$sql = "UPDATE `$table` SET ";
				foreach ($fields as $key => $value) {
					$sql .= "`$key` = :$key ,";
				}
				$sql = substr($sql, 0, -1);
				$data[":tempid"] = $id;
				$where = $this->compileid($idkey) . " = :tempid";
				$sql .= " WHERE $where";
			} else {
				$sql = "INSERT INTO `$table` SET ";
				foreach ($fields as $key => $value) {
					$sql .= "`$key` = :$key ,";
				}
				$sql = substr($sql, 0, -1);
			}
			//echo $sql.PHP_EOL;
			//echo print_r($data,TRUE).PHP_EOL;
			$this->init();
			$sth = $this::$db[$this->module]->prepare($sql);
			//var_dump($sth);
			$res = $sth->execute($data);
			//$sth->debugDumpParams();
			if (!$res) app::Controller()->addMessage("Errore durante il salvataggio: ".$sth->errorInfo());
			return $res;
		}
		
	}
	/**
	 * resultset
	 *
	 * Classe ritornata dalla funzione database->read(...)
	 * Include le righe e le informazioni sulla paginazione
	 *
	 * @author Marco Camplese <info@wolfmc3.com>
	 * @package minifw/database
	 *
	 * @see \framework\db\database::read()
	 *
	 */
	class resultset {
		/**
		 * @var mixed[] Righe della tabella
		 */
		public $rows = array();
		/**
		 * @var number Conteggio record totali
		 */
		public $count;
		/**
		 * 
		 * 
		 * @var number Indice progressivo numerico del primo record rispetto al totale
		 */
		public $start;
		/**
		 * @var number Quantità di righe del blocco (numero di righe della pagina)
		 */
		public $block;
		
		/**
		 * page()
		 * 
		 * Ritorna il numero di pagina corrente
		 * @return number
		 */
		public function page() {
			if ($this->block == 0) return 1;
			return ceil($this->start/$this->block);
		}
		/**
		 * Ritorna il numero di pagine totali
		 * @return number
		 */
		public function pages() {
			if ($this->block == 0) return 1;
			return ceil(($this->start+$this->count)/$this->block);
		}
		/**
		 * next()
		 * 
		 * Ritorna un array contentente:
		 * <code>
		 * array(
		 * [0] //numero di riga del prossimo blocco
		 * [1] //il totale dei record del prossimo blocco
		 * )
		 * 
		 * FALSE = Ultimo blocco  
		 * </code>
		 * @return boolean|number[] 
		 */
		public function next() {
			if ($this->start+$this->block > $this->count) {
				return false;
			} else {
				return array($this->start+$this->block,$this->block);
			}
		}
	}

}
