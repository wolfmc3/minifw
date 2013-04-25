<?php 
namespace framework\html\responsive;
use framework\html\element;
use framework\html\orderedlist;
use framework\html\anchor;
use framework\html\img;
use framework\html\jsscript;
class carousel extends div {
	/**
	 * 
	 * @var number 
	 */
	private $currentslide = 0;
	/**
	 * 
	 * @var \framework\html\orderedlist
	 */
	private $carouselindicators = NULL;
	/**
	 * 
	 * @var \framework\html\responsive\div
	 */
	private $carouselinner = NULL;
	
	private $id;
	
	function __construct($id,$options = array(),$interval = "5000") {
		$this->id = $id; 
		parent::__construct("carousel slide", $id,$options);
		$this->carouselindicators = new orderedlist("carousel-indicators");
		$this->carouselinner = new div("carousel-inner", "");
		$this->append($this->carouselindicators);
		$this->append($this->carouselinner);
		$this->append(new anchor("#".$this->id, "‹",array("class"=>"left carousel-control","data-slide"=>"prev")));
		$this->append(new anchor("#".$this->id, "›",array("class"=>"right carousel-control","data-slide"=>"next")));
		$this->append(new jsscript('$("#'.$id.'").carousel({interval:'.$interval.'});'.PHP_EOL.'$("#'.$id.'").carousel("cycle");'));
	}
	
	function addSlide($img,$title,$text,$active = FALSE) {
		$item = new div("item".($active?" active":""), "");
		$item->append(new img($img));
		$caption = $item->append(new div("carousel-caption", ""));
		$caption->add(new element("h4",array(),$title));
		$caption->add(new element("p",array(),$text));
		$this->carouselinner->add($item);
		$this->carouselindicators->addItem("",array("class"=>($active?"active":""), "data-target"=>"#".$this->id, "data-slide-to"=>$this->currentslide));
		$this->currentslide++;
	}
}



