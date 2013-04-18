<?php 
namespace framework;
use framework\db\database;
//TODO: DA COMPLETARE
class pdosessions implements \SessionHandlerInterface {
	private $db;
	private $data;
	public function close(){
		$this->db = NULL;
	}
	
	public function destroy ($session_id ) {
		$this->db->delete("sessions", $session_id);
	}
	
	public function gc($maxlifetime ) {
		$this->db->execute("DELETE FROM `sessions` WHERE TIMESTAMPDIFF(SECOND,`lasttime`,CURRENT_TIMESTAMP) > :time",[":time"=>$maxlifetime]);
		return TRUE;
	}
	
	public function open($save_path, $name ) {
		$this->db = new database("sessions");
		return TRUE;
	}
	
	public function read($session_id ) {
		$row = $this->db->row("sessions", $session_id);
		return $this->data = $row["data"];
	}
	
	public function write($session_id , $session_data ) {
			$row = [
			":data"=>$session_data,
			":id"=>$session_id
			];
			if (!$this->db->row("sessions",$session_id )) $session_id = NULL; 
		
			$this->db->write("sessions", $row, ["data"=>"data","id"=>"id"],$session_id);
		return TRUE;
	}
}