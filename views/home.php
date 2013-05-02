<?php
/**
 *
 * home.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */

namespace views;
use framework\html\element;
use framework\html\img;
use framework\app;
use framework\html\anchorbutton;
use framework\html\source;
use framework\html\responsive\textblock;
use framework\html\responsive\div;
use framework\html\html;
use framework\io\file;
/**
 *
 * View Home
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package samples
 */
class home extends \framework\page {
	/**
	 *
	 * @var string Titolo pagina
	 */
	protected $title = "Home";
	/**
	 * Azione predefinita
	 * @see \framework\page::action_def()
	 */
	function action_def() {
		app::Controller()->addMessage("Accedi con User:demo Password:demo");
		$cont = new element("");

		$cont->addBR();
		$row = $cont->append(new div("row-fluid",""));

		$row->append(new textblock("Demo accesso ai dati",3))
		->append(new html(file::cache("dbpages.txt")->read()))
		->append(new anchorbutton("customers", "Vedi clienti"));

		$row->append(new textblock("Demo immagini",6))
		->append(array(new img("minifwlogo.jpg/width/230"),new img("minifwlogo.jpg/width/230/bw")))
		->append("Visualizza la demo sulle immagini")
		->append(new anchorbutton("images", "Vedi demo"))
		->append(file::cache("home.txt")->read());

		$row->append(new textblock("Demo messaggi di sistema",3))
		->append(file::cache("home.txt")->read())
		->append(new anchorbutton("functions", "Funzioni di notifica"));

		$cont->append(new element("h3"))->add("Il codice necessario per questa pagina:");
		$cont->add(new source($this->name()));
		return $cont;
	}

}
