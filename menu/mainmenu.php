<?php 
namespace menu;
use framework\menu;
use framework\html\logincontrol;
use framework\html\img;
use framework\app;
use framework\html\anchor;
use framework\html\html;
use framework\html\element;
use framework\html\responsive\div;
class mainmenu extends element {
	function __construct() {
		parent::__construct("");
		$this->append(new anchor(app::root().app::conf()->system->defaultobj, app::conf()->system->appname,array("class"=>"brand")));
		$menu = new menu("mainmenu");
		$menu->createMenu("menu1", "nav");
		$menu->addMenuItem("menu1","functions", "functions", "Messaggi",TRUE);
		$menu->addMenuItem("menu1","images", "images", "Immagini",TRUE);
		$menu->addMenuItem("menu1","customers", "customers", "Clienti",TRUE);
		$menu->addSubMenuItem("customers", "customers_add", app::root()."customers/add", "Nuovo cliente");
		$menu->addMenuItem("menu1","employees", "employees", "Impiegati",TRUE);
		$menu->addMenuItem("menu1","offices", "offices", "Uffici",TRUE);
		$menu->addMenuItem("menu1","products", "products", "Articoli",TRUE);
		$menu->addMenuItem("menu1","admin", "admin", "Amministrazione",TRUE);
		$menu->addMenuItem("menu1","docs", "http://www.wolfmc3.com/minifw-docs/", "Documentazione",TRUE);
		$menu->addSubMenuItem("admin", "info", app::root()."admin/info", "Informazioni PHP");
		$menu->addSubMenuItem("admin", "config", app::root()."admin_config", "Configurazione");
		$menu->addMenuItem("menu1","github", "https://github.com/wolfmc3/minifw", "Codice su GitHub");
		$menu->append(new logincontrol());
		$menudiv = new div("nav-collapse collapse","main_menu_cont");
		$menudiv->append($menu);
		$this->append($menudiv);
	}
}