<?php 
namespace framework\html;

use framework\html\element;
use framework\app;
use framework\html\br;
use framework\html\anchor;
use framework\html\form\jsondata;
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
class logincontrol extends element {
	/**
	 * Costruttore
	 * 
	 * Genera un blocco dinamico che contiene i dati utente e il link per il login/logout
	 * 
	 */
	function __construct() {
		app::Controller()->getPage()->addJqueryUi();
		app::Controller()->getPage()->addJavascript("logincontrol.js");
		parent::__construct("div",["id"=>"logincontrol"]);
		if (app::Security()->user()->isok) {
			$this->add(new element("span",[],app::Security()->user()->username.":".app::Security()->user()->group));
			$this->add(new anchor(app::root()."login/exit", "Esci"));
		} else {
			$this->add(new anchor(app::root()."login", "Accedi"));
		} 
		if (app::Security()->user()->isok) {
			$this->add(new icon("LockOpen"));
		} else {
			$this->add(new icon("Lock"));
		}
		$this->add(new jsondata("notlogged", !app::Security()->user()->isok));
		foreach (app::Security()->getPermission() as $key => $value) {
			if ($value)	$this->add($key);
		}
	}
}