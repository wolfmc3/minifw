<?
namespace plugins\google;
use framework\html\element;
use framework\app;
use framework\html\form\jsondata;
class maps extends element {
	function __construct($lat = "0,0", $lon = "0,0", $width = "100%",$height = "450px") {
		parent::__construct();
		$cont = new element("div",array("id"=>"googlemapsdiv","style"=>"width: $width; height: $height;"),"");
		$this->add($cont);
		app::Controller()->getPage()->addJavascript("http://maps.googleapis.com/maps/api/js?&sensor=false");
		app::Controller()->getPage()->addJavascript("googlemaps.js");
		$this->add(new jsondata("mapsconf", array("lat"=>$lat,"lon"=>$lon)));
	}
}