<?php 
namespace framework\html;

use framework\html\element;
use framework\app;
use framework\html\br;
use framework\html\anchor;
use framework\html\form\jsondata;
use framework\menu;
use framework\html\responsive\div;
/**
 * 
 * logincontrol
 *
 * Crea i rifermenti alla views e gestisce le richieste di dati 
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/html
 *
 */
class logincontrol extends template {
	/**
	 * Costruttore
	 * 
	 * Genera un blocco dinamico che contiene i dati utente e il link per il login/logout
	 * 
	 */
	function __construct() {
		app::Controller()->getPage()->addJqueryUi();
		app::Controller()->getPage()->addJavascript("logincontrol.js");
		$data = [];
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
			$data["lock"] = "LockOpen";
		}
		$data["ulmenu"] = $dropdown;
		//$this->add(new jsondata("notlogged", !app::Security()->user()->isok));
		/*foreach (app::Security()->getPermission() as $key => $value) {
			if ($value)	$this->add($key);
		}*/
		parent::__construct("logincontrol", $data);
		
	}
}