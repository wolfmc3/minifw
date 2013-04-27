<?php 
namespace views;
use \framework\html\anchor;
use framework\html\element;
use framework\html\img;
use framework\app;
use framework\html\anchorbutton;
use framework\html\form\text;
use framework\html\form\submit;
use framework\html\source;
class functions extends \framework\page {
	protected $title = "Test funzioni";
	
	function action_def() {
		$cont = new element("");
		$cont->add(new img("minifwlogo.jpg", app::Controller()));
		$cont->add(new element("h1",array(),"Test messaggi di sistema" ));
		$form = $cont->append(new element("form",array("action"=>$this->url("save"),"method"=>"POST")));
		$form->add(new text("new_msg", "Testo scritto alle ".date(app::conf()->format->time)));
		$form->add(new submit("invia"));
		$form->add(new source($this->obj));	
		return $cont;
	}
	
	function action_save() {
		$this->type = $this::TYPE_REDIRECT;
		if (isset($_POST['new_msg'])) {
			app::Controller()->addMessage($_POST['new_msg'],new anchor("#test", "Bottone di prova"),NULL,"Messaggio che hai scritto");
		}
		return $this->url();
	}

	
}
