<?php 
namespace framework\security\modules;
use framework\security\securitymoduleinterface;
use framework\app;
use framework\security\user;
/**
 * 
 * onlyadmin
 *
 * Sistema di autenticazione base dove l'unico utente ammesso è admin con permessi illimitati<br>
 * La password (codificata MD5) è memorizzata nel file /framework/config/defaults.ini<br>
 * Prima di utilizzare questo modulo inserire nel file di configurazione il nome utente e la password (codificata MD5)<br>
 * Esempio:<br>
 * <code>
 * [onlyadmin]
 * user=admin
 * password=a1234567891a2345678912345x
 * </code>
 * sostiuire "a1234567891a2345678912345x" con la password codificata MD5<br>
 * 
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/security
 *
 */

class onlyadmin implements securitymoduleinterface {
	private $user;
	function getUser($username, $password) {
		$password = md5($password);
		//echo "onlyadmin:login:$username - $password\n<hr>";
		//echo "config:onlyadmin:".app::conf()->onlyadmin->user." - ".app::conf()->onlyadmin->password."\n<hr>";
		
		if (app::conf()->onlyadmin->user == $username && app::conf()->onlyadmin->password == $password) {
			return $this->user;
		} else {
			return false;
		}
	}
	
	function setUser($userdata) {
		return false;
	}
	
	function getUserAuthID($authid) {
		//print_r($_SESSION);
		if (isset($_SESSION["onlyadmin_authid"]) && $_SESSION["onlyadmin_authid"] == $authid) {
			return $this->user;
		} else {
			return false;
		}
	}
	
	function setUserAuthID($user, $authid) {
		$_SESSION["onlyadmin_authid"] = $authid;
		return true;
	}
	
	function readPermissions() {
		return array(
			array("path"=> "/index/", "group"=>"*","perm"=>"L"),
			array("path"=> "/login/", "group"=>"?","perm"=>"L"),
			array("path"=> "/*/" , "group"=>"?","perm"=>"L"),
			array("path"=>"/*/" , "group"=>"admins","perm"=>"RWLA"),
			array("path"=> "/config/", "group"=>"admins","perm"=>"RWLA"),
			array("path"=> "/admin/", "group"=>"?","perm"=>"rwla"),
			array("path"=> "/admin/", "group"=>"admins","perm"=>"RWLA"),
			array("path"=> "/config/", "group"=>"?","perm"=>"RWLA"),
		);
	}
	
	function init() {
		$this->user = array("username"=>"admin","group"=>"admins","isok"=>TRUE);
		return session_start();
	}
	
	function ready() {
		return session_status() == PHP_SESSION_ACTIVE;
	}
	
	function groupsPage() {
		return NULL;
	}
	
	function usersPage() {
		return NULL;
	}
	
	function permissionsPage() {
		return NULL;
	}
}