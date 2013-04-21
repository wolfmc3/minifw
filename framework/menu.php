<?php 
namespace framework;
use framework\html\element;
use framework\html\anchor;
use framework\html\dotlist;
use framework\html\icon;
/**
 * 
 * menu
 *
 * Crea un blocco html compatibile con i menu ul->li (page->setMenu) 
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw
 *
 */
class menu extends element {
	/**
	 * @var \framework\menu[] Array dei submenu inseriti con addSubMenuItem
	 */
	private $menuitems = [];
	/**
	 * 
	 * @var \framework\html\dotlist Oggetto che gerera la lista dei menu
	 */
	private $dotlist;
	/**
	 * Costruttore
	 * 
	 * @param string $id attributo id del contenitore del menu (div)
	 * @param string $ulclass Attributo class della lista dei menu (ul)
	 * @param string[] $options Attributi optionali del contenitore (div)
	 */
	function __construct($id,$ulclass = "nav", $options = []) {
		app::Controller()->getPage()->addJavascript("menu.js");
		$options["id"] = $id;
		if (!isset($options["class"])) $options["class"] = "navbar-inner";
		parent::__construct("div",$options);
		$this->dotlist = new dotlist($ulclass);
		$this->add($this->dotlist);
	}
	
	/**
	 * addMenuItem()
	 * 
	 * @param string $id id del tag a (anchor)
	 * @param string $obj url o oggetto da visulizzare 
	 * @param string $text testo del link generato
	 * @param string $checkpermission se TRUE verifica e decide se visulizzare il link, tramite l'oggetto security
	 * @return boolean Ritorna TRUE se la voce è stata inserita, FALSE se i permessi dell'utente non permettono di vilualizzare l'oggetto
	 */
	function addMenuItem($id, $obj, $text, $checkpermission = FALSE) {
		if ($checkpermission && app::Security()->getPermission($obj)->L != 1) return FALSE;
		if ($checkpermission && (substr($obj,0,7) != 'http://')) $obj = app::root().$obj;
		$submenu = new menu("submenu_$id","",["class"=>"dropdown"]);
		$this->menuitems[$id] = $submenu;
		$this->dotlist->addItem([new anchor($obj, $text,["id"=>$id]),$submenu] );
		//$this->append(new icon("Lock"));
		return TRUE;
	}
	/**
	 * addSubMenuItem()
	 * 
	 * Aggiunge alla voce di menù già creata un sottomenu
	 * 
	 * @param string $parent Id della voce del menu dove aggiungere l'oggetto
	 * @param string $id id del tag a (anchor) da inserire
	 * @param string $obj url o oggetto da visulizzare 
	 * @param string $text testo del link generato
	 * @return boolean Ritorna TRUE se la voce $parent esiste e il menu è stato inserito
	 */
	function addSubMenuItem($parent, $id, $obj, $text) {
		if (!array_key_exists($parent, $this->menuitems)) return false;
		$submenu = $this->menuitems[$parent];
		//var_dump($submenu);
		$submenu->addMenuItem("submenu_{$parent}_{$id}", $obj, $text);
		return true;
	}
} 