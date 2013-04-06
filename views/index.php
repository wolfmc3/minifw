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
		$cont->addElement(new element("h1",array(),"Ciao!!" ));		
		$cont->addElement(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));		
		$cont->addElement(new anchor("customers", "Vedi clienti",array("class"=>"button")));
		$cont->addElement(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));
		$cont->addElement(new anchor("orders", "Vedi Ordini",array("class"=>"button")));
		$cont->addElement(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));
		
		echo $cont;
	}

}
