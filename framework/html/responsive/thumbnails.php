<?php 
namespace framework\html\responsive;
use framework\html\dotlist;
use framework\html\element;
use framework\html\img;
use framework\html\anchor;
class thumbnails extends dotlist {
	private $width = 0;
	private $height = 0;
	private $method = "";
	function __construct($method="",$width=0,$height=0,$class="",$options=array()) {
		parent::__construct($class);
		$this->addAttr("class", "thumbnails");
		$this->width = $width;
		$this->height = $height;
		$this->method = $method;
		$this->span = 1;
	}
	
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