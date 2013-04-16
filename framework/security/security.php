<?php 
namespace framework\security;
	use framework\app;
/**
	 * Security
	 *
	 * Inzializza il controller per la sicurezza 
	 * Questa classe è inizializzata dalla classe application
	 *
	 * @author Marco Camplese <info@wolfmc3.com>
	 * @package minifw/security
	 *
	 * @see \framework\app Applicazione
	 * 
	 */
class security {
	/**
	 * @var \framework\security\securitymoduleinterface Modulo utilizzato
	 */
	private $module = "";
	private $permissions;
	private $currentuser = FALSE;
	/**
	 * Construttore
	 * 
	 * Inizializza la classe sicurezza e carica il modulo specificato nella configurazione (security->module)
	 * 
	 * @see \framework\config
	 * 
	 */
	function __construct() {
		$modulename = "\\framework\\security\\modules\\".app::conf()->security->module;
		$this->module = new $modulename();
		
		if (!$this->module->ready()) {
			if (!$this->module->init()) {
				exit("Security Module not ready");
			}
		}
		$this->permissions = $this->module->readPermissions();
		if (isset($_COOKIE['AUTHID'])) {
			$authid = $_COOKIE['AUTHID'];
			if (($res = $this->module->getUserAuthID($authid)) !== FALSE) {
				$this->currentuser = $res;
			}
		} 
		if (!$this->currentuser) {
			$this->currentuser = new user(["username"=>"anonimo","group"=>"?","isok"=>FALSE]);
		}
		//var_dump($this);
	}
	
	/**
	 * 
	 * @param string $user
	 * @param string $password
	 * @param string $store
	 * @return \framework\security\user
	 */
	function login($username,$password,$store = TRUE) {
		//echo "Security:login:$username - $password\n<hr>";
		$data = $this->module->getUser($username, $password);
		//echo "Security:data:".print_r($data,TRUE)."\n<hr>";
		if ($data === FALSE) {
			return FALSE;
		} else {
			$user = new user($data);
			$newauthid = sha1(bin2hex(openssl_random_pseudo_bytes(16)).$password);
			$_SESSION["AUTHID"] = $newauthid;
			$_SESSION["userdata"] = $user;
			$this->currentuser = $user;
			setcookie("AUTHID", $newauthid, $store?(time()+60*60*24*30):0,app::root());
			return TRUE;
		}
	}
	
	function getPermission($view = "") {
		if ($view == "") $view = app::Controller()->getPage()->name();
		$perm = "";
		$viewpath = "/$view/";
		$genericgroup = $this->user()->isok?"*":"?";
		foreach ($this->permissions as $path => $data) {
			$patho = $path;
			$path = str_replace("*", $view, $path);
			if ($viewpath == $path && ($data["group"] == $this->user()->group || $data["group"] == $genericgroup) ) {
				$perm .= $data['perm'];
			}
		}
		if ($perm != "") $perm = str_split($perm); else $perm = []; 
		$res = new \stdClass();
		$res->A = $res->L = $res->W = $res->R = NULL;
		foreach ($perm as $char) {
			$curperm = strtoupper($char); 
			if ($curperm == $char) { //Consenti
				if ($res->$curperm == NULL) {
					$res->$curperm = 1;
				}
			} else { //NEGA
				$res->$curperm = 0;
			}
		}
		return $res;
	}
	
	function user() {
		return $this->currentuser;
	}
	
}

/**
 * Securitymoduleinterface
 *
 */
interface securitymoduleinterface {
	/**
	 * Legge dalla fonte l'utente richiesto
	 * @param string $username
	 * @param string $password
	 * 
	 * @return FALSE|string[] FALSE se l'utente non corrisponde, ritorna i dati dell'utente
	 */
	function getUser($username, $password);
	function getUserAuthID($authid);
	function readPermissions();
	function init();
	function ready();
	function usersPage();
	function groupsPage();
	function permissionsPage();
}

/**
 *  user
 * 
 *  Classe utilizzata dal modulo security per identificare l'utente
 *
 */
class user {
	private $data;
	function __construct($data) {
		$this->data = $data;
	}
	
	function __get($key) {
		if (array_key_exists($key, $this->data)) {
			return $this->data[$key];
		} else {
			return false;
		}
	}
}
