<?php 
namespace menu;
use framework\menu;
use framework\html\logincontrol;
use framework\html\img;
use framework\app;
class mainmenu extends menu {
	function __construct() {
		parent::__construct("mainmenu");

		$this->addMenuItem("index", "index", "Home",TRUE);
		$this->addMenuItem("functions", "functions", "Test funzioni",TRUE);
		$this->addMenuItem("customers", "customers", "Clienti",TRUE);
		$this->addMenuItem("employees", "employees", "Impiegati",TRUE);
		$this->addMenuItem("offices", "offices", "Uffici",TRUE);
		$this->addMenuItem("products", "products", "Articoli",TRUE);
		$this->addMenuItem("admin", "admin", "Amministrazione",TRUE);
		$this->addMenuItem("docs", "http://www.wolfmc3.com/minifw-docs/", "Documentazione",TRUE);
		$this->addSubMenuItem("admin", "info", app::root()."admin/info", "Informazioni PHP");
		$this->addSubMenuItem("admin", "config", "admin_config", "Configurazione");
		
		$this->append(new logincontrol());
	}
}