<?php
/**
 *
 * thumbnails.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 *
 */
namespace framework\html\responsive;
use framework\html\dotlist;
use framework\html\element;
use framework\html\img;
use framework\html\anchor;
/**
 *
 * Elemento thumbnails
 *
 * Genera un gruppo di anteprime come da sintassi bootstrap
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/responsive
 *
 */
class thumbnails extends dotlist {
	/**
	 *
	 * @var number Larghezza dell'immagine
	 */
	private $width = 0;
	/**
	 *
	 * @var number Alezza dell'immagine
	 */
	private $height = 0;
	/**
	 *
	 * @var string Methodo di ridimensionamento
	 */
	private $method = "";
	/**
	 * Costruttore
	 *
	 * @param string $method Methodo di ridimensionamento. normalmente resize
	 * @param number $width Larghezza dell'immagine
	 * @param number $height Alezza dell'immagine
	 * @param string $class Classe aggiuntiva
	 * @param string[] $options attributi opzionali
	 */
	function __construct($method="",$width=0,$height=0,$class="",$options=array()) {
		parent::__construct($class);
		$this->addAttr("class", "thumbnails");
		$this->width = $width;
		$this->height = $height;
		$this->method = $method;
		$this->span = 1;
	}
	/**
	 * addThumbnail()
	 * @param string $imgpath Percorso immagine
	 * @param string $url Url del link collegato all'immagine
	 * @param string $title Titolo dell'anteprima
	 * @param string $description Descrizione dell'anteprima
	 * @param number $span Colonne che occupa nel layout responsivo
	 */
	function addThumbnail($imgpath,$url="",$title="",$description="",$span=3) {
		if ($this->method) $imgpath .= "/".$this->method."/".$this->width."/".$this->height;
		$img = new img($imgpath);
		$link = NULL;
		if ($url) $link = new anchor($url,"");
		//$cont = NULL;
		if ($title) {
			$cont = new div("thumbnail", "");
			$cont->add($img);
			if ($title) $cont->append(new element("h3"))->add($title);
			if ($description) $cont->append(new element("p"))->add($description);
			if ($link) {
				$link->addAttr("class", "btn btn-mini btn-info");
				$link->html("Vedi");
				$cont->append(new element("p"))->append($link);
			}
		} else {
			$link->addAttr("class", "thumbnail");
			$link->addAttr("target", "_blank");
			$link->add($img);
			$cont = $link;
		}
		//$cont = new anchor("#", "");
		$this->addItem($cont,array("class"=>"span$span"));
	}
}