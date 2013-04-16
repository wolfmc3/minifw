<?php 
namespace framework\views;
use framework\contentBase;
use framework\html\table;
use framework\html\form\text;
use framework\db\database;
use framework\app;
use framework\html\element;
use framework\html\select;
use framework\html\form\hidden;
use framework\html\form\checkboxes;
use framework\html\br;
use framework\html\form\submit;
use framework\html\anchor;
class admin extends contentBase {

	function init() {
		parent::init();
		$this->addJavascript(app::root()."js/admin.js");
		$this->typeByAction("secinfo", self::TYPE_AJAX);
	}
	
	function action_def() {
		$modules = array();
		chdir("framework/security/modules");
		$list = glob('*.php',GLOB_BRACE);
		chdir("../../..");
		$list = explode("/", str_replace(".php", "", implode("/", $list))); 
		 $list = array_combine($list,$list);
		$cont = new element();
		$sec_cont = new element("div",["class"=>"box"]);
		$sec_title = new element("div",["class"=>"title"]);
		$sec_title->add("Sicurezza: ");
		$sec_title->add(new select("sec_modules",$list,app::conf()->security->module,["id"=>"sec_modules","data-info"=>$this->url("secinfo"), "style"=>"vertical-align: baseline;"]));
		$sec_cont->add($sec_title);
		$sec_cont->add(new element("div",["class"=>"box", "id"=>"secinfo"],"Scegli il modulo"));
		$cont->add($sec_cont);
		return $cont;
	}
	
	function action_secinfo() {
		$modulename = "\\framework\\security\\modules\\".$this->item;
		$module = new $modulename();
		$cont = new element();
		if ($this->item == app::conf()->security->module) {
			$cont->add("-- Modulo in uso --");
			$cont->addBR(2);
		}
		$cont->add(new anchor($module->usersPage(), "Gestione utenti"));
		$cont->addBR();
		$cont->add(new anchor($module->permissionsPage(), "Gestione permessi"));
		$cont->addBR();
		$cont->add(new anchor($module->groupsPage(), "Gestione gruppi"));
		
		return $cont;
	}
}