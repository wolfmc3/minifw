<?php 
namespace modules;
use framework\html\module;
use framework\menu;
use framework\html\template;
use framework\app;
class logincontrol extends module {
	function render($force) {

		app::Controller()->getPage()->addJqueryUi();
		app::Controller()->getPage()->addJavascript("logincontrol.js");
		$data = array();

		$dropdown = new menu("dropdown_login","dropdown-menu");
		$dropdown->createMenu("logincontrol_menu", "dropdown-menu");
		if (app::Security()->user()->isok) {
			$data["user"] = app::Security()->user()->username.":".app::Security()->user()->group;
			$dropdown->addMenuItem("logincontrol_menu","drp_login", app::root()."login/exit", "Esci");
		} else {
			$dropdown->addMenuItem("logincontrol_menu","drp_login", app::root()."login", "Accedi");
		}
		if (app::Security()->user()->isok) {
			$data["lock"] = "LockOpen";
		} else {
			$data["lock"] = "Lock";
		}
		$data["ulmenu"] = $dropdown;
		//$this->add(new jsondata("notlogged", !app::Security()->user()->isok));
		/*foreach (app::Security()->getPermission() as $key => $value) {
		 if ($value)	$this->add($key);
		}*/
		$template = new template("logincontrol", $data);
		$this->add($template);
	}
}