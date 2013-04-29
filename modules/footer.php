<?php 
namespace modules;
use framework\html\module;
use framework\html\element;
use framework\html\responsive\div;
use framework\html\anchor;
use framework\app;
class footer extends module {
	function render() {
		$this->add(element::hr());
		$this->append(new div("navbar text-center"))->append(new element("p",array("class"=>"text-center")))->add(array(
			"Builded with mini_fw v.".app::conf()->core->version,
			new anchor("https://github.com/wolfmc3/minifw", "Info"),
			app::Controller()->Module("themeswitch")
		));
	}
}