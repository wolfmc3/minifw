<?php 
namespace framework\db {

	class database {
		private static $db;
		function init() {
			if (!$this::$db) {
				$config = parse_ini_file(__DIR__."/../../config/db.ini");
				$dsn = $config['driver'].":";
				$dsn .= "host=".$config['host'].";";
				$dsn .= "dbname=".$config['database'];
				$this::$db = new \PDO($dsn, $config['user'], $config['password'],array(\PDO::ERRMODE_EXCEPTION));
				$this::$db->exec("set names utf8");
			}
		}
		
		function columnInfo($table) {
			$this->init();
			$sql = "SHOW COLUMNS FROM $table";
			$res = array();
			$ret = $this::$db->query($sql);
			while ($row = $ret->fetch(\PDO::FETCH_ASSOC)) {
				$res[] = $row;
			}
			return $res;
		}

		function read($table,$start = 0,$count = NULL) {
			$this->init();
			$sql = "SELECT * FROM $table";
			$ret = new resultset();
			
			if ($count) {
				$sqlcount = "SELECT count(*) FROM $table";
				$sth = $this::$db->query($sqlcount);
				$row = $sth->fetch(\PDO::FETCH_NUM);
				$ret->count = $row[0]-$start;
				$ret->start = $start;
				$ret->block = $count;
				$sql .= " LIMIT $start,$count"; 
			}
			$res = array();
			$sth = $this::$db->query($sql);
			while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
				$res[] = $row;	
			}
			$ret->rows = $res;
			return $ret;
		}
		
		function row($table,$id,$idkey = "id") {
			$this->init();
			$sql = "SELECT * FROM $table WHERE $idkey = ?";
			$id = array($id);
			$sth = $this::$db->prepare($sql);
			$sth->execute($id);
			//$sth->debugDumpParams();
			$row = $sth->fetch(\PDO::FETCH_ASSOC);
			return $row;
		}
		
		function delete($table,$id,$idkey = "id") {
			$this->init();
			$sql = "DELETE FROM $table WHERE $idkey = ?";
			$id = array($id);
			$sth = $this::$db->prepare($sql);
			return $sth->execute($id);
		}
		
		function write($table,$data,$fields,$idkey = "id") {
			if (isset($data[":".$idkey])) { //aggiornamento
				$sql = "UPDATE $table SET ";
				foreach ($fields as $key => $value) {
					$sql .= "$key = :$key ,";
				}
				$sql = substr($sql, 0, -1);
				$sql .= " WHERE $idkey = :$idkey";
			} else {
				$sql = "INSERT INTO $table SET ";
				foreach ($fields as $key => $value) {
					$sql .= "$key = :$key ,";
				}
				$sql = substr($sql, 0, -1);
			}
			echo $sql.PHP_EOL;
			var_dump($data);
			$this->init();
			$sth = $this::$db->prepare($sql);
			var_dump($sth);
			return $sth->execute($data);
			//$sth->debugDumpParams();
		}
		
	}
	class resultset {
		public $rows = array();
		public $count;
		public $start;
		public $block;
		
		public function page() {
			if ($this->block == 0) return 1;
			return ceil($this->start/$this->block);
		}
		public function pages() {
			if ($this->block == 0) return 1;
			return ceil(($this->start+$this->count)/$this->block);
		}
		public function next() {
			if ($this->start+$this->block > $this->count) {
				return false;
			} else {
				return array($this->start+$this->block,$this->block);
			}
		}
	}

}
