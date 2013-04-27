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
class menu extends element {
	/**
	 * Costruttore
	 * 
	 * @param string $id attributo id del contenitore del menu (div)
	 * @param string $ulclass Attributo class della lista dei menu (ul)
	 * @param string[] $options Attributi optionali del contenitore (div)
	 */
	function __construct() {
		parent::__construct("");
	}
	
	function &createMenu($id, $class) {
		$newmenu = new dotlist($class,array("id"=>$id));
		$this->add($newmenu);
		return $newmenu;
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
	function addMenuItem($menu,$id, $obj, $text, $checkpermission = FALSE) {
		$menu = $this->findId($menu);
		if (!$menu) return;
		if ($checkpermission && app::Security()->getPermission($obj)->L != 1) return FALSE;
		$link = $obj;
		if ($checkpermission && (substr($obj,0,7) != 'http://')) $link = app::root().$obj;
		$anc = new anchor($link, $text,array());
		$attr = array("id"=>$id);
		if ($checkpermission && $obj == app::Controller()->getPage()->name()) {
			$attr["class"] = "active";
		}
		$menu->addItem($anc,$attr);
		/*$submenu = new menu("submenu_$id","",array("class"=>"dropdown"));
		$this->menuitems[$id] = $submenu;
		//$this->append(new icon("Lock"));*/
		return TRUE;
	}
	function addCustomItem($menu,$class,$inner) {
		$menu = $this->findId($menu);
		if (!$menu) return;
		$menu->addItem($inner,array("class"=>$class));
		
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
		$submenu = $emp->findId("menu_items_".$parent);
		if (!$submenu) {
			$link = $emp->findTag("a");
			$emp->html(NULL);
			$openlink = new anchor("#",$link->getContents(),array("class"=>"dropdown-toggle","data-toggle"=>"dropdown"));
			$openlink->add(new element("b",array("class"=>"caret"),""));
			$emp->append($openlink);
			$emp->addAttr("class", "dropdown");
			$link->html("Apri");
			$contsubmenu = new menu();
			$submenu = $contsubmenu->createMenu("menu_items_".$parent, "dropdown-menu");
			$emp->add($contsubmenu);
			$submenu->addItem($link);
			$submenu->addItem("",array("class"=>"divider"));
		}
		$submenu->addItem(new anchor($obj,$text));
		return true;
	}
} 