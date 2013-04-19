<?php 
namespace framework\views;
use framework\page;
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
use framework\html\html;
/**
 *
 * admin
 *
 * Pagina di accesso alla gestione del sistema
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/security
 *
 * @see \framework\
 *
 */

class admin extends page {

	function init() {
		parent::init();
		$this->addJavascript(app::conf()->jquery->ui);
		$this->addCss(app::conf()->jquery->theme);
		$this->addJavascript("admin.js");
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
		$sec_title->add("Moduli sicurezza: ");
		$sec_title->add(new select("sec_modules",$list,app::conf()->security->module,["id"=>"sec_modules","data-info"=>$this->url("secinfo"), "style"=>"vertical-align: baseline;"]));
		$sec_cont->add($sec_title);
		$sec_cont->add(new element("div",["class"=>"box", "id"=>"secinfo"],"Scegli il modulo"));
		$cont->add($sec_cont);
		$tests_cont = new element("div",["class"=>"box"]);
		$tests_title = new element("div",["class"=>"title"]);
		$tests_title->add("Test di sistema: ");
		$tests_cont->add($tests_title);
		$tests_div = $tests_cont->append(new element("div",["class"=>"box", "id"=>"secinfo"],""));
		$tests_div->add(new anchor($this->url("permissiontest"),"Controllo permessi"));
		$tests_div->addBR();
		$tests_div->add(new anchor(app::root()."admin_config","Vedi configurazione"));
		$cont->add($tests_cont);
		return $cont;
	}
	
	function action_info() {
		ob_start();
		phpinfo();
		$s = ob_get_contents();
		ob_end_clean();
		$res = []; 
		preg_match("/.*<body>(.*?)<\/body>.*/s", $s,$res);
		//print_r($res);
		return $res[1];
	}
	
	function action_permissiontest() {
		$permstr = ["A0" => "<b><s>%s</s>","A1" => "%s"];
		$users = app::Security()->getUsersInfo();
		$views = app::getViews(TRUE);
		$rows = [];
		$cont = new element("div");
		$table = $cont->append(new element("table",["width"=>"100%"]));
		$tr = $table->append(new element("tr"));
		$tr->add(new element("th",["colspan"=>2],"Utente"));
		foreach ($views as $view) {
			$view = str_replace("_", "<br>", $view);
			$tr->add(new element("th",[],new element("small",[], new html($view))));
		}
		foreach ($users as $username => $data) {
			$tr = new element("tr");
			$tr->add(new element("th",[],$username)); 
			$tr->add(new element("th",[],$data["group"])); 
			foreach ($views as $view) {
				$perm = app::Security()->getPermission($view,$username);
				$permtext = "";
				//var_dump($perm);
				if ($perm->W !== NULL) $permtext .= sprintf($permstr["A".$perm->W],"W");
				if ($perm->R !== NULL) $permtext .= sprintf($permstr["A".$perm->R],"R");
				if ($perm->L !== NULL) $permtext .= sprintf($permstr["A".$perm->L],"L");
				if ($perm->A !== NULL) $permtext .= sprintf($permstr["A".$perm->A],"A");
				$tr->add(new element("td",[],new element("small",[],new html($permtext)))); 
			}
			$table->add($tr);
		}
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
		if ($module->usersPage()) {
			$cont->add(new anchor($module->usersPage(), "Gestione utenti"));
			$cont->addBR();
		}
		if ($module->usersPage()) {
			$cont->add(new anchor($module->permissionsPage(), "Gestione permessi"));
			$cont->addBR();
		}
		if ($module->usersPage()) {
			$cont->add(new anchor($module->groupsPage(), "Gestione gruppi"));
			$cont->addBR();
		}
		return $cont;
	}
}