<?php 
namespace framework;
use framework\html\element;
use framework\html\anchor;
use framework\html\dotlist;
use framework\html\icon;
use framework\html\responsive\div;
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
class menu extends dotlist {
	/**
	 * Costruttore
	 * 
	 * @param string $id attributo id del contenitore del menu (div)
	 * @param string $ulclass Attributo class della lista dei menu (ul)
	 * @param string[] $options Attributi optionali del contenitore (div)
	 */
	function __construct($id,$ulclass = "nav", $options = []) {
		app::Controller()->getPage()->addJavascript("menu.js");
		parent::__construct($ulclass,$options);
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
		$link = $obj;
		if ($checkpermission && (substr($obj,0,7) != 'http://')) $link = app::root().$obj;
		$anc = new anchor($link, $text,["id"=>$id]);
		$attr = [];
		if ($checkpermission && $obj == app::Controller()->getPage()->name()) {
			$attr["class"] = "active";
		}
		$this->addItem($anc,$attr);
		/*$submenu = new menu("submenu_$id","",["class"=>"dropdown"]);
		$this->menuitems[$id] = $submenu;
		//$this->append(new icon("Lock"));*/
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
		$emp = $this->findId($parent);
		//echo "search:";print_r($emp);
		if ($emp === NULL) return FALSE;
		//var_dump($submenu);
		$emp->add(new div("bubu", "sub$parent"));
		return true;
	}
} 