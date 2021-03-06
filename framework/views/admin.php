<?php
/**
 *
 * admin.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
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
use framework\html\responsive\div;
use framework\html\dotlist;
use framework\html\responsive\textblock;
use framework\html\anchorbutton;

/**
 *
 * admin
 *
 * Pagina di accesso alla gestione del sistema
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/security
 *
 *
 */
class admin extends page {
	/**
	 * @var string Titolo
	 */
	protected $title = "Amministrazione";
	/**
	 * Init()
	 *
	 * Inizializza la pagina
	 *
	 * */
	function init() {
		parent::init();
		$this->addJavascript(app::conf()->jquery->ui);
		$this->addCss(app::conf()->jquery->theme);
		$this->addJavascript("admin.js");
		$this->typeByAction("secinfo", self::TYPE_AJAX);
	}
	/**
	 * Azione predefinita
	 */
	function action_def() {
		$modules = array();
		chdir("framework/security/modules");
		$list = glob('*.php',GLOB_BRACE);
		chdir("../../..");
		$list = explode("/", str_replace(".php", "", implode("/", $list)));
		$list = array_combine($list,$list);
		$cont = new div("row");
		$secblock = $cont->append(new textblock(array("Moduli sicurezza: ", new select("sec_modules",$list,app::conf()->security->module,array("id"=>"sec_modules","data-info"=>$this->url("secinfo"), "style"=>"vertical-align: baseline;"))),3,0,"well"));
		$secblock->add(new element("p",array("id"=>"secinfo"),"Scegli il modulo"));

		$opblock = $cont->append(new textblock("Menutenzione e test",3,0,"well"));
		$opblock->append(new anchorbutton($this->url("permissiontest"),"Controllo permessi"));
		$opblock->append(new anchorbutton(app::root()."admin_config","Vedi configurazione"));
		$opblock->append(new anchorbutton(app::root()."admin_menu","Menu di sistema"));
		$opblock->append(new anchorbutton($this->url("clearcache"),"Azzera cache immagini"));
		$opblock->append(new anchorbutton(app::root()."admin_update","Manutenzione file"));

		return $cont;
	}
	/**
	 * Azione Info
	 *
	 * */
	function action_info() {
		ob_start();
		phpinfo();
		$s = ob_get_contents();
		ob_end_clean();
		$res = array();
		preg_match("/.*<body>(.*?)<\/body>.*/s", $s,$res);
		//print_r($res);
		return $res[1];
	}

	/**
	 * Azione controllo permessi
	 *
	 * */

	function action_permissiontest() {
		$permstr = array("A0" => "<b><s>%s</s>","A1" => "%s");
		$users = app::Security()->getUsersInfo();
		$views = app::getViews(TRUE);
		$rows = array();
		$cont = new element("div");
		$table = $cont->append(new element("table",array("width"=>"100%")));
		$tr = $table->append(new element("tr"));
		$tr->add(new element("th",array("colspan"=>2),"Utente"));
		foreach ($views as $view) {
			$view = str_replace("_", "<br>", $view);
			$tr->add(new element("th",array(),
					new element("small",array(), new html($view))));
		}
		foreach ($users as $username => $data) {
			$tr = new element("tr");
			$tr->add(new element("th",array(),$username));
			$tr->add(new element("th",array(),$data["group"]));
			foreach ($views as $view) {
				$perm = app::Security()->getPermission($view,$username);
				$permtext = "";
				//var_dump($perm);
				if ($perm->W !== NULL) $permtext .= sprintf($permstr["A".$perm->W],"W");
				if ($perm->R !== NULL) $permtext .= sprintf($permstr["A".$perm->R],"R");
				if ($perm->L !== NULL) $permtext .= sprintf($permstr["A".$perm->L],"L");
				if ($perm->A !== NULL) $permtext .= sprintf($permstr["A".$perm->A],"A");
				$tr->add(new element("td",array(),new element("small",array(),new html($permtext))));
			}
			$table->add($tr);
		}
		return $cont;
	}
	/**
	 * Azione Cancella cache
	 *
	 * */

	function action_clearcache() {
		$this->type = page::TYPE_REDIRECT;
		//chdir(app::conf()->system->imagecache);

		$list = glob(app::conf()->system->imagecache.'*',GLOB_BRACE);
		$filesize = 0;
		foreach ($list as $file) {
			$filesize += filesize($file);
			unlink($file);
		}
		app::Controller()->addMessage("Cache cancellata, recuperati ".ceil($filesize/1024/1024)."MB");
		return $this->url();
	}

	/**
	 * Azione Security info
	 *
	 * */
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