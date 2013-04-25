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
use framework\html\anchorbutton;
/**
 *
 * admin_pdoauth_permissions
 *
 * Pagina per la gestione dei permessi per il modulo sicurezza pdoauth
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/security
 *
 * @see \framework\security\modules\pdoauth
 *
 */

class admin_pdoauth_permissions extends page {
	private $cols = array(
	"path"=>array("name"=>"Percorso","ontable"=>1),
	"group"=>array("name"=>"Gruppo","ontable"=>1),
	"permission"=>array("name"=>"Permessi","ontable"=>1)
	);
	private $groups;
	private $permitNames = array(
		"W"=>"Write+",
		"R"=>"Read+",
		"L"=>"List+",
		"A"=>"Add+",
	);
	private $deniedNames = array(
		"w"=>"Write-",
		"r"=>"Read-",
		"l"=>"List-",
		"a"=>"Add-"
	);
	
	/**
	 * init()
	 *
	 * @see \framework\page::init()
	 */
	function init() {
		parent::init();
		$this->addJavascript("pdoauth.js");
		$this->addJavascript(app::conf()->jquery->ui);
		$this->addCss(app::conf()->jquery->theme);
		$this->typeByAction("edit", $this::TYPE_AJAX);
		$this->typeByAction("save", $this::TYPE_REDIRECT);
		$db = new database("pdoauth");
		$groupsret = $db->read("groups");
		$this->groups = array("?"=>"Anonimi","*"=>"Qualsiasi utente");
		foreach ($groupsret->rows as $row) {
			$this->groups[$row['group']] = $row["name"];
		} 
		
	}

	function action_edit() {
		$div = new element("div");
		$cont = $div->append(new element("form",array("action"=>$this->url("save/$this->item"),"method"=>"post")));
		$db = new database("pdoauth");
		$row = $db->row("permissions",$this->item);
		$table = $cont->append(new element("table"));
		foreach ($this->cols as $key => $value) {
			$el = NULL;
			if ($key == "path") $el = new text($key, $row[$key]);
			if ($key == "group") $el = new select($key, $this->groups, $row[$key]);
			if ($key == "permission") {
				$values = str_split($row[$key]); 
				$el = array(
					new checkboxes($key, $this->permitNames, $values),
					new br(),
					new checkboxes($key, $this->deniedNames, $values)
				);
			}
	
			$tr = $table->append(new element("tr"));
			$tr->append(new element("th",array(),$value['name']));
			$tr->append(new element("td",array(),$el));
		}
		$cont->append(new hidden("id", $this->item));
		return $div;
	}
	
	function action_def() {
		$db = new database("pdoauth");
		$ret = $db->read("permissions");
		//print_r($ret->rows);
		$permissions = new table($this->cols, $ret->rows,"id",array("data-openurl" => app::root().$this->obj."/edit/"));
		$cont = new element();
		$cont->add($permissions);
		$cont->addBR(2);
		$cont->add(new anchorbutton($this->url("edit"), "Aggiungi",array("class"=>"addperm")));
		return $cont;
	}
	
	function action_save() {
		$row = NULL;
		try {
			$row = array(
				":path"=>$_POST["path"],
				":group"=>$_POST["group"],
				":permission"=>implode("", $_POST['permission'])
			);
			$db = new database("pdoauth");
			$db->write("permissions", $row, $this->cols,$this->item);
		} catch (Exception $e) {
			die("impossibile salvare!!");
		}
		//print_r($res);
		return $this->url();
	}
}