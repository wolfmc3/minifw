<?php
/**
 *
 * noauth.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\security\modules;
use framework\security\securitymoduleinterface;
use framework\app;
/**
 *
 * noauth
 *
 * Sistema di autenticazione dove tutti gli utenti sono autenticati come admin con permessi illimitati
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/security
 *
 */
class noauth implements securitymoduleinterface {
	/**
	 * GetUser()
	 *
	 * @param string $username Nome Utente
	 * @param string $password Password (codificata MD5)
	 * @see \framework\security\securitymoduleinterface::getUser()
	 */
	function getUser($username, $password) {
		return array("username"=>"system","group"=>"admin","isok"=>TRUE);
	}
	/**
	 * setUser()
	 *
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
	 * Ritorna le impostazioni utente
	 *
	 * @param string $authid Non usato
	 * @see \framework\security\securitymoduleinterface::getUserAuthID()
	 */
	function getUserAuthID($authid) {
		return array("username"=>"system","group"=>"admin","isok"=>TRUE);
	}

	/**
	 * Non usato
	 * @param string $user Non usato
	 * @param string $authid non usato
	 * @see \framework\security\securitymoduleinterface::setUserAuthID()
	 */
	function setUserAuthID($user, $authid) {
		return true;
	}

	/**
	 * Non  usato
	 * @see \framework\security\securitymoduleinterface::readPermissions()
	 */
	function readPermissions() {
		return array(
				array("path"=>"/*/", "group"=>"?","perm"=>"RWLA"),
		);
	}
	/**
	 * Non usato ritorna sempre true
	 * @see \framework\security\securitymoduleinterface::init()
	 */
	function init() {
		return true;
	}
	/**
	 * Non usato ritorna sempre true
	 * @see \framework\security\securitymoduleinterface::ready()
	 */
	function ready() {
		return true;
	}
	/**
	 * Non usato ritorna null
	 * @see \framework\security\securitymoduleinterface::groupsPage()
	 */
	function groupsPage() {
		return NULL;
	}
	/**
	 * Non usato ritorna null
	 * @see \framework\security\securitymoduleinterface::usersPage()
	 */
	function usersPage() {
		return NULL;
	}
	/**
	 * Non usato ritorna null
	 * @see \framework\security\securitymoduleinterface::permissionsPage()
	 */
	function permissionsPage() {
		return NULL;
	}
}