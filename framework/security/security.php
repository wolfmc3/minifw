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
			$this->currentuser = new user($this->module->getUserAuthID($authid));
		} 
		if (!$this->currentuser) {
			$this->currentuser = new user();
		}
		//var_dump($this);
	}
	
	/**
	 * 
	 * @param string $user
	 * @param string $password
	 * @param string $store
	 * @return boolean
	 */
	function login($username,$password,$store = TRUE) {
		//echo "Security:login:$username - $password\n<hr>";
		$data = $this->module->getUser($username, md5($password));
		//echo "Security:data:".print_r($data,TRUE)."\n<hr>";
		if ($data === FALSE) {
			return FALSE;
		} else {
			$user = new user($data);
			$newauthid = sha1(bin2hex(openssl_random_pseudo_bytes(16)).$password);
			$_SESSION["AUTHID"] = $newauthid;
			$this->currentuser = $user;
			setcookie("AUTHID", $newauthid, $store?(time()+60*60*24*30):0,app::root());
			$this->module->setUserAuthID($user->username, $newauthid);
			return TRUE;
		}
	}
	
	function logout() {
		unset($_SESSION["AUTHID"]);
		setcookie("AUTHID", NULL, 0,app::root());
	}
	
	function getUsersInfo() {
		return $this->module->getUsersInfo();
	}
	
	function getPermission($view = "",$username = "") {
		if ($view == "") $view = app::Controller()->getPage()->name();
		$user = $this->user();
		if ($username) {
			$users = $this->module->getUsersInfo();
			$user = new user($users[$username]);
		}

		$perm = "";
		$viewpath = "/$view/";
		$genericgroup = $user->isok?"*":"?";
		//echo "user:";print_r($this->user());
		//echo "getPermission:$view:"; print_r($this->permissions);
		foreach ($this->permissions as $data) {
			$path = $data["path"];
			$regexpath = "/^".str_replace("\\*", ".*", preg_quote($path,"/"))."$/e";
			//echo "PERM GROUP:".$data["group"]."\tCLASS GROUP:".$genericgroup."\tREGEX:$viewpath=$path: $regexpath: RESULT:"; echo preg_match($regexpath, $viewpath); echo PHP_EOL;
			//echo "$path:".$data['perm']."-\n";
			if (preg_match($regexpath, $viewpath) && ($data["group"] == $user->group || $data["group"] == $genericgroup) ) {
				$perm .= $data['perm'];
				//echo $data["group"]."@$path:".$data['perm']."-\n";
			}
		}
		
		if ($perm != "") $perm = str_split($perm); else $perm = array(); 
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
		//print_r($res);
		return $res;
	}
	
	function user() {
		return $this->currentuser;
	}
	
}

/**
 * Securitymoduleinterface
 *
 * @package minifw/security
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
	function getUsersInfo();
	function setUserAuthID($user,$authid);
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
 *  Classe utilizzata dal modulo security per riportare i dettagli utente 
 *
 */
class user {
	private $data;
	function __construct($data = FALSE) {
		//echo "New user istance:"; print_r($data);
		if (!is_array($data)) $data = array("username"=>"anonimo","group"=>"?","isok"=>FALSE);
		$this->data = $data;
	}
	
	function __get($key) {
		if (array_key_exists($key, $this->data)) {
			return $this->data[$key];
		} else {
			return "";
		}
	}
}