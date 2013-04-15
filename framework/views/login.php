<?php 
namespace framework\views;

use framework\contentBase;
use framework\app;
use framework\html\template;
class login extends contentBase {
	protected $title = "Login";
	protected $template = "html";
	
	function init() {
		parent::init();
		$this->addJavascript(app::root()."js/jquery-ui.js");
		$this->addCss(app::root()."css/black-tie/jquery-ui.css");
	}
	
	function action_def() {
		$returnurl = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"../";
		if (isset($this->extra['redirect'])) $returnurl = $this->extra['redirect']; 
		$result = new template("login", ["loginurl"=>$this->url("login"),"returnurl"=>$returnurl]);
		return $result;
	}
	
	function action_login() {
		$username = isset($_POST['username'])?$_POST['username']:"~~~";
		$password = isset($_POST['password'])?$_POST['password']:"~~~";
		$store = isset($_POST['store'])?$_POST['store']:"0";
		$ret = app::Security()->login($username, $password,$store);
		if ($ret !== FALSE) {
			header("location: " . $_POST['returnurl']);
		} else {
			header("location: " . $this->url(""));
		}
		exit();
	}
	function action_exit() {
		session_destroy();
		setcookie("AUTHID",NULL,time()-1000,app::root());
		header("location: " . $this->url(""));
	}
	
}