<?php 
namespace framework\html;

use framework\html\element;
use framework\app;
use framework\html\br;
use framework\html\anchor;
use framework\html\form\jsondata;
class logincontrol extends element {
	function __construct() {
		app::Controller()->getPage()->addJqueryUi();
		app::Controller()->getPage()->addJavascript("logincontrol.js");
		parent::__construct("div",["id"=>"logincontrol"]);
		if (app::Security()->user()->isok) {
			$this->add(new element("span",[],app::Security()->user()->username.":".app::Security()->user()->group));
			$this->add(new anchor(app::root()."login/exit", "Esci"));
		} else {
			$this->add(new element("span",[],app::Security()->user()->username));
			$this->add(new anchor(app::root()."login", "Accedi"));
		} 
		if (app::Security()->user()->isok) {
			$this->add(new icon("Lock"));
		} else {
			$this->add(new icon("LockOpen"));
		}
		$this->add(new jsondata("notlogged", !app::Security()->user()->isok));
		foreach (app::Security()->getPermission() as $key => $value) {
			if ($value)	$this->add($key);
		}
	}
}