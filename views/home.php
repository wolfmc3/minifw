<?php 
namespace views;
use framework\html\element;
use framework\html\img;
use framework\app;
use framework\html\anchorbutton;
use framework\html\source;
use framework\html\responsive\textblock;
use framework\html\responsive\div;
use framework\html\html;
class home extends \framework\page {
	protected $title = "Home"; 
		
	function action_def() {
		app::Controller()->addMessage("Accedi con User:demo Password:demo");
		$cont = new element("");
		
		$cont->addBR();
		$row = $cont->append(new div("row",""));
		
		$row->append(new textblock("Demo accesso ai dati",3))
			->append(new html(file_get_contents(__DIR__."/../lib/dbpages.txt")))
			->append(new anchorbutton("customers", "Vedi clienti"));
		
		$row->append(new textblock("Demo immagini",6))
			->append([new img("minifwlogo.jpg/width/230"),new img("minifwlogo.jpg/width/230/bw")])
			->append("Visualizza la demo sulle immagini")
			->append(new anchorbutton("images", "Vedi demo"))
			->append(file_get_contents(__DIR__."/../lib/home.txt"));
		
		$row->append(new textblock("Demo messaggi di sistema",3))
			->append(file_get_contents(__DIR__."/../lib/home.txt"))
			->append(new anchorbutton("functions", "Funzioni di notifica"));
		
		$result = "".$cont;
		$cont->append(new element("h3"))->add("Il codice necessario per questa pagina:");
		$cont->add(new source($this->name()));
		$cont->append(new element("h3"))->add("Codice HTML:");
		$cont->append(new element("pre"))->add($result);
		return $cont;
	}

}
