<?php 
namespace modules;
use framework\menu;
use framework\html\img;
use framework\app;
use framework\html\anchor;
use framework\html\html;
use framework\html\element;
use framework\html\responsive\div;
use framework\html\module;
use framework\html\template;
use framework\html\dotlist;
use framework\io\file;
class mainmenu extends module {
	private $menufile = "menu.dat";
	
	function render() {
		$menuitems = file::file($this->menufile)->getValues();
		//var_dump($menuitems);
		app::Controller()->getPage()->addJavascript("menu.js");
		$data = array("homelink"=>app::Controller()->Module("applink"));
		$data["menuitems"] = array();
		foreach ($menuitems as $key => $value) {
			//var_dump($value);
			//var_dump(app::Security()->getPermission($value["url"]));
			$permission = $value["permission"];
			if ($permission && app::Security()->getPermission($permission)->L != 1) continue;
			$link = $value["url"];
			if ((substr($link,0,7) != 'http://')) $link = app::root().$link;
			if ($value["url"] == app::Controller()->getPage()->name()) {
				$value["class"] .= " active";
			}
			
			$item = NULL;
			if ($value["url"] && $value["text"]) {
				$item = new anchor($link,$value["text"]);
			} else {
				$item = ($value["text"])?new element("p",array("class"=>"navbar-text"), $value["text"]):new element();
			}
			if (!$value["parent"]) {
				$data["menuitems"][$value["id"]] = array(
						"itemcontent"=>$item,
						"class"=>$value["class"],
						"id"=>$value["id"]
				);
				//var_dump($data);
			} else {
				$sub = &$data["menuitems"][$value["parent"]];
				if (!is_a($sub["itemcontent"], "framework\\html\\anchor")) {
					$sub["itemcontent"] = new anchor("#",$menuitems[$value["parent"]]["text"]);
				}
				if (!isset($sub["submenu"])) {
					$sub["submenu"] = new dotlist("submenu",array("data-parent"=>$value["parent"]));
				}
				$sub["submenu"]->addItem($item,array("class"=>$value["class"]));
			}
		}
		$template = new template("menu", $data ,"themes/".app::conf()->system->pagetemplate."/");
		$this->add($template);
		
		/*
		$menu->addMenuItem("menu1","functions", "functions", "Messaggi",TRUE);
		$menu->addMenuItem("menu1","images", "images", "Immagini",TRUE);
		$menu->addMenuItem("menu1","customers", "customers", "Clienti",TRUE);
		$menu->addSubMenuItem("customers", "customers_add", app::root()."customers/add", "Nuovo cliente");
		$menu->addMenuItem("menu1","employees", "employees", "Impiegati",TRUE);
		$menu->addMenuItem("menu1","offices", "offices", "Uffici",TRUE);
		$menu->addMenuItem("menu1","products", "products", "Articoli",TRUE);
		$menu->addCustomItem("menu1","divider divider-vertical","");
		$menu->addMenuItem("menu1","admin", "admin", "Amministrazione",TRUE);
		$menu->addMenuItem("menu1","docs", "http://www.wolfmc3.com/minifw-docs/", "Documentazione",TRUE);
		$menu->addSubMenuItem("admin", "info", app::root()."admin/info", "Informazioni PHP");
		$menu->addSubMenuItem("admin", "config", app::root()."admin_config", "Configurazione");
		$menu->addMenuItem("menu1","github", "https://github.com/wolfmc3/minifw", "Codice su GitHub");
		*/
	}
	
}