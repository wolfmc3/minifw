<?php
namespace framework\html\form;
use framework\html\element;
use framework\html\anchor;
use framework\app;
use framework\html\dotlist;
use framework\html\responsive\div;
/**
 * paging
 *
 * Genera un blocco html utile per visualizzare la paginazione
 * NOTA: Utilizzato da dbpages
 *
 * @author Marco Camplese <info@wolfmc3.com>
 * @package minifw/html
 * 
 * @see \framework\db\dbpage
 * @see \framework\db\resultset
 *
 */

class paging extends element {
	/**
	 * Costruttore
	 * @param string $object View
	 * @param string $action Azione
	 * @param number $page Pagina visualizzata
	 * @param number $pages Pagine totali
	 * @param number $block Righe per pagina
	 */
	function __construct($object,$action,$page,$pages,$block) {
		parent::__construct("div");
		if ($pages < 2 && $block != 0) return;
		$this->addAttr("class", "fwpaging");

		$row = $this->append(new div("container row-fluid alert-info", "",array("style"=>"margin-top:5px;margin-bottom:5px;")));
		
		$pagin = $row->append(new div("pagination pagination-mini offset1 span10","",array("style"=>"margin:0px;")));
		$basepath = app::root();

		$pagescont = $pagin->append(new dotlist("nav nav-pills span11"));
		if ($pages == 0) $pages = 1;
		$pagescont->addItem(new anchor("$basepath$object/$action/0/$block", new element("i",array("class"=>"icon-fast-backward"),"")));
		for ($i = 0;$i < $pages;$i++) {
			if (!($i+5 > $page && $i-5 < $page)) {
				continue; 
			}
			if ($i == $page) {
				$pagescont->addItem(new anchor("$basepath$object/$action/$i/$block", $i+1),array("class"=>"active"));
			} else {
				$pagescont->addItem(new anchor("$basepath$object/$action/$i/$block", $i+1));
			}
		}
		$pages--; 
		$pagescont->addItem(new anchor("$basepath$object/$action/$pages/$block", new element("i",array("class"=>"icon-fast-forward"),"")));

		
		$divblock = new div("btn-group span1", "");
		
		$divblock->add(new anchor("#", array($block." elementi per pagina", new element("span",array("class"=>"caret"))),array("class"=>"btn btn-mini btn-primary dropdown-toggle","data-toggle"=>"dropdown")));
		$blockmenu = $divblock->append(new dotlist("dropdown-menu"));
		$blocks = array(10=>"10",25=>"25",50=>"50",100=>"100",0=>"Tutti");
		//$this->add("Record per pagina:");
		foreach ($blocks as $key => $value) {
			$blockmenu->addItem(new anchor("$basepath$object/$action/0/$key",$value ));
		}
		$row->add($divblock);
	}
}

