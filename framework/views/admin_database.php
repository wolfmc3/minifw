<?
/**
 * admin_database.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\views;
use framework\page;
use framework\html\element;
use framework\db\database;
class admin_database extends page {
	protected $title = "Amministrazione database";

	function action_def() {
		$data = array();
		$db = new database("database");
		$db->execute("USE classicmodels", "", array());
		$tables = $db->execute("SHOW TABLES", "", array());
		foreach ($tables as $label => $table) {
			$table = reset($table);
			$data[$table] = $this->readTableSchema($table, $db);
		}
		$cont = new element("pre");
		$cont->add(var_export($data,TRUE));
		return $cont;
	}

	function readTableSchema($table, $db) {
		$data = array();
		$tableinfo = $db->execute("SHOW COLUMNS FROM `$table`", "`$table`", array());
		$data["columns"] = $tableinfo;
		$tablecreate = $db->execute("SHOW CREATE TABLE `$table`", "`$table`", array());
		$data["sql"] = next(reset($tablecreate));
		return $data;
	}
}