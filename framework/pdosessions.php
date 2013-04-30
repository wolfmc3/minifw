<?php 
namespace framework;
use framework\db\database;
/**
 * 
 * pdosessions
 *
 * Gestione sessione su database mysql 
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/security
 *
 */
class pdosessions implements \SessionHandlerInterface {
	private $db;
	private $data;

	/**
	 * @see SessionHandlerInterface::close()
	 */
	public function close(){
		$this->db = NULL;
	}

	/**
	 * @see SessionHandlerInterface::destroy()
	 */
	public function destroy ($session_id ) {
		$this->db->delete("sessions", $session_id);
	}

	/**
	 * @see SessionHandlerInterface::gc()
	 */
	public function gc($maxlifetime ) {
		$this->db->execute("DELETE FROM `sessions` WHERE TIMESTAMPDIFF(SECOND,`lasttime`,CURRENT_TIMESTAMP) > :time","`sessions`",array(":time"=>$maxlifetime));
		return TRUE;
	}

	/**
	 * @see SessionHandlerInterface::open()
	 */
	public function open($save_path, $name ) {
		$this->db = new database("sessions");
		return TRUE;
	}

	/**
	 * @see SessionHandlerInterface::read()
	 */
	public function read($session_id ) {
		$row = $this->db->row("sessions", $session_id);
		return $this->data = $row["data"];
	}

	/**
	 * @see SessionHandlerInterface::write()
	 */
	public function write($session_id , $session_data ) {
			$row = array(
			":data"=>$session_data,
			":id"=>$session_id
			);
			if (!$this->db->row("sessions",$session_id )) $session_id = NULL; 
		
			$this->db->write("sessions", $row, array("data"=>"data","id"=>"id"),$session_id);
		return TRUE;
	}
}