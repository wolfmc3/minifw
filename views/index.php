<?php 
use \framework\html\anchor;
use framework\html\element;
use framework\html\img;
use framework\system;
class content extends \framework\contentBase {
	protected $menu = "menu";
	
	function title() {
		return "Indice";
	}
	
	function def() {
		$cont = new element("");
		$cont->addElement(new img("minifwlogo.jpg", system::getController()));
		$cont->addElement(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));		
		$cont->addElement(new anchor("users", "Utenti",array("class"=>"button")));

		echo $cont;
	}

}
