<?php 
namespace menu;
use framework\menu;
use framework\html\logincontrol;
use framework\html\img;
use framework\app;
use framework\html\anchor;
use framework\html\html;
class mainmenu extends menu {
	function __construct() {
		parent::__construct("mainmenu");
		$this->append(new anchor(app::root().app::conf()->system->defaultobj, app::conf()->system->appname,["class"=>"brand"]));
		$this->addMenuItem("functions", "functions", "Test funzioni",TRUE);
		$this->addMenuItem("customers", "customers", "Clienti",TRUE);
		$this->addMenuItem("employees", "employees", "Impiegati",TRUE);
		$this->addMenuItem("offices", "offices", "Uffici",TRUE);
		$this->addMenuItem("products", "products", "Articoli",TRUE);
		$this->addMenuItem("admin", "admin", "Amministrazione",TRUE);
		$this->addMenuItem("docs", "http://www.wolfmc3.com/minifw-docs/", "Documentazione",TRUE);
		$this->addSubMenuItem("admin", "info", app::root()."admin/info", "Informazioni PHP");
		$this->addSubMenuItem("admin", "config", "admin_config", "Configurazione");
		$this->append(new html("</ul>"));
		$this->append(new logincontrol());
	}
}