<?php 
namespace framework;
use framework\html\element;
use framework\html\anchor;
use framework\html\dotlist;
class menu extends dotlist {
	function __construct($id, $options = []) {
		$options["id"] = $id;
		parent::__construct("div",$options);
	}
	
	function addMenuItem($id, $obj, $text, $checkpermission = FALSE) {
		if ($checkpermission && app::Security()->getPermission("index")->L != 1) return;
		if ($checkpermission) $link = app::root().$obj;
		$this->add(new anchor($link, $text,["id"=>$id]));
	}
} 