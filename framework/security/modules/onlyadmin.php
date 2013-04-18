<?php 
namespace framework\security\modules;
use framework\security\securitymoduleinterface;
use framework\app;
use framework\security\user;
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
		return [
			["path"=> "/index/", "group"=>"*","perm"=>"L"],
			["path"=> "/login/", "group"=>"?","perm"=>"L"],
			["path"=> "/*/" , "group"=>"?","perm"=>"L"],
			["path"=>"/*/" , "group"=>"admins","perm"=>"RWLA"],
			["path"=> "/config/", "group"=>"admins","perm"=>"RWLA"],
			["path"=> "/admin/", "group"=>"?","perm"=>"rwla"],
			["path"=> "/admin/", "group"=>"admins","perm"=>"RWLA"],
			["path"=> "/config/", "group"=>"?","perm"=>"RWLA"],
		];
	}
	
	function init() {
		$this->user = ["username"=>"admin","group"=>"admins","isok"=>TRUE];
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