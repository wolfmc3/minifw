<?php
/**
 *
 * admin_menu.php
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
use framework\html\anchorbutton;
use framework\html\form\edittable;
use framework\html\responsive\textblock;
use framework\io\file;
/**
 *
 * View admin_menu
 *
 * Pagina per la gestione del menu di sistema
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw
 *
 *
 */
class admin_menu extends page {
	/**
	 *
	 * @var string File del menu
	 */
	private $menufile = "menu.dat";
	/**
	 *
	 * @var string Titolo del menu
	 */
	protected $title = "Amministazione menu";
	/**
	 *
	 * @var string[] Dati del menu
	 */
	private $data = array();
	/**
	 *
	 * @var string Descrizione colonne
	 */
	private $cols = array(
			"id"=>array("name"=>"ID","ontable"=>1),
			"parent"=>array("name"=>"Id Menu padre","ontable"=>1),
			"url"=>array("name"=>"Url","ontable"=>1),
			"text"=>array("name"=>"Testo","ontable"=>1),
			"class"=>array("name"=>"Classe CSS","ontable"=>1),
			"permission"=>array("name"=>"Controlla permessi","ontable"=>1),
	);

	/**
	 * init()
	 *
	 * @see \framework\page::init()
	 */
	function init() {
		parent::init();
		$file = file::file($this->menufile);
		if ($file->exist()) {
			$this->data = $file->getValues();
		}
		$this->typeByAction("save", $this::TYPE_REDIRECT);
		$this->addJavascript("dbpages.js");
		$this->addJavascript("admin_menu.js");
	}

	/**
	 * Azione di default
	 * @see \framework\page::action_def()
	 */
	function action_def() {
		$this->addJqueryUi();
		$cont = new element();
		$this->cols = array_merge($this->cols,array(":DELETE:"=>array("name"=>"Cancella","ontable"=>1)));
		$table = new table($this->cols, $this->data,"id");
		$table->addAttr("data-id", "id");
		$table->addAttr("data-editurl", $this->url("edit"));
		$table->addAttr("data-delurl", $this->url("del"));
		$table->addAttr("data-moveurl", $this->url("move"));
		$cont->add($table);
		$cont->add(new anchorbutton($this->url("edit"), "Nuovo menù",array("class"=>"btn-primary")));

		return $cont;
	}

	/**
	 * Azione di spostamento
	 * @return string
	 */
	function action_move() {
		$this->type = page::TYPE_REDIRECT;
		$id = $this->item;
		$data = $this->data;
		$element = $data[$id];
		unset($data[$id]);
		$newindex = $this->extra[0];
		$newdata = array();
		$i=0;
		foreach ($data as $key => $value) {
			if ($i == $newindex) {
				$newdata[$id] = $element;
			}
			$newdata[$key] = $value;
			$i++;
		}
		if ($i == $newindex) {
			$newdata[$id] = $element;
		}
		file::file($this->menufile)->setValues($newdata);
		return $this->url();
	}

	/**
	 * Cancellazione
	 */
	function action_del() {
		$this->type = page::TYPE_REDIRECT;
		$id = $this->item;
		$data = $this->data;
		unset($data[$id]);
		file::file($this->menufile)->setValues($data);
		return $this->url();
	}

	/**
	 * Modifica
	 * @return \framework\html\element
	 */
	function action_edit() {
		$cont = new element();
		$row = array();
		if (!$this->item) {
			$row = array_fill_keys(array_keys($this->cols), '');
		} else {
			$row = $this->data[$this->item];
		}
		$form = new element("form");
		$form->addAttr("method", "post");
		$form->addAttr("action", $this->url("save"));
		$table = new edittable($row,$this->cols);
		$form->add($table);
		$cont->add($form);
		return $cont;
	}
	/**
	 * Salva
	 * @return string
	 */
	function action_save() {
		if (isset($_POST["SAVE"])) {
			$id = intval($_POST["id"]);
			$row = array (
					'url' => $_POST["url"],
					'text' => $_POST["text"],
					'class' => $_POST["class"],
					'parent' => $_POST["parent"],
					'permission' => $_POST["permission"]
			);
			if (!$id) $id = count($this->data)+1;
			$row['id'] = $id;
			$this->data[$id] = $row;
			file::file($this->menufile)->setValues($this->data);
		}
		return $this->url();
	}
}