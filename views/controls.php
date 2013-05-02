<?php
/**
 *
 * controls.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 */
namespace views;
use framework\page;
use framework\html\element;
use plugins\tinymce\tinymce;
use plugins\tinymce\tmcetextarea;
use framework\io\file;
use plugins\google\maps;
use framework\html\source;
/**
 *
 * controls
 *
 * Crea un oggetto Page per la visualizzazione degli oggetti di terze parti
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package samples
 *
 */
class controls extends page {
	/**
	 *
	 * @var string Titolo della pagina
	 */
	protected $title = "Controlli";
	/**
	 * Visualizzazione di default
	 * @see \framework\page::action_def()
	 */
	function action_def() {
		$cont = new element();
		$cont->addBR();
		$cont->append(new element("h1"))->add("Tinymce");
		$textarea = $cont->append(new tmcetextarea("txt1","txt1"));
		$textarea->setContents(file::cache("tinymcedemo.txt"));
		$cont->addBR();
		$cont->append(new element("h1"))->add("Google Maps");
		$cont->add(new maps("42.4617902","14.2160898"));
		$cont->append(new element("h3"))->add("Il codice necessario per questa pagina:");
		$cont->add(new source($this->name()));
		return $cont;
	}
}