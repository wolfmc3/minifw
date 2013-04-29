<?php 
namespace views;
use framework\page;
use framework\html\element;
use plugins\tinymce\tinymce;
use plugins\tinymce\tmcetextarea;
use framework\io\file;

class controls extends page {
	protected $title = "Controlli";
	function action_def() {
		$cont = new element();
		$cont->addBR();
		$textarea = $cont->append(new tmcetextarea("txt1","txt1"));
		$textarea->setContents(file::cache("tinymcedemo.txt"));
		return $cont;
	}
}