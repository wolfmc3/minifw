<?php
/**
 *
 * pdoauth.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\security\modules;
use framework\security\securitymoduleinterface;
use framework\app;
use framework\db\database;
/**
 *
 * pdoauth
 *
 * Sistema di autenticazione completo basato su db mysql<br>
 * Prima di utilizzare questo modulo inserire i parametri di configurazione nel file di configurazione<br>
 * Esempio:<br>
 * <code>
 * [security]
 * module=noauth
 *
 * [pdoauth:database]
 * database=pdoauth
 * </code>
 *
 * per la lista completa dei parametri vedi il file /framework/config/defaults.ini
 *
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/security
 *
 */

class pdoauth implements securitymoduleinterface {
	/**
	 *
	 * @var \framework\db\database Database di appoggio
	 */
	private $db = NULL;
	/**
	 * getUser
	 * @param string $username Nome Utente
	 * @param string $password Password (già codifcata MD5)
	 * @see \framework\security\securitymoduleinterface::getUser()
	 */
	function getUser($username, $password) {
		//echo "onlyadmin:login:$username - $password\n<hr>";
		//echo "config:onlyadmin:".app::conf()->onlyadmin->user." - ".app::conf()->onlyadmin->password."\n<hr>";
		$res = $this->db->read("users",0,0,"username = ? AND password = ?",array($username,$password));
		//echo "getUser:"; print_r($res);
		if (count($res->rows) == 1) { //UTENTE CORRETTO
			$userdata = $res->rows[0];
			unset($userdata['password']);
			$userdata["isok"] = TRUE;
			return $userdata;
		} else {
			return false;
		}
	}
	/**
	 * getUsersInfo()
	 *
	 * @see \framework\security\securitymoduleinterface::getUsersInfo()
	 */
	function getUsersInfo() {
		$res = $this->db->read("users");
		$users = array();
		foreach ($res->rows as $userdata) {
			unset($userdata['password']);
			$userdata["isok"] = TRUE;
			$users[$userdata['username']] = $userdata;
		}
		$users["anonimo"] = array("username"=>"anonimo","group"=>"?","isok"=>FALSE);
		return $users;
	}

	/**
	 * setUserAuthID()
	 *
	 * @param string $user None utente
	 * @param string $authid id autenticazione
	 * @see \framework\security\securitymoduleinterface::setUserAuthID()
	 */
	function setUserAuthID($user,$authid) {
		$row = array(":username"=>$user,":authid"=>$authid,":ip"=>$_SERVER['REMOTE_ADDR']);
		$this->db->write("usersessions", $row);
	}

	/**
	 * setUser
	 * Non usato
	 *
	 * @param mixed $userdata
	 * @return boolean
	 */
	function setUser($userdata) {
		return false;
	}

	/**
	 * getUserAuthID()
	 *
	 * @param string $authid ID Autorizzazione
	 *
	 * @see \framework\security\securitymoduleinterface::getUserAuthID()
	 */
	function getUserAuthID($authid) {
		$res = $this->db->read("usersessions",0,1,"authid = ?",array($authid));
		//echo "getUserAuthID:sessions:$authid:"; print_r($res);
		if (count($res->rows) == 1) { //UTENTE ESISTENTE
			$user = $this->db->row("users", $res->rows[0]['username'],"username");
			unset($user['password']);
			$user["isok"] = TRUE;
			//echo "getUserAuthID:users:$authid:"; print_r($user);
			return $user;
		} else {
			return false;
		}
	}

	/**
	 * readPermissions()
	 *
	 * @see \framework\security\securitymoduleinterface::readPermissions()
	 */
	function readPermissions() {
		$rawperm = $this->db->read("permissions");
		//echo "readPermission RAW:";print_r($rawperm);
		$perm = array();
		foreach ($rawperm->rows as $value) {
			$perm[] = array("path"=>$value['path'], "group" => $value['group'],"perm"=>$value['permission']);
		}
		//echo "readPermission DEF:";print_r($perm);
		return $perm;
	}

	/**
	 * Init
	 * @see \framework\security\securitymoduleinterface::init()
	 */
	function init() {
		$this->db = new database("pdoauth");
		return TRUE;
	}

	/**
	 * ready
	 * @see \framework\security\securitymoduleinterface::ready()
	 */
	function ready() {
		return $this->db != NULL;
	}

	/**
	 * groupsPage
	 * @see \framework\security\securitymoduleinterface::groupsPage()
	 */
	function groupsPage() {
		return app::root()."admin_pdoauth_groups";
	}
	/**
	 * usersPage
	 * @see \framework\security\securitymoduleinterface::usersPage()
	 */
	function usersPage() {
		return app::root()."admin_pdoauth_users";
	}
	/**
	 * permissionsPage
	 * @see \framework\security\securitymoduleinterface::permissionsPage()
	 */
	function permissionsPage() {
		return app::root()."admin_pdoauth_permissions";
	}

}