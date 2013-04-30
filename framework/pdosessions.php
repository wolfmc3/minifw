<?php
/**
 *
 * pdosessions.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
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
	/**
	 *
	 * @var \framework\db\database Oggetto Database utilizzato per memorizzare le sessioni
	 */
	private $db;
	/**
	 *
	 * @var array Dati della sessione utente
	 */
	private $data;

	/**
	 * Chiude la sessione
	 *
	 * @see SessionHandlerInterface::close()
	 */
	public function close(){
		$this->db = NULL;
	}

	/**
	 * Distrugge la sessione
	 * @param string $session_id ID sessione
	 * @see SessionHandlerInterface::destroy()
	 */
	public function destroy ($session_id ) {
		$this->db->delete("sessions", $session_id);
	}

	/**
	 * Garbage Collector
	 * @param number $maxlifetime Scadenza sessione in secondi
	 * @see SessionHandlerInterface::gc()
	 */
	public function gc($maxlifetime ) {
		$this->db->execute("DELETE FROM `sessions` WHERE TIMESTAMPDIFF(SECOND,`lasttime`,CURRENT_TIMESTAMP) > :time","`sessions`",array(":time"=>$maxlifetime));
		return TRUE;
	}

	/**
	 * Apre la sessione
	 *
	 * @param string $save_path Non utilizzato
	 * @param string $name 		Non utilizzato
	 *
	 * @see SessionHandlerInterface::open()
	 */
	public function open($save_path, $name ) {
		$this->db = new database("sessions");
		return TRUE;
	}

	/**
	 * Legge i dati dalla sessione
	 * @param string $session_id ID sessione
	 * @see SessionHandlerInterface::read()
	 */
	public function read($session_id ) {
		$row = $this->db->row("sessions", $session_id);
		return $this->data = $row["data"];
	}

	/**
	 * Scrive i dati della sessione
	 * @param string $session_id ID sessione
	 * @param mixed $session_data Dati della sessione da scrivere
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