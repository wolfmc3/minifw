<?php 
namespace framework\security\modules;
use framework\security\securitymoduleinterface;
use framework\app;
class pdoauth implements securitymoduleinterface {
	public 
	function getUser($username, $password) {
		$password = md5($password);
		//echo "onlyadmin:login:$username - $password\n<hr>";
		//echo "config:onlyadmin:".app::conf()->onlyadmin->user." - ".app::conf()->onlyadmin->password."\n<hr>";
		
		if (app::conf()->onlyadmin->user == $username && app::conf()->onlyadmin->password == $password) {
			return ["username"=>$username,"group"=>"admin","isok"=>TRUE];
		} else {
			return false;
		}
	}
	
	function setUser($userdata) {
		return false;
	}
	
	function getUserAuthID($authid) {
		//print_r($_SESSION);
		if (isset($_SESSION["AUTHID"]) && $_SESSION["AUTHID"] == $authid) {
			return $_SESSION["userdata"];
		} else {
			return false;
		}
	}
	
	
	function readPermissions() {
		return [
			"/index/"	=>	["group"=>"*","perm"=>"L"],
			"/login/"	=>	["group"=>"?","perm"=>"L"],
			"/*/"		=>	["group"=>"?","perm"=>"L"],
			"/*/"		=>	["group"=>"admin","perm"=>"RWLA"],
			"/config/"	=>	["group"=>"admin","perm"=>"RWLA"],
			"/admin/"	=>	["group"=>"?","perm"=>"rwla"],
			"/admin/"	=>	["group"=>"admin","perm"=>"RWLA"],
			"/config/"	=>	["group"=>"?","perm"=>"rwla"],
			];
	}
	
	function init() {
		return session_start();
	}
	
	function ready() {
		return session_status() == PHP_SESSION_ACTIVE;
	}
	
	function groupsPage() {
		return app::root()."pdoauth_groups";
	}
	
	function usersPage() {
		return app::root()."pdoauth_users";
	}
	
	function permissionsPage() {
		return app::root()."pdoauth_permissions";
	}
	
}