<?php 
namespace menu;
use framework\menu;
use framework\html\logincontrol;
use framework\html\img;
class mainmenu extends menu {
	function __construct() {
		parent::__construct("menua");
		$this->append(new img("icon.png"));

		$this->addMenuItem("index", "index", "Home",TRUE);
		$this->addMenuItem("customers", "customers", "Clienti",TRUE);
		$this->addMenuItem("employees", "employees", "Impiegati",TRUE);
		$this->addMenuItem("offices", "offices", "Uffici",TRUE);
		$this->addMenuItem("products", "products", "Articoli",TRUE);
		$this->addMenuItem("admin", "admin", "Amministrazione",TRUE);
		
		$this->append(new logincontrol());
	}
}