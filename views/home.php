<?php 
namespace views;
use \framework\html\anchor;
use framework\html\element;
use framework\html\img;
use framework\app;
use framework\html\anchorbutton;
class home extends \framework\page {
	function title() {
		return "Home";
	}
	
	function action_def() {
$samplecode = <<<'SAMPLE'
<?php 
namespace views;
use \framework\html\anchor;
use framework\html\element;
use framework\html\img;
use framework\app;
use framework\html\anchorbutton;
class index extends \framework\page {
	function title() {
		return "Home";
	}

	function action_def() {
		$cont = new element("");
		$cont->add(new img("minifwlogo.jpg"));
		$cont->add(new element("h1",array(),"Ciao!!" ));		
		$cont->add(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));		
		$cont->add(new anchorbutton("customers", "Vedi clienti",array("class"=>"button")));
		$cont->add(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));
		$cont->add(new anchorbutton("orders", "Vedi Ordini",array("class"=>"button")));
		$cont->add(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));
		app::Controller()->addMessage("Benvenuto!!");
		return $cont;
	}
}
SAMPLE;
		app::Controller()->addMessage("Benvenuto!!");
		$cont = new element("");
		$cont->add(new img("minifwlogo.jpg"));
		$cont->add(new element("h1",array(),"Ciao!!" ));		
		$cont->add(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));		
		$cont->add(new anchorbutton("customers", "Vedi clienti",array("class"=>"button")));
		$cont->add(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));
		$cont->add(new anchorbutton("orders", "Vedi Ordini",array("class"=>"button")));
		$cont->add(new element("p",array(), file_get_contents(__DIR__."/../lib/home.txt")));
		$code = new element("pre",[],htmlspecialchars($samplecode),TRUE);
		$cont->add([new element("h3",[],"Il codice necessario per questa pagina:"), $code]);
		return $cont;
	}

}
