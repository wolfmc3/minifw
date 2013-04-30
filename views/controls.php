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
		$textarea = $cont->append(new tmcetextarea("txt1","txt1"));
		$textarea->setContents(file::cache("tinymcedemo.txt"));
		return $cont;
	}
}