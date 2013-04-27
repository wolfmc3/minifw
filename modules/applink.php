<?php 
namespace modules;
use framework\html\module;
use framework\html\anchor;
use framework\app;
class applink extends module {
	function render() {
		$this->append(new anchor(app::root().app::conf()->system->defaultobj, app::conf()->system->appname,array("class"=>"brand","id"=>"homelink")));
	}
}