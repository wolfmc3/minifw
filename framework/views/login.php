<?php 
namespace framework\views;

use framework\page;
use framework\app;
use framework\html\template;
/**
 *
 * login
 *
 * Pagina di login
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/security
 *
 * @see \framework\security\
 *
 */

class login extends page {
	protected $title = "Login";
	protected $template = "html";
	
	function init() {
		parent::init();
		$this->addJavascript(app::conf()->jquery->ui);
		$this->addCss(app::conf()->jquery->theme);
	}
	
	function action_def() {
		$returnurl = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"../";
		if (isset($this->extra['redirect'])) $returnurl = $this->extra['redirect']; 
		$result = new template("login", array("loginurl"=>$this->url("login"),"returnurl"=>$returnurl));
		return $result;
	}
	
	function action_login() {
		$username = isset($_POST['username'])?$_POST['username']:"~~~";
		$password = isset($_POST['password'])?$_POST['password']:"~~~";
		//VERIFICARE tipo variabile $Store meglio boolean?
		$store = isset($_POST['store'])?$_POST['store']:"0";
		$ret = app::Security()->login($username, $password,$store);
		
		if ($ret !== FALSE) {
			app::Controller()->addMessage("Ciao, ".app::Security()->user()->name);
			header("location: " . $_POST['returnurl']);
		} else {
			app::Controller()->addMessage("Nome utente o password errati!!");
			header("location: " . $this->url(""));
		}
		exit();
	}
	function action_exit() {
		$this->type = $this::TYPE_REDIRECT;
		app::Security()->logout();
		app::Controller()->addMessage("Sei uscito dalla sessione");

		return app::root();
	}
	
}