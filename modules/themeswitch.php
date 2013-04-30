<?php 
/**
 * themeswitch.php
 *
 * @author Marco Camplese <info@wolfmc3.com>
 */

namespace modules;
use framework\html\module;
use framework\html\select;
use framework\html\element;
use framework\app;
use framework\html\form\submit;
use framework\html\responsive\div;
/**
 * 
 * Modulo themeswitch
 *
 * Crea un mini form che permette di selezionare uno dei temi nella cartella /templates 
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package modules
 * 
 */
class themeswitch extends module {
	/**
	 * Genera il blocco HTML 
	 * @see \framework\html\module::render()
	 */
	function render() {
		$cont = new div("row-fluid text-center");
		$form = new element("form",array("action"=>app::root()."themeswitcher","method"=>"POST","class"=>"form-inline"));
		$curtheme = isset($_SESSION["theme"])?$_SESSION["theme"]:app::conf()->system->pagetemplate;		
		app::conf()->system->pagetemplate = $curtheme;
		$cwd = getcwd();
		chdir("themes");
		$data = glob("*",GLOB_ONLYDIR);
		chdir($cwd);
		$data = array_combine($data, $data);
		$select = new select("newtheme", $data, $curtheme,array("class"=>"input-mini","style"=>"font-size:75%;height:22px;padding:1px;"));
		$cont->add("Cambia tema: ");
		$cont->add($select);
		$cont->add(new submit("Cambia",array("class"=>"btn-mini","style"=>"margin: 0px;")));
		$form->add($cont);
		$this->add($form);
	}
}
