<?php 
namespace views;
use \framework\html\anchor;
use framework\html\element;
use framework\html\img;
use framework\app;
class index extends \framework\contentBase {
	protected $menu = "menu";
	
	function title() {
		return "Indice";
	}
	
	function action_def() {
		$cont = new element("");
		$cont->add(new img("minifwlogo.jpg", app::Controller()));
		$cont->add(new element("h1",array(),"Ciao!!" ));		
		$cont->add(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));		
		$cont->add(new anchor("customers", "Vedi clienti",array("class"=>"button")));
		$cont->add(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));
		$cont->add(new anchor("orders", "Vedi Ordini",array("class"=>"button")));
		$cont->add(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));
		return $cont;
	}

}
