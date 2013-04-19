<?php 
namespace framework;
use framework\html\element;
use framework\html\anchor;
use framework\html\dotlist;
use framework\html\icon;
class menu extends element {
	private $menuitems = [];
	private $dotlist;
	function __construct($id,$ulclass = "menu", $options = []) {
		app::Controller()->getPage()->addJavascript("menu.js");
		$options["id"] = $id;
		parent::__construct("div",$options);
		$this->dotlist = new dotlist($ulclass);
		$this->add($this->dotlist);
	}
	
	function addMenuItem($id, $obj, $text, $checkpermission = FALSE) {
		if ($checkpermission && app::Security()->getPermission($obj)->L != 1) return;
		if ($checkpermission && (substr($obj,0,7) != 'http://')) $obj = app::root().$obj;
		$submenu = new menu("submenu_$id","",["class"=>"submenu"]);
		$this->menuitems[$id] = $submenu;
		$this->dotlist->addItem([new anchor($obj, $text,["id"=>$id]),$submenu] );
		//$this->append(new icon("Lock"));
	}
	
	function addSubMenuItem($parent, $id, $obj, $text) {
		if (!array_key_exists($parent, $this->menuitems)) return false;
		$submenu = $this->menuitems[$parent];
		//var_dump($submenu);
		$submenu->addMenuItem("submenu_{$parent}_{$id}", $obj, $text);
		return true;
	}
} 