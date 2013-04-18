<?php 
namespace framework\security\modules;
use framework\security\securitymoduleinterface;
use framework\app;
class noauth implements securitymoduleinterface {
	
	function getUser($username, $password) {
		return ["username"=>"system","group"=>"admin","isok"=>TRUE];
	}
	
	function setUser($userdata) {
		return false;
	}
	
	function getUserAuthID($authid) {
		return ["username"=>"system","group"=>"admin","isok"=>TRUE];
	}
	
	function setUserAuthID($user, $authid) {
		return true;
	}
	
	function readPermissions() {
		return [
			["path"=>"/*/", "group"=>"?","perm"=>"RWLA"],
		];
	}
	
	function init() {
		return true;
	}
	
	function ready() {
		return true;
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