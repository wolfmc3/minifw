<?php 
namespace views;
use framework\page;
use framework\html\element;
use framework\html\html;
use framework\html\responsive\carousel;
class images extends page {
	protected $title = "Image show";
	function action_def() {
		$cont = new element();
		$carousel = new carousel("car1",["style"=>"max-width: 870px;margin-left:auto;margin-right:auto;","class"=>"center"]);
		$carousel->addSlide("user/minifw.png", "Mini fw", "Questo framework fà anche il caffè",TRUE);
		$carousel->addSlide("user/mountain.jpg","Paesaggi di montagna", "Ho sempre gradito i paesaggi di montagna, sono rilassanti");
		$carousel->addSlide("user/flowers.jpg", "Fiori", "I fiori mettono pace, la loro accuratezza di dettagli è impressionanate");
		$carousel->addSlide("user/animal.jpg", "Animali", "Prendiamo esempio, molto più corretti delgi uomini");
		$cont->append($carousel);
		return $cont;
	}
}